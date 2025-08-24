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
        <h2>Yugas</h2>
<p>The Bhagavad Gita, as part of the larger epic Mahabharata, references the concept of Yugas. In Hindu cosmology, Yugas are the large, cyclical epochs of time that govern the moral, spiritual, and physical state of the universe. They represent the decline in Dharma (cosmic law) over time and are central to understanding the progression and eventual renewal of the cosmos. Each Yuga is characterized by its distinct qualities, societal structures, and spiritual practices, forming part of an eternal cycle.</p>
<p>The Yugas are sequential and cyclical, following a pattern of moral and spiritual decline. Together, the four Yugas make up a complete time cycle called a Mahayuga, lasting 4.32 million years.</p>

<h3>1) Satya Yuga</h3>
<p>Satya Yuga, also known as the Golden Age, is the first and most virtuous era in the cycle of Yugas. Lasting 1,728,000 years, it is characterized by truth, purity, and righteousness, with Dharma (cosmic law) firmly established on all four legs, symbolizing perfect moral and spiritual integrity.</p>
<p>In this era, people live in harmony with nature and the divine, leading long and fulfilling lives. Meditation and direct communion with the divine are the primary spiritual practices. There is no deceit, greed, or violence, and all beings are naturally inclined toward virtue and wisdom. Satya Yuga represents the pinnacle of human and cosmic harmony, where truth and justice prevail universally.</p>

<h4>Avatars of Lord Vishnu in Satya Yuga:</h4>
<ul>
    <li><strong>Matsya:</strong> Vishnu, in the form of a giant fish, saved sacred scriptures and the Vedas during the cosmic deluge. Matsya symbolizes protection and the restoration of cosmic order.</li>
    <li><strong>Kurma:</strong> As a tortoise, Vishnu stabilized Mount Mandara during the churning of the ocean, enabling the gods and demons to obtain the elixir of immortality. Kurma represents stability and balance.</li>
    <li><strong>Varaha:</strong> In the form of a boar, Vishnu rescued the Earth (Bhudevi) from the demon Hiranyaksha, restoring cosmic balance. Varaha symbolizes strength and courage.</li>
    <li><strong>Narasimha:</strong> This half-man, half-lion avatar protected the devotee Prahlada and destroyed the demon king Hiranyakashipu, exemplifying divine justice and protection.</li>
</ul>

<h3>2) Treta Yuga</h3>
<p>Treta Yuga is the second age in the cycle, lasting 1.296 million years. It marks a gradual decline in righteousness and the emergence of complexities in life. Society began to experience shorter lifespans, and adherence to Dharma diminished. Despite these changes, Treta Yuga witnessed remarkable events, teachings, and the flourishing of civilizations, art, and culture.</p>

<h4>Avatars of Lord Vishnu in Treta Yuga:</h4>
<ul>
    <li><strong>Vamana:</strong> In the form of a dwarf Brahmin, Vishnu humbled the demon king Bali, demonstrating humility and divine wisdom.</li>
    <li><strong>Parashurama:</strong> The warrior-sage with an axe eradicated corrupt Kshatriyas to restore balance. Parashurama symbolizes justice and strength tempered by wisdom.</li>
    <li><strong>Rama:</strong> The hero of the Ramayana, Lord Rama exemplified ideal behavior, morality, and the triumph of good over evil, defeating the demon king Ravana.</li>
</ul>

<h3>3) Dvapara Yuga</h3>
<p>Dvapara Yuga, lasting 864,000 years, is characterized by further moral decline and the increased complexity of human relationships. This era witnessed significant cultural achievements and pivotal events, including the Mahabharata and the teachings of the Bhagavad Gita.</p>

<h4>Avatars of Lord Vishnu in Dvapara Yuga:</h4>
<ul>
    <li><strong>Krishna:</strong> The central figure of the Mahabharata, Krishna’s life and teachings in the Bhagavad Gita provide timeless spiritual guidance on Dharma, devotion, and liberation.</li>
    <li><strong>Balarama:</strong> As Krishna’s elder brother, Balarama represents strength, loyalty, and agricultural prosperity. He supported Krishna in restoring Dharma.</li>
</ul>

<h3>4) Kali Yuga</h3>
<p>Kali Yuga, the current age, lasts 432,000 years and is marked by a significant decline in virtue and righteousness. It is characterized by moral corruption, materialism, and spiritual disconnection. Despite these challenges, this age offers unique opportunities for spiritual growth through devotion and faith.</p>

<h4>Avatars of Lord Vishnu in Kali Yuga:</h4>
<ul>
    <li><strong>Buddha:</strong> As Gautama Buddha, Vishnu guided humanity away from ritualistic practices and violence, emphasizing peace, compassion, and ethical living.</li>
    <li><strong>Kalki:</strong> The prophesied warrior on a white horse, Kalki will appear at the end of Kali Yuga to eradicate evil and restore Dharma, initiating a new Satya Yuga.</li>
</ul>

<p>The Yugas, with their cyclical nature, emphasize the progression of time and the enduring struggle between good and evil. They reflect the divine promise of renewal and the eternal commitment to restoring balance and righteousness in the universe.</p>

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
