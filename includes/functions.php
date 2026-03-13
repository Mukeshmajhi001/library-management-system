<?php
require_once 'config.php';

// Authentication functions
function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function login($username, $password) {
    global $conn;
    $username = mysqli_real_escape_string($conn, $username);
    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        // Temporary fix - direct comparison
        if ($password == 'admin123') {  // Sirf testing ke liye
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            return true;
        }
        // Original password verification
        // if (password_verify($password, $admin['password'])) {
        //     $_SESSION['admin_id'] = $admin['id'];
        //     $_SESSION['admin_username'] = $admin['username'];
        //     return true;
        // }
    }
    return false;
}

function logout() {
    session_destroy();
    return true;
}

// Book functions
function addBook($data) {
    global $conn;
    
    $isbn = mysqli_real_escape_string($conn, $data['isbn']);
    $title = mysqli_real_escape_string($conn, $data['title']);
    $author = mysqli_real_escape_string($conn, $data['author']);
    $category = mysqli_real_escape_string($conn, $data['category']);
    $publisher = mysqli_real_escape_string($conn, $data['publisher']);
    $publication_year = (int)$data['publication_year'];
    $total_copies = (int)$data['total_copies'];
    $shelf_location = mysqli_real_escape_string($conn, $data['shelf_location']);
    $description = mysqli_real_escape_string($conn, $data['description']);
    
    $query = "INSERT INTO books (isbn, title, author, category, publisher, publication_year, total_copies, available_copies, shelf_location, description) 
              VALUES ('$isbn', '$title', '$author', '$category', '$publisher', $publication_year, $total_copies, $total_copies, '$shelf_location', '$description')";
    
    return mysqli_query($conn, $query);
}

function getBooks($search = '', $page = 1) {
    global $conn;
    $offset = ($page - 1) * RECORDS_PER_PAGE;
    $search = mysqli_real_escape_string($conn, $search);
    
    $where = '';
    if (!empty($search)) {
        $where = "WHERE title LIKE '%$search%' OR author LIKE '%$search%' OR isbn LIKE '%$search%'";
    }
    
    $query = "SELECT * FROM books $where ORDER BY id DESC LIMIT " . RECORDS_PER_PAGE . " OFFSET $offset";
    $result = mysqli_query($conn, $query);
    
    $books = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $books[] = $row;
    }
    
    // Get total count for pagination
    $countQuery = "SELECT COUNT(*) as total FROM books $where";
    $countResult = mysqli_query($conn, $countQuery);
    $total = mysqli_fetch_assoc($countResult)['total'];
    $totalPages = ceil($total / RECORDS_PER_PAGE);
    
    return ['books' => $books, 'totalPages' => $totalPages, 'currentPage' => $page];
}

function getBookById($id) {
    global $conn;
    $id = (int)$id;
    $query = "SELECT * FROM books WHERE id = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function updateBook($id, $data) {
    global $conn;
    
    $id = (int)$id;
    $isbn = mysqli_real_escape_string($conn, $data['isbn']);
    $title = mysqli_real_escape_string($conn, $data['title']);
    $author = mysqli_real_escape_string($conn, $data['author']);
    $category = mysqli_real_escape_string($conn, $data['category']);
    $publisher = mysqli_real_escape_string($conn, $data['publisher']);
    $publication_year = (int)$data['publication_year'];
    $total_copies = (int)$data['total_copies'];
    $shelf_location = mysqli_real_escape_string($conn, $data['shelf_location']);
    $description = mysqli_real_escape_string($conn, $data['description']);
    
    // Get current available copies
    $currentBook = getBookById($id);
    $copiesDifference = $total_copies - $currentBook['total_copies'];
    $available_copies = $currentBook['available_copies'] + $copiesDifference;
    
    $query = "UPDATE books SET 
              isbn = '$isbn',
              title = '$title',
              author = '$author',
              category = '$category',
              publisher = '$publisher',
              publication_year = $publication_year,
              total_copies = $total_copies,
              available_copies = $available_copies,
              shelf_location = '$shelf_location',
              description = '$description'
              WHERE id = $id";
    
    return mysqli_query($conn, $query);
}

function deleteBook($id) {
    global $conn;
    $id = (int)$id;
    $query = "DELETE FROM books WHERE id = $id";
    return mysqli_query($conn, $query);
}

