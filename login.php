<?php
session_start();
include("db/db_config.php");

$email = $_POST['email'];
$password = $_POST['password'];

$result = $conn->query("SELECT * FROM users WHERE email='$email'");

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        if ($user['role'] == 'admin') {
            header("Location: admin.php");
        } else {
            header("Location: home.php");
        }
    } else {
        echo "Invalid password.";
    }
} else {
    echo "No user found.";
}
?>
