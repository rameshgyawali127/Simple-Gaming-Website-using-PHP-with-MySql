<?php
$con = mysqli_connect("localhost", "root", "", "testing");
if (mysqli_connect_error()) {
    echo "<script>alert('Cannot connect to the database');</script>";
    exit();
}
?>