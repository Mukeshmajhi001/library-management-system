
-- phpMyAdmin SQL Dump
-- Database: `library_db`

CREATE DATABASE IF NOT EXISTS `library_db`;
USE `library_db`;


CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `email`, `created_at`) VALUES
(1, 'admin', '$2y$10$YourHashedPasswordHere', 'admin@library.com', '2026-03-17 17:43:34');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `publication_year` int(4) DEFAULT NULL,
  `total_copies` int(11) NOT NULL DEFAULT 1,
  `available_copies` int(11) NOT NULL DEFAULT 1,
  `shelf_location` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `isbn`, `title`, `author`, `category`, `publisher`, `publication_year`, `total_copies`, `available_copies`, `shelf_location`, `description`, `added_date`) VALUES
(1, '9780451524935', '1984', 'George Orwell', 'Fiction', 'Secker & Warburg', 1949, 5, 3, 'A-01-01', 'A dystopian social science fiction novel and cautionary tale about the dangers of totalitarianism.', '2026-03-17 17:51:00'),
(2, '9780061120084', 'To Kill a Mockingbird', 'Harper Lee', 'Fiction', 'J.B. Lippincott & Co.', 1960, 4, 2, 'A-01-02', 'The story of racial injustice and the loss of innocence in the American South.', '2026-03-17 17:51:00'),
(3, '9780141187761', 'The Great Gatsby', 'F. Scott Fitzgerald', 'Fiction', 'Charles Scribner\'s Sons', 1925, 3, 1, 'A-01-03', 'A critique of the American Dream set in the Jazz Age on Long Island.', '2026-03-17 17:51:00'),
(4, '9780743273565', 'The Catcher in the Rye', 'J.D. Salinger', 'Fiction', 'Little, Brown and Company', 1951, 4, 3, 'A-01-04', 'The story of Holden Caulfield\'s teenage angst and alienation in New York City.', '2026-03-17 17:51:00'),
(5, '9780140283334', 'One Hundred Years of Solitude', 'Gabriel García Márquez', 'Fiction', 'Harper & Row', 1967, 3, 2, 'A-01-05', 'A multi-generational story of the Buendía family in the fictional town of Macondo.', '2026-03-17 17:51:00'),
(6, '9780544003415', 'The Lord of the Rings', 'J.R.R. Tolkien', 'Fantasy', 'Allen & Unwin', 1954, 6, 4, 'B-02-01', 'An epic high-fantasy novel about the quest to destroy the One Ring.', '2026-03-17 17:51:00'),
(7, '9780439064873', 'Harry Potter and the Chamber of Secrets', 'J.K. Rowling', 'Fantasy', 'Bloomsbury', 1998, 8, 5, 'B-02-02', 'The second installment of the Harry Potter series about the young wizard\'s adventures.', '2026-03-17 17:51:00'),
(8, '9780316015844', 'The Name of the Wind', 'Patrick Rothfuss', 'Fantasy', 'DAW Books', 2007, 3, 2, 'B-02-03', 'The story of Kvothe, a legendary magician and adventurer, told in his own words.', '2026-03-17 17:51:00'),
(9, '9780553386790', 'A Game of Thrones', 'George R.R. Martin', 'Fantasy', 'Bantam Spectra', 1996, 5, 3, 'B-02-04', 'The first novel in the epic fantasy series A Song of Ice and Fire.', '2026-03-17 17:51:00'),
(10, '9780441013593', 'Dune', 'Frank Herbert', 'Science Fiction', 'Chilton Books', 1965, 4, 2, 'C-03-01', 'A science fiction masterpiece set on the desert planet Arrakis.', '2026-03-17 17:51:00'),
(11, '9780553293357', 'Foundation', 'Isaac Asimov', 'Science Fiction', 'Gnome Press', 1951, 3, 2, 'C-03-02', 'The first novel in the Foundation series about the fall and rise of a galactic empire.', '2026-03-17 17:51:00'),
(12, '9780547928227', 'The Hobbit', 'J.R.R. Tolkien', 'Fantasy', 'Allen & Unwin', 1937, 5, 4, 'B-02-05', 'The classic prelude to The Lord of the Rings about Bilbo Baggins\' adventure.', '2026-03-17 17:51:00'),
(13, '9780062073488', 'Fahrenheit 451', 'Ray Bradbury', 'Science Fiction', 'Ballantine Books', 1953, 3, 1, 'C-03-03', 'A dystopian novel about a fireman who burns books in a future society.', '2026-03-17 17:51:00'),
(14, '9780385472579', 'Things Fall Apart', 'Chinua Achebe', 'Literary Fiction', 'Heinemann', 1958, 2, 2, 'A-02-01', 'A classic novel about pre-colonial life in Nigeria and the arrival of Europeans.', '2026-03-17 17:51:00'),
(15, '9780143039433', 'The Kite Runner', 'Khaled Hosseini', 'Historical Fiction', 'Riverhead Books', 2003, 4, 3, 'A-02-02', 'A story of friendship, betrayal, and redemption set in Afghanistan.', '2026-03-17 17:51:00'),
(16, '9780307277671', 'The Road', 'Cormac McCarthy', 'Post-Apocalyptic', 'Alfred A. Knopf', 2006, 3, 2, 'C-04-01', 'A father and son journey through a desolate, post-apocalyptic America.', '2026-03-17 17:51:00'),
(17, '9780747532743', 'Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', 'Fantasy', 'Bloomsbury', 1997, 8, 6, 'B-02-06', 'The first book in the Harry Potter series.', '2026-03-17 17:51:00'),
(18, '9780439064866', 'Harry Potter and the Prisoner of Azkaban', 'J.K. Rowling', 'Fantasy', 'Bloomsbury', 1999, 7, 5, 'B-02-07', 'The third book in the Harry Potter series.', '2026-03-17 17:51:00'),
(19, '9780439139601', 'Harry Potter and the Goblet of Fire', 'J.K. Rowling', 'Fantasy', 'Bloomsbury', 2000, 7, 4, 'B-02-08', 'The fourth book in the Harry Potter series.', '2026-03-17 17:51:00'),
(20, '9780439358071', 'Harry Potter and the Order of the Phoenix', 'J.K. Rowling', 'Fantasy', 'Bloomsbury', 2003, 7, 3, 'B-02-09', 'The fifth book in the Harry Potter series.', '2026-03-17 17:51:00'),
(21, '9780439785969', 'Harry Potter and the Half-Blood Prince', 'J.K. Rowling', 'Fantasy', 'Bloomsbury', 2005, 7, 4, 'B-02-10', 'The sixth book in the Harry Potter series.', '2026-03-17 17:51:00'),
(22, '9780545139700', 'Harry Potter and the Deathly Hallows', 'J.K. Rowling', 'Fantasy', 'Bloomsbury', 2007, 8, 5, 'B-02-11', 'The seventh and final book in the Harry Potter series.', '2026-03-17 17:51:00'),
(23, '9780142000670', 'Of Mice and Men', 'John Steinbeck', 'Classic', 'Covici Friede', 1937, 4, 3, 'A-01-06', 'A novella about two displaced migrant workers during the Great Depression.', '2026-03-17 17:51:00'),
(24, '9780060850524', 'Brave New World', 'Aldous Huxley', 'Science Fiction', 'Chatto & Windus', 1932, 3, 2, 'C-03-04', 'A dystopian novel set in a futuristic World State.', '2026-03-17 17:51:00'),
(25, '9780679720201', 'The Stranger', 'Albert Camus', 'Philosophical Fiction', 'Gallimard', 1942, 2, 1, 'A-03-01', 'A classic existentialist novel about a French Algerian man.', '2026-03-17 17:51:00'),
(26, '9780812972159', 'The Shining', 'Stephen King', 'Horror', 'Doubleday', 1977, 4, 3, 'D-01-01', 'A horror novel about a family who becomes caretakers of an isolated hotel.', '2026-03-17 17:51:00'),
(27, '9781501142970', 'It', 'Stephen King', 'Horror', 'Viking', 1986, 5, 4, 'D-01-02', 'A horror novel about seven children terrorized by an evil entity.', '2026-03-17 17:51:00'),
(28, '9780385514231', 'The Da Vinci Code', 'Dan Brown', 'Mystery', 'Doubleday', 2003, 6, 4, 'D-02-01', 'A mystery thriller novel about a conspiracy in the Catholic Church.', '2026-03-17 17:51:00'),
(29, '9780307474278', 'Gone Girl', 'Gillian Flynn', 'Thriller', 'Crown Publishing', 2012, 4, 3, 'D-02-02', 'A thriller novel about a woman who goes missing on her fifth wedding anniversary.', '2026-03-17 17:51:00'),
(30, '9780735219090', 'The Silent Patient', 'Alex Michaelides', 'Thriller', 'Celadon Books', 2019, 5, 4, 'D-02-03', 'A psychological thriller about a woman who stops speaking after a violent act.', '2026-03-17 17:51:00'),
(31, '9780385490818', 'The Handmaid\'s Tale', 'Margaret Atwood', 'Dystopian', 'McClelland and Stewart', 1985, 3, 2, 'C-04-02', 'A dystopian novel set in a totalitarian society called Gilead.', '2026-03-17 17:51:00'),
(32, '9781400033416', 'The Namesake', 'Jhumpa Lahiri', 'Literary Fiction', 'Houghton Mifflin', 2003, 2, 2, 'A-02-03', 'A novel about the Ganguli family and their experiences as immigrants.', '2026-03-17 17:51:00'),
(33, '9780375704024', 'The Blind Assassin', 'Margaret Atwood', 'Historical Fiction', 'McClelland and Stewart', 2000, 2, 1, 'A-02-04', 'A novel-within-a-novel about two sisters growing up in Canada.', '2026-03-17 17:51:00'),
(34, '9780345803481', 'The Goldfinch', 'Donna Tartt', 'Literary Fiction', 'Little, Brown and Company', 2013, 3, 2, 'A-02-05', 'A novel about a boy who steals a famous painting after a terrorist attack.', '2026-03-17 17:51:00'),
(35, '9780679760801', 'Norwegian Wood', 'Haruki Murakami', 'Literary Fiction', 'Kodansha', 1987, 3, 2, 'A-03-02', 'A nostalgic story of loss and sexuality set in 1960s Tokyo.', '2026-03-17 17:51:00'),
(36, '9781400079278', 'Kafka on the Shore', 'Haruki Murakami', 'Magical Realism', 'Shinchosha', 2002, 2, 1, 'A-03-03', 'A surreal story about a teenage boy and an aging simpleton.', '2026-03-17 17:51:00'),
(37, '9780385721792', 'The Time Traveler\'s Wife', 'Audrey Niffenegger', 'Romance', 'MacAdam/Cage', 2003, 4, 3, 'E-01-01', 'A love story about a man with a genetic disorder that causes time travel.', '2026-03-17 17:51:00'),
(38, '9780452282157', 'Memoirs of a Geisha', 'Arthur Golden', 'Historical Fiction', 'Alfred A. Knopf', 1997, 3, 2, 'A-02-06', 'A novel about a geisha working in Kyoto before World War II.', '2026-03-17 17:51:00'),
(39, '9780062024039', 'The Help', 'Kathryn Stockett', 'Historical Fiction', 'Penguin Books', 2009, 5, 4, 'A-02-07', 'A novel about African American maids in 1960s Mississippi.', '2026-03-17 17:51:00'),
(40, '9780316769174', 'The Catcher in the Rye', 'J.D. Salinger', 'Classic', 'Little, Brown and Company', 1951, 3, 2, 'A-01-07', 'Another copy of the classic novel about teenage alienation.', '2026-03-17 17:51:00'),
(41, '9780743477123', 'Romeo and Juliet', 'William Shakespeare', 'Drama', 'Thomas Creede', 1597, 2, 2, 'F-01-01', 'A tragedy about two young star-crossed lovers.', '2026-03-17 17:51:00'),
(42, '9780743477116', 'Hamlet', 'William Shakespeare', 'Drama', 'N. Ling', 1603, 2, 1, 'F-01-02', 'A tragedy about Prince Hamlet and his quest for revenge.', '2026-03-17 17:51:00'),
(43, '9780141395204', 'Pride and Prejudice', 'Jane Austen', 'Classic', 'T. Egerton', 1813, 4, 3, 'A-01-08', 'A romantic novel about Elizabeth Bennet and Mr. Darcy.', '2026-03-17 17:51:00'),
(44, '9780141439518', 'Jane Eyre', 'Charlotte Brontë', 'Classic', 'Smith, Elder & Co.', 1847, 3, 2, 'A-01-09', 'A novel about an orphaned girl\'s journey to womanhood.', '2026-03-17 17:51:00'),
(45, '9780142437220', 'Moby-Dick', 'Herman Melville', 'Adventure', 'Harper & Brothers', 1851, 2, 1, 'G-01-01', 'A novel about Captain Ahab\'s obsession with a white whale.', '2026-03-17 17:51:00'),
(46, '9780143039952', 'Crime and Punishment', 'Fyodor Dostoevsky', 'Philosophical Fiction', 'The Russian Messenger', 1866, 3, 2, 'A-03-04', 'A novel about the mental anguish of a impoverished student who commits a crime.', '2026-03-17 17:51:00'),
(47, '9780140449266', 'War and Peace', 'Leo Tolstoy', 'Historical Fiction', 'The Russian Messenger', 1869, 2, 1, 'A-02-08', 'A novel about five families during the Napoleonic Wars.', '2026-03-17 17:51:00'),
(48, '9780141185071', 'The Picture of Dorian Gray', 'Oscar Wilde', 'Philosophical Fiction', 'Lippincott\'s Monthly Magazine', 1890, 3, 2, 'A-03-05', 'A novel about a man who remains youthful while his portrait ages.', '2026-03-17 17:51:00'),
(49, '9780141182551', 'The Old Man and the Sea', 'Ernest Hemingway', 'Literary Fiction', 'Charles Scribner\'s Sons', 1952, 4, 3, 'A-02-09', 'A novella about an aging fisherman\'s struggle with a giant marlin.', '2026-03-17 17:51:00'),
(50, '9780141185484', 'Slaughterhouse-Five', 'Kurt Vonnegut', 'Science Fiction', 'Delacorte Press', 1969, 3, 0, 'C-03-05', 'A science fiction-infused novel about World War II soldier Billy Pilgrim.', '2026-03-17 17:51:00');

