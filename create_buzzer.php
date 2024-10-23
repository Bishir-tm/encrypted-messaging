<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php?error=not_logged_in");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Buzzer</title>
    <link href="./bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5 vh-100">
    <h2 class="text-center mb-4 text-white">Create Buzzer</h2>
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'error'): ?>
            <div class="alert alert-danger" role="alert">
                Error creating buzzer. Please try again.
            </div>
        <?php elseif ($_GET['status'] === 'exists'): ?>
            <div class="alert alert-warning" role="alert">
                Device number already exists. Please try a different one.
            </div>
        <?php elseif ($_GET['status'] === 'invalid_credentials'): ?>
            <div class="alert alert-danger" role="alert">
                Invalid credentials. Please make sure your username and password match the logged-in user.
            </div>
        <?php elseif ($_GET['status'] === 'success'): ?>
            <div class="alert alert-success" role="alert">
                Buzzer created successfully!
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <form action="create_buzzer_process.php" method="post" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="device_number" class="form-label text-white">Device Number</label>
            <input type="text" class="form-control" id="device_number" name="device_number" required>
            <div class="invalid-feedback bg-danger p-2 text-white">
                Please provide a device number.
            </div>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label text-white">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
            <div class="invalid-feedback bg-danger p-2 text-white">
                Please provide your username.
            </div>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label text-white">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <div class="invalid-feedback bg-danger p-2 text-white">
                Please provide your password.
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Create Buzzer</button>
    </form>
</div>
<script>
    // Bootstrap client-side validation
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
<script src="bootstrap5/js/bootstrap.bundle.min.js"></script>
</body>
</html>
