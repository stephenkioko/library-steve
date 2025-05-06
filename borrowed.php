<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="header">
    <nav>
        <ul>
            <a href="dashboard.php">Dashboard</a>
            <a href="user_profile.php">Profile</a>
            <a href="browsing.php">Book Browsing</a>
           
           
            <a href="logout.php">Logout</a>
        </ul>
    </nav>
</div>

<div class="container">
    <h1>Borrowed Books</h1>

    <!-- Borrowed Books List -->
    <div class="borrowed-books-list" id="borrowed-books-list">
        <!-- Book items will be dynamically populated here -->
    </div>
</div>

<script>
// Fetch borrowed books from the backend
function fetchBorrowedBooks() { 
    fetch('fetch_borrowed_books.php')
        .then(response => response.json())
        .then(data => {
            renderBorrowedBooks(data);
        })
        .catch(error => console.error('Error fetching borrowed books:', error));
}

// Render borrowed books on the page
function renderBorrowedBooks(borrowedBooks) {
    const borrowedBooksList = document.getElementById('borrowed-books-list');
    borrowedBooksList.innerHTML = '';

    borrowedBooks.forEach(book => {
        const bookItem = document.createElement('div');
        bookItem.classList.add('borrowed-book-item');
        bookItem.innerHTML = `
            <h3>${book.title}</h3>
            <p>by ${book.author}</p>
            <p><strong>Borrowed Date:</strong> ${book.borrowed_date}</p>
            <p><strong>Status:</strong> ${book.status}</p>
        `;
        borrowedBooksList.appendChild(bookItem);
    });
}

// Initialize by fetching borrowed books
fetchBorrowedBooks();
</script>

</body>
</html>
