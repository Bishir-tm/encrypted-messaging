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
    <title>Messages</title>
    <link href="./bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5 vh-100">
        <h2 class="text-center mb-4 display-1 text-white">Messages</h2>
        <div class="d-flex justify-content-center gap-3">
            <a href="Send_message.php" class="btn btn-dark border fs-3 btn-lg">Send Message</a>
            <a href="read_message.php" class="btn btn-dark border fs-3 btn-lg">Read Messages</a>
        </div>
    </div>
<script src="bootstrap5/js/bootstrap.bundle.min.js"></script>
</body>
</html>
