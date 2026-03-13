<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check login
if (!isLoggedIn()) {
    redirect('index.php');
}

// Get statistics for reports
global $conn;

// Most issued books
$popularBooksQuery = "SELECT b.id, b.title, b.author, COUNT(ib.id) as issue_count 
                      FROM books b 
                      LEFT JOIN issued_books ib ON b.id = ib.book_id 
                      GROUP BY b.id 
                      ORDER BY issue_count DESC 
                      LIMIT 10";
$popularBooks = mysqli_query($conn, $popularBooksQuery);

// Students with most books issued
$activeStudentsQuery = "SELECT s.id, s.name, s.student_id, COUNT(ib.id) as issue_count 
                        FROM students s 
                        LEFT JOIN issued_books ib ON s.student_id = ib.student_id 
                        GROUP BY s.id 
                        ORDER BY issue_count DESC 
                        LIMIT 10";
$activeStudents = mysqli_query($conn, $activeStudentsQuery);

// Monthly statistics
$monthlyStatsQuery = "SELECT 
                        DATE_FORMAT(issue_date, '%Y-%m') as month,
                        COUNT(CASE WHEN status = 'issued' THEN 1 END) as issued_count,
                        COUNT(CASE WHEN status = 'returned' THEN 1 END) as returned_count,
                        SUM(fine_amount) as total_fine
                      FROM issued_books 
                      WHERE issue_date >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
                      GROUP BY DATE_FORMAT(issue_date, '%Y-%m')
                      ORDER BY month DESC";
$monthlyStats = mysqli_query($conn, $monthlyStatsQuery);

// Category wise distribution
$categoryQuery = "SELECT category, COUNT(*) as count 
                  FROM books 
                  WHERE category IS NOT NULL 
                  GROUP BY category 
                  ORDER BY count DESC";
$categories = mysqli_query($conn, $categoryQuery);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Library Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include 'includes/navbar.php'; ?>
    
    <div class="container-fluid">
        <div class="row">
            <?php include 'includes/sidebar.php'; ?>
            
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Reports & Analytics</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button onclick="window.print()" class="btn btn-sm btn-primary">
                            <i class="fas fa-print me-2"></i>Print Report
                        </button>
                    </div>
                </div>
                
                <!-- Charts Row -->
                <div class="row mb-4">
                    <div class="col-xl-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Monthly Issue/Return Statistics</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="monthlyChart"></canvas>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-xl-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Books by Category</h6>
                            </div>
                            <div class="card-body">
                                <canvas id="categoryChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Popular Books -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Most Popular Books</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Book Title</th>
                                                <th>Author</th>
                                                <th>Times Issued</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($book = mysqli_fetch_assoc($popularBooks)): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($book['title']); ?></td>
                                                <td><?php echo htmlspecialchars($book['author']); ?></td>
                                                <td><span class="badge bg-primary"><?php echo $book['issue_count']; ?></span></td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Most Active Students</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Student Name</th>
                                                <th>Student ID</th>
                                                <th>Books Issued</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($student = mysqli_fetch_assoc($activeStudents)): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($student['name']); ?></td>
                                                <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                                                <td><span class="badge bg-success"><?php echo $student['issue_count']; ?></span></td>
                                            </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Monthly Statistics Table -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Monthly Statistics (Last 6 Months)</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Month</th>
                                        <th>Books Issued</th>
                                        <th>Books Returned</th>
                                        <th>Total Fine Collected</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    mysqli_data_seek($monthlyStats, 0);
                                    while ($stat = mysqli_fetch_assoc($monthlyStats)): 
                                    ?>
                                    <tr>
                                        <td><?php echo date('F Y', strtotime($stat['month'] . '-01')); ?></td>
                                        <td><?php echo $stat['issued_count']; ?></td>
                                        <td><?php echo $stat['returned_count']; ?></td>
                                        <td>₹<?php echo number_format($stat['total_fine'] ?? 0, 2); ?></td>
                                    </tr>
                                    <?php endwhile; ?>
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
    
    <script>
        // Monthly Chart Data
        <?php
        mysqli_data_seek($monthlyStats, 0);
        $months = [];
        $issued = [];
        $returned = [];
        while ($stat = mysqli_fetch_assoc($monthlyStats)) {
            $months[] = date('M Y', strtotime($stat['month'] . '-01'));
            $issued[] = $stat['issued_count'];
            $returned[] = $stat['returned_count'];
        }
        ?>
        
        // Monthly Chart
        new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: {
                labels: <?php echo json_encode(array_reverse($months)); ?>,
                datasets: [{
                    label: 'Books Issued',
                    data: <?php echo json_encode(array_reverse($issued)); ?>,
                    borderColor: 'rgb(54, 162, 235)',
                    tension: 0.1
                }, {
                    label: 'Books Returned',
                    data: <?php echo json_encode(array_reverse($returned)); ?>,
                    borderColor: 'rgb(75, 192, 192)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
        
        // Category Chart Data
        <?php
        mysqli_data_seek($categories, 0);
        $catNames = [];
        $catCounts = [];
        while ($cat = mysqli_fetch_assoc($categories)) {
            $catNames[] = $cat['category'] ?: 'Uncategorized';
            $catCounts[] = $cat['count'];
        }
        ?>
        
        // Category Chart
        new Chart(document.getElementById('categoryChart'), {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($catNames); ?>,
                datasets: [{
                    data: <?php echo json_encode($catCounts); ?>,
                    backgroundColor: [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(153, 102, 255)',
                        'rgb(255, 159, 64)'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>