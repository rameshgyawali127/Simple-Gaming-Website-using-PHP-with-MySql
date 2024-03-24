<?php 
require('connection.php');
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMain($email, $v_code){
    require("PHPMailer/PHPMailer.php");
    require("PHPMailer/SMTP.php");
    require("PHPMailer/Exception.php"); 
    // making a php mailer object -> to handle a exception
    $mail = new PHPMailer(true);
    try {
        // Server settings   
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'gamingrowmexh@gmail.com';              // SMTP username
        $mail->Password   = 'RAMESHGYAWALI30516005#';              // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Enable implicit TLS encryption
        $mail->Port       = 465;                                    // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
        // Recipients
        $mail->setFrom('gamingrowmexh@gmail.com', 'Ramesh');
        $mail->addAddress($email);     // Add a recipient
        
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Email Verification from ROYAL GAMING';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'Click the link below to verify the email address: <a href="http://localhost/emailverify/verify.php?email='.$email.'&v_code='.$v_code.'">Verify</a>';
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

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
    $v_code = bin2hex(random_bytes(16)); // Generate verification code
    
    $user_exist_query = "SELECT * FROM `testing`.`registered_user` WHERE `username` = '$username' OR `email` = '$email'";
    $result = mysqli_query($con, $user_exist_query);
    
    if($result) {
        if(mysqli_num_rows($result) > 0) {
            $result_fetch = mysqli_fetch_assoc($result);
            if($result_fetch['username'] == $username) {
                echo "<script>alert('$username - username already registered'); window.location.href ='index.php';</script>";
            } else {
                echo "<script>alert('$email - Email already registered'); window.location.href ='index.php';</script>";
            }
        } else {
            $query = "INSERT INTO `testing`.`registered_user` (`full_name`, `username`, `email`, `password`, `verification_code`, `is_verified`) VALUES ('$fullname', '$username', '$email', '$hashed_password', '$v_code', '0')";
            if(mysqli_query($con, $query) && sendMain($_POST['email'], $v_code)) {
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