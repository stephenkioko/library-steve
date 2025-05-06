<?php
ini_set('session.gc_maxlifetime', 3600); // Session timeout to 1 hour
session_start();
include('config.php'); // Assuming you have a db_connection.php file for the database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Database connection details (make sure these are correct)
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_username = $_POST['name'];
    $new_email = $_POST['email'];
    $new_password = $_POST['password'];

    // Prepare the SQL query to update the user information
    if (!empty($new_password)) {
        // If a new password is provided, hash it and update the password as well
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("sssi", $new_username, $new_email, $hashed_password, $user_id);
    } else {
        // If no new password, just update username and email
        $update_query = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ssi", $new_username, $new_email, $user_id);
    }

    // Execute the update query
    if ($stmt->execute()) {
        // Update session variables if username or email is changed
        $_SESSION['username'] = $new_username;
        $_SESSION['email'] = $new_email;

        // Set a session message to indicate successful update
        $_SESSION['profile_update_message'] = "Profile updated successfully!";
    } else {
        // If the update failed, set an error message
        $_SESSION['profile_update_message'] = "Error updating profile. Please try again.";
    }

    // Close the statement
    $stmt->close();

    // Redirect back to the profile page
    header("Location: user_profile.php");
    exit();
}

// Close the database connection
$conn->close();
?>
