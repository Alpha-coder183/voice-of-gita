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
        <h2>Karma: The Cosmic Law of Cause and Effect in the Bhagavad Gita</h2>
<p>The Bhagavad Gita, a profound Hindu scripture, offers a comprehensive understanding of karma, the universal law of cause and effect. This concept, central to Indian philosophy, governs the cyclical nature of existence and the consequences of our actions.</p>

<h3>The Mechanics of Karma</h3>
<p>Karma is not simply a system of reward and punishment. It is a complex interplay of actions, intentions, and consequences that shapes our destiny. Every action, thought, and word we utter creates an impression or a "seed" in our consciousness. These impressions, known as <strong>samskaras</strong>, accumulate over lifetimes and influence our future experiences.</p>
<p>The law of karma ensures that we reap what we sow, not necessarily in this life, but in future lives. This principle is often misunderstood as a deterministic system, but the Bhagavad Gita offers a more nuanced perspective. Karma is not a rigid, mechanical law, but rather a dynamic process that can be influenced by our choices and actions.</p>

<h3>The Three Gunas and Karma</h3>
<p>The Bhagavad Gita introduces the concept of the three <strong>gunas</strong>:</p>
<ol>
    <li>
        <strong>Sattva (Purity):</strong> Actions performed with purity, knowledge, and detachment lead to positive results and spiritual growth. These actions are characterized by harmony, balance, and clarity.
    </li>
    <li>
        <strong>Rajas (Passion):</strong> Actions driven by passion, desire, and attachment lead to mixed results and can bind us to the cycle of rebirth. These actions are characterized by restlessness, impulsiveness, and a craving for sensory pleasures.
    </li>
    <li>
        <strong>Tamas (Inertia):</strong> Actions performed with ignorance, laziness, and cruelty lead to negative consequences and suffering. These actions are characterized by dullness, lethargy, and a lack of motivation.
    </li>
</ol>
<p>The predominance of these <strong>gunas</strong> in our actions determines the nature of our karma and its subsequent effects. By cultivating <strong>sattvic</strong> qualities and minimizing <strong>rajasic</strong> and <strong>tamasic</strong> tendencies, we can purify our karma and progress spiritually.</p>

<h3>Karma Yoga: The Path of Selfless Action</h3>
<p>The Bhagavad Gita advocates for <strong>karma yoga</strong>, the path of selfless action. This involves performing one's duties without attachment to the results, surrendering them to the divine will. By acting with detachment, we can transcend the cycle of karma and attain liberation (<strong>moksha</strong>).</p>

<h4>Key Principles of Karma Yoga:</h4>
<ul>
    <li>
        <strong>The Divine Nature of Action:</strong> We are not the doers of action; it is the material nature (<strong>prakriti</strong>) that acts through us. Our true self (<strong>atman</strong>) is a witness to these actions, unaffected by their outcomes.
    </li>
    <li>
        <strong>The Path of Selfless Service:</strong> By performing our duties without attachment, we can purify our karma and progress spiritually. This involves acting with a sense of duty and responsibility, without expecting rewards or recognition.
    </li>
    <li>
        <strong>The Ultimate Goal:</strong> The ultimate goal of karma yoga is to attain liberation from the cycle of birth and death. By surrendering our ego and aligning our actions with the divine will, we can transcend the limitations of karma and experience eternal bliss.
    </li>
</ul>

<h3>Understanding Karma's Role in Spiritual Growth</h3>
<p>Karma is not a rigid, deterministic system. It offers an opportunity for spiritual growth and liberation. By understanding the law of karma and practicing selfless action, we can gradually purify our consciousness and move towards a higher state of being.</p>
<p>The Bhagavad Gita's teachings on karma provide a profound framework for living a meaningful and purposeful life. By embracing the principles of karma yoga, we can cultivate inner peace, compassion, and a deep connection with the divine.</p>

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
