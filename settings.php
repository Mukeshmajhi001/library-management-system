<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check login
if (!isLoggedIn()) {
    redirect('index.php');
}

$settings = getSettings();
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    updateSettings($_POST);
    $message = displayMessage('Settings updated successfully!');
    $settings = getSettings(); // Refresh settings
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - Library Management System</title>
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
                    <h1 class="h2">System Settings</h1>
                </div>
                
                <?php echo $message; ?>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Library Information</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label for="library_name" class="form-label">Library Name</label>
                                        <input type="text" class="form-control" id="library_name" name="library_name" value="<?php echo htmlspecialchars($settings['library_name']); ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="library_address" class="form-label">Address</label>
                                        <textarea class="form-control" id="library_address" name="library_address" rows="2"><?php echo htmlspecialchars($settings['library_address']); ?></textarea>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="library_phone" class="form-label">Phone</label>
                                            <input type="text" class="form-control" id="library_phone" name="library_phone" value="<?php echo htmlspecialchars($settings['library_phone']); ?>">
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <label for="library_email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="library_email" name="library_email" value="<?php echo htmlspecialchars($settings['library_email']); ?>">
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Library Rules</h6>
                            </div>
                            <div class="card-body">
                                    <div class="mb-3">
                                        <label for="fine_per_day" class="form-label">Fine per Day (₹)</label>
                                        <input type="number" step="0.01" min="0" class="form-control" id="fine_per_day" name="fine_per_day" value="<?php echo $settings['fine_per_day']; ?>" required>
                                        <small class="text-muted">Fine amount charged per day for late returns</small>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="max_books_per_student" class="form-label">Maximum Books per Student</label>
                                        <input type="number" min="1" class="form-control" id="max_books_per_student" name="max_books_per_student" value="<?php echo $settings['max_books_per_student']; ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="loan_period_days" class="form-label">Loan Period (Days)</label>
                                        <input type="number" min="1" class="form-control" id="loan_period_days" name="loan_period_days" value="<?php echo $settings['loan_period_days']; ?>" required>
                                        <small class="text-muted">Number of days a book can be issued</small>
                                    </div>
                                    
                                    <hr>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save Settings
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Change Password Section -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Change Password</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="change-password.php" onsubmit="return validatePassword()">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key me-2"></i>Change Password
                            </button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        function validatePassword() {
            var newPass = document.getElementById('new_password').value;
            var confirmPass = document.getElementById('confirm_password').value;
            
            if (newPass != confirmPass) {
                alert('New password and confirm password do not match!');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>