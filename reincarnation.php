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
            <button type="submit">My Profile</button>
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
            <img src="1.png" alt="">
            <b><h2>Reincarnation & Transmigration of Soul</h2></b>
            <p>Reincarnation, also known as rebirth or transmigration, is the belief that the soul or spirit begins a new life in a different physical form or body after biological death.</p>
            <p>In the Bhagavad Gita, reincarnation is a central theme. It is described as the process by which the soul (Atman) is reborn in different bodies across various lifetimes. This cycle of birth, death, and rebirth is known as Samsara.</p>
<p>
            <ul>
    <li>
        The Gita asserts that the soul is eternal and indestructible. In Chapter 2, Verse 20, it states:
        <blockquote>
            "For the soul there is neither birth nor death. Nor, having once been, does he ever cease to be. He is unborn, eternal, ever-existing, undying and primeval."
        </blockquote>
    </li>
    <li>
        The soul transitions from one body to another, much like changing clothes. In Chapter 2, Verse 22, it mentions:
        <blockquote>
            "As a person puts on new garments, giving up old ones, the soul similarly accepts new material bodies, giving up the old and useless ones."
        </blockquote>
    </li>
    <li>
        The actions performed in one's life (Karma) determine the circumstances of future births. Good deeds lead to favourable rebirths, while negative actions result in less favourable ones. This concept emphasizes moral and ethical living.
    </li>
</ul>
</p>
<img src="2.png" alt="">
<p>
<ol>
    <li><strong>Cycle of Birth and Death:</strong> The soul undergoes a cycle of birth, death, and rebirth until it achieves enlightenment or liberation.</li>
    <li><strong>Karma:</strong> Actions in past lives influence one's current life circumstances, including social status, health, and personal experiences.</li>
    <li><strong>Goal:</strong> The ultimate goal is to break free from this cycle (Samsara) and achieve liberation (Moksha or Nirvana).</li>
</ol>
</p>
<img src="3.png" alt="">
<p><b>Transmigration of Soul :</b> While the Gita primarily focuses on reincarnation, the idea of transmigration, where the soul can inhabit different life forms, is also implicit in its teachings.</p>
<ul>
        <li>
            The Gita acknowledges that the soul can be reborn in various forms based on one's actions and desires. This includes human, animal, or even divine forms.
        </li>
        <li>
            Chapter 14, Verse 18, states: "Those who are in the mode of goodness gradually go upward to the higher planets; those in the mode of passion live on the earthly planets; and those in the mode of ignorance go down to the hellish worlds."
        </li>
        <li>
            The journey of the soul through different forms is seen as an opportunity for spiritual growth and eventual liberation.
        </li>
        <li>
            The ultimate aim is to transcend the cycle of rebirth and attain union with the Supreme (Moksha).
        </li>
    </ul>
    <img src="4.png" alt="">
    <h3>Let’s dive deep into the concept of Reincarnation :</h3>
    <p>
        In Chapter 8, Verse 6, Lord Krishna says: “Whatever state of being one remembers when he quits his body, that state he will attain without fail.”
    </p>
    <p>
        This highlights the process of changing one’s nature at the critical moment of death. It is a very scientific process summarized in one key principle: our state of mind at the time of death determines the state we will attain after death.
    </p>
    <p>
        From this, we can understand that we are eternal. Even though our bodies will age and eventually die, we, the spirit souls within these bodies, do not die. Death is simply the soul leaving one body and moving to another destination.
    </p>
    <p>
        This verse clearly and scientifically explains that our destination after leaving the body is determined by our state of mind at the time of death.
    </p>

    <h3>Conclusion</h3>
    <p>So there are many examples. If one is very much attached to swimming and surfing in the ocean then the human form of body is not very good for that. So if at the time of death one is dreaming about swimming and surfing in the ocean then Krishna may mercifully award him the benediction of getting the body of a fish in his next life. In that way he can swim in the ocean to his hearts content.</p>
    <p>But a fish does not have the ability to ponder the meaning of life. All a fish is conscious of is how to eat, how to sleep, how to have sex and how to defend himself. His thoughts will never be able to rise above these basic animal needs. It is only in the human form of life that we have the ability to question: “Why am I here?“, “What is the purpose of life?”, “Where did I come from?”, “What will happen after death? “. Finding the answers to questions like this is the purpose of human life. This is how the Brahma Sutra starts: ahato brahma jijnasa: “The purpose of life is to question about brahman.” Brahman means the spirit.
    So the human form of life is a great facility which we can use to raise our consciousness form the material platform to the spiritual platform. And from reading this verse we can understand if we die in Krishna consciousness then after death we will certainly attain the state of Krishna consciousness.</p>
    <p>So how can one die in the proper state of mind? Maharaja Bharata thought of a deer at the time of death and so was transferred to that form of life. However, as a deer, Maharaja Bharata could remember his past activities.</p>
    <p>Of course the cumulative effect of the thoughts and actions of one’s life influences one’s thoughts at the moment of death; therefore the actions of this life determine one’s future state of being. If one is transcendentally absorbed in Krishna’s service,then his next body will be transcendental (spiritual), not physical. Therefore the chanting of Hare Krishna’s is the best process for successfully changing one’s state of being to transcendental life.</p>
    
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
