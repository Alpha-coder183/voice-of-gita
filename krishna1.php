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
        .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .ab {
            width: 20%; /* Each image takes 20% of the width */
            height: auto; /* Maintain aspect ratio */
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
            <img src="k1.png" alt="">
            <h2>Birth of Krishna</h2>
<p>Krishna, one of the most revered deities in Hindu mythology, was born to Devaki and Vasudeva in Mathura. His birth was a divine event prophesied to bring an end to the tyrannical rule of his uncle, Kansa. The prophecy foretold that the eighth child of Devaki would be the one to overthrow Kansa, causing the wicked king to live in constant fear.</p>

<p>To prevent the prophecy from coming true, Kansa imprisoned Devaki and Vasudeva, killing their first six children. However, on the night of Krishna's birth, a series of miraculous events unfolded. The prison guards fell asleep, and the chains binding Vasudeva broke. Guided by divine intervention, Vasudeva secretly transported the infant Krishna across the Yamuna River to Gokul, where he was left in the care of Yashoda and Nanda.</p>

<p>This secretive act ensured Krishna's safety from Kansa's wrath, allowing him to grow up in the peaceful village of Gokul. His journey from the confines of the prison to the nurturing environment of Gokul symbolizes hope, divine protection, and the triumph of good over evil.</p>
<img src="k2.png" alt="">
<h2>Krishna’s Childhood in Gokul</h2>
<p>Krishna grew up as the beloved son of Nanda and Yashoda in the serene village of Gokul. From a young age, his playful mischief and enchanting charm captured the hearts of everyone around him. His antics, such as stealing butter with his friends and playfully teasing the gopis, became legendary, earning him the affectionate title of "Makhan Chor" (Butter Thief).</p>

<p>Despite his mischievous nature, Krishna's divine aura was unmistakable. His presence brought joy and prosperity to Gokul, and his laughter resonated as a source of delight for all who encountered him. Krishna's childhood stories, filled with innocence and wonder, remain an integral part of Hindu mythology, symbolizing the pure, playful aspects of the divine.</p>
<div class="container">
        <img src="k3.png" alt="Image 1" class="ab">
        <img src="k4.png" alt="Image 2" class="ab">
        <img src="k5.png" alt="Image 3" class="ab">
    </div>
    <h2>Krishna’s Triumph Over Demons</h2>
<p>As a child, Krishna displayed extraordinary feats of divine power by defeating numerous demons sent by his tyrannical uncle, Kansa. Among these were Putana, a demoness who tried to poison him; Trinavarta, a whirlwind demon; and Bakasura, a monstrous crane. Despite his young age, Krishna vanquished these formidable foes effortlessly, protecting the people of Gokul and affirming his divine nature.</p>

<p>Each victory was not merely an act of defense but a profound symbol of Krishna's role as the destroyer of evil and protector of Dharma. These tales of valor and divine intervention continue to inspire devotees, highlighting Krishna's mission to uphold righteousness even as a child.</p>
<img src="k6.png" alt="">
<h2> Kansa Vadh (Killing of Kansa)</h2>
<p>Krishna and Balram were cunningly invited to Mathura by their uncle, Kansa, who sought to eliminate them. Under the guise of a wrestling competition, Kansa planned their demise, believing he could outmaneuver the divine brothers.</p>

<p>Despite the sinister intentions behind the invitation, Krishna and Balram accepted the challenge, showcasing their unshakable courage and readiness to face the forces of evil. The stage was set in Mathura for a confrontation that would not only seal Kansa’s fate but also restore righteousness.</p>
<img src="k7.png" alt="">
<h2>Kansa’s Death</h2>
<p>In the wrestling arena of Mathura, Krishna confronted Kansa with divine determination. Despite Kansa’s cunning schemes and his formidable wrestlers, Krishna displayed unparalleled strength and skill.</p>

<p>Krishna killed Kansa, fulfilling the prophecy foretold at his birth. This pivotal act marked the liberation of Mathura from the clutches of tyranny and injustice. With Kansa's demise, peace and righteousness were restored, and the people of Mathura rejoiced in newfound freedom.</p>
<img src="k8.png" alt="">
<h2>Establishment of Dwarika</h2>
<p>Following the death of Kansa, Mathura became a target for repeated attacks by Jarasandha, the powerful king of Magadha. Despite Krishna and Balram's efforts to protect the city, the relentless assaults put the Yadava clan at risk.</p>

<p>To ensure the safety and prosperity of his people, Krishna made the strategic decision to relocate the Yadava clan. He led them to the western coast, where he established the city of Dwarika. Built on a secure and picturesque island, Dwarika became a fortress of peace and a thriving center of culture, trade, and spirituality.</p>

<p>The establishment of Dwarika symbolized Krishna's role as a visionary leader who prioritized the well-being of his people. Under his guidance, the city flourished, becoming a beacon of prosperity and harmony in a tumultuous time.</p>
<img src="k9.png" alt="">
<h2>Kurukshetra and the Mahabharata</h2>
<p>During the epic Mahabharata, Krishna assumed the pivotal role of a guide, mentor, and charioteer to Arjuna, one of the Pandava princes. Faced with moral dilemmas and the burden of waging war against his own relatives, Arjuna sought Krishna's counsel on the battlefield of Kurukshetra.</p>

<p>In response, Krishna delivered the Bhagavad Gita, a timeless discourse on duty (dharma), righteousness, and the nature of life and the soul. Through his profound wisdom, Krishna inspired Arjuna to rise above personal attachments and fulfill his duties as a warrior. He emphasized the importance of selfless action, devotion, and the pursuit of truth.</p>

<p>Krishna's strategic guidance and unwavering support were instrumental in shaping the Pandavas' eventual victory over the Kauravas. His role in the Mahabharata underscores his divine mission to uphold dharma and restore balance in the world.</p>
<img src="k10.png" alt="">
<h2>Bhagavad Gita</h2>
<p>Amidst the epic battle of Kurukshetra, Krishna imparted the Bhagavad Gita, a sacred scripture that transcends time and culture. Delivered to Arjuna, who was paralyzed by moral conflict, the Gita is a spiritual and philosophical discourse that addresses the fundamental questions of life, duty, and devotion.</p>

<p>Krishna emphasized the path of righteousness (dharma), urging Arjuna to rise above personal attachments and fulfill his role as a warrior. The Gita outlines key principles such as the importance of selfless action (Karma Yoga), the pursuit of knowledge (Jnana Yoga), and unwavering devotion (Bhakti Yoga).</p>

<p>Through the Bhagavad Gita, Krishna not only guided Arjuna to clarity and purpose but also provided a universal framework for leading a life of meaning and spiritual growth. This divine dialogue remains a cornerstone of spiritual and philosophical thought worldwide.</p>
<img src="k11.png" alt="">
<h2>Leaving the Mortal Body</h2>
<p>As the wheel of time turned, Krishna, having fulfilled his divine purpose on Earth, chose to leave his mortal form. Tired of the worldly conflicts and recognizing the inevitability of cosmic transitions, he bid farewell to Dwarka and his beloved devotees.</p>

<p>Krishna’s departure was serene and symbolic, as he merged back into the eternal divine consciousness. His passing marked the end of the Dwapara Yuga, the third epoch in the cycle of ages, and ushered in the Kali Yuga, a period characterized by moral and spiritual decline.</p>

<p>Though Krishna left the mortal world, his teachings, actions, and the timeless wisdom of the Bhagavad Gita continue to inspire and guide humanity, reminding us of the eternal presence of the divine in every aspect of life.</p>

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
