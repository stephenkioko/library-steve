<?php
ini_set('session.gc_maxlifetime', 3600); // Session timeout to 1 hour
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

include('config.php'); // Assuming you have a config.php with database connection details

// Get user information from session
$username = $_SESSION['username'];
$user_id = $_SESSION['user_id']; // Assuming 'user_id' is set during login

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs
    $current_password = trim($_POST['current-password']);
    $new_password = trim($_POST['new-password']);
    $confirm_password = trim($_POST['confirm-password']);

    // Check if all fields are filled
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['profile_update_message'] = "All fields are required.";
        header("Location: user_profile.php");
        exit();
    }

    // Check if the new password and confirm password match
    if ($new_password !== $confirm_password) {
        $_SESSION['profile_update_message'] = "New password and confirm password do not match.";
        header("Location: user_profile.php");
        exit();
    }

    // Database connection
    $servername = "localhost"; // Replace with your MySQL server hostname if different
    $db_username = "root"; // Replace with your MySQL username
    $db_password = ""; // Replace with your MySQL password
    $dbname = "lib"; // Replace with your database name

    // Create connection to MySQL database
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query to fetch the current password
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id); // 'i' for integer parameter (user_id)
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($stored_password);
    $stmt->fetch();

    // Check if the current password matches the stored password
    if (!password_verify($current_password, $stored_password)) {
        $_SESSION['profile_update_message'] = "Current password is incorrect.";
        $stmt->close();
        header("Location: user_profile.php");
        exit();
    }

    // Hash the new password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the password in the database
    $update_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $update_stmt->bind_param("si", $hashed_password, $user_id);
    
    if ($update_stmt->execute()) {
        // Set a session message indicating the password was updated
        $_SESSION['profile_update_message'] = "Password updated successfully!";
    } else {
        $_SESSION['profile_update_message'] = "Error updating password. Please try again.";
    }

    // Close the statements and the connection
    $stmt->close();
    $update_stmt->close();
    $conn->close();

    // Redirect back to the user profile page
    header("Location: user_profile.php");
    exit();
}
?>
