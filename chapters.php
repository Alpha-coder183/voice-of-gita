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
    <title>Chapters</title>
    <style>
        /* Your CSS styles here */
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
            overflow: hidden; /* Prevents scrolling */
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
            scrollbar-width: thin; /* Optional: Custom scrollbar for Firefox */
        }

        .welcome-form input[type="text"] {
        flex: 1; /* Allows the input field to take up available space */
        padding: 10px;
        margin-right: 10px; /* Adds spacing between input and button */
        border: none;
        border-radius: 5px;
        position: relative;
    }
        .welcome-form h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .welcome-form p {
            font-size: 20px;
            margin: 10px 0;
        }

        .welcome-form button {
        background-color: black;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .welcome-form button:hover {
        background-color: gray;
    }

    .qa-entry, #last-qa-entry {
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #555;
    border-radius: 10px;
    background-color: rgba(0, 0, 0, 0.5); /* A semi-transparent black background */
    color: #f1f1f1;
    text-align: left;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3); /* Adds a subtle shadow for depth */
}

.qa-entry h4, #last-qa-entry h4 {
    margin: 5px 0;
    font-size: 18px;
    color: #f39c12; /* Golden yellow for the question */
}

.qa-entry p, #last-qa-entry p {
    margin: 10px 0;
    font-size: 16px;
    color: #ecf0f1; /* Light gray for the answer */
    line-height: 1.5; /* Improves readability */
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
            <button type="submit" class="active">Chapters</button>
        </form>
        <form action="concepts.php" method="POST">
            <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
            <input type="hidden" name="password" value="<?php echo htmlspecialchars($password); ?>">
            <button type="submit">Some Concepts</button>
        </form>
    </div>
    <?php
// Include the database connection file


// Initialize variables for form submission
$chapterNumber = "";
$verseNumber = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $chapterNumber = isset($_POST['chapter_number']) ? intval($_POST['chapter_number']) : "";
    $verseNumber = isset($_POST['verse_number']) ? intval($_POST['verse_number']) : "";
}
?>
    <div class="welcome-form-container">
        <div class="welcome-form" id="scrollableDiv">
        <h1>Bhagavad Gita</h1>
    <!-- Form for entering chapter and verse -->
    <form method="POST" action="chapters.php">
        <label for="chapter_number">Chapter Number:</label>
        <input type="number" id="chapter_number" name="chapter_number">
        <br><br>
        <label for="verse_number">Verse Number:</label>
        <input type="number" id="verse_number" name="verse_number">
        <input type="hidden" name="username" value="<?php echo $username; ?>">
        <input type="hidden" name="password" value="<?php echo $password; ?>">
        <br><br>
        <button type="submit">Search</button>
    </form>
    <hr>
    <?php
    // Query logic based on input
    if ($chapterNumber && $verseNumber) {
        // Fetch specific verse
        $sql = "SELECT chapter_number, chapter_name, verse_number, verse, translation 
                FROM gita 
                WHERE chapter_number = $chapterNumber AND verse_number = $verseNumber";
    } elseif ($chapterNumber) {
        // Fetch all verses in the given chapter
        $sql = "SELECT chapter_number, chapter_name, verse_number, verse, translation 
                FROM gita 
                WHERE chapter_number = $chapterNumber 
                ORDER BY verse_number";
    } elseif($verseNumber) {
        $sql = "SELECT chapter_number, chapter_name, verse_number, verse, translation 
                FROM gita 
                WHERE chapter_number = 19
                ORDER BY verse_number";
    } else {
        // Fetch the entire Bhagavad Gita
        $sql = "SELECT chapter_number, chapter_name, verse_number, verse, translation 
                FROM gita 
                ORDER BY chapter_number, verse_number";
    }

    $result = $conn->query($sql);

    // Display data
    if ($result->num_rows > 0) {
        $currentChapter = 0;
        while ($row = $result->fetch_assoc()) {
            // Display chapter header only when the chapter changes
            if ($currentChapter != $row['chapter_number']) {
                $currentChapter = $row['chapter_number'];
                echo "<h2>Chapter {$row['chapter_number']}: {$row['chapter_name']}</h2>";
            }
            
            // Display verse number, Sanskrit verse, and translation
            echo "<p><strong>Verse {$row['verse_number']}:</strong></p>";
            echo "<p><em>{$row['verse']}</em></p>";
            echo "<p><strong>Translation:</strong> {$row['translation']}</p><hr>";
        }
    } else {
        echo "<p>No results found for the given input.</p>";
    }?>
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
