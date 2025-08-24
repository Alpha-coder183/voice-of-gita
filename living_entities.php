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
            <h2>Living:"Diving into the Divine Essence of Living Entities:"</h2>
        <p><b>The Eternal Self: </b>  The Bhagavad Gita repeatedly emphasizes the eternal nature of the soul (Atman). The soul is beyond the confines of the physical body and remains unaffected by the cycle of birth and death. This forms the bedrock of the Gita's philosophy.   - **Chapter 2, Verse 22:**  - _&quot;As a person puts on new garments, giving up old ones, the soul similarly accepts new bodies, giving up the old and useless ones.&quot;_   This metaphor underscores the idea that the soul, like changing clothes, transitions from one body to another without being affected by the physical changes.    The Immortality of the Soul   Building on the concept of the eternal self, the Gita elaborates on the immortality and indestructibility of the soul.   - **Chapter 2, Verse 23-24:**  - _&quot;The soul can never be cut to pieces by any weapon, nor burned by fire, nor moistened by water, nor withered by the wind. This individual soul is unbreakable and insoluble, and can be neither burned nor dried. He is everlasting, present everywhere, unchangeable, immovable and eternally the same.&quot;_   These verses provide a vivid description of the soul's indestructible nature, reinforcing the idea that the essence of living entities transcends the material world.   The Divine Connection:</p>

<p>   The relationship between the individual soul and the Supreme Soul (Paramatma) is a core concept in the Gita. Every living entity is a fragment of the Supreme, and this divine connection is integral to understanding our true nature.   - **Chapter 10, Verse 20:**  - _&quot;I am the Self, O Gudakesha, seated in the hearts of all creatures. I am the beginning, the middle, and the end of all beings.&quot;_   This verse highlights that the Supreme Being resides within all living entities, signifying the divine essence present in each one of us.   The Nature of Reality:   The Gita delves into the nature of reality, explaining that the material world is temporary and illusory (Maya), while the spiritual realm is eternal. Understanding this distinction is crucial for realizing the divine essence of living entities.   - **Chapter 7, Verse 14:**  - _&quot;This divine energy of Mine, consisting of the three modes of material nature, is difficult to overcome. But those who have surrendered unto Me can easily cross beyond it.&quot;_   This verse suggests that by transcending the material world and connecting with the divine, one can realize their true nature.</p>

<p><b> The Role of Dharma:</b></p>

<p>  Dharma, or righteous duty, plays a significant role in the Gita's teachings. Adhering to one's Dharma aligns individuals with their true nature and the cosmic order.   - **Chapter 18, Verse 47:**  - _&quot;It is better to perform one's own duty, even though imperfectly, than to perform another's duty perfectly. The duty prescribed according to one&rsquo;s nature, even though faulty, is no cause for getting entangled in the actions of another.&quot;_   This verse emphasizes the importance of performing one's prescribed duties to attain self-realization.   The Path of Devotion:</p>

<p></p>

<p>  Devotion (Bhakti) is presented as a powerful means to realize the divine essence. By cultivating a deep, personal relationship with the Supreme Being, one can attain spiritual enlightenment.   - **Chapter 9, Verse 34:**  - _&quot;Engage your mind always in thinking of Me, become My devotee, offer obeisances to Me and worship Me. Being completely absorbed in Me, surely you will come to Me.&quot;_   This verse encourages individuals to engage in devotional practices to connect with the divine essence within themselves.   The Practice of Detachment:   The Gita teaches that detachment from material possessions and desires is essential for understanding the divine essence of living entities. By practicing detachment, one can focus on their spiritual growth.   - **Chapter 5, Verse 10:**  - _&quot;One who performs his duty without attachment, surrendering the results unto the Supreme Lord, is unaffected by sinful action, as the lotus leaf is untouched by water.&quot;_   This verse uses the lotus leaf as a metaphor to illustrate how detachment from material outcomes can lead to spiritual purity.   The Oneness of All Beings:</p>

<p>   The Gita also emphasizes the unity of all living entities, suggesting that all beings are manifestations of the same divine consciousness.   - **Chapter 6, Verse 29:**  - _&quot;A true yogi observes Me in all beings and also sees every being in Me. Indeed, the self-realized man sees Me everywhere.&quot;_   This verse highlights the interconnectedness of all life forms and the presence of the divine in every living entity.   The Vision of Universal Form:   One of the most awe-inspiring chapters of the Gita is Chapter 11, where Lord Krishna reveals His universal form to Arjuna. This vision encapsulates the entirety of creation and the divine essence present in all beings.   - **Chapter 11, Verse 12:**  &quot;If hundreds of thousands of suns rose up at once into the sky, they might resemble the effulgence of the Supreme Person in that universal form.&quot;   This verse describes the overwhelming brilliance of the universal form, symbolizing the omnipresence and omnipotence of the divine.   The Path of Knowledge:   The Gita also discusses the importance of knowledge (Jnana) in realizing the divine essence. By gaining spiritual knowledge, one can see beyond the material illusion and understand their true nature.   - **Chapter 4, Verse 38:**  - _&quot;In this world, there is nothing so purifying as transcendental knowledge. One who is perfect in yoga enjoys this knowledge within himself in due course of time.&quot;_   This verse emphasizes that knowledge is a powerful tool for spiritual purification and enlightenment. </p>

<p></p>

<p></p>

<p></p>


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