-- --------------------------------------------------------

--
-- Table structure for table `issued_books`
--

CREATE TABLE `issued_books` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `book_id` int(11) NOT NULL,
  `issue_date` date NOT NULL,
  `due_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('issued','returned','overdue') DEFAULT 'issued',
  `fine_amount` decimal(10,2) DEFAULT 0.00,
  `remarks` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `issued_books`
--

INSERT INTO `issued_books` (`id`, `student_id`, `book_id`, `issue_date`, `due_date`, `return_date`, `status`, `fine_amount`, `remarks`) VALUES
(1, 'STU24100', 50, '2026-03-17', '2026-03-31', NULL, 'issued', 0.00, NULL),
(2, 'STU24100', 50, '2026-03-17', '2026-03-31', NULL, 'issued', 0.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `setting_key` varchar(100) NOT NULL,
  `setting_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`) VALUES
(1, 'library_name', 'Mukesh Library'),
(2, 'library_address', '123 Library Street, City'),
(3, 'library_phone', '+1234567890'),
(4, 'library_email', 'library@example.com'),
(5, 'fine_per_day', '5.00'),
(6, 'max_books_per_student', '3'),
(7, 'loan_period_days', '14');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `department` varchar(100) DEFAULT NULL,
  `semester` int(2) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `student_id`, `name`, `email`, `phone`, `department`, `semester`, `address`, `created_at`) VALUES
(1, 'STU24001', 'Rahul Kumar', 'rahul.kumar@email.com', '9876543210', 'Computer Science', 3, 'Delhi', '2026-03-17 17:52:17'),
(2, 'STU24002', 'Priya Singh', 'priya.singh@email.com', '9876543211', 'Mathematics', 5, 'Mumbai', '2026-03-17 17:52:17'),
(3, 'STU24003', 'Amit Sharma', 'amit.sharma@email.com', '9876543212', 'Physics', 1, 'Jaipur', '2026-03-17 17:52:17'),
(4, 'STU24004', 'Neha Gupta', 'neha.gupta@email.com', '9876543213', 'Chemistry', 3, 'Lucknow', '2026-03-17 17:52:17'),
(5, 'STU24005', 'Vikas Patel', 'vikas.patel@email.com', '9876543214', 'Biology', 5, 'Patna', '2026-03-17 17:52:17'),
(6, 'STU24006', 'Sneha Reddy', 'sneha.reddy@email.com', '9876543215', 'Computer Science', 2, 'Hyderabad', '2026-03-17 17:52:17'),
(7, 'STU24007', 'Rajesh Yadav', 'rajesh.yadav@email.com', '9876543216', 'Commerce', 4, 'Agra', '2026-03-17 17:52:17'),
(8, 'STU24008', 'Pooja Jain', 'pooja.jain@email.com', '9876543217', 'English', 6, 'Indore', '2026-03-17 17:52:17'),
(9, 'STU24009', 'Suraj Singh', 'suraj.singh@email.com', '9876543218', 'History', 2, 'Bhopal', '2026-03-17 17:52:17'),
(10, 'STU24010', 'Anjali Mishra', 'anjali.mishra@email.com', '9876543219', 'Political Science', 4, 'Chandigarh', '2026-03-17 17:52:17'),
(11, 'STU24011', 'Mohit Chauhan', 'mohit.chauhan@email.com', '9876543220', 'Economics', 6, 'Nagpur', '2026-03-17 17:52:17'),
(12, 'STU24012', 'Deepika Joshi', 'deepika.joshi@email.com', '9876543221', 'Psychology', 1, 'Pune', '2026-03-17 17:52:17'),
(13, 'STU24013', 'Akash Verma', 'akash.verma@email.com', '9876543222', 'Sociology', 3, 'Surat', '2026-03-17 17:52:17'),
(14, 'STU24014', 'Riya Kapoor', 'riya.kapoor@email.com', '9876543223', 'Geography', 5, 'Varanasi', '2026-03-17 17:52:17'),
(15, 'STU24015', 'Gaurav Tiwari', 'gaurav.tiwari@email.com', '9876543224', 'Computer Science', 2, 'Amritsar', '2026-03-17 17:52:17'),
(16, 'STU24016', 'Simran Kaur', 'simran.kaur@email.com', '9876543225', 'Mathematics', 4, 'Ludhiana', '2026-03-17 17:52:17'),
(17, 'STU24017', 'Nitin Rawat', 'nitin.rawat@email.com', '9876543226', 'Physics', 6, 'Dehradun', '2026-03-17 17:52:17'),
(18, 'STU24018', 'Tanu Shrivastava', 'tanu.shrivastava@email.com', '9876543227', 'Chemistry', 1, 'Ranchi', '2026-03-17 17:52:17'),
(19, 'STU24019', 'Abhishek Tripathi', 'abhishek.tripathi@email.com', '9876543228', 'Biology', 3, 'Jabalpur', '2026-03-17 17:52:17'),
(20, 'STU24020', 'Nidhi Agarwal', 'nidhi.agarwal@email.com', '9876543229', 'Computer Science', 5, 'Guwahati', '2026-03-17 17:52:17'),
(21, 'STU24021', 'Aditya Pandey', 'aditya.pandey@email.com', '9876543230', 'Commerce', 2, 'Mysore', '2026-03-17 17:52:17'),
(22, 'STU24022', 'Kajal Shah', 'kajal.shah@email.com', '9876543231', 'English', 4, 'Vadodara', '2026-03-17 17:52:17'),
(23, 'STU24023', 'Vishal Gupta', 'vishal.gupta@email.com', '9876543232', 'History', 6, 'Kochi', '2026-03-17 17:52:17'),
(24, 'STU24024', 'Sakshi Sharma', 'sakshi.sharma@email.com', '9876543233', 'Political Science', 1, 'Bhubaneswar', '2026-03-17 17:52:17'),
(25, 'STU24025', 'Harsh Vardhan', 'harsh.vardhan@email.com', '9876543234', 'Economics', 3, 'Jodhpur', '2026-03-17 17:52:17'),
(26, 'STU24026', 'Shruti Menon', 'shruti.menon@email.com', '9876543235', 'Psychology', 5, 'Thiruvananthapuram', '2026-03-17 17:52:17'),
(27, 'STU24027', 'Karan Singh', 'karan.singh@email.com', '9876543236', 'Sociology', 2, 'Udaipur', '2026-03-17 17:52:17'),
(28, 'STU24028', 'Disha Patil', 'disha.patil@email.com', '9876543237', 'Geography', 4, 'Kolhapur', '2026-03-17 17:52:17'),
(29, 'STU24029', 'Ayush Sharma', 'ayush.sharma@email.com', '9876543238', 'Computer Science', 6, 'Nashik', '2026-03-17 17:52:17'),
(30, 'STU24030', 'Pranav Khanna', 'pranav.khanna@email.com', '9876543239', 'Mathematics', 1, 'Amravati', '2026-03-17 17:52:17'),
(31, 'STU24031', 'Chetna Rathore', 'chetna.rathore@email.com', '9876543240', 'Physics', 3, 'Aurangabad', '2026-03-17 17:52:17'),
(32, 'STU24032', 'Sameer Das', 'sameer.das@email.com', '9876543241', 'Chemistry', 5, 'Durgapur', '2026-03-17 17:52:17'),
(33, 'STU24033', 'Mansi Desai', 'mansi.desai@email.com', '9876543242', 'Biology', 2, 'Belgaum', '2026-03-17 17:52:17'),
(34, 'STU24034', 'Yash Mehta', 'yash.mehta@email.com', '9876543243', 'Computer Science', 4, 'Gaya', '2026-03-17 17:52:17'),
(35, 'STU24035', 'Shivani Dubey', 'shivani.dubey@email.com', '9876543244', 'Commerce', 6, 'Tiruchirappalli', '2026-03-17 17:52:17'),
(36, 'STU24036', 'Ravi Kant', 'ravi.kant@email.com', '9876543245', 'English', 1, 'Bareilly', '2026-03-17 17:52:17'),
(37, 'STU24037', 'Garima Saxena', 'garima.saxena@email.com', '9876543246', 'History', 3, 'Aligarh', '2026-03-17 17:52:17'),
(38, 'STU24038', 'Aryan Bhatt', 'aryan.bhatt@email.com', '9876543247', 'Political Science', 5, 'Moradabad', '2026-03-17 17:52:17'),
(39, 'STU24039', 'Priyanka Chaudhary', 'priyanka.chaudhary@email.com', '9876543248', 'Economics', 2, 'Kollam', '2026-03-17 17:52:17'),
(40, 'STU24040', 'Dhruv Malik', 'dhruv.malik@email.com', '9876543249', 'Psychology', 4, 'Kurukshetra', '2026-03-17 17:52:17'),
(41, 'STU24041', 'Arpita Saha', 'arpita.saha@email.com', '9876543250', 'Sociology', 6, 'Panaji', '2026-03-17 17:52:17'),
(42, 'STU24042', 'Lalit Mohan', 'lalit.mohan@email.com', '9876543251', 'Geography', 1, 'Siliguri', '2026-03-17 17:52:17'),
(43, 'STU24043', 'Kiran Bala', 'kiran.bala@email.com', '9876543252', 'Computer Science', 3, 'Dhanbad', '2026-03-17 17:52:17'),
(44, 'STU24044', 'Ajay Singh', 'ajay.singh@email.com', '9876543253', 'Mathematics', 5, 'Bokaro', '2026-03-17 17:52:17'),
(45, 'STU24045', 'Vaishali Pawar', 'vaishali.pawar@email.com', '9876543254', 'Physics', 2, 'Bikaner', '2026-03-17 17:52:17'),
(46, 'STU24046', 'Shivam Jha', 'shivam.jha@email.com', '9876543255', 'Chemistry', 4, 'Haridwar', '2026-03-17 17:52:17'),
(47, 'STU24047', 'Saloni Kumari', 'saloni.kumari@email.com', '9876543256', 'Biology', 6, 'Rishikesh', '2026-03-17 17:52:17'),
(48, 'STU24048', 'Devansh Goyal', 'devansh.goyal@email.com', '9876543257', 'Computer Science', 1, 'Rohtak', '2026-03-17 17:52:17'),
(49, 'STU24049', 'Alka Singh', 'alka.singh@email.com', '9876543258', 'Commerce', 3, 'Hisar', '2026-03-17 17:52:17'),
(50, 'STU24050', 'Tarun Sethi', 'tarun.sethi@email.com', '9876543259', 'English', 5, 'Panchkula', '2026-03-17 17:52:17'),
(51, 'STU24051', 'Shreya Banerjee', 'shreya.banerjee@email.com', '9876543260', 'History', 2, 'Howrah', '2026-03-17 17:52:17'),
(52, 'STU24052', 'Aniket Pathak', 'aniket.pathak@email.com', '9876543261', 'Political Science', 4, 'Gorakhpur', '2026-03-17 17:52:17'),
(53, 'STU24053', 'Saumya Tiwari', 'saumya.tiwari@email.com', '9876543262', 'Economics', 6, 'Faizabad', '2026-03-17 17:52:17'),
(54, 'STU24054', 'Mukesh Kumar', 'mukesh.kumar@email.com', '9876543263', 'Psychology', 1, 'Mathura', '2026-03-17 17:52:17'),
(55, 'STU24055', 'Bhavna Solanki', 'bhavna.solanki@email.com', '9876543264', 'Sociology', 3, 'Jhansi', '2026-03-17 17:52:17'),
(56, 'STU24056', 'Sachin Meena', 'sachin.meena@email.com', '9876543265', 'Geography', 5, 'Kota', '2026-03-17 17:52:17'),
(57, 'STU24057', 'Aarti Yadav', 'aarti.yadav@email.com', '9876543266', 'Computer Science', 2, 'Ajmer', '2026-03-17 17:52:17'),
(58, 'STU24058', 'Rohit Choudhary', 'rohit.choudhary@email.com', '9876543267', 'Mathematics', 4, 'Gwalior', '2026-03-17 17:52:17'),
(59, 'STU24059', 'Tanishka Verma', 'tanishka.verma@email.com', '9876543268', 'Physics', 6, 'Ujjain', '2026-03-17 17:52:17'),
(60, 'STU24060', 'Abhinav Sharma', 'abhinav.sharma@email.com', '9876543269', 'Chemistry', 1, 'Raipur', '2026-03-17 17:52:17'),
(61, 'STU24061', 'Isha Nair', 'isha.nair@email.com', '9876543270', 'Biology', 3, 'Durg', '2026-03-17 17:52:17'),
(62, 'STU24062', 'Saurabh Shukla', 'saurabh.shukla@email.com', '9876543271', 'Computer Science', 5, 'Bilaspur', '2026-03-17 17:52:17'),
(63, 'STU24063', 'Megha Reddy', 'megha.reddy@email.com', '9876543272', 'Commerce', 2, 'Karnal', '2026-03-17 17:52:17'),
(64, 'STU24064', 'Arjun Singh', 'arjun.singh@email.com', '9876543273', 'English', 4, 'Sonipat', '2026-03-17 17:52:17'),
(65, 'STU24065', 'Supriya Pal', 'supriya.pal@email.com', '9876543274', 'History', 6, 'Faridabad', '2026-03-17 17:52:17'),
(66, 'STU24066', 'Kunal Das', 'kunal.das@email.com', '9876543275', 'Political Science', 1, 'Ghaziabad', '2026-03-17 17:52:17'),
(67, 'STU24067', 'Shagun Chawla', 'shagun.chawla@email.com', '9876543276', 'Economics', 3, 'Noida', '2026-03-17 17:52:17'),
(68, 'STU24068', 'Himanshu Garg', 'himanshu.garg@email.com', '9876543277', 'Psychology', 5, 'Meerut', '2026-03-17 17:52:17'),
(69, 'STU24069', 'Rashmi Singh', 'rashmi.singh@email.com', '9876543278', 'Sociology', 2, 'Shimla', '2026-03-17 17:52:17'),
(70, 'STU24070', 'Amandeep Kaur', 'amandeep.kaur@email.com', '9876543279', 'Geography', 4, 'Jammu', '2026-03-17 17:52:17'),
(71, 'STU24071', 'Kamlesh Yadav', 'kamlesh.yadav@email.com', '9876543280', 'Computer Science', 6, 'Srinagar', '2026-03-17 17:52:17'),
(72, 'STU24072', 'Damini Chaudhary', 'damini.chaudhary@email.com', '9876543281', 'Mathematics', 1, 'Kullu', '2026-03-17 17:52:17'),
(73, 'STU24073', 'Vivek Ojha', 'vivek.ojha@email.com', '9876543282', 'Physics', 3, 'Mandi', '2026-03-17 17:52:17'),
(74, 'STU24074', 'Aditi Rao', 'aditi.rao@email.com', '9876543283', 'Chemistry', 5, 'Dharamshala', '2026-03-17 17:52:17'),
(75, 'STU24075', 'Naveen Kumar', 'naveen.kumar@email.com', '9876543284', 'Biology', 2, 'Palampur', '2026-03-17 17:52:17'),
(76, 'STU24076', 'Ranjana Singh', 'ranjana.singh@email.com', '9876543285', 'Computer Science', 4, 'Kangra', '2026-03-17 17:52:17'),
(77, 'STU24077', 'Akshay Gupta', 'akshay.gupta@email.com', '9876543286', 'Commerce', 6, 'Una', '2026-03-17 17:52:17'),
(78, 'STU24078', 'Vibha Sharma', 'vibha.sharma@email.com', '9876543287', 'English', 1, 'Bilaspur', '2026-03-17 17:52:17'),
(79, 'STU24079', 'Ashish Kumar', 'ashish.kumar@email.com', '9876543288', 'History', 3, 'Hamirpur', '2026-03-17 17:52:17'),
(80, 'STU24080', 'Deepali Chauhan', 'deepali.chauhan@email.com', '9876543289', 'Political Science', 5, 'Chamba', '2026-03-17 17:52:17'),
(81, 'STU24081', 'Manish Singh', 'manish.singh@email.com', '9876543290', 'Economics', 2, 'Kathua', '2026-03-17 17:52:17'),
(82, 'STU24082', 'Harshita Rai', 'harshita.rai@email.com', '9876543291', 'Psychology', 4, 'Udhampur', '2026-03-17 17:52:17'),
(83, 'STU24083', 'Rinku Yadav', 'rinku.yadav@email.com', '9876543292', 'Sociology', 6, 'Rajouri', '2026-03-17 17:52:17'),
(84, 'STU24084', 'Sourav Ghosh', 'sourav.ghosh@email.com', '9876543293', 'Geography', 1, 'Puducherry', '2026-03-17 17:52:17'),
(85, 'STU24085', 'Palak Sharma', 'palak.sharma@email.com', '9876543294', 'Computer Science', 3, 'Port Blair', '2026-03-17 17:52:17'),
(86, 'STU24086', 'Sunil Kumar', 'sunil.kumar@email.com', '9876543295', 'Mathematics', 5, 'Daman', '2026-03-17 17:52:17'),
(87, 'STU24087', 'Kavita Patel', 'kavita.patel@email.com', '9876543296', 'Physics', 2, 'Diu', '2026-03-17 17:52:17'),
(88, 'STU24088', 'Prakash Rao', 'prakash.rao@email.com', '9876543297', 'Chemistry', 4, 'Silvassa', '2026-03-17 17:52:17'),
(89, 'STU24089', 'Jyoti Singh', 'jyoti.singh@email.com', '9876543298', 'Biology', 6, 'Lucknow', '2026-03-17 17:52:17'),
(90, 'STU24090', 'Aravind Kumar', 'aravind.kumar@email.com', '9876543299', 'Computer Science', 1, 'Kanpur', '2026-03-17 17:52:17'),
(91, 'STU24091', 'Shalini Mishra', 'shalini.mishra@email.com', '9876543300', 'Commerce', 3, 'Allahabad', '2026-03-17 17:52:17'),
(92, 'STU24092', 'Deepak Verma', 'deepak.verma@email.com', '9876543301', 'English', 5, 'Varanasi', '2026-03-17 17:52:17'),
(93, 'STU24093', 'Smriti Singh', 'smriti.singh@email.com', '9876543302', 'History', 2, 'Agra', '2026-03-17 17:52:17'),
(94, 'STU24094', 'Anupriya Gupta', 'anupriya.gupta@email.com', '9876543303', 'Political Science', 4, 'Mathura', '2026-03-17 17:52:17'),
(95, 'STU24095', 'Rajat Sharma', 'rajat.sharma@email.com', '9876543304', 'Economics', 6, 'Jhansi', '2026-03-17 17:52:17'),
(96, 'STU24096', 'Saumya Singh', 'saumya.singh@email.com', '9876543305', 'Psychology', 1, 'Bareilly', '2026-03-17 17:52:17'),
(97, 'STU24097', 'Akanksha Yadav', 'akanksha.yadav@email.com', '9876543306', 'Sociology', 3, 'Moradabad', '2026-03-17 17:52:17'),
(98, 'STU24098', 'Prashant Kumar', 'prashant.kumar@email.com', '9876543307', 'Geography', 5, 'Aligarh', '2026-03-17 17:52:17'),
(99, 'STU24099', 'Shweta Singh', 'shweta.singh@email.com', '9876543308', 'Computer Science', 2, 'Gorakhpur', '2026-03-17 17:52:17'),
(100, 'STU24100', 'Vikram Singh', 'vikram.singh@email.com', '9876543309', 'Mathematics', 4, 'Faizabad', '2026-03-17 17:52:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issued_books`
--
ALTER TABLE `issued_books`
  ADD PRIMARY KEY (`id`),
  ADD KEY `student_id` (`student_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_id` (`student_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `issued_books`
--
ALTER TABLE `issued_books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `issued_books`
--
ALTER TABLE `issued_books`
  ADD CONSTRAINT `issued_books_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `students` (`student_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `issued_books_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
