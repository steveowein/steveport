<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$is_local = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']);

if ($is_local) {
    // Local configuration
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'portfolio_steve';
    $base_url = 'http://localhost/steve';
} else {
    // InfinityFree Production configuration
    $host = 'sql213.infinityfree.com';
    $username = 'if0_42011510';
    $password = 'wxUepqw3Xw9813';
    $dbname = 'if0_42011510_portfolio_steve';
    
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443 || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? "https://" : "http://";
    $base_url = $protocol . $_SERVER['HTTP_HOST'];
}

// Attempt to connect to MySQL server
if ($is_local) {
    $conn = new mysqli($host, $username, $password);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    // Create database if not exists locally
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) === TRUE) {
        $conn->select_db($dbname);
    } else {
        die("Error creating database: " . $conn->error);
    }
} else {
    // Connect directly to the specific database in production
    $conn = new mysqli($host, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
}

// Create Users Table (for Admin)
$conn->query("CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL
)");

// Create Personal Info Table
$conn->query("CREATE TABLE IF NOT EXISTS personal_info (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100),
    address VARCHAR(255),
    contact_number VARCHAR(50),
    email VARCHAR(100),
    linkedin VARCHAR(255),
    career_objective TEXT,
    profile_image VARCHAR(255) DEFAULT 'steve.jpg'
)");

// Insert default personal info if empty
$result = $conn->query("SELECT * FROM personal_info");
if ($result->num_rows == 0) {
    $conn->query("INSERT INTO personal_info (full_name, address, contact_number, email, linkedin, career_objective) 
    VALUES ('STEVE OWEIN G. PRESIDENTE', 'Balagunan, Sto. Tomas, Davao del Norte', '0993-461-7106', 'steveoweinpresidente@gmail.com', 'https://www.linkedin.com/in/steve-owein-presidente-68b28a409', 'Motivated Bachelor of Science in Information Systems student with practical experience in technical tasks, simple UI design in Figma, and SMAW operations. Desire to use problem solving, adaptability and teamwork skills in a professional setting, and to acquire industry experience and help the organization grow.')");
}

// Create other tables briefly
$conn->query("CREATE TABLE IF NOT EXISTS education (id INT(11) AUTO_INCREMENT PRIMARY KEY, degree VARCHAR(100), institution VARCHAR(100), year VARCHAR(50))");
$conn->query("CREATE TABLE IF NOT EXISTS experience (id INT(11) AUTO_INCREMENT PRIMARY KEY, role VARCHAR(100), date VARCHAR(50), description TEXT)");
$conn->query("CREATE TABLE IF NOT EXISTS skills (id INT(11) AUTO_INCREMENT PRIMARY KEY, skill_name VARCHAR(100))");
$conn->query("CREATE TABLE IF NOT EXISTS certificates (id INT(11) AUTO_INCREMENT PRIMARY KEY, title VARCHAR(100), issuer VARCHAR(100))");
$conn->query("CREATE TABLE IF NOT EXISTS services (id INT(11) AUTO_INCREMENT PRIMARY KEY, title VARCHAR(100), description TEXT, icon VARCHAR(50))");
$conn->query("CREATE TABLE IF NOT EXISTS portfolio (id INT(11) AUTO_INCREMENT PRIMARY KEY, title VARCHAR(100), description TEXT, image VARCHAR(255), link VARCHAR(255))");
$conn->query("CREATE TABLE IF NOT EXISTS messages (id INT(11) AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255), email VARCHAR(255), message TEXT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, is_read TINYINT(1) DEFAULT 0)");
$conn->query("CREATE TABLE IF NOT EXISTS visitors (id INT(11) AUTO_INCREMENT PRIMARY KEY, ip_address VARCHAR(50), visit_date DATE, visits INT DEFAULT 1)");


// Helper function for graceful alter tables
function add_column_if_not_exists(mysqli $conn, string $table, string $column_def) {
    try {
        @$conn->query("ALTER TABLE $table ADD COLUMN $column_def");
    } catch (Exception $e) {
        // Ignore errors
    }
}

add_column_if_not_exists($conn, 'skills', 'level INT DEFAULT 0');
add_column_if_not_exists($conn, 'skills', 'icon_image VARCHAR(255)');
add_column_if_not_exists($conn, 'skills', 'icon_class VARCHAR(100)');
add_column_if_not_exists($conn, 'certificates', 'month VARCHAR(20)');
add_column_if_not_exists($conn, 'certificates', 'year VARCHAR(10)');
add_column_if_not_exists($conn, 'certificates', 'image VARCHAR(255)');
add_column_if_not_exists($conn, 'certificates', 'keywords VARCHAR(255)');
add_column_if_not_exists($conn, 'certificates', 'description TEXT');
add_column_if_not_exists($conn, 'portfolio', 'tech_stack VARCHAR(255)');
add_column_if_not_exists($conn, 'portfolio', 'client VARCHAR(255)');
add_column_if_not_exists($conn, 'portfolio', 'project_date VARCHAR(50)');
add_column_if_not_exists($conn, 'portfolio', 'additional_images TEXT');
add_column_if_not_exists($conn, 'personal_info', 'hero_title VARCHAR(255)');
add_column_if_not_exists($conn, 'personal_info', 'hero_tagline VARCHAR(255)');
add_column_if_not_exists($conn, 'personal_info', 'github VARCHAR(255)');

// Insert default Admin user if empty (password is 'admin123')
$user_result = $conn->query("SELECT * FROM users");
if ($user_result->num_rows == 0) {
    $hashed_pw = password_hash('admin123', PASSWORD_DEFAULT);
    $conn->query("INSERT INTO users (username, password) VALUES ('admin', '$hashed_pw')");
}
?>
