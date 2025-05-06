<?php
include('config.php');  // Database connection

// Fetch all users' plain-text passwords
$sql = "SELECT id, password FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($user = $result->fetch_assoc()) {
        // Hash the plain-text password
        $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);

        // Update the password with the hashed version
        $updateSql = "UPDATE users SET password = '$hashedPassword' WHERE id = {$user['id']}";
        if ($conn->query($updateSql) === TRUE) {
            echo "Password updated for user ID: " . $user['id'] . "<br>";
        } else {
            echo "Error updating password: " . $conn->error . "<br>";
        }
    }
} else {
    echo "No users found with plain-text passwords.";
}

$conn->close();
?>
