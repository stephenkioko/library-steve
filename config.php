<?php
// config.php
$servername = "localhost"; // Database server (adjust as needed)
$username = "root";        // Database username
$password = "";            // Database password (adjust as needed)
$dbname = "lib"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
