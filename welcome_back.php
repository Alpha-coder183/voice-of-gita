<?php
session_start();
include('db_connection.php'); // Database connection

if (isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // 1) Check if the username exists and retrieve the required fields
    $query = $conn->prepare("SELECT password, checked FROM users WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $stored_hashed_password = $row['password'];
        $checked_status = $row['checked'];

        // 2) Redirect to varify.php if checked is 0
        if ($checked_status == 0) {
            echo '<form id="redirectForm" action="varify.php" method="POST">
                    <input type="hidden" name="username" value="' . htmlspecialchars($username) . '">
                    <input type="hidden" name="password" value="' . htmlspecialchars($password) . '">
                  </form>
                  <script>
                      document.getElementById("redirectForm").submit();
                  </script>';
            exit();
        }

        // 3) Check if the password matches
        if (password_verify($password, $stored_hashed_password)) {
            // Successful login
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        .welcome-form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
        }

        .welcome-form {
            background-color: rgba(0, 0, 0, 0.57); /* Black with 30% transparency */
            padding: 30px;
            border-radius: 10px;
            width: 1000px;
            color: white;
            text-align: center;
        }

        .welcome-form h2 {
            margin-bottom: 20px;
        }

        .welcome-form input[type="text"], 
        .welcome-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            position: relative;
        }

        .welcome-form button {
            width: 100%;
            padding: 10px;
            background-color: black;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .welcome-form button:hover {
            background-color: gray;
        }

        .welcome-form a {
            color: white;
            text-decoration: none;
            font-size: 14px;
            display: block;
            margin-top: 10px;
        }

        .welcome-form a:hover {
            text-decoration: underline;
        }

        button.active {
            background-color: white;
            color: black;
            font-weight: bold;
            border: 2px solid black;
        }
        #output {
            font-family: Arial, sans-serif;
            font-size: 20px;
            white-space: pre-wrap;
            text-align: justify;
        }
    </style>
</head>
<body>
    <div class="header">
        
    </div>
    <div class="welcome-form-container">
        <div class="welcome-form">
            <div id="output"></div>
            <form id="continueForm" action="my_profile.php" method="POST" style="display: none;">
                <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
                <input type="hidden" name="password" value="<?php echo htmlspecialchars($password); ?>">
                <button type="submit">Continue</button>
            </form>
        </div>
    </div>

    <script>
        const text = "Welcome back, <?php echo $username; ?>! It’s wonderful to have you with us again. Here at Voice of Gita, we’re committed to helping you explore the profound teachings of the Bhagavad Gita and applying its timeless wisdom to your life. As always, feel free to ask me any questions, and I will provide thoughtful responses inspired by the Gita to offer clarity and guidance. Together, we can delve deeper into core concepts such as reincarnation, the cycles of yugas, karma, and so much more. Whether you're seeking answers, inspiration, or simply wish to connect with the teachings of the Gita, I’m here to assist you. Let’s continue this enriching journey of self-discovery and growth, <?php echo $username; ?>!"
        const outputDiv = document.getElementById("output");
        const continueForm = document.getElementById("continueForm");
        let index = 0;

        function typeLetter() {
            if (index < text.length) {
                outputDiv.textContent += text[index];
                index++;
                setTimeout(typeLetter, 20); // Adjust speed by changing 20ms
            } else {
                continueForm.style.display = "block"; // Show the form when typing is complete
            }
        }

        typeLetter(); // Start the typing effect
    </script>
</body>
</html>

<?php

        } else {
            // Incorrect password
            $_SESSION['error'] = "Invalid password. Please try again.";
            header("Location: login.php");
            exit();
        }
    } else {
        // Username does not exist
        $_SESSION['error'] = "Username does not exist.";
        header("Location: login.php");
        exit();
    }
} else {
    // Missing data
    $_SESSION['error'] = "Invalid access. Please log in.";
    header("Location: login.php");
    exit();
}
?>
