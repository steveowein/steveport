<?php
session_start();
require_once '../core/config.php';

if (isset($_SESSION['admin_logged_in'])) {
    header("Location: index");
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    
    $result = $conn->query("SELECT * FROM users WHERE username = '$username'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $user['id'];
            header("Location: index");
            exit;
        } else {
            $error = 'Invalid credentials!';
        }
    } else {
        $error = 'Invalid credentials!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Steve Portfolio</title>
    <link rel="icon" href="../assets/images/favicon.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #0a0a0a;
            color: #ffffff;
            font-family: 'Syne', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-card {
            background-color: #141414;
            border: 1px solid rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 4px;
            width: 100%;
            max-width: 400px;
        }
        .form-control {
            background-color: transparent;
            border: 1px solid rgba(255,255,255,0.2);
            color: #fff;
        }
        .form-control:focus {
            background-color: transparent;
            color: #fff;
            border-color: #ffffff;
            box-shadow: none;
        }
        .btn-login {
            background: #ffffff;
            color: #0a0a0a;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            width: 100%;
        }
        
        .text-muted { color: #888888 !important; }
        label { color: #ffffff !important; font-weight: 600; }
    </style>
</head>
<body>
    <div class="login-card">
        <h3 class="mb-4 text-center">ADMIN LOGIN</h3>
        <?php if($error): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: '<?= $error ?>',
                        background: '#141414',
                        color: '#fff',
                        confirmButtonColor: '#fff'
                    });
                });
            </script>
        <?php endif; ?>
        <?php if(isset($_GET['logout'])): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Successfully logged out',
                        showConfirmButton: false,
                        timer: 3000,
                        background: '#141414',
                        color: '#fff'
                    });
                });
            </script>
        <?php endif; ?>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label text-muted">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-4">
                <label class="form-label text-muted">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-login py-2">Login</button>
        </form>
    </div>
</body>
</html>
