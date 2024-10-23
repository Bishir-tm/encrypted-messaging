<?php
session_start();
// Redirect already logged-in users to the home page
if (isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="./bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="">
    <?php include 'navbar.php'; ?>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 rounded-4 bg-dark" style="max-width: 400px;">
            <h2 class="text-center mb-4 text-white text-white"><?php $a = 16;
            $b=4; 
            $c = (((++$a)!=4) && (-$b ==4));
            echo $c;; ?></h2>
            
            <?php if (isset($_GET['error']) && $_GET['error'] === 'invalid'): ?>
                <div class="alert alert-danger" role="alert">
                    Invalid username or password. Please try again.
                </div>
            <?php elseif (isset($_GET['error']) && $_GET['error'] === 'notfound'): ?>
                <div class="alert alert-danger" role="alert">
                    User not found. Please check your username.
                </div>
            <?php elseif (isset($_GET['error']) && $_GET['error'] === 'not_logged_in'): ?>
                <div class="alert alert-warning" role="alert">
                    You need to log in to access this page.
                </div>
            <?php endif; ?>
            <form action="login_process.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label text-white">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-white">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
            </form>
            <p class="text-center mt-3"><a href="register.php">Create an account</a></p>
        </div>
    </div>
<script src="bootstrap5/js/bootstrap.bundle.min.js"></script>
</body>
</html>
