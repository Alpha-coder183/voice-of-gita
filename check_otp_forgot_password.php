<?php
session_start();
function mask_string($str) {
    if (strlen($str) > 4) {
        return substr($str, 0, 2) . "........" . substr($str, -2);
    }
    return $str; // If too short, return as is
}
if (isset($_POST['username'], $_POST['email'])) {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    list($first_part, $second_part) = explode('@', $email);

    $masked_first_part = mask_string($first_part);
    // Combine the masked parts
    $masked_mail = $masked_first_part . "@" . $second_part;
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        html, body {
            height: 100%; /* Ensure the body and html take up full height */
            margin: 0;
        }

        body {
            background-image: url('background.webp');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            font-family: Arial, sans-serif;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 60px;
            background: transparent; /* Invisible header */
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding-right: 20px;
            z-index: 1000;
        }

        .header form {
            margin-left: 20px;
        }

        .header button {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .header button:hover {
            background-color: gray;
        }

        .login-form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .login-form {
            background-color: rgba(0, 0, 0, 0.57); /* Black with 30% transparency */
            padding: 30px;
            border-radius: 10px;
            width: 300px;
            color: white;
            text-align: center;
        }

        .login-form h2 {
            margin-bottom: 20px;
        }

        .login-form input[type="text"], 
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            position: relative;
        }

        .login-form button {
            width: 100%;
            padding: 10px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .login-form button:hover {
            background-color: gray;
        }

        .login-form a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            display: block;
            margin-top: 10px;
        }

        .login-form a:hover {
            text-decoration: underline;
        }

        button.active {
            background-color: white;
            color: black;
            font-weight: bold;
            border: 2px solid black;
        }

        .login-form .toggle-password {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #888;
            font-size: 18px;
        }

        .password-container {
            position: relative;
        }
    </style>
</head>
<body>
    <div class="header">
        <form action="login.php" method="POST">
            <button type="submit">Login</button>
        </form>
        <form action="signup.php" method="POST">
            <button type="submit">Signup</button>
        </form>
    </div>

    <div class="login-form-container">
        <div class="login-form">
            <h2>Write the otp sent to you at your mail <?php echo $masked_mail ?></h2>
            <form action="change_password.php" method="POST">
                <input type="text" name="otp" placeholder="OTP" required>
                <input type="hidden" name="username" value="<?php echo $username ?>">
                <button type="submit">Varify Email</button>
            </form>
        </div>
    </div>
    
</body>
</html>

<?php
    

} else {
    // Set session error and redirect to login page
    $_SESSION['error'] = "Something went wrong. Please try again.";
    header("Location: signup.php");
    exit();
}
?>
