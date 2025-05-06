<?php
// Start session to access user data
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to login page
    header("Location: login.html");
    exit();
}

// User is logged in, display dashboard content
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="dashboard.css"> <!-- Link to your CSS for styling -->
</head>
<body>
<h1>Welcome to Your Dashboard, <?php echo $_SESSION['username']; ?>!</h1>

    <div class="header">
        
        <nav>
            <ul>
               <a href="user_profile.php">Profile</a>
               <a href="browsing.php">Book Browsing</a>
               <a href="borrowed.php">Borrowed Books</a>
              
               <a href="logout.php">Logout</a>
            </ul>
        </nav>
</div>
    
    <main>
        <section>
            <h2>Your Dashboard</h2>
            <p>Here you can manage your profile, browse the library, and update your settings.</p>
            <!-- You can also add more sections or features here -->
        </section>
    </main>
    
    <footer>
        <p>&copy; 2025 Library System. All rights reserved.</p>
    </footer>
</body>
</html>
