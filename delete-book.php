<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check login
if (!isLoggedIn()) {
    redirect('index.php');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    if (deleteBook($id)) {
        $_SESSION['success'] = 'Book deleted successfully!';
    } else {
        $_SESSION['error'] = 'Failed to delete book.';
    }
}

redirect('view-books.php');
?>