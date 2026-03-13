<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check login
if (!isLoggedIn()) {
    redirect('index.php');
}

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';

$data = getStudents($search, $page);
$students = $data['students'];
$totalPages = $data['totalPages'];
$currentPage = $data['currentPage'];

// Handle add/edit/delete operations
if (isset($_POST['action'])) {
    if ($_POST['action'] == 'add') {
        $result = addStudent($_POST);
        if ($result) {
            $_SESSION['success'] = 'Student added successfully!';
        } else {
            $_SESSION['error'] = 'Failed to add student.';
        }
        redirect('students.php');
    } elseif ($_POST['action'] == 'edit') {
        $result = updateStudent($_POST['id'], $_POST);
        if ($result) {
            $_SESSION['success'] = 'Student updated successfully!';
        } else {
            $_SESSION['error'] = 'Failed to update student.';
        }
        redirect('students.php');
    } elseif ($_POST['action'] == 'delete') {
        $result = deleteStudent($_POST['id']);
        if ($result) {
            $_SESSION['success'] = 'Student deleted successfully!';
        } else {
            $_SESSION['error'] = 'Failed to delete student.';
        }
        redirect('students.php');
    }
}

$message = '';
if (isset($_SESSION['success'])) {
    $message = displayMessage($_SESSION['success']);
    unset($_SESSION['success']);
}
if (isset($_SESSION['error'])) {
    $message = displayMessage($_SESSION['error'], 'danger');
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Students - Library Management System</title>
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
                    <h1 class="h2">Students Management</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#addStudentModal">
                            <i class="fas fa-plus me-2"></i>Add New Student
                        </button>
                    </div>
                </div>
                
                <?php echo $message; ?>
                
                <!-- Search Bar -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <form method="GET" action="" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search by ID, name, or email..." value="<?php echo htmlspecialchars($search); ?>">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
                
                <!-- Students Table -->
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-primary">
                                    <tr>
                                        <th>ID</th>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Department</th>
                                        <th>Semester</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($students)): ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No students found</td>
                                    </tr>
                                    <?php else: ?>
                                        <?php foreach ($students as $student): ?>
                                        <tr>
                                            <td><?php echo $student['id']; ?></td>
                                            <td><?php echo htmlspecialchars($student['student_id']); ?></td>
                                            <td><?php echo htmlspecialchars($student['name']); ?></td>
                                            <td><?php echo htmlspecialchars($student['email']); ?></td>
                                            <td><?php echo htmlspecialchars($student['phone']); ?></td>
                                            <td><?php echo htmlspecialchars($student['department']); ?></td>
                                            <td><?php echo $student['semester']; ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning edit-student" 
                                                        data-id="<?php echo $student['id']; ?>"
                                                        data-student_id="<?php echo htmlspecialchars($student['student_id']); ?>"
                                                        data-name="<?php echo htmlspecialchars($student['name']); ?>"
                                                        data-email="<?php echo htmlspecialchars($student['email']); ?>"
                                                        data-phone="<?php echo htmlspecialchars($student['phone']); ?>"
                                                        data-department="<?php echo htmlspecialchars($student['department']); ?>"
                                                        data-semester="<?php echo $student['semester']; ?>"
                                                        data-address="<?php echo htmlspecialchars($student['address']); ?>"
                                                        data-bs-toggle="modal" data-bs-target="#editStudentModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-danger delete-student" 
                                                        data-id="<?php echo $student['id']; ?>"
                                                        data-name="<?php echo htmlspecialchars($student['name']); ?>"
                                                        data-bs-toggle="modal" data-bs-target="#deleteStudentModal">
                                                    <i class="fas fa-trash"></i>
                                                </button>
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
    
    <!-- Add Student Modal -->
    <div class="modal fade" id="addStudentModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="add">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="student_id" class="form-label">Student ID <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="student_id" name="student_id" required>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="department" class="form-label">Department</label>
                                <input type="text" class="form-control" id="department" name="department">
                            </div>
                            <div class="col-md-6">
                                <label for="semester" class="form-label">Semester</label>
                                <input type="number" class="form-control" id="semester" name="semester" min="1" max="8">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Student Modal -->
    <div class="modal fade" id="editStudentModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="edit">
                        <input type="hidden" name="id" id="edit-id">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit-student_id" class="form-label">Student ID <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit-student_id" name="student_id" required>
                            </div>
                            <div class="col-md-6">
                                <label for="edit-name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="edit-name" name="name" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit-email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="edit-email" name="email">
                            </div>
                            <div class="col-md-6">
                                <label for="edit-phone" class="form-label">Phone</label>
                                <input type="text" class="form-control" id="edit-phone" name="phone">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="edit-department" class="form-label">Department</label>
                                <input type="text" class="form-control" id="edit-department" name="department">
                            </div>
                            <div class="col-md-6">
                                <label for="edit-semester" class="form-label">Semester</label>
                                <input type="number" class="form-control" id="edit-semester" name="semester" min="1" max="8">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="edit-address" class="form-label">Address</label>
                                <textarea class="form-control" id="edit-address" name="address" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Delete Student Modal -->
    <div class="modal fade" id="deleteStudentModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="">
                    <div class="modal-body">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" id="delete-id">
                        <p>Are you sure you want to delete student: <strong id="delete-name"></strong>?</p>
                        <p class="text-danger">This action cannot be undone!</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete Student</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script>
        // Edit student modal
        $('.edit-student').click(function() {
            $('#edit-id').val($(this).data('id'));
            $('#edit-student_id').val($(this).data('student_id'));
            $('#edit-name').val($(this).data('name'));
            $('#edit-email').val($(this).data('email'));
            $('#edit-phone').val($(this).data('phone'));
            $('#edit-department').val($(this).data('department'));
            $('#edit-semester').val($(this).data('semester'));
            $('#edit-address').val($(this).data('address'));
        });
        
        // Delete student modal
        $('.delete-student').click(function() {
            $('#delete-id').val($(this).data('id'));
            $('#delete-name').text($(this).data('name'));
        });
    </script>
</body>
</html>