<?php
// Assuming you have a database connection
include('config.php');

// Get the bookId from the request body
$data = json_decode(file_get_contents("php://input"), true);
$bookId = $data['bookId'];

// Update the book status to 'Returned'
$sql = "UPDATE borrowed_books SET status = 'Returned' WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$bookId]);

// Return a success response
echo json_encode(['success' => true]);
?>
