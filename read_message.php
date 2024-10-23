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
$sql = "SELECT buzzers.id AS buzzer_id, buzzers.device_number
        FROM buzzers
        INNER JOIN users ON users.id = buzzers.user_id
        WHERE users.username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();
$buzzers = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read Messages</title>
    <link href="./bootstrap5/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container mt-5 vh-100">
    <h2 class="text-center mb-4 text-white">Read Messages</h2>
    <?php if (isset($_GET['status'])): ?>
        <?php if ($_GET['status'] === 'error'): ?>
            <div class="alert alert-danger" role="alert">
                Error retrieving messages. Please try again.
            </div>
        <?php elseif ($_GET['status'] === 'no_messages'): ?>
            <div class="alert alert-warning" role="alert">
                No messages found for the selected buzzer.
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <form id="read-message-form" action="read_message_process.php" method="post" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="buzzer_id" class="form-label text-white">Select Buzzer</label>
            <select id="buzzer_id" name="buzzer_id" class="form-select" required>
                <option value="" disabled selected>Select your buzzer</option>
                <?php foreach ($buzzers as $buzzer): ?>
                    <option value="<?php echo htmlspecialchars($buzzer['buzzer_id']); ?>">
                        <?php echo htmlspecialchars($buzzer['device_number']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <div class="invalid-feedback bg-danger p-2 text-white">
                Please select a buzzer.
            </div>
        </div>
        <button type="submit" name="action" value="read" class="btn btn-primary">Read Messages</button>
    </form>

    <?php if (isset($_GET['messages'])): ?>
        <h3 class="mt-4 text-white">Messages for Device Number: <?php echo htmlspecialchars($_GET['device_number']); ?></h3>
        <ul class="list-group">
            <?php foreach (json_decode($_GET['messages'], true) as $message): ?>
                <li class="list-group-item"><?php echo htmlspecialchars($message); ?></li>
            <?php endforeach; ?>
        </ul>
        <form id="decrypt-message-form" action="read_message_process.php" method="post" class="mt-3">
            <input type="hidden" name="buzzer_id" value="<?php echo htmlspecialchars($_GET['buzzer_id']); ?>">
            <button type="submit" name="action" value="decrypt" class="btn btn-secondary">Decrypt Messages</button>
        </form>
    <?php endif; ?>
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
