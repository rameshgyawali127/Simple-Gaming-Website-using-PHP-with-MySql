<?php
// Include the database connection file
include('db_login.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate the form data
    $email = mysqli_real_escape_string($conn, $email); // Escape special characters to prevent SQL injection
    $password = mysqli_real_escape_string($conn, $password);

    // Query to check if the user exists in the database
    $sql = "SELECT * FROM login WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    // Check if a matching record is found
    if (mysqli_num_rows($result) == 1) {
        // User authenticated successfully
        header('Location: http://www.gyawaliramesh.com.np');
        // echo "<script>alert('Login successful!');</script>";
    } else {
        // User authentication failed
        echo "<script>alert('Incorrect email or password. Please try again.');</script>";
    }
}
?>