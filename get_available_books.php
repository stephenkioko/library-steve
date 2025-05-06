<?php
// Fetch all books that are available for reservation
$query = "SELECT id, title, author, genre, image FROM books WHERE available = TRUE";
$stmt = $pdo->prepare($query);
$stmt->execute();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return the books as JSON
header('Content-Type: application/json');
echo json_encode($books);
?>
