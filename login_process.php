<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'buzzer_system');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password_hash'])) {
        // Store user details in session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $username;
        $_SESSION['device_number'] = $user['device_number']; // Store device number in session
        header("Location: index.php");
    } else {
        header("Location: login.php?error=invalid");
    }
} else {
    header("Location: login.php?error=notfound");
}

$stmt->close();
$conn->close();
?>
