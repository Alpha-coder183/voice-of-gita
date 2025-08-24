<?php
session_start();
include('db_connection.php'); // Include database connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

// Retrieve form data
$username = $_POST['username'] ?? '';
$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// Step 1: Validate password match
if ($password !== $confirm_password) {
    $_SESSION['error'] = "Passwords do not match!";
    header("Location: signup.php");
    exit();
}

// Step 2: Check if username already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $_SESSION['error'] = "Username already exists!";
    header("Location: signup.php");
    exit();
}
$stmt->close();

// Step 3: Check if email already exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $_SESSION['error'] = "Email already exists!";
    header("Location: signup.php");
    exit();
}
$stmt->close();

// Step 4: Generate OTP
$otp = rand(100000, 999999);

// Step 5: Hash password and OTP
$hashed_password = password_hash($password, PASSWORD_BCRYPT);
$hashed_otp = password_hash($otp, PASSWORD_BCRYPT);

// Step 6: Insert new user into database
$stmt = $conn->prepare("INSERT INTO users (username, email, password, OTP, checked) VALUES (?, ?, ?, ?, 0)");
$stmt->bind_param("ssss", $username, $email, $hashed_password, $hashed_otp);

if (!$stmt->execute()) {
    $_SESSION['error'] = "Database error! Please try again.";
    header("Location: signup.php");
    exit();
}
$stmt->close();

// Step 7: Send OTP email
$mail = new PHPMailer(true);
try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'voiceofgitawebsite@gmail.com';
    $mail->Password   = 'effi mucu dhae gusx'; // Make sure this is secured or use env variables
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Email content
    $mail->setFrom('voiceofgitawebsite@gmail.com', 'OTP Generator');
    $mail->addAddress($email, $username);
    $mail->isHTML(true);
    $mail->Subject = 'Your OTP for Voice of Gita';
    $mail->Body = "
        <p>Dear $username,</p>
        <p>Your OTP for account verification is: <strong>$otp</strong></p>
        <p>Please do not share this OTP with anyone.</p>
        <br>
        <p>Regards,<br>Voice of Gita Team</p>
        <p><small>This is a system-generated mail. Do not reply.</small></p>
    ";

    $mail->send();
} catch (Exception $e) {
    $_SESSION['error'] = "Failed to send OTP: " . $mail->ErrorInfo;
    header("Location: signup.php");
    exit();
}

// Step 8: Redirect to OTP verification page
echo '
<form id="otpForm" action="check_otp.php" method="POST">
    <input type="hidden" name="username" value="' . htmlspecialchars($username) . '">
    <input type="hidden" name="email" value="' . htmlspecialchars($email) . '">
    <input type="hidden" name="password" value="' . htmlspecialchars($password) . '">
</form>
<script>
    document.getElementById("otpForm").submit();
</script>';
?>
