<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to reserve a book.";
    exit;
}

$user_id = $_SESSION['user_id'];
$book_id = $_GET['book_id'];  // Book ID from the query parameter

// Check if the book is available for reservation
$query = "SELECT available FROM books WHERE id = :book_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':book_id', $book_id);
$stmt->execute();
$book = $stmt->fetch(PDO::FETCH_ASSOC);

if ($book['available']) {
    // Insert reservation
    $query = "INSERT INTO reservations (user_id, book_id) VALUES (:user_id, :book_id)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':book_id', $book_id);
    $stmt->execute();

    // Mark book as unavailable
    $query = "UPDATE books SET available = FALSE WHERE id = :book_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':book_id', $book_id);
    $stmt->execute();

    echo "Book reserved successfully!";
} else {
    echo "Sorry, the book is not available for reservation.";
}
?>
