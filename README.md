# 📚 Library Management System

A comprehensive Library Management System built with PHP, MySQL, Bootstrap, and JavaScript. This system helps librarians manage books, students, and track book issuances/returns efficiently.

![Library Management System](https://github.com/Mukeshmajhi001/library-management-system/blob/639d648e049065ae0fda2f27748418c522ca4e80/screenshots/image%20copy.png)
![Library Management System](https://github.com/Mukeshmajhi001/library-management-system/blob/639d648e049065ae0fda2f27748418c522ca4e80/screenshots/image.png)


## ✨ Features

### 🔐 Authentication

- Secure admin login system
- Session management
- Password encryption

### 📖 Book Management

- Add new books with details (ISBN, title, author, category, publisher, etc.)
- Edit existing book information
- Delete books from catalog
- View all books with search and pagination
- Track available copies
- Book category management

### 👨‍🎓 Student Management

- Register new students
- Edit student details
- Delete student records
- Search students by ID, name, or email
- View student's issued books history
- Track maximum books per student

### 📤 Issue/Return System

- Issue books to students
- Auto-calculate due dates
- Return books with fine calculation
- Prevent issuing when book not available
- Check student's book limit
- Real-time student details via AJAX

### 📊 Dashboard

- Statistics overview (total books, available books, students, issued books)
- Recent activities feed
- Overdue books alert
- Quick access to all modules

### 📈 Reports & Analytics

- Most popular books report
- Most active students report
- Monthly issue/return statistics
- Category-wise book distribution
- Fine collection report
- Visual charts using Chart.js
- Export to CSV
- Print reports

### ⚙️ Settings

- Library information management
- Fine per day configuration
- Maximum books per student limit
- Loan period configuration
- Change admin password

### 🎨 UI/UX Features

- Responsive design (works on mobile, tablet, desktop)
- Dark mode toggle
- Interactive charts
- Toast notifications
- Confirmation modals
- Loading spinners
- Back to top button
- Print-friendly layouts

## 🛠️ Technologies Used

- **Backend:** PHP 7.4+
- **Database:** MySQL 5.7+
- **Frontend:** HTML5, CSS3, JavaScript
- **CSS Framework:** Bootstrap 5
- **Icons:** Font Awesome 6
- **Charts:** Chart.js
- **AJAX:** jQuery
- **Version Control:** Git

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- PHP (version 7.4 or higher)
- MySQL (version 5.7 or higher)
- Apache/Nginx web server
- Web browser (Chrome, Firefox, Edge, etc.)
- Git (optional)

## 🚀 Installation Guide

### Step 1: Clone the Repository

```bash
git clone https://github.com/yourusername/library-management-system.git
cd library-management-system
```



## Step 2: Configure Database

1. Open **phpMyAdmin** or MySQL command line.
2. Create a new database named:

```
library_db
```

3. Import the database structure:

```bash
mysql -u root -p library_db < database/library.sql
```

### Or Import via phpMyAdmin

1. Select **library_db** database
2. Click on **Import** tab
3. Choose `database/library.sql` file
4. Click **Go**

---

## Step 3: Configure Database Connection

1. Navigate to the **includes/** folder.
2. Rename:

```
config.example.php → config.php
```

(if the example file exists)

3. Update database credentials in `config.php`.

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'library_db');
```

---

## Step 4: Set Permissions

Ensure the following directories have write permissions.

```bash
chmod 755 -R assets/
chmod 755 -R includes/
```

---

## Step 5: Run the Application

1. Place the project inside your web server directory.

**For different servers:**

* XAMPP

```
C:/xampp/htdocs/library-management-system/
```

* WAMP

```
C:/wamp/www/library-management-system/
```

* Linux

```
/var/www/html/library-management-system/
```

2. Start **Apache** and **MySQL** services.

3. Open your browser and visit:

```
http://localhost/library-management-system/
```

---

## Step 6: Default Login

Use the following credentials to log in:

**Username:**

```
admin
```

**Password:**

```
admin123
```

---

# 📁 Project Structure

```
library-management-system/
├── assets/
│   ├── css/
│   │   └── style.css
│   └── js/
│       └── script.js
├── database/
│   └── library.sql
├── includes/
│   ├── config.php
│   ├── functions.php
│   ├── navbar.php
│   └── sidebar.php
├── add-book.php
├── change-password.php
├── dashboard.php
├── delete-book.php
├── edit-book.php
├── get-student-details.php
├── index.php
├── issue-book.php
├── issued-books.php
├── logout.php
├── reports.php
├── return-book.php
├── settings.php
├── students.php
├── view-books.php
├── .gitignore
└── README.md
```

---

# 🎯 Usage Guide

## Adding a Book

1. Login to the system
2. Click **"Add Book"** in the sidebar
3. Fill in book details (Title, Author, ISBN, etc.)
4. Click **"Save Book"**

---

## Registering a Student

1. Go to **Students** section
2. Click **Add New Student**
3. Enter student details
4. Click **Save Student**

---

## Issuing a Book

1. Go to **Issue Book**
2. Enter **Student ID** (auto-fetches student details)
3. Select book from dropdown
4. Choose **due date**
5. Click **Issue Book**

## 📚 Returning a Book

1. Go to **"Return Book"**
2. Find the issued book in the list
3. Click **"Return"** button
4. System calculates fine if applicable

---

## 📊 Generating Reports

1. Go to **"Reports"** section
2. View various statistics and charts
3. Use **"Print Report"** for hard copy
4. Use **"Export CSV"** for data analysis

---

## ⚙️ Configuration Options

Edit `includes/config.php` to modify:

* Database settings
* Site URL
* Records per page
* Date format

Edit settings via web interface:

* Library name and contact info
* Fine amount per day
* Maximum books per student
* Loan period duration

---

## 🔒 Security Features

* Password hashing using **bcrypt**
* SQL injection prevention
* XSS protection
* Session-based authentication
* Input validation and sanitization
* CSRF protection (can be added)

---

## 🐛 Troubleshooting

### Common Issues and Solutions

#### Database Connection Error

* Check MySQL service is running
* Verify database credentials in `config.php`
* Ensure database `library_db` exists

#### Login Failed

* Default credentials: **admin / admin123**
* Check if `admin` table has records
* Verify password hash in database

#### 404 Page Not Found

* Check if files are in correct directory
* Verify `.htaccess` configuration
* Check file permissions

#### CSS / JS not loading

* Clear browser cache
* Check file paths in HTML
* Verify asset permissions

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch

   ```bash
   git checkout -b feature/AmazingFeature
   ```
3. Commit your changes

   ```bash
   git commit -m "Add some AmazingFeature"
   ```
4. Push to the branch

   ```bash
   git push origin feature/AmazingFeature
   ```
5. Open a Pull Request

### Contribution Guidelines

* Follow **PSR-12 coding standards**
* Write clean, documented code
* Test thoroughly before submitting
* Update README if needed

---

## 📝 License

This project is licensed under the **MIT License**.
See the `LICENSE` file for details.

---

## 🙏 Acknowledgments

* Bootstrap team for amazing framework
* Font Awesome for beautiful icons
* Chart.js for interactive charts
* jQuery for simplified AJAX
* All contributors and users

---

## 📞 Support

For support, email:
`your-email@example.com`

or create an issue on GitHub.

---

## 🚀 Future Enhancements

* Email notifications for due dates
* SMS alerts for overdue books
* Barcode / RFID integration
* Online book reservation system
* Multiple admin roles
* Backup and restore functionality
* REST API for mobile apps
* E-book management
* Library card generation
* Fine payment gateway integration

---

## 👥 Authors

**Mukesh majhi** – Initial work – YourGitHub

---

## 🎉 Version History

### v1.0.0 (Current)

* Initial release
* Basic CRUD operations
* Issue / Return system
* Reports and analytics

---

Made with ❤️ by **[Mukesh majhi]** **[@mukeshmajhi001]**
