<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Directory where profile pictures will be uploaded
$target_dir = "uploads/"; // Ensure this directory exists and is writable
$target_file = $target_dir . basename($_FILES["profile-picture"]["name"]);
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Check if the uploaded file is a valid image
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["profile-picture"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
    } else {
        echo "File is not an image.";
        exit();
    }
}

// Check if the file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    exit();
}

// Limit the file size to 5MB (adjust as necessary)
if ($_FILES["profile-picture"]["size"] > 5000000) {
    echo "Sorry, your file is too large.";
    exit();
}

// Allow certain file formats (e.g., JPG, PNG, GIF)
if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png" && $imageFileType != "gif") {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    exit();
}

// Try to upload the file
if (move_uploaded_file($_FILES["profile-picture"]["tmp_name"], $target_file)) {
    // File upload was successful, update database with the file path
    include('config.php'); // Include your database connection

    $username = $_SESSION['username']; // Get username from session
    $user_id = $_SESSION['user_id'];  // Assuming you are storing user ID in session
    $profile_picture_path = $target_file;

    // Update profile picture in the database
    $stmt = $conn->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
    $stmt->bind_param("si", $profile_picture_path, $user_id);

    if ($stmt->execute()) {
        // Set success message in session
        $_SESSION['profile_update_message'] = "Profile picture updated successfully!";
    } else {
        $_SESSION['profile_update_message'] = "Error updating profile picture.";
    }

    $stmt->close();
    $conn->close();

    // Redirect back to the user profile page
    header("Location: user_profile.php");
    exit();

} else {
    echo "Sorry, there was an error uploading your file.";
    exit();
}
?>
