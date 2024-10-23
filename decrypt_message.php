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

$buzzer_id = $_POST['buzzer_id'];

// Validate input
if (empty($buzzer_id)) {
    header("Location: read_message.php?status=error");
    exit();
}

// Get the device number for the selected buzzer
$sql = "SELECT device_number FROM buzzers WHERE id = ? AND user_id = (SELECT id FROM users WHERE username = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('is', $buzzer_id, $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $buzzer = $result->fetch_assoc();
    $device_number = $buzzer['device_number'];

    // Get the hashed messages for the buzzer
    $sql = "SELECT message FROM messages WHERE buzzer_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $buzzer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $messages = [];
        while ($row = $result->fetch_assoc()) {
            $messages[] = $row['message'];
        }
        header("Location: read_message.php?device_number=" . urlencode($device_number) . "&messages=" . urlencode(json_encode($messages)));
    } else {
        header("Location: read_message.php?status=no_messages&device_number=" . urlencode($device_number));
    }
} else {
    header("Location: read_message.php?status=error");
}

$stmt->close();
$conn->close();
?>
