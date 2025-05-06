<?php
// Include database connection
include 'config.php';

// Start session to access logged-in user
session_start();
if (!isset($_SESSION['user_id'])) {
    echo "Please log in first.";
    exit;
}

$user_id = $_SESSION['user_id'];  // Get the logged-in user's ID
$book_id = $_GET['book_id'];  // Get the book ID from the GET parameter

// Check if the book is available (status = 1 means available, 0 means not available)
$query = "SELECT available FROM books WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $book_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($available);
$stmt->fetch();

if ($available == 1) {
    // If the book is available, return a message that the user can borrow it directly
    echo "This book is available for borrowing, you can borrow it directly.";
} else {
    // Reserve the book if it's not available
    // Insert a reservation record for this user
    $reserve_query = "INSERT INTO reservations (user_id, book_id, reservation_date) VALUES (?, ?, NOW())";
    $reserve_stmt = $conn->prepare($reserve_query);
    $reserve_stmt->bind_param("ii", $user_id, $book_id);

    if ($reserve_stmt->execute()) {
        // Send success message
        echo "The book has been reserved successfully. You will be notified when it becomes available.";
    } else {
        // If the reservation failed
        echo "Failed to reserve the book. Please try again.";
    }
}
?>
