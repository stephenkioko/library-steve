<?php
// fetch_borrowed_books.php

include 'config.php';

$query = "SELECT b.id, b.title, b.author, bb.borrowed_date, b.book_status 
          FROM borrowed_books bb
          JOIN books b ON bb.book_id = b.id
          WHERE b.borrowed_status = 1"; // Only fetch borrowed books

$result = $conn->query($query);

$books = [];
while ($row = $result->fetch_assoc()) {
    $books[] = $row;
}

echo json_encode($books);
?>
