<?php
session_start();
include("db/db_config.php");

$id = $_GET['id'];

$conn->query("DELETE FROM tickets WHERE id=$id AND user_id={$_SESSION['user_id']} AND status != 'Resolved'");
header("Location: home.php");
?>