// Student functions
function addStudent($data) {
    global $conn;
    
    $student_id = mysqli_real_escape_string($conn, $data['student_id']);
    $name = mysqli_real_escape_string($conn, $data['name']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $phone = mysqli_real_escape_string($conn, $data['phone']);
    $department = mysqli_real_escape_string($conn, $data['department']);
    $semester = (int)$data['semester'];
    $address = mysqli_real_escape_string($conn, $data['address']);
    
    $query = "INSERT INTO students (student_id, name, email, phone, department, semester, address) 
              VALUES ('$student_id', '$name', '$email', '$phone', '$department', $semester, '$address')";
    
    return mysqli_query($conn, $query);
}

function getStudents($search = '', $page = 1) {
    global $conn;
    $offset = ($page - 1) * RECORDS_PER_PAGE;
    $search = mysqli_real_escape_string($conn, $search);
    
    $where = '';
    if (!empty($search)) {
        $where = "WHERE student_id LIKE '%$search%' OR name LIKE '%$search%' OR email LIKE '%$search%'";
    }
    
    $query = "SELECT * FROM students $where ORDER BY id DESC LIMIT " . RECORDS_PER_PAGE . " OFFSET $offset";
    $result = mysqli_query($conn, $query);
    
    $students = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }
    
    $countQuery = "SELECT COUNT(*) as total FROM students $where";
    $countResult = mysqli_query($conn, $countQuery);
    $total = mysqli_fetch_assoc($countResult)['total'];
    $totalPages = ceil($total / RECORDS_PER_PAGE);
    
    return ['students' => $students, 'totalPages' => $totalPages, 'currentPage' => $page];
}

function getStudentById($id) {
    global $conn;
    $id = (int)$id;
    $query = "SELECT * FROM students WHERE id = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function getStudentByStudentId($student_id) {
    global $conn;
    $student_id = mysqli_real_escape_string($conn, $student_id);
    $query = "SELECT * FROM students WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}

function updateStudent($id, $data) {
    global $conn;
    
    $id = (int)$id;
    $student_id = mysqli_real_escape_string($conn, $data['student_id']);
    $name = mysqli_real_escape_string($conn, $data['name']);
    $email = mysqli_real_escape_string($conn, $data['email']);
    $phone = mysqli_real_escape_string($conn, $data['phone']);
    $department = mysqli_real_escape_string($conn, $data['department']);
    $semester = (int)$data['semester'];
    $address = mysqli_real_escape_string($conn, $data['address']);
    
    $query = "UPDATE students SET 
              student_id = '$student_id',
              name = '$name',
              email = '$email',
              phone = '$phone',
              department = '$department',
              semester = $semester,
              address = '$address'
              WHERE id = $id";
    
    return mysqli_query($conn, $query);
}

function deleteStudent($id) {
    global $conn;
    $id = (int)$id;
    $query = "DELETE FROM students WHERE id = $id";
    return mysqli_query($conn, $query);
}

// Issue/Return functions
function issueBook($student_id, $book_id, $due_date) {
    global $conn;
    
    $student_id = mysqli_real_escape_string($conn, $student_id);
    $book_id = (int)$book_id;
    $issue_date = date('Y-m-d');
    $due_date = mysqli_real_escape_string($conn, $due_date);
    
    // Check if book is available
    $book = getBookById($book_id);
    if ($book['available_copies'] <= 0) {
        return ['success' => false, 'message' => 'Book is not available'];
    }
    
    // Check student's issued books count
    $settings = getSettings();
    $maxBooks = $settings['max_books_per_student'];
    
    $query = "SELECT COUNT(*) as count FROM issued_books WHERE student_id = '$student_id' AND status = 'issued'";
    $result = mysqli_query($conn, $query);
    $count = mysqli_fetch_assoc($result)['count'];
    
    if ($count >= $maxBooks) {
        return ['success' => false, 'message' => 'Student has reached maximum book limit'];
    }
    
    // Issue book
    $query = "INSERT INTO issued_books (student_id, book_id, issue_date, due_date, status) 
              VALUES ('$student_id', $book_id, '$issue_date', '$due_date', 'issued')";
    
    if (mysqli_query($conn, $query)) {
        // Update available copies
        $new_available = $book['available_copies'] - 1;
        $updateQuery = "UPDATE books SET available_copies = $new_available WHERE id = $book_id";
        mysqli_query($conn, $updateQuery);
        
        return ['success' => true, 'message' => 'Book issued successfully'];
    }
    
    return ['success' => false, 'message' => 'Failed to issue book'];
}

function returnBook($issue_id) {
    global $conn;
    
    $issue_id = (int)$issue_id;
    $return_date = date('Y-m-d');
    
    // Get issue details
    $query = "SELECT * FROM issued_books WHERE id = $issue_id";
    $result = mysqli_query($conn, $query);
    $issue = mysqli_fetch_assoc($result);
    
    if (!$issue) {
        return ['success' => false, 'message' => 'Issue record not found'];
    }
    
    // Calculate fine if any
    $due_date = strtotime($issue['due_date']);
    $return_timestamp = strtotime($return_date);
    $fine = 0;
    
    if ($return_timestamp > $due_date) {
        $days_late = floor(($return_timestamp - $due_date) / (60 * 60 * 24));
        $settings = getSettings();
        $fine_per_day = $settings['fine_per_day'];
        $fine = $days_late * $fine_per_day;
    }
    
    // Update issue record
    $updateQuery = "UPDATE issued_books SET 
                    return_date = '$return_date',
                    status = 'returned',
                    fine_amount = $fine
                    WHERE id = $issue_id";
    
    if (mysqli_query($conn, $updateQuery)) {
        // Update available copies
        $book = getBookById($issue['book_id']);
        $new_available = $book['available_copies'] + 1;
        $bookUpdate = "UPDATE books SET available_copies = $new_available WHERE id = " . $issue['book_id'];
        mysqli_query($conn, $bookUpdate);
        
        return ['success' => true, 'message' => 'Book returned successfully', 'fine' => $fine];
    }
    
    return ['success' => false, 'message' => 'Failed to return book'];
}

function getIssuedBooks($status = '', $search = '', $page = 1) {
    global $conn;
    $offset = ($page - 1) * RECORDS_PER_PAGE;
    $search = mysqli_real_escape_string($conn, $search);
    
    $where = "1=1";
    if (!empty($status)) {
        $where .= " AND ib.status = '$status'";
    }
    if (!empty($search)) {
        $where .= " AND (s.name LIKE '%$search%' OR s.student_id LIKE '%$search%' OR b.title LIKE '%$search%')";
    }
    
    $query = "SELECT ib.*, s.name as student_name, s.student_id, b.title as book_title, b.author 
              FROM issued_books ib
              JOIN students s ON ib.student_id = s.student_id
              JOIN books b ON ib.book_id = b.id
              WHERE $where
              ORDER BY ib.issue_date DESC
              LIMIT " . RECORDS_PER_PAGE . " OFFSET $offset";
    
    $result = mysqli_query($conn, $query);
    
    $issues = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $issues[] = $row;
    }
    
    $countQuery = "SELECT COUNT(*) as total 
                   FROM issued_books ib
                   JOIN students s ON ib.student_id = s.student_id
                   JOIN books b ON ib.book_id = b.id
                   WHERE $where";
    $countResult = mysqli_query($conn, $countQuery);
    $total = mysqli_fetch_assoc($countResult)['total'];
    $totalPages = ceil($total / RECORDS_PER_PAGE);
    
    return ['issues' => $issues, 'totalPages' => $totalPages, 'currentPage' => $page];
}

