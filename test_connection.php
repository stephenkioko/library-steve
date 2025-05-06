<?php
// Include the database configuration file
include('config.php');

// Test the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Successfully connected to the database!";
}

// Close the database connection
$conn->close();
?>
