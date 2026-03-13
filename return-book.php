<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check login
if (!isLoggedIn()) {
    redirect('index.php');
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['issue_id'])) {
        $result = returnBook($_POST['issue_id']);
        if ($result['success']) {
            $fineMessage = $result['fine'] > 0 ? ' Fine amount: ₹' . $result['fine'] : '';
            $message = displayMessage($result['message'] . $fineMessage);
        } else {
            $error = displayMessage($result['message'], 'danger');
        }
    }
}

// Get issued books for return
$issuedData = getIssuedBooks('issued');
$issuedBooks = $issuedData['issues'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book - Library Management System</title>
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
                    <h1 class="h2">Return Book</h1>
                </div>
                
                <?php echo $message; ?>
                <?php echo $error; ?>
                
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Issued Books List</h6>
                    </div>
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
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($issuedBooks)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No issued books found</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($issuedBooks as $issue): 
                                            $isOverdue = strtotime($issue['due_date']) < time();
                                        ?>
                                        <tr class="<?php echo $isOverdue ? 'table-danger' : ''; ?>">
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
                                            <td>
                                                <?php echo date('d-m-Y', strtotime($issue['due_date'])); ?>
                                                <?php if ($isOverdue): ?>
                                                    <br><span class="badge bg-danger">Overdue</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">Issued</span>
                                            </td>
                                            <td>
                                                <form method="POST" action="" style="display: inline;" onsubmit="return confirm('Return this book?')">
                                                    <input type="hidden" name="issue_id" value="<?php echo $issue['id']; ?>">
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="fas fa-undo-alt me-1"></i>Return
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
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