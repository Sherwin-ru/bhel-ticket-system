<?php
session_start();
include("db/db_config.php");

$id = $_POST['id'];
$title = $_POST['title'];
$desc = $_POST['description'];

$conn->query("UPDATE tickets SET title='$title', description='$desc' WHERE id=$id AND user_id={$_SESSION['user_id']}");
header("Location: home.php");
?>
