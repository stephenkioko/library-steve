<div class="container">
    <h1>Your Reservations</h1>
    <div class="reserved-books" id="reserved-books">
        <!-- Reserved books will be listed here -->
    </div>
</div>

<script>
    // Fetch the reserved books from the backend
    fetch('/get-reserved-books.php') // Replace with actual URL
        .then(response => response.json())
        .then(data => {
            const reservedContainer = document.getElementById('reserved-books');
            if (data && data.length > 0) {
                data.forEach(book => {
                    const bookElement = document.createElement('div');
                    bookElement.classList.add('book-item');
                    bookElement.innerHTML = `
                        <img src="${book.image}" alt="${book.title}">
                        <h3>${book.title}</h3>
                        <p>by ${book.author}</p>
                        <p>Reserved on: ${book.reserved_at}</p>
                        <button onclick="cancelReservation(${book.id})">Cancel Reservation</button>
                    `;
                    reservedContainer.appendChild(bookElement);
                });
            } else {
                reservedContainer.innerHTML = '<p>You have no reserved books.</p>';
            }
        })
        .catch(error => console.error('Error fetching reserved books:', error));

    // Function to cancel reservation
    function cancelReservation(bookId) {
        fetch(`/cancel-reservation.php?book_id=${bookId}`, { method: 'GET' })
            .then(response => response.text())
            .then(message => {
                alert(message);
                // Optionally, reload the page or update the list of reserved books
            })
            .catch(error => console.error('Error cancelling reservation:', error));
    }
</script>
