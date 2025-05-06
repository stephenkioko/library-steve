<?php
// Assuming the user is logged in and you have their user ID in the session
$user_id = $_SESSION['user_id'];

// Query to get the reserved books for the user
$query = "
    SELECT b.id AS book_id, b.title, b.author, b.image, r.reserved_at
    FROM reservations r
    JOIN books b ON r.book_id = b.id
    WHERE r.user_id = :user_id AND r.status = 'reserved'
";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Return reserved books as JSON
header('Content-Type: application/json');
echo json_encode($reservations);
?>
