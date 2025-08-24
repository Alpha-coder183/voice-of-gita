<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        html, body {
            height: 100%;
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
            background: transparent;
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

        .signup-form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .signup-form {
            background-color: rgba(0, 0, 0, 0.57);
            padding: 30px;
            border-radius: 10px;
            width: 300px;
            color: white;
            text-align: center;
            position: relative;
        }

        .signup-form h2 {
            margin-bottom: 20px;
        }

        .signup-form input[type="text"], 
        .signup-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            position: relative;
        }

        .signup-form button {
            width: 100%;
            padding: 10px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .signup-form button:hover {
            background-color: gray;
        }

        .signup-form a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            display: block;
            margin-top: 10px;
        }

        .signup-form a:hover {
            text-decoration: underline;
        }

        button.active {
            background-color: white;
            color: black;
            font-weight: bold;
            border: 2px solid black;
        }

        .signup-form .toggle-password {
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
            <button type="submit" class="active">Signup</button>
        </form>
    </div>

    <div class="signup-form-container">
        <div class="signup-form">
            <h2>Signup</h2>
            <form action="signup_process.php" method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="text" name="email" placeholder="Email" required>
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Password" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('password')">👁</span>
                </div>
                <div class="password-container">
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                    <span class="toggle-password" onclick="togglePasswordVisibility('confirm_password')">👁</span>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId) {
            const passwordField = document.getElementById(inputId);
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</body>
</html>
