<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check login
if (!isLoggedIn()) {
    redirect('index.php');
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$status = isset($_GET['status']) ? $_GET['status'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

$data = getIssuedBooks($status, $search, $page);
$issues = $data['issues'];
$totalPages = $data['totalPages'];
$currentPage = $data['currentPage'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issued Books - Library Management System</title>
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
                    <h1 class="h2">Issued Books</h1>
                </div>
                
                <!-- Filters -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <form method="GET" action="" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search by student name, ID, or book title..." value="<?php echo htmlspecialchars($search); ?>">
                            <select name="status" class="form-select me-2" style="width: auto;">
                                <option value="">All Status</option>
                                <option value="issued" <?php echo $status == 'issued' ? 'selected' : ''; ?>>Issued</option>
                                <option value="returned" <?php echo $status == 'returned' ? 'selected' : ''; ?>>Returned</option>
                                <option value="overdue" <?php echo $status == 'overdue' ? 'selected' : ''; ?>>Overdue</option>
                            </select>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Issued Books Table -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Student</th>
                                        <th>Book</th>
                                        <th>Issue Date</th>
                                        <th>Due Date</th>
                                        <th>Return Date</th>
                                        <th>Status</th>
                                        <th>Fine</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($issues)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No records found</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($issues as $issue): 
                                            $isOverdue = ($issue['status'] == 'issued' && strtotime($issue['due_date']) < time());
                                            $status = $issue['status'];
                                            if ($isOverdue) $status = 'overdue';
                                        ?>
                                        <tr class="<?php echo $status == 'overdue' ? 'table-danger' : ($status == 'returned' ? 'table-success' : ''); ?>">
                                            <td><?php echo $issue['id']; ?></td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($issue['student_name']); ?></strong><br>
                                                <small><?php echo htmlspecialchars($issue['student_id']); ?></small>
                                            </td>
                                            <td>
                                                <strong><?php echo htmlspecialchars($issue['book_title']); ?></strong><br>
                                                <small><?php echo htmlspecialchars($issue['author']); ?></small>
                                            </td>
                                            <td><?php echo date('d-m-Y', strtotime($issue['issue_date'])); ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($issue['due_date'])); ?></td>
                                            <td>
                                                <?php echo $issue['return_date'] ? date('d-m-Y', strtotime($issue['return_date'])) : '-'; ?>
                                            </td>
                                            <td>
                                                <?php if ($status == 'returned'): ?>
                                                    <span class="badge bg-success">Returned</span>
                                                <?php elseif ($status == 'overdue'): ?>
                                                    <span class="badge bg-danger">Overdue</span>
                                                <?php else: ?>
                                                    <span class="badge bg-primary">Issued</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($issue['fine_amount'] > 0): ?>
                                                    ₹<?php echo number_format($issue['fine_amount'], 2); ?>
                                                <?php else: ?>
                                                    -
                                                <?php endif; ?>
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
                                    <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>&status=<?php echo urlencode($status); ?>&search=<?php echo urlencode($search); ?>">Previous</a>
                                </li>
                                
                                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>&status=<?php echo urlencode($status); ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                </li>
                                <?php endfor; ?>
                                
                                <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>&status=<?php echo urlencode($status); ?>&search=<?php echo urlencode($search); ?>">Next</a>
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