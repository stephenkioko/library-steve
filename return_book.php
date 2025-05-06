<?php
// return_book.php

// Include database connection
include 'config.php';

// Get the book ID from the request
$data = json_decode(file_get_contents("php://input"));
$bookId = $data->id;

// First, update the books table to set borrowed_status to 0 (returned) and book_status to 'available'
$query = "UPDATE books SET borrowed_status = 0, book_status = 'available' WHERE id = ? AND borrowed_status = 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $bookId);

// If the update to the books table is successful
if ($stmt->execute()) {
    // Now remove the corresponding entry from the borrowed_books table
    $deleteQuery = "DELETE FROM borrowed_books WHERE book_id = ?";
    $deleteStmt = $conn->prepare($deleteQuery);
    $deleteStmt->bind_param("i", $bookId);

    if ($deleteStmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete borrowed book record from borrowed_books table']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update book status to available']);
}
?>
