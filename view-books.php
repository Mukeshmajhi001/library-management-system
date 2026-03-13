<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check login
if (!isLoggedIn()) {
    redirect('index.php');
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';

$data = getBooks($search, $page);
$books = $data['books'];
$totalPages = $data['totalPages'];
$currentPage = $data['currentPage'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Books - Library Management System</title>
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
                    <h1 class="h2">Books Collection</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <a href="add-book.php" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus me-2"></i>Add New Book
                        </a>
                    </div>
                </div>
                
                <!-- Search Bar -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form method="GET" action="" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search by title, author, or ISBN..." value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Books Table -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>ISBN</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>Category</th>
                                        <th>Total Copies</th>
                                        <th>Available</th>
                                        <th>Shelf</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($books)): ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No books found</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($books as $book): ?>
                                        <tr>
                                            <td><?php echo $book['id']; ?></td>
                                            <td><?php echo $book['isbn'] ?: '-'; ?></td>
                                            <td><?php echo htmlspecialchars($book['title']); ?></td>
                                            <td><?php echo htmlspecialchars($book['author']); ?></td>
                                            <td><?php echo $book['category'] ?: '-'; ?></td>
                                            <td><?php echo $book['total_copies']; ?></td>
                                            <td>
                                                <span class="badge <?php echo $book['available_copies'] > 0 ? 'bg-success' : 'bg-danger'; ?>">
                                                    <?php echo $book['available_copies']; ?>
                                                </span>
                                            </td>
                                            <td><?php echo $book['shelf_location'] ?: '-'; ?></td>
                                            <td>
                                                <a href="edit-book.php?id=<?php echo $book['id']; ?>" class="btn btn-sm btn-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="delete-book.php?id=<?php echo $book['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this book?')" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <?php if ($totalPages > 1): ?>
                        <nav aria-label="Page navigation">
                            <ul class="pagination justify-content-center">
                                <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                                </li>
                                
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                </li>
                                <?php endfor; ?>
                                
                                <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>&search=<?php echo urlencode($search); ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                        <?php endif; ?>
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