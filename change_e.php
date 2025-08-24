<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer\Exception.php';
require 'PHPMailer\PHPMailer.php';
require 'PHPMailer\SMTP.php';

session_start();
include('db_connection.php'); // Include the database connection

if (isset($_POST['username'], $_POST['new_email'], $_POST['password'], $_POST['email'])) {
    $username = $_POST['username'];
    $new_email = $_POST['new_email'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Check if the new email already exists
    $check_email_query = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check_email_query->bind_param("s", $new_email);
    $check_email_query->execute();
    $email_result = $check_email_query->get_result();

    if ($email_result->num_rows > 0) {
        $_SESSION['error'] = "The new email is already in use. Please try another.";
        header("Location: login.php");
        exit();
    }

    // Validate the current username, email, and password
    $query = $conn->prepare("SELECT password FROM users WHERE username = ? AND email = ?");
    $query->bind_param("ss", $username, $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $stored_hashed_password = $row['password'];

        if (password_verify($password, $stored_hashed_password)) {
            // 1) Generate a new OTP
            $otp = rand(100000, 999999);

            // 2) Hash the OTP
            $hashed_otp = password_hash($otp, PASSWORD_BCRYPT);

            // 3) Store the hashed OTP in the database
            $update_otp_query = $conn->prepare("UPDATE users SET OTP = ?, email = ?, checked = 0 WHERE username = ?");
            $update_otp_query->bind_param("sss", $hashed_otp, $new_email, $username);

            if ($update_otp_query->execute()) {
                // Send email
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'voiceofgitawebsite@gmail.com';
                    $mail->Password   = 'effi mucu dhae gusx';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;

                    //Recipients
                    $mail->setFrom('voiceofgitawebsite@gmail.com', 'OTP Generator');
                    $mail->addAddress($new_email, 'Mail');

                    //Content
                    $mail->isHTML(true);
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
                    header("Location: login.php");
                    exit();
                }

                // Auto-submit form to check_otp.php
                echo '<form id="checkOtpForm" action="check_otp.php" method="POST">
                        <input type="hidden" name="username" value="' . htmlspecialchars($username) . '">
                        <input type="hidden" name="email" value="' . htmlspecialchars($new_email) . '">
                        <input type="hidden" name="password" value="' . htmlspecialchars($password) . '">
                      </form>
                      <script>
                          document.getElementById("checkOtpForm").submit();
                      </script>';
            } else {
                $_SESSION['error'] = "Failed to update email and OTP. Please try again.";
                header("Location: change_email.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid password. Please try again.";
            header("Location: change_email.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "User not found. Please try again.";
        header("Location: change_email.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid access. Please try again.";
    header("Location: change_email.php");
    exit();
}
?>
