<?php
require('connection.php');

if(isset($_GET['email']) && isset($_GET['v_code'])) {
    $email = mysqli_real_escape_string($con, $_GET['email']);
    $v_code = mysqli_real_escape_string($con, $_GET['v_code']);
    
    // Check if the provided email and verification code match in the database
    $query = "SELECT * FROM `testing`.`registered_user` WHERE `email` = '$email' AND `verification_code` = '$v_code'";
    $result = mysqli_query($con, $query);
    
    if($result && mysqli_num_rows($result) == 1) {
        // Update the user's record to mark them as verified
        $update_query = "UPDATE `testing`.`registered_user` SET `is_verified` = '1' WHERE `email` = '$email'";
        if(mysqli_query($con, $update_query)) {
            echo "<h1>Email Verification Successful</h1>";
            echo "<p>Your email has been verified. You can now login to your account.</p>";
        } else {
            echo "<h1>Verification Failed</h1>";
            echo "<p>There was an error verifying your email. Please try again later.</p>";
        }
    } else {
        echo "<h1>Invalid Verification Link</h1>";
        echo "<p>The verification link is invalid or expired. Please make sure you have clicked the correct link.</p>";
    }
} else {
    echo "<h1>Invalid Request</h1>";
    echo "<p>The verification link is incomplete. Please make sure you have clicked the correct link.</p>";
}
?>