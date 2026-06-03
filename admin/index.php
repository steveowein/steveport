<?php
session_start();
require_once '../core/config.php';

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login");
    exit;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
$page_path = "pages/{$page}.php";

// Fetch unread messages count
$msg_res = $conn->query("SELECT COUNT(id) as unread FROM messages WHERE is_read = 0");
$unread_msgs = $msg_res ? $msg_res->fetch_assoc()['unread'] : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Steve</title>
    <link rel="icon" href="../assets/images/favicon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Syncopate:wght@400;700&family=Syne:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #0a0a0a;
            color: #ffffff;
            font-family: 'Syne', sans-serif;
            margin: 0;
            overflow-x: hidden;
        }
        .admin-wrapper {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            background-color: #141414;
            border-right: 1px solid rgba(255,255,255,0.1);
            display: flex;
            flex-direction: column;
        }
        .sidebar-brand {
            padding: 20px;
            font-family: 'Syncopate', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            color: #fff;
            text-decoration: none;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            text-align: center;
        }
        .sidebar-nav {
            flex: 1;
            padding: 20px 0;
            list-style: none;
            margin: 0;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #888;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        .sidebar-link:hover, .sidebar-link.active {
            color: #fff;
            background: rgba(255,255,255,0.05);
            border-left: 3px solid #fff;
        }
        .sidebar-link i {
            width: 25px;
            font-size: 1.1rem;
        }
        .badge-unread {
            background: #0d6efd;
            color: white;
            border-radius: 50%;
            padding: 2px 8px;
            font-size: 0.7rem;
            margin-left: auto;
        }
        .main-content {
            flex: 1;
            background-color: #0a0a0a;
            padding: 40px;
            overflow-y: auto;
            max-height: 100vh;
        }
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .admin-title {
            font-family: 'Syncopate', sans-serif;
            margin: 0;
        }
        .card-admin {
            background: #141414;
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 4px;
            padding: 25px;
            margin-bottom: 25px;
        }
        .form-control, .form-select {
            background-color: #0a0a0a;
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
        }
        .form-control:focus, .form-select:focus {
            background-color: #0a0a0a;
            color: #fff;
            border-color: #fff;
            box-shadow: none;
        }
        .table {
            color: #fff;
        }
        .table th {
            border-bottom-color: rgba(255,255,255,0.2);
            color: #888;
            font-weight: 600;
        }
        .table td {
            border-bottom-color: rgba(255,255,255,0.1);
            vertical-align: middle;
        }
        .btn-solid {
            background: #fff;
            color: #000;
            border: none;
            padding: 10px 20px;
            font-weight: 700;
        }
        .btn-solid:hover { background: #ccc; }
        .btn-danger-outline {
            background: transparent;
            color: #dc3545;
            border: 1px solid #dc3545;
        }
        .btn-danger-outline:hover { background: #dc3545; color: #fff; }
        
        /* Font visibility fixes for Admin Panel */
        .text-muted { color: #888888 !important; }
        .text-secondary { color: #aaaaaa !important; }
        label { color: #ffffff !important; font-weight: 600; }
        input::placeholder, textarea::placeholder { color: #666666 !important; }
        
        /* Hide old HTML status alerts since we use SweetAlert globally */
        .main-content > .alert { display: none !important; }
        
        @media (max-width: 768px) {
            .admin-wrapper {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid rgba(255,255,255,0.1);
            }
            .main-content {
                padding: 20px;
                max-height: none;
                overflow-y: visible;
            }
            .admin-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="index" class="sidebar-brand">STEVE ADMIN</a>
            <ul class="sidebar-nav">
                <li><a href="?page=dashboard" class="sidebar-link <?= $page == 'dashboard' ? 'active' : '' ?>"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
                <li><a href="?page=profile" class="sidebar-link <?= $page == 'profile' ? 'active' : '' ?>"><i class="fas fa-user-cog"></i> Profile & Settings</a></li>
                <li><a href="?page=about" class="sidebar-link <?= $page == 'about' ? 'active' : '' ?>"><i class="fas fa-address-card"></i> About</a></li>
                <li><a href="?page=services" class="sidebar-link <?= $page == 'services' ? 'active' : '' ?>"><i class="fas fa-layer-group"></i> Services</a></li>
                <li><a href="?page=skills" class="sidebar-link <?= $page == 'skills' ? 'active' : '' ?>"><i class="fas fa-star"></i> Skills</a></li>
                <li><a href="?page=certificates" class="sidebar-link <?= $page == 'certificates' ? 'active' : '' ?>"><i class="fas fa-award"></i> Certificates</a></li>
                <li><a href="?page=portfolio" class="sidebar-link <?= $page == 'portfolio' ? 'active' : '' ?>"><i class="fas fa-briefcase"></i> Portfolio</a></li>
                <li>
                    <a href="?page=messages" class="sidebar-link <?= $page == 'messages' ? 'active' : '' ?>">
                        <i class="fas fa-envelope"></i> Messages 
                        <?php if($unread_msgs > 0): ?><span class="badge-unread"><?= $unread_msgs ?></span><?php endif; ?>
                    </a>
                </li>
            </ul>
            <div style="padding: 20px;">
                <a href="logout" class="sidebar-link text-danger" style="padding: 10px; justify-content: center; border: 1px solid #dc3545; border-radius: 4px;"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <?php 
                if(file_exists($page_path)) {
                    include $page_path;
                } else {
                    echo "<div class='card-admin'><h3 class='text-danger'>Page Not Found</h3><p>The requested admin module does not exist.</p></div>";
                }
            ?>
        </div>
    </div>
    
    <!-- Global SweetAlert Handler for Admin Actions -->
    <?php if(isset($status) && $status != ''): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: '<?= (strpos(strtolower($status), "error") !== false || strpos(strtolower($status), "failed") !== false) ? "error" : "success" ?>',
                title: '<?= addslashes($status) ?>',
                showConfirmButton: false,
                timer: 3000,
                background: '#141414',
                color: '#fff'
            });
        });
    </script>
    <?php endif; ?>
    
    <script>
        // Global interceptor to upgrade native confirm() dialogs on forms to SweetAlert2
        document.addEventListener('click', function(e) {
            let btn = e.target.closest('button[type="submit"]');
            if (btn) {
                let form = btn.closest('form');
                let onsubmitVal = form ? form.getAttribute('onsubmit') : null;
                
                if (onsubmitVal && onsubmitVal.includes('confirm')) {
                    e.preventDefault();
                    let match = onsubmitVal.match(/confirm\(['"](.*?)['"]\)/);
                    let msg = match ? match[1] : "Are you sure you want to proceed?";
                    
                    Swal.fire({
                        title: 'Are you sure?',
                        text: msg,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#333333',
                        confirmButtonText: 'Yes, proceed',
                        background: '#141414',
                        color: '#ffffff'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.removeAttribute('onsubmit');
                            let hidden = document.createElement('input');
                            hidden.type = 'hidden';
                            hidden.name = btn.name;
                            hidden.value = btn.value || '1';
                            form.appendChild(hidden);
                            form.submit();
                        }
                    });
                }
            }
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
