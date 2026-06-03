<?php 
require_once 'core/config.php';
// Get personal info for header
$info_result = $conn->query("SELECT * FROM personal_info LIMIT 1");
$personal_info = $info_result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($personal_info['full_name'] ?? 'Portfolio') ?></title>
    
    <!-- Favicon -->
    <link rel="icon" href="<?= $base_url ?>/assets/images/favicon.png" type="image/png">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= $base_url ?>/assets/css/style.css?v=<?= time() ?>">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-premium" id="mainNav">
    <div class="container-fluid px-5">
        <a class="brand-text" href="<?= $base_url ?>/">STEVE<span>.</span></a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars text-white fs-4"></i>
        </button>
        
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <div class="navbar-nav">
                <a class="nav-link-premium <?= (!isset($_GET['url']) || $_GET['url'] == 'home' || $_GET['url'] == '') ? 'active' : '' ?>" href="<?= $base_url ?>/">Home</a>
                <a class="nav-link-premium <?= (isset($_GET['url']) && $_GET['url'] == 'about') ? 'active' : '' ?>" href="<?= $base_url ?>/about">About</a>
                <a class="nav-link-premium <?= (isset($_GET['url']) && $_GET['url'] == 'services') ? 'active' : '' ?>" href="<?= $base_url ?>/services">Services</a>
                <a class="nav-link-premium <?= (isset($_GET['url']) && $_GET['url'] == 'skills') ? 'active' : '' ?>" href="<?= $base_url ?>/skills">Skills</a>
                <a class="nav-link-premium <?= (isset($_GET['url']) && $_GET['url'] == 'certificates') ? 'active' : '' ?>" href="<?= $base_url ?>/certificates">Certificates</a>
                <a class="nav-link-premium <?= (isset($_GET['url']) && $_GET['url'] == 'portfolio') ? 'active' : '' ?>" href="<?= $base_url ?>/portfolio">Portfolio</a>
            </div>
        </div>
        
        <div class="d-none d-lg-flex align-items-center">
            <?php if (!empty($personal_info['linkedin'])): ?>
                <a href="<?= htmlspecialchars($personal_info['linkedin']) ?>" class="text-white me-3 fs-5" target="_blank"><i class="fab fa-linkedin-in"></i></a>
            <?php endif; ?>
            <?php if (!empty($personal_info['github'])): ?>
                <a href="<?= htmlspecialchars($personal_info['github']) ?>" class="text-white me-4 fs-5" target="_blank"><i class="fab fa-github"></i></a>
            <?php endif; ?>
            <a class="btn-cta-header" href="<?= $base_url ?>/contact">Contact Me</a>
        </div>
    </div>
</nav>

<div class="main-wrapper">
