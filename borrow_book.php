<?php
// borrow_book.php

// Include database connection
include 'config.php';

// Get the book ID from the request
$data = json_decode(file_get_contents("php://input"));
$bookId = $data->id;

// Update the book status and borrowed status in the books table
$query = "UPDATE books SET borrowed_status = 1, book_status = 'borrowed' WHERE id = ? AND borrowed_status = 0";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $bookId);

if ($stmt->execute()) {
    // Add the borrowed book to the borrowed_books table
    $borrowDate = date('Y-m-d H:i:s');
    $insertQuery = "INSERT INTO borrowed_books (book_id, borrowed_date) VALUES (?, ?)";
    $insertStmt = $conn->prepare($insertQuery);
    $insertStmt->bind_param("is", $bookId, $borrowDate);

    if ($insertStmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        // Log error if insert failed
        echo json_encode(['success' => false, 'message' => 'Failed to add borrowed book record']);
    }
} else {
    // Log error if update failed
    echo json_encode(['success' => false, 'message' => 'Failed to borrow book']);
}
?>
