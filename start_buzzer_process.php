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

$username = $_SESSION['username'];
$device_number = $_POST['device_number'];

// Prepare statement to fetch the buzzer id for the given device number and ensure it belongs to the logged-in user
$sql = "SELECT b.id FROM buzzers b
        JOIN users u ON b.user_id = u.id
        WHERE u.username = ? AND b.device_number = ?";
$stmt = $conn->prepare($sql);
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param('ss', $username, $device_number);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $buzzer = $result->fetch_assoc();
    $buzzer_id = $buzzer['id'];

    // Check if the buzzer is already started
    $sql = "SELECT * FROM messages WHERE buzzer_id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('i', $buzzer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Start the buzzer
        $sql = "INSERT INTO messages (buzzer_id, message, encrypted_message) VALUES (?, '', '')";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param('i', $buzzer_id);
        if ($stmt->execute()) {
            header("Location: start_buzzer.php?status=success");
        } else {
            header("Location: start_buzzer.php?status=error");
        }
    } else {
        header("Location: start_buzzer.php?status=exists");
    }
} else {
    header("Location: start_buzzer.php?status=error");
}

$stmt->close();
$conn->close();
?>
