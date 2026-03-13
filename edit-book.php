<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check login
if (!isLoggedIn()) {
    redirect('index.php');
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$book = getBookById($id);

if (!$book) {
    $_SESSION['error'] = 'Book not found';
    redirect('view-books.php');
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = [
        'isbn' => $_POST['isbn'],
        'title' => $_POST['title'],
        'author' => $_POST['author'],
        'category' => $_POST['category'],
        'publisher' => $_POST['publisher'],
        'publication_year' => $_POST['publication_year'],
        'total_copies' => $_POST['total_copies'],
        'shelf_location' => $_POST['shelf_location'],
        'description' => $_POST['description']
    ];
    
    if (updateBook($id, $data)) {
        $_SESSION['success'] = 'Book updated successfully!';
        redirect('view-books.php');
    } else {
        $error = displayMessage('Failed to update book. Please try again.', 'danger');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book - Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Edit Book</h1>
                </div>
                
                <?php echo $error; ?>
                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Book Information</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="isbn" class="form-label">ISBN</label>
                                    <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="category" class="form-label">Category</label>
                                    <input type="text" class="form-control" id="category" name="category" value="<?php echo htmlspecialchars($book['category']); ?>" required>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="title" class="form-label">Book Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="author" class="form-label">Author <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="publisher" class="form-label">Publisher</label>
                                    <input type="text" class="form-control" id="publisher" name="publisher" value="<?php echo htmlspecialchars($book['publisher']); ?>">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="publication_year" class="form-label">Publication Year</label>
                                    <input type="number" class="form-control" id="publication_year" name="publication_year" min="1900" max="<?php echo date('Y'); ?>" value="<?php echo $book['publication_year']; ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="total_copies" class="form-label">Total Copies <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="total_copies" name="total_copies" min="1" value="<?php echo $book['total_copies']; ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="shelf_location" class="form-label">Shelf Location</label>
                                    <input type="text" class="form-control" id="shelf_location" name="shelf_location" value="<?php echo htmlspecialchars($book['shelf_location']); ?>">
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($book['description']); ?></textarea>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Book
                                    </button>
                                    <a href="view-books.php" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Cancel
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>