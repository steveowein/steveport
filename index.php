<?php
// Main entry point and simple router
require_once 'core/config.php';

// Visitor Analytics Tracking
$ip_address = $_SERVER['REMOTE_ADDR'];
$visit_date = date('Y-m-d');
$check_visit = $conn->query("SELECT id FROM visitors WHERE ip_address = '$ip_address' AND visit_date = '$visit_date'");
if ($check_visit->num_rows > 0) {
    $conn->query("UPDATE visitors SET visits = visits + 1 WHERE ip_address = '$ip_address' AND visit_date = '$visit_date'");
} else {
    $conn->query("INSERT INTO visitors (ip_address, visit_date, visits) VALUES ('$ip_address', '$visit_date', 1)");
}

$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'home';

// Basic routing logic
$allowed_pages = ['home', 'about', 'services', 'skills', 'certificates', 'portfolio', 'contact', 'view-resume', 'project'];

if (in_array($url, $allowed_pages)) {
    $page = $url;
} else {
    // 404 fallback
    $page = 'home';
}

require_once 'components/header.php';

// Include the requested page
$file_path = "pages/{$page}.php";
if (file_exists($file_path)) {
    require_once $file_path;
} else {
    echo "<div class='container section-padding text-center'><h1>Page under construction</h1></div>";
}

require_once 'components/footer.php';
?>
