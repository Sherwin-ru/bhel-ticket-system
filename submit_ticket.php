<?php
session_start();
include("db/db_config.php");

$user_id = $_SESSION['user_id'];
$title = $_POST['title'];
$description = $_POST['description'];

$sql = "INSERT INTO tickets (user_id, title, description) VALUES ('$user_id', '$title', '$description')";

if ($conn->query($sql)) {
    echo "<script>alert('Complaint Raised Successfully'); window.location.href='home.php';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
