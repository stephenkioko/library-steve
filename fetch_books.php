<?php
// Include database connection
include('config.php');

// Get the genre and search query from the request
$genre = isset($_GET['genre']) ? $_GET['genre'] : 'all';
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Build the SQL query
$query = "SELECT * FROM books WHERE title LIKE '%$search%'";

// Filter by genre if selected
if ($genre !== 'all') {
    $query .= " AND genre = '$genre'";
}

// Execute the query
$result = mysqli_query($conn, $query);

// Fetch the books and return as JSON
$books = [];
while ($row = mysqli_fetch_assoc($result)) {
    $books[] = $row;
}

echo json_encode($books);
?>
