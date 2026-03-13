<?php
// Get current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>
<nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'dashboard.php' ? 'active' : ''; ?>" href="dashboard.php">
                    <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'view-books.php' || $current_page == 'add-book.php' ? 'active' : ''; ?>" href="view-books.php">
                    <i class="fas fa-book me-2"></i>Books
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'add-book.php' ? 'active' : ''; ?>" href="add-book.php">
                    <i class="fas fa-plus-circle me-2"></i>Add Book
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'students.php' ? 'active' : ''; ?>" href="students.php">
                    <i class="fas fa-users me-2"></i>Students
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'issue-book.php' ? 'active' : ''; ?>" href="issue-book.php">
                    <i class="fas fa-hand-holding me-2"></i>Issue Book
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'return-book.php' ? 'active' : ''; ?>" href="return-book.php">
                    <i class="fas fa-undo-alt me-2"></i>Return Book
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'issued-books.php' ? 'active' : ''; ?>" href="issued-books.php">
                    <i class="fas fa-list me-2"></i>Issued Books
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'reports.php' ? 'active' : ''; ?>" href="reports.php">
                    <i class="fas fa-chart-bar me-2"></i>Reports
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link <?php echo $current_page == 'settings.php' ? 'active' : ''; ?>" href="settings.php">
                    <i class="fas fa-cog me-2"></i>Settings
                </a>
            </li>
        </ul>
    </div>
</nav>