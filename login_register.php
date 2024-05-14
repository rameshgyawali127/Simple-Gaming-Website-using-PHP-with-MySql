<?php 
require('connection.php');
session_start();

# For Login
if(isset($_POST['login'])){
    $email_username = mysqli_real_escape_string($con, $_POST['email_username']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $query = "SELECT * FROM `testing`.`registered_user` WHERE `email` = '$email_username' OR `username` = '$email_username'";
    $result = mysqli_query($con, $query);

    if($result) {
        if(mysqli_num_rows($result) == 1) {
            $result_fetch = mysqli_fetch_assoc($result);
            if(password_verify($_POST['password'], $result_fetch['password'])) {
                // Login successful
                $_SESSION['logged_in'] = true;
                $_SESSION['username'] = $result_fetch['username'];
                header("location: index.php"); // Redirect to dashboard page
                exit(); // Stop further execution
            } else {
                // Incorrect password
                echo "<script>alert('Incorrect password');</script>";
            }
        } else {
            // No user found
            echo "<script>alert('No user found');</script>";
        }
    } else {
        // Query failed
        echo "<script>alert('Login query failed');</script>";
    }
}

# For Registration
if(isset($_POST['register'])) {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $fullname = mysqli_real_escape_string($con, $_POST['fullname']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $user_exist_query = "SELECT * FROM `testing`.`registered_user` WHERE `username` = '$username' OR `email` = '$email'";
    $result = mysqli_query($con, $user_exist_query);
    
    if($result) {
        if(mysqli_num_rows($result) > 0) {
            $result_fetch = mysqli_fetch_assoc($result);
            if($result_fetch['username'] == $username) {
                echo "<script>alert('$username - Username already taken'); window.location.href ='index.php';</script>";
            } else {
                echo "<script>alert('$email - Email already registered'); window.location.href ='index.php';</script>";
            }
        } else {
            $query = "INSERT INTO `testing`.`registered_user` (`full_name`, `username`, `email`, `password`, `is_verified`) VALUES ('$fullname', '$username', '$email', '$hashed_password', '1')";
            if(mysqli_query($con, $query)) {
                echo "<script>alert('Registration Successful'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Server Down');</script>";
            }
        }
    } else {
        echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
    }
}
?>