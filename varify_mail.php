<?php
session_start();
include('db_connection.php'); // Include the database connection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'PHPMailer\Exception.php';
require 'PHPMailer\PHPMailer.php';
require 'PHPMailer\SMTP.php';

if (isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1) Generate a new OTP
    $otp = rand(100000, 999999);

    // 2) Hash the OTP
    $hashed_otp = password_hash($otp, PASSWORD_BCRYPT);

    // 3) Update the OTP in the database for the given username
    $query = $conn->prepare("UPDATE users SET OTP = ? WHERE username = ?");
    $query->bind_param("ss", $hashed_otp, $username);
    if (!$query->execute()) {
        $_SESSION['error'] = "Failed to update OTP. Please try again.";
        header("Location: login.php");
        exit();
    }

    // 4) Retrieve the email for the given username
    $email_query = $conn->prepare("SELECT email FROM users WHERE username = ?");
    $email_query->bind_param("s", $username);
    $email_query->execute();
    $email_result = $email_query->get_result();

    if ($email_result->num_rows === 1) {
        $row = $email_result->fetch_assoc();
        $email = $row['email'];
    } else {
        $_SESSION['error'] = "User not found. Please try again.";
        header("Location: login.php");
        exit();
    }

    // 5) Send OTP via email
    // **SEND MAIL FUNCTIONALITY GOES HERE** (You can add your mailing logic here)
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
    // 6) Auto-submit the form to check_otp.php
    echo '<form id="checkOtpForm" action="check_otp.php" method="POST">
            <input type="hidden" name="username" value="' . htmlspecialchars($username) . '">
            <input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
            <input type="hidden" name="password" value="' . htmlspecialchars($password) . '">
          </form>
          <script>
              document.getElementById("checkOtpForm").submit();
          </script>';
} else {
    $_SESSION['error'] = "Invalid access. Please try again.";
    header("Location: login.php");
    exit();
}
?>
