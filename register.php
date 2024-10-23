<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body class="bg-dark">
    <?php include 'navbar.php'; ?>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg p-4 rounded-4 bg-dark" style="max-width: 400px;">
            <h2 class="text-center mb-4 text-white text-white">Register</h2>
            <?php if (isset($_GET['error']) && $_GET['error'] === 'device_number_exists'): ?>
                <div class="alert alert-danger" role="alert">
                    Device number already exists. Please choose another.
                </div>
            <?php endif; ?>
            <form action="register_process.php" method="post">
                <div class="mb-3">
                    <label for="username" class="form-label text-white">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label text-white">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2">Register</button>
            </form>
            <p class="text-center mt-3"><a href="login.php">Already have an account? Login</a></p>
        </div>
    </div>
<script src="bootstrap5/js/bootstrap.bundle.min.js"></script>
</body>
</html>
