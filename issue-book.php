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
    $student_id = $_POST['student_id'];
    $book_id = $_POST['book_id'];
    $due_date = $_POST['due_date'];
    
    // Get student by student_id
    $student = getStudentByStudentId($student_id);
    
    if (!$student) {
        $error = displayMessage('Student not found!', 'danger');
    } else {
        $result = issueBook($student_id, $book_id, $due_date);
        if ($result['success']) {
            $message = displayMessage($result['message']);
        } else {
            $error = displayMessage($result['message'], 'danger');
        }
    }
}

// Get available books for dropdown
$booksData = getBooks('', 1);
$availableBooks = array_filter($booksData['books'], function($book) {
    return $book['available_copies'] > 0;
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Book - Library Management System</title>
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
                    <h1 class="h2">Issue Book</h1>
                </div>
                
                <?php echo $message; ?>
                <?php echo $error; ?>
                
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Issue Book Form</h6>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="" id="issueForm">
                                    <div class="mb-3">
                                        <label for="student_id" class="form-label">Student ID <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="student_id" name="student_id" required>
                                        <div id="studentInfo" class="form-text"></div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="book_id" class="form-label">Select Book <span class="text-danger">*</span></label>
                                        <select class="form-select" id="book_id" name="book_id" required>
                                            <option value="">Choose a book...</option>
                                            <?php foreach ($availableBooks as $book): ?>
                                            <option value="<?php echo $book['id']; ?>">
                                                <?php echo htmlspecialchars($book['title'] . ' by ' . $book['author'] . ' (Available: ' . $book['available_copies'] . ')'); ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="due_date" name="due_date" 
                                               min="<?php echo date('Y-m-d', strtotime('+1 day')); ?>" 
                                               value="<?php echo date('Y-m-d', strtotime('+14 days')); ?>" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-hand-holding me-2"></i>Issue Book
                                        </button>
                                        <button type="reset" class="btn btn-secondary">
                                            <i class="fas fa-undo me-2"></i>Reset
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Student Information</h6>
                            </div>
                            <div class="card-body" id="studentDetails" style="display: none;">
                                <!-- Student details will be loaded here via AJAX -->
                            </div>
                            <div class="card-body" id="noStudentMessage">
                                <p class="text-muted text-center mb-0">Enter Student ID to view details</p>
                            </div>
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
        $(document).ready(function() {
            $('#student_id').on('blur', function() {
                var studentId = $(this).val();
                if (studentId.length > 0) {
                    $.ajax({
                        url: 'get-student-details.php',
                        type: 'POST',
                        data: {student_id: studentId},
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                var student = response.student;
                                var html = '<h6 class="font-weight-bold">' + student.name + '</h6>' +
                                          '<p class="mb-1"><i class="fas fa-id-card me-2"></i>ID: ' + student.student_id + '</p>' +
                                          '<p class="mb-1"><i class="fas fa-envelope me-2"></i>Email: ' + (student.email || 'N/A') + '</p>' +
                                          '<p class="mb-1"><i class="fas fa-phone me-2"></i>Phone: ' + (student.phone || 'N/A') + '</p>' +
                                          '<p class="mb-1"><i class="fas fa-graduation-cap me-2"></i>Department: ' + (student.department || 'N/A') + '</p>' +
                                          '<p class="mb-1"><i class="fas fa-layer-group me-2"></i>Semester: ' + (student.semester || 'N/A') + '</p>';
                                
                                if (response.issued_count !== undefined) {
                                    html += '<p class="mb-1"><i class="fas fa-book-reader me-2"></i>Books Issued: ' + response.issued_count + '</p>';
                                }
                                
                                $('#studentDetails').html(html).show();
                                $('#noStudentMessage').hide();
                            } else {
                                $('#studentDetails').hide();
                                $('#noStudentMessage').show();
                                $('#noStudentMessage').html('<p class="text-danger text-center mb-0">' + response.message + '</p>');
                            }
                        },
                        error: function() {
                            $('#studentDetails').hide();
                            $('#noStudentMessage').show();
                            $('#noStudentMessage').html('<p class="text-danger text-center mb-0">Error fetching student details</p>');
                        }
                    });
                } else {
                    $('#studentDetails').hide();
                    $('#noStudentMessage').show();
                    $('#noStudentMessage').html('<p class="text-muted text-center mb-0">Enter Student ID to view details</p>');
                }
            });
        });
    </script>
</body>
</html>