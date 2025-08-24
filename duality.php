<?php
session_start();
include('db_connection.php'); // Include the database connection

if (isset($_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username exists and retrieve email and checked status
    $query = $conn->prepare("SELECT email, checked, password FROM users WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $email = $row['email'];
        $stored_hashed_password = $row['password'];
        $checked_status = $row['checked'];

        // Redirect to varify.php if checked is 0
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

        // Verify password
        if (password_verify($password, $stored_hashed_password)) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Krishna</title>
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
        button.active {
            background-color: white;
            color: black;
            font-weight: bold;
            border: 2px solid black;
        }
        .welcome-form {
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
            width: 80%;
            height: 65%;
            text-align: center;
            color: white;
            overflow-y: auto; /* Adds vertical scrolling */
            scrollbar-width: thin;
        }

        .welcome-form h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .welcome-form p {
            font-size: 20px;
            margin: 10px 0;
            text-align: justify;
        }

        .welcome-form li {
            font-size: 20px;
            margin: 10px 0;
            text-align: justify;
        }

        .welcome-form button {
            background-color: black;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 10px;
        }

        .welcome-form button:hover {
            background-color: gray;
        }
    </style>
</head>
<body>
    <div class="header">
        <form action="my_profile.php" method="POST">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <input type="hidden" name="password" value="<?php echo htmlspecialchars($password); ?>">
            <button type="submit" >My Profile</button>
        </form>
        <form action="sanjay.php" method="POST">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <input type="hidden" name="password" value="<?php echo htmlspecialchars($password); ?>">
            <button type="submit">Sanjay</button>
        </form>
        <form action="chapters.php" method="POST">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <input type="hidden" name="password" value="<?php echo htmlspecialchars($password); ?>">
            <button type="submit">Chapters</button>
        </form>
        <form action="concepts.php" method="POST">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <input type="hidden" name="password" value="<?php echo htmlspecialchars($password); ?>">
            <button type="submit" class="active">Some Concepts</button>
        </form>
    </div>
    <div class="welcome-form-container">
        <div class="welcome-form">
        <h2>Duality: The Dance of Opposites in the Bhagavad Gita</h2>
<p>The Bhagavad Gita, a profound Hindu scripture, delves into the intricate dance of duality, a fundamental principle that permeates all aspects of existence. Duality refers to the existence of two opposing forces or principles, such as good and evil, light and darkness, creation and destruction. These seemingly contradictory forces are interconnected and interdependent, creating a dynamic interplay that drives the universe.</p>

<h3>The Duality of Existence</h3>
<p>In the Bhagavad Gita, duality is often represented by the concept of <strong>prakriti</strong> (material nature) and <strong>purusha</strong> (pure consciousness). Prakriti, the source of all creation, is characterized by constant change, impermanence, and duality. It is the realm of the senses, emotions, and the material world. Purusha, on the other hand, is the eternal, unchanging consciousness that underlies all existence. It is the witness of the play of prakriti, unaffected by its fluctuations.</p>
<p>The Bhagavad Gita teaches that duality is an inherent part of the human experience. We are constantly faced with choices between right and wrong, good and evil, and pleasure and pain. These choices shape our actions and ultimately determine our destiny. However, the scripture also emphasizes that attachment to these dualities can lead to suffering and bondage.</p>

<h3>The Path Beyond Duality</h3>
<p>The Bhagavad Gita offers a path beyond duality, a path of liberation and enlightenment. This path involves recognizing the illusory nature of duality and cultivating a deeper understanding of the underlying unity of all things. By transcending the limitations of the mind and the senses, one can experience the divine within and attain spiritual freedom.</p>

<h3>The Role of Duality in Spiritual Growth</h3>
<p>Duality can be a powerful tool for spiritual growth. By recognizing the existence of opposing forces, we can learn to balance them and develop a more integrated and harmonious personality. For instance:</p>
<ul>
    <li><strong>Embracing Joy and Sorrow:</strong> By accepting both joy and sorrow, we can develop greater resilience and compassion.</li>
    <li><strong>Learning from Success and Failure:</strong> By embracing both success and failure, we can learn from our mistakes and grow stronger.</li>
</ul>

<h3>The Bhagavad Gita's Perspective</h3>
<p>The Bhagavad Gita encourages us to view duality as a necessary part of the cosmic play. While it acknowledges the existence of opposites, it also emphasizes the ultimate unity that underlies all diversity. By understanding the nature of duality and its role in our lives, we can cultivate a more balanced and enlightened perspective.</p>

<p>In conclusion, the Bhagavad Gita offers a profound understanding of duality and its role in the human experience. By embracing the teachings of this sacred text, we can learn to navigate the complexities of life and move towards a higher state of consciousness.</p>

        </div>
    </div>
</body>
</html>
<?php
        } else {
            $_SESSION['error'] = "Invalid password. Please try again.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Username not found.";
        header("Location: login.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid access. Please log in.";
    header("Location: login.php");
    exit();
}
?>
