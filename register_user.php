<?php
include("db/db_config.php");

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
if ($conn->query($sql)) {
    header("Location: index.html");
} else {
    echo "Error: " . $conn->error;
}
?>
