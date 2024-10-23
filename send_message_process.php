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

$device_number = $_POST['device_number'];
$message = $_POST['message'];

// Validate input
if (empty($device_number) || empty($message)) {
    header("Location: send_message.php?status=error");
    exit();
}

// Fetch the buzzer id for the given device number
$sql = "SELECT id FROM buzzers WHERE device_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $device_number);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $buzzer = $result->fetch_assoc();
    $buzzer_id = $buzzer['id'];

    // Encrypt the message
    $encryption_key = 'your_secret_key'; // Use a secure key
    $iv = openssl_random_pseudo_bytes(16);
    $encrypted_message = openssl_encrypt($message, 'aes-256-cbc', $encryption_key, 0, $iv);
    $encrypted_message = base64_encode($encrypted_message . '::' . $iv);

    // Insert the message into the messages table
    $sql = "INSERT INTO messages (buzzer_id, encrypted_message) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $buzzer_id, $encrypted_message);

    if ($stmt->execute()) {
        header("Location: send_message.php?status=success");
    } else {
        header("Location: send_message.php?status=error");
    }
} else {
    header("Location: send_message.php?status=error");
}

$stmt->close();
$conn->close();
?>
