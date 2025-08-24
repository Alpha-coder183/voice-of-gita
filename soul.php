
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
        <h2><b>Soul:</b> &ldquo;The Eternal Dance: Harmony of the Atman and Paramatma&rdquo;</h2>

<p></p>

<p></p>

<p></p>

<p>The Bhagavad Gita, often regarded as the most revered scripture in Hindu philosophy, provides profound insights into the nature of the self, the essence of existence, and the divine presence in all living beings. In this sacred dialogue between Lord Krishna and Arjuna, the concepts of *Atman* (soul), *Brahman* (universal consciousness), and *Ishvara* (God as the Supreme Being) are explored in depth. These teachings offer a comprehensive understanding of the divine essence within all living entities, and how human beings can transcend their limited, material perspective to perceive their true spiritual nature.   The Divine Essence: Atman and Brahman:   In the Bhagavad Gita, Lord Krishna consistently emphasizes that every living entity possesses an eternal, indestructible essence&mdash;*Atman*. The *Atman* is the innermost self, beyond the body, mind, and emotions, and it is inherently divine. It is not subject to the cycles of birth and death but is ever-present, immutable, and immortal. This divine essence is one with the supreme cosmic reality&mdash;*Brahman*.   *Atman* and *Brahman* &ndash; The Unity of the Self and the Supreme:</p>

<p></p>

<p>  The Gita reveals that the Atman is not separate from Brahman. Instead, it is a manifestation of the Divine, a spark of the cosmic consciousness that resides within all living entities. In Chapter 10, verse 20, Krishna declares:   > *&quot;I am the Self (Atman), O Gudakesha, seated in the hearts of all creatures. I am the beginning, the middle and the end of all beings.&quot;* (Bhagavad Gita 10.20)   Here, Krishna speaks of the universal presence of the divine essence. Every living being's essence is intrinsically connected to the divine, and the Supreme Being pervades the entire creation. The idea is that while the individual *Atman* may appear distinct and isolated in various forms, in reality, it is always part of the one eternal *Brahman*. This divine unity is the core teaching of the Gita.   The Illusion of Separateness:</p>

<p></p>

<p></p>

<p>A major theme of the Gita is the idea that human beings mistakenly identify with their body, mind, and ego, thereby losing sight of their true nature as the divine *Atman*. Krishna urges Arjuna to transcend the limited view of the self and to realize that the physical form is temporary and impermanent, while the divine essence within is eternal.   In Chapter 2, verse 13, Krishna compares the soul's journey to the changing of clothes:   > *&quot;Just as the boyhood, youth and old age come to the embodied Soul in this body, in the same manner, old age comes to the Soul; it is not deluded at that time.&quot;* (Bhagavad Gita 2.13)   This analogy suggests that just as we discard old clothes for new ones, the soul discards worn-out bodies and takes on new forms. The body is but a temporary vehicle for the soul, and the soul remains constant and untouched by the passage of time.   The mistaken belief in separateness leads to suffering, as individuals identify with the fleeting material world and fail to recognize the divine essence within them. Krishna addresses this in Chapter 3, verse 27:   > *&quot;All action is carried out by the modes of material nature, but the one who believes himself to be the doer is deluded.&quot;* (Bhagavad Gita 3.27)   The Gita teaches that true wisdom lies in realizing that the individual self is not the doer but a mere instrument of the divine will. The essence of every living being is, in fact, the same divine consciousness that pervades the entire universe.   Divine Presence in All Living Entities:</p>

<p>   A recurring theme in the Bhagavad Gita is the omnipresence of the divine essence in all living beings. Krishna states that every being, regardless of its form, is an expression of His divine energy. In Chapter 9, verse 4, He says:   > *&quot;By Me, in My unmanifested form, this entire universe is pervaded. All beings exist in Me, but I do not exist in them.&quot;* (Bhagavad Gita 9.4)   This verse highlights the paradoxical nature of the Divine: while all beings exist within the divine essence, the divine is not bound by the limitations of space or time. Krishna&rsquo;s statement points to the fact that the Divine, though present in every being, is beyond all comprehension and not confined to any one form.   In Chapter 13, verse 27, Krishna further elucidates the idea of His presence within all living entities:   > *&quot;And I am the Self, O Gudakesha, seated in the hearts of all creatures. I am the beginning, the middle, and the end of all beings.&quot;* (Bhagavad Gita 13.27)   Here, Krishna affirms that the divine essence is within the heart of every living entity. The heart, in a spiritual sense, is not merely the physical organ, but the core of consciousness where the eternal soul resides. Thus, Krishna is the inner Self, the witness of all actions, and the ultimate reality within each being.   The Path to Realizing the Divine Essence:   The Bhagavad Gita offers practical paths for recognizing and connecting with the divine essence within oneself and in others. These paths&mdash;*karma yoga*, *bhakti yoga*, *jnana yoga*, and *raja yoga*&mdash;are designed to help individuals transcend their egoistic limitations and attain a direct experience of the divine.</p>

<p></p>

<p>  <b>Karma Yoga</b> &ndash; Selfless Action:   One of the core teachings of the Gita is to perform one's duty without attachment to the results. In Chapter 2, verse 47, Krishna advises Arjuna:   > *&quot;Your right is to perform your duty only, but never to its fruits. Let not the fruits of action be your motive, nor let your attachment be to inaction.&quot;* (Bhagavad Gita 2.47)   Through selfless action, a person can purify their mind and align their will with the divine. By surrendering the ego and dedicating all actions to God, one can realize the divine essence both within and around them. When we act without attachment to the outcome, we recognize the divine flow in everything we do, as all actions are ultimately expressions of the divine will.   *Bhakti Yoga* &ndash; Devotion to the Divine:</p>

<p>Bhakti yoga, the path of devotion, is another profound way to connect with the divine essence. Through intense love and surrender to God, a devotee transcends the illusion of separateness and experiences the presence of the divine in every aspect of life. Krishna assures in Chapter 9, verse 22:   > *&quot;To those who are constantly devoted and who always remember Me with love, I give the understanding by which they can come to Me.&quot;* (Bhagavad Gita 9.22)   By cultivating a relationship with the Divine through love and devotion, a person can experience the divinity within themselves and others. Bhakti dissolves the barriers created by the ego, leading to the realization that all beings are manifestations of the same divine essence.   *Jnana Yoga* &ndash; Knowledge of the Self:</p>

<p>   The path of knowledge (Jnana Yoga) involves the deep inquiry into the nature of the self and the universe. It is through wisdom and discernment that one comes to understand that the *Atman* (soul) is not different from *Brahman* (the Supreme). In Chapter 4, verse 35, Krishna says:   > *&quot;When you have gained this knowledge, you will never again be deluded. Through this knowledge, you will see all beings as yourself, and you will be able to transcend all sorrow.&quot;* (Bhagavad Gita 4.35)   The practice of Jnana Yoga enables one to penetrate the illusion of individuality and see the interconnectedness of all life. This realization leads to inner peace and liberation, as one recognizes that the divine essence is in every living entity.</p>

<p>    </p>  
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
