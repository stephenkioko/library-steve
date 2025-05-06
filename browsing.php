<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Browsing</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="header">
    <nav>
        <ul>
            <a href="dashboard.php">Dashboard</a>
            <a href="user_profile.php">Profile</a>
            <a href="borrowed.php">Borrowed Books</a>
          
            <a href="logout.php">Logout</a>
        </ul>
    </nav>
</div>

<div class="container">
    <h1>Browse Books</h1>

    <!-- Search Bar -->
    <div class="search-bar">
        <input type="text" id="search-input" placeholder="Search for a book...">
        <button id="search-button">Search</button>
    </div>

    <!-- Filters -->
    <div class="filters">
        <label for="genre">Genre:</label>
        <select id="genre">
            <option value="all">All</option>
            <option value="play">Play</option>
            <option value="drama">Drama</option>
            <option value="short story">Short Story</option>
        </select>
    </div>

    <!-- Book List -->
    <div class="book-list" id="book-list">
        <!-- Book items will be dynamically populated here -->
    </div>

    <!-- Pagination -->
    <div class="pagination">
        <button id="prev">Previous</button>
        <button id="next">Next</button>
    </div>
</div>

<script>
// Fetch books from the backend
function fetchBooks() {
    const genre = document.getElementById('genre').value;
    const searchQuery = document.getElementById('search-input').value;

    fetch(`fetch_books.php?genre=${genre}&search=${searchQuery}`)
        .then(response => response.json())
        .then(books => {
            renderBooks(books); // Call the function to render books on the page
        })
        .catch(error => {
            console.error('Error fetching books:', error);
        });
}

// Function to render books
function renderBooks(books) {
    const bookListElement = document.getElementById('book-list');
    bookListElement.innerHTML = '';  // Clear previous content

    if (books.length === 0) {
        bookListElement.innerHTML = "<p>No books found.</p>";
        return;
    }

    books.forEach(book => {
        const bookItem = document.createElement('div');
        bookItem.classList.add('book-item');
        bookItem.innerHTML = `
            <div class="book-image">
                <img src="${book.image ? book.image : 'default.jpg'}" alt="${book.title}">
            </div>
            <div class="book-info">
                <h3>${book.title}</h3>
                <p>by ${book.author}</p>
                <p>Genre: ${book.genre}</p>
                <p>Status: ${book.available ? 'Available' : 'Not Available'}</p>
                <button class="borrow-button" onclick="borrowBook(${book.id})" ${book.borrowed_status === 1 ? 'disabled' : ''}>Borrow</button>
                <button class="return-button" onclick="returnBook(${book.id})" ${book.borrowed_status === 0 ? 'style="display:none;"' : ''}>Return</button>
            </div>
        `;
        bookListElement.appendChild(bookItem);
    });
}

// Function to handle borrowing a book
function borrowBook(bookId) {
    fetch('borrow_book.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: bookId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('You have successfully borrowed the book!');
            fetchBooks();  // Refresh the books list after borrowing
        } else {
            alert('Failed to borrow book.' + data.message);
        }
    })
    .catch(error => console.error('Error borrowing book:', error));
}

// Function to handle returning a book
function returnBook(bookId) {
    fetch('return_book.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ id: bookId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('You have successfully returned the book!');
            fetchBooks();  // Refresh the books list after returning
        } else {
            alert('Failed to return book.');
        }
    })
    .catch(error => console.error('Error returning book:', error));
}

// Fetch books when the page loads
document.addEventListener('DOMContentLoaded', fetchBooks);

// Search button functionality
document.getElementById('search-button').addEventListener('click', fetchBooks);

// Genre filter functionality
document.getElementById('genre').addEventListener('change', fetchBooks);
</script>

</body>
</html>
