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
        <h2>Material Nature</h2>
<p>In the Bhagavad Gita, material nature, often referred to as "Prakriti," is a fundamental concept that explains the physical world and its workings. Krishna, the speaker of the Gita, elucidates the nature and properties of Prakriti and how it interacts with the soul (Atman). Here are the key aspects of Prakriti as explained in the Gita:</p>

<h3>Three Gunas (Modes of Nature)</h3>
<ul>
    <li><strong>Sattva (Goodness):</strong> Represents purity, knowledge, and harmony, leading to clarity and happiness. Sattva binds the soul with attachment to knowledge and joy.</li>
    <li><strong>Rajas (Passion):</strong> Associated with activity, desire, and restlessness, Rajas leads to attachment and endless pursuits. It binds the soul through attachment to action and its fruits.</li>
    <li><strong>Tamas (Ignorance):</strong> Symbolizes darkness, inertia, and delusion, resulting in confusion and lethargy. It binds the soul through ignorance and indolence.</li>
</ul>

<h3>Interaction of Soul and Prakriti</h3>
<ul>
    <li><strong>Cause of Bondage:</strong> The soul's attachment to the three Gunas causes bondage in the material world. The continuous interaction with Prakriti's modes keeps the soul trapped in the cycle of Samsara (birth and rebirth).</li>
    <li><strong>Liberation (Moksha):</strong> Liberation is achieved by transcending the influence of the Gunas through spiritual practices such as devotion (Bhakti), knowledge (Jnana), and selfless action (Karma Yoga). The ultimate goal is to attain Moksha, freeing the soul from the cycle of birth and rebirth and achieving union with the Supreme (Brahman).</li>
</ul>

<p>The Bhagavad Gita's teachings on Prakriti provide a comprehensive understanding of the material world's nature and its impact on the soul. By recognizing the influence of the Gunas and striving to transcend them, individuals can work towards spiritual liberation and self-realization.</p>

<h2>Demigods</h2>
<p>Demigods, also known as Devas in Hinduism, are divine beings that possess supernatural powers and play significant roles in the cosmic order. They are considered celestial entities who govern various aspects of the natural and moral law, acting as intermediaries between the Supreme Being and the material world.</p>

<h3>Roles and Attributes of Demigods</h3>
<ul>
    <li>Demigods possess extraordinary abilities and control over natural phenomena like weather, seasons, and elements.</li>
    <li>Each demigod has specific duties, such as overseeing the heavens, administering justice, protecting the earth, and maintaining cosmic balance.</li>
    <li>Unlike the Supreme Being, demigods are still part of the material nature (Prakriti) and are subject to the laws of Karma and Samsara (cycle of birth and rebirth).</li>
    <li>People often worship demigods for blessings, protection, and guidance in various aspects of life. This form of worship is known as "Deva Puja."</li>
    <li>There are 33 Demigods, also referred to as "Trayastrimsati Koti," which include 12 Adityas, 8 Vasus, 11 Rudras, and 2 Ashwini Kumaras.</li>
</ul>

<h3>The Twelve Adityas (Solar Deities)</h3>
<ul>
    <li><strong>Vivasvan (Surya):</strong> The Sun god, responsible for providing light, energy, and life to the world. Symbolizes the triumph of light over darkness.</li>
    <li><strong>Aryaman:</strong> Represents nobility, social order, and matrimonial alliances, emphasizing the sacredness of societal norms.</li>
    <li><strong>Bhaga:</strong> Associated with wealth, prosperity, and marital bliss, ensuring the fair distribution of resources.</li>
    <li><strong>Amsha:</strong> Oversees the equitable sharing of wealth, promoting balance and fairness in society.</li>
    <li><strong>Varuna:</strong> The god of water and cosmic order, upholder of Rta (cosmic truth and justice).</li>
    <li><strong>Mitra:</strong> Represents friendship, contracts, and alliances, promoting harmony and cooperation.</li>
    <li><strong>Savitr:</strong> The solar deity associated with dawn and dusk, symbolizing inspiration and renewal.</li>
    <li><strong>Daksha:</strong> The god of ritual skill and progenitor, emphasizing the importance of rituals in maintaining cosmic order.</li>
    <li><strong>Martanda (Yama):</strong> The god of death and justice, overseeing the moral and ethical balance of the universe.</li>
    <li><strong>Ans:</strong> Associated with prosperity and fair distribution, ensuring harmony in society.</li>
</ul>

<h3>The Eight Vasus (Deities of Elements)</h3>
<ul>
    <li><strong>Agni (Fire):</strong> The god of fire, mediator between humans and gods, and symbol of transformation and renewal.</li>
    <li><strong>Prithvi (Earth):</strong> The Earth goddess, symbolizing fertility, stability, and sustenance.</li>
    <li><strong>Vayu (Wind):</strong> The god of wind and life force, representing vitality and the essence of Prana (breath).</li>
    <li><strong>Varuna (Water):</strong> Oversees water and cosmic order, maintaining balance in natural and moral realms.</li>
    <li><strong>Dyaus (Sky):</strong> The Sky Father, symbolizing the vastness and strength of the heavens.</li>
    <li><strong>Surya (Sun):</strong> The Sun god, representing light, energy, and the cycle of time.</li>
    <li><strong>Chandra (Moon):</strong> The Moon god, symbolizing tranquility, fertility, and the cyclical nature of time.</li>
</ul>

<h3>The Eleven Rudras (Deities of Destruction and Transformation)</h3>
<ul>
    <li><strong>Mahadev (Shiva):</strong> Represents destruction and renewal, maintaining the balance of the cosmos.</li>
    <li><strong>Ishana:</strong> Symbolizes purity, wisdom, and transcendence, guiding seekers toward liberation.</li>
    <li><strong>Tatpurusha:</strong> Embodies universal consciousness and self-realization.</li>
    <li><strong>Aghora:</strong> Represents fearlessness and the transformative power of destruction.</li>
    <li><strong>Vamadeva:</strong> Embodies preservation, beauty, and compassion.</li>
    <li><strong>Rudra:</strong> Symbolizes both destruction and healing, maintaining balance in the universe.</li>
    <li><strong>Bhava:</strong> Represents creation and the cycle of life and rebirth.</li>
    <li><strong>Bhima:</strong> Embodies strength and the power to overcome adversity.</li>
    <li><strong>Ugra:</strong> Symbolizes intensity and righteous anger for the preservation of Dharma.</li>
    <li><strong>Sadasiva:</strong> Represents eternal perfection, grace, and bliss.</li>
    <li><strong>Kapali:</strong> Symbolizes asceticism, detachment, and the acceptance of impermanence.</li>
</ul>

<h3>The Ashwini Kumaras (Celestial Physicians)</h3>
<ul>
    <li><strong>Nasatya:</strong> Represents truth, order, and healing, symbolizing harmony and well-being.</li>
    <li><strong>Dasra:</strong> Embodies action and renewal, promoting vitality and overcoming challenges.</li>
</ul>

<p>The roles of demigods in Hindu cosmology emphasize their significance in maintaining cosmic order, balancing natural forces, and guiding humanity toward harmony and righteousness. Through their unique attributes, the demigods serve as intermediaries between the material and divine realms, ensuring the well-being of all creation.</p>

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
