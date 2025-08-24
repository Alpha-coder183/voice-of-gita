<?php
session_start();
include('db_connection.php'); // Include the database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer\Exception.php';
require 'PHPMailer\PHPMailer.php';
require 'PHPMailer\SMTP.php';

if (isset($_POST['check'])) {
    $check = $_POST['check'];
    $username = "";
    $email = "";

    // 3) Check if $check is a username
    $query = $conn->prepare("SELECT username, email FROM users WHERE username = ?");
    $query->bind_param("s", $check);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        // 4) If found as username, retrieve email
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $email = $row['email'];
    } else {
        // 5) Check if $check is an email
        $query = $conn->prepare("SELECT username, email FROM users WHERE email = ?");
        $query->bind_param("s", $check);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows === 1) {
            // 6) If found as email, retrieve username
            $row = $result->fetch_assoc();
            $username = $row['username'];
            $email = $row['email'];
        } else {
            // 7) If neither, set session error and redirect
            $_SESSION['error'] = "Username or Email not found.";
            header("Location: forgot_password.php");
            exit();
        }
    }

    // 8) Generate a new OTP
    $otp = rand(100000, 999999);

    // 9) Hash the OTP and update it in the database
    $hashed_otp = password_hash($otp, PASSWORD_BCRYPT);
    $update_query = $conn->prepare("UPDATE users SET OTP = ? WHERE username = ?");
    $update_query->bind_param("ss", $hashed_otp, $username);
    if (!$update_query->execute()) {
        $_SESSION['error'] = "Failed to update OTP. Please try again.";
        header("Location: forgot_password.php");
        exit();
    }

    // 10) Send email
    // **SEND EMAIL FUNCTIONALITY GOES HERE** (You can add your email-sending code here)
    $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'voiceofgitawebsite@gmail.com';                     //SMTP username
                $mail->Password   = 'effi mucu dhae gusx';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            
                //Recipients
                $mail->setFrom('voiceofgitawebsite@gmail.com', 'OTP Generator');
                $mail->addAddress($email, 'Mail');     //Add a recipient
                
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'New OTP';
                $mail->Body = '
                                <p>Dear Sir/Madam,</p>
                                <p>We are pleased to provide you with the requested details for your Voice of Gita account:</p>
                                <p><strong>Username: ' . $username . '</strong></p>
                                <p><strong>One-Time Password (OTP): ' . $otp . '</strong></p>
                                <p>Please use this OTP to complete your login or verification process. Note that the OTP should not be shared with anyone.</p>
                                <p>If you did not request this OTP, kindly ignore this email. We prioritize the security of your account and appreciate your vigilance.</p>
                                <br>
                                <p>Thank you for choosing Voice of Gita.</p>
                                <p>Warm Regards,<br>Voice of Gita Support Team</p>
                                <b>This is a System Generated Mail No need to reply</b>
                            ';
            
                $mail->send();
            } catch (Exception $e) {
    $_SESSION['error'] = "OTP email failed to send: " . $mail->ErrorInfo;
    header("Location: signup.php");
    exit();
}
    

    // 11) Auto-submit the form to check_otp_forgot_password.php
    echo '<form id="checkOtpForgotForm" action="check_otp_forgot_password.php" method="POST">
            <input type="hidden" name="username" value="' . htmlspecialchars($username) . '">
            <input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
          </form>
          <script>
              document.getElementById("checkOtpForgotForm").submit();
          </script>';
} else {
    $_SESSION['error'] = "Invalid access. Please try again.";
    header("Location: forgot_password.php");
    exit();
}
?>
