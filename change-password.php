<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check login
if (!isLoggedIn()) {
    redirect('index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current = $_POST['current_password'];
    $new = $_POST['new_password'];
    $confirm = $_POST['confirm_password'];
    
    if ($new != $confirm) {
        $_SESSION['error'] = 'New password and confirm password do not match!';
        redirect('settings.php');
    }
    
    // Verify current password
    global $conn;
    $admin_id = $_SESSION['admin_id'];
    $query = "SELECT password FROM admin WHERE id = $admin_id";
    $result = mysqli_query($conn, $query);
    $admin = mysqli_fetch_assoc($result);
    
    if (password_verify($current, $admin['password'])) {
        $hashed = password_hash($new, PASSWORD_DEFAULT);
        $update = "UPDATE admin SET password = '$hashed' WHERE id = $admin_id";
        if (mysqli_query($conn, $update)) {
            $_SESSION['success'] = 'Password changed successfully!';
        } else {
            $_SESSION['error'] = 'Failed to change password!';
        }
    } else {
        $_SESSION['error'] = 'Current password is incorrect!';
    }
}

redirect('settings.php');
?>