// Settings functions
function getSettings() {
    global $conn;
    $query = "SELECT setting_key, setting_value FROM settings";
    $result = mysqli_query($conn, $query);
    
    $settings = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    
    return $settings;
}

function updateSettings($data) {
    global $conn;
    
    foreach ($data as $key => $value) {
        $key = mysqli_real_escape_string($conn, $key);
        $value = mysqli_real_escape_string($conn, $value);
        
        $query = "UPDATE settings SET setting_value = '$value' WHERE setting_key = '$key'";
        mysqli_query($conn, $query);
    }
    
    return true;
}

// Dashboard statistics
function getDashboardStats() {
    global $conn;
    
    $stats = [];
    
    // Total books
    $query = "SELECT COUNT(*) as total FROM books";
    $result = mysqli_query($conn, $query);
    $stats['total_books'] = mysqli_fetch_assoc($result)['total'];
    
    // Available books
    $query = "SELECT SUM(available_copies) as total FROM books";
    $result = mysqli_query($conn, $query);
    $stats['available_books'] = mysqli_fetch_assoc($result)['total'];
    
    // Total students
    $query = "SELECT COUNT(*) as total FROM students";
    $result = mysqli_query($conn, $query);
    $stats['total_students'] = mysqli_fetch_assoc($result)['total'];
    
    // Issued books
    $query = "SELECT COUNT(*) as total FROM issued_books WHERE status = 'issued'";
    $result = mysqli_query($conn, $query);
    $stats['issued_books'] = mysqli_fetch_assoc($result)['total'];
    
    // Overdue books
    $today = date('Y-m-d');
    $query = "SELECT COUNT(*) as total FROM issued_books WHERE status = 'issued' AND due_date < '$today'";
    $result = mysqli_query($conn, $query);
    $stats['overdue_books'] = mysqli_fetch_assoc($result)['total'];
    
    // Recent activities
    $query = "SELECT ib.*, s.name as student_name, b.title as book_title 
              FROM issued_books ib
              JOIN students s ON ib.student_id = s.student_id
              JOIN books b ON ib.book_id = b.id
              ORDER BY ib.issue_date DESC
              LIMIT 5";
    $result = mysqli_query($conn, $query);
    
    $stats['recent_activities'] = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $stats['recent_activities'][] = $row;
    }
    
    return $stats;
}

// Helper functions
function displayMessage($message, $type = 'success') {
    $class = $type == 'success' ? 'alert-success' : 'alert-danger';
    return "<div class='alert $class alert-dismissible fade show' role='alert'>
            $message
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function isAjaxRequest() {
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}

function sanitize($input) {
    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars(trim($input)));
}
?>