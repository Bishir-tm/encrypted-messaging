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

// Fetch user's own buzzers
$username = $_SESSION['username'];
$sql = "SELECT b.id, b.device_number FROM buzzers b
        JOIN users u ON b.user_id = u.id
        WHERE u.username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

$buzzers = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $buzzers[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Buzzer</title>
    <link href="./bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5">
    <h2 class="text-center mb-4 text-white">Start Buzzer</h2>
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'success'): ?>
            <div class="alert alert-success" role="alert">
                Buzzer started successfully!
            </div>
        <?php elseif ($_GET['status'] === 'error'): ?>
            <div class="alert alert-danger" role="alert">
                Error starting buzzer. Please try again.
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <form action="start_buzzer_process.php" method="post">
        <div class="mb-3">
            <label for="device_number" class="form-label text-white">Select Buzzer</label>
            <select class="form-select" id="device_number" name="device_number" required>
                <option value="">Choose...</option>
                <?php foreach ($buzzers as $buzzer): ?>
                    <option value="<?php echo htmlspecialchars($buzzer['device_number']); ?>"><?php echo htmlspecialchars($buzzer['device_number']); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback bg-danger p-2 text-white">
                Please select a buzzer.
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Start Buzzer</button>
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
