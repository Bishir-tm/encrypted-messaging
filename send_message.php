<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php?error=not_logged_in");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'buzzer_system');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all buzzers
$sql = "SELECT device_number FROM buzzers";
$result = $conn->query($sql);

$buzzers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $buzzers[] = $row['device_number'];
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
    <link href="./bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5 vh-100">
    <h2 class="text-center mb-4 text-white">Send Message</h2>
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'success'): ?>
            <div class="alert alert-success" role="alert">
                Message sent successfully!
            </div>
        <?php elseif ($_GET['status'] === 'error'): ?>
            <div class="alert alert-danger" role="alert">
                Error sending message. Please try again.
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <form action="send_message_process.php" method="post" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="device_number" class="form-label text-white">Select Buzzer</label>
            <select class="form-select" id="device_number" name="device_number" required>
                <option value="" disabled selected>Choose...</option>
                <?php foreach ($buzzers as $device_number): ?>
                    <option value="<?php echo htmlspecialchars($device_number); ?>"><?php echo htmlspecialchars($device_number); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback bg-danger p-2 text-white">
                Please select a buzzer.
            </div>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label text-white">Message</label>
            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Enter your message" required></textarea>
            <div class="invalid-feedback bg-danger p-2 text-white">
                Please enter a message.
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Send Message</button>
    </form>
</div>
<script>
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
