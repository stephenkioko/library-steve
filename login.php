<?php
ini_set('session.gc_maxlifetime', 3600); // Session timeout to 1 hour
session_start(); // Start session to track user login status

// Database connection details
$servername = "localhost"; 
$db_username = "root"; 
$db_password = ""; 
$dbname = "lib"; 

// Create connection to MySQL database
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $pass = trim(mysqli_real_escape_string($conn, $_POST['password']));

    // Check if username and password are empty
    if (empty($user) || empty($pass)) {
        echo "Both username and password are required.";
        exit();
    }

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=?");
    $stmt->bind_param("s", $user); 
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        // Fetch the user data
        $row = $result->fetch_assoc();

        // Verify the password using password_verify
        if (password_verify($pass, $row['password'])) {
            // Password is correct, set session variables
            $_SESSION['username'] = $user;
            $_SESSION['user_id'] = $row['id']; // Assuming user_id is the primary key in the table

            // Redirect to the dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Invalid password
            echo "Invalid credentials. Please try again.";
        }
    } else {
        // User does not exist
        echo "Invalid credentials. Please try again.";
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
