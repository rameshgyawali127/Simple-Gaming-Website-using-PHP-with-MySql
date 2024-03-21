<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'ramesh');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}
?>