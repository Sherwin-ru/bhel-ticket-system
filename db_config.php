<?php
$conn = new mysqli("localhost", "root", "", "bhel_ticket_mgmt_rgb");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
