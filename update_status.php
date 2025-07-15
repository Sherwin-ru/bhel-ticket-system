<?php
session_start();
include("db/db_config.php");

if ($_SESSION['role'] !== 'admin') {
    header("Location: index.html");
    exit();
}

$ticket_id = $_POST['ticket_id'];
$status = $_POST['status'];

$sql = "UPDATE tickets SET status = '$status' WHERE id = $ticket_id";

if ($conn->query($sql)) {
    header("Location: admin.php");
} else {
    echo "Error updating status: " . $conn->error;
}
?>
