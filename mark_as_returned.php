<?php
include 'config.php';

// Get the raw POST data from the request body
$data = json_decode(file_get_contents('php://input'), true);

// Ensure the 'bookId' field is provided
if (!isset($data['bookId'])) {
    echo json_encode(['success' => false, 'message' => 'No book ID provided']);
    exit;
}

$bookId = (int)$data['bookId'];

// Update the status of the borrowed book to 'returned'
$query = "UPDATE borrowed_books SET status = 'Returned' WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $bookId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to mark book as returned']);
}
?>
