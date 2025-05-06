<?php
ini_set('session.gc_maxlifetime', 3600); // Session timeout to 1 hour
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$username = $_SESSION['username'];
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';

// Display any profile update message
if (isset($_SESSION['profile_update_message'])) {
    echo '<p class="message">' . $_SESSION['profile_update_message'] . '</p>';
    unset($_SESSION['profile_update_message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title> 
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="header">
    <nav>
        <ul>
            <a href="dashboard.php">Dashboard</a>
            <a href="browsing.php">Book Browsing</a>
            <a href="borrowed.php">Borrowed Books</a>
          
            <a href="logout.php">Logout</a>
        </ul>
    </nav>
</div>

<main class="profile-container">
    <h2>User Profile</h2>

    
    <section class="profile-info">
        <h3>Personal Information</h3>
        <form action="update_profile.php" method="POST">
            <label for="name">Username:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($username); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter new password (optional)">

            <button type="submit">Update Information</button>
        </form>
    </section>

    <section class="password-change">
        <h3>Change Password</h3>
        <form action="change_password.php" method="POST">
            <label for="current-password">Current Password:</label>
            <input type="password" id="current-password" name="current-password" required>

            <label for="new-password">New Password:</label>
            <input type="password" id="new-password" name="new-password" required>

            <label for="confirm-password">Confirm New Password:</label>
            <input type="password" id="confirm-password" name="confirm-password" required>

            <button type="submit">Change Password</button>
        </form>
    </section>

    <section class="profile-picture">
        <h3>Upload Profile Picture</h3>
        <form action="upload_profile_picture.php" method="POST" enctype="multipart/form-data">
            <label for="profile-picture">Choose a new profile picture:</label>
            <input type="file" id="profile-picture" name="profile-picture" accept="image/*" required>
            <button type="submit">Upload Picture</button>
        </form>
    </section>
</main>

<footer>
    <p>&copy; 2025 Library System. All rights reserved.</p>
</footer>

</body>
</html>
