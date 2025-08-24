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
        <h2>Our Body:</h2>
<p>Lord Krishna says in Bhagavad Gita that the body, made of the gross physical elements i.e. earth, water, fire, air and sky and the subtle elements (mind, intelligence and ego), is completely different from the soul proper. One should therefore not be disturbed by the action and reaction of these eight gross and subtle material elements. The practical process to attain this stage of indifference is to execute devotional service.</p>

<p>“Anyone who knows that this material body, made of the five gross elements, the sense organs, the working senses and the mind, is simply supervised by the fixed soul is eligible to be liberated from material bondage”.</p>

<p>This verse describes how one can become liberated from material bondage. The first point is that one must know that the soul is different from his body. The soul is called deha, or one who possesses the body, and the material body is called deha, or the embodiment of the soul. The body is changing at every moment, but the soul is fixed; therefore the soul is called kūṭa-stham. The change of body is enacted by the reactions of the three modes of nature. One who has understood the fixed position of the soul should not be disturbed by the incoming and outgoing interactions of the modes of material nature in the form of happiness and distress. In Bhagavad gita also, Lord Krishna recommends that since happiness and distress come and go due to the interaction of the modes of nature on the body, one should not be disturbed by such external movements. Even though one is sometimes absorbed in such external movements, he has to learn to tolerate them. The living entity should be always indifferent to the action and reaction of the external body.</p>

<p>Lord Kṛṣṇa says in Bhagavad gita that the body, made of the gross physical elements (earth, water, fire, air and sky) and the subtle elements (mind, intelligence and ego), is completely different from the soul proper. One should therefore not be disturbed by the action and reaction of these eight gross and subtle material elements. The practical process to attain this stage of indifference is to execute devotional service. Only one who constantly engages in devotional service twenty-four hours a day can be indifferent to the action and reaction of the external body. When a man is absorbed in a particular thought, he does not hear or see any external activities, even though they are enacted in his presence. Similarly, those who are fully absorbed in devotional service do not care what is going on with the external body. That status is called samadhi. One who is actually situated in samādhi is understood to be a first-class yogi.</p>

<p>In the Bhagavad Gita, the human body is described as a temporary vessel for the eternal soul, or Atman. The Gita, which is a 700-verse Hindu scripture that is part of the Mahabharata, presents profound insights into the nature of existence, the self, and the path to enlightenment. Here’s an explanation of how "our body" is perceived according to the Gita:</p>

<ul>
    <li>
        <h2>The Body as a Temporary Vessel:</h2>
        <p>The Bhagavad Gita emphasizes that the physical body (Deha) is perishable and subject to decay. In contrast, the soul (Atman) is eternal, indestructible, and transcends life and death. The body is seen as a garment that the soul wears, and at the time of death, the soul sheds the body just as a person discards old clothes and takes on new ones (Bhagavad Gita 2.22).</p>
    </li>
    <li>
        <h2>The Dual Nature: The Body and the Soul:</h2>
        <p>Krishna, in his dialogue with Arjuna, makes it clear that while the body may experience birth, aging, and death, the soul remains constant and unchanging. This dual nature underscores that one should not overly identify with the body but understand the true nature of the self as the soul. This teaching helps cultivate detachment and reduces fear of mortality (Bhagavad Gita 2.13, 2.20).</p>
    </li>
    <li>
        <h2>The Body as a Temple:</h2>
        <p>The Gita also teaches that the body should be treated with respect, as it houses the divine spark within. It is regarded as a temple that must be cared for and disciplined, allowing one to perform their duties (Dharma) and seek higher spiritual truths. Practicing Yoga and meditation as taught in the Gita is a way to maintain the body's health and prepare it for deeper spiritual practices.</p>
    </li>
    <li>
        <h2>The Body and Karma:</h2>
        <p>The actions performed through the body contribute to one's Karma, which affects the cycle of birth and rebirth. The Gita emphasizes performing one's duties selflessly without attachment to the results, as this leads to liberation from the cycle of reincarnation (Bhagavad Gita 3.19).</p>
    </li>
</ul>

<p>The Bhagavad Gita, a sacred Hindu text, offers a unique perspective on the body. It teaches that the body is a temporary vessel for the soul, which is eternal and indestructible. The body is subject to change and decay, but the soul remains unchanged.</p>

<p>The Gita also teaches that the body is a tool for spiritual growth. By practicing yoga and meditation, we can purify the body and mind, and prepare ourselves for spiritual enlightenment. The body is a precious gift from God. We should take good care of it by eating a healthy diet, exercising regularly, and getting enough sleep. We should also avoid harmful substances, such as alcohol and drugs.</p>

<p>By taking care of our bodies, we are taking care of our souls. We are also showing our gratitude to God for the gift of life.</p>

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
