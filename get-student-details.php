<?php
require_once 'includes/config.php';
require_once 'includes/functions.php';

// Check login
if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Not authorized']);
    exit();
}

if (isset($_POST['student_id'])) {
    $student_id = sanitize($_POST['student_id']);
    $student = getStudentByStudentId($student_id);
    
    if ($student) {
        // Get count of issued books
        global $conn;
        $query = "SELECT COUNT(*) as count FROM issued_books WHERE student_id = '$student_id' AND status = 'issued'";
        $result = mysqli_query($conn, $query);
        $count = mysqli_fetch_assoc($result)['count'];
        
        echo json_encode([
            'success' => true,
            'student' => $student,
            'issued_count' => $count
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Student not found']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Student ID required']);
}
?>