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
$username = $_POST['username'];
$password = $_POST['password'];

// Validate input
if (empty($device_number) || empty($username) || empty($password)) {
    header("Location: create_buzzer.php?status=error");
    exit();
}

// Check if the username matches the logged-in username
if ($username !== $_SESSION['username']) {
    header("Location: create_buzzer.php?status=invalid_credentials");
    exit();
}

// Check if the password matches the logged-in user's password
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password_hash'])) {
        // Check if the buzzer already exists
        $sql = "SELECT * FROM buzzers WHERE device_number = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $device_number);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            header("Location: create_buzzer.php?status=exists");
        } else {
            // Create new buzzer
            $sql = "INSERT INTO buzzers (device_number, user_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('si', $device_number, $user['id']);
            
            if ($stmt->execute()) {
                header("Location: create_buzzer.php?status=success");
            } else {
                header("Location: create_buzzer.php?status=error");
            }
        }
    } else {
        header("Location: create_buzzer.php?status=invalid_credentials");
    }
} else {
    header("Location: create_buzzer.php?status=invalid_credentials");
}

$stmt->close();
$conn->close();
?>
