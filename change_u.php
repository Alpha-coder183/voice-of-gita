<?php
session_start();
include('db_connection.php'); // Include the database connection

if (isset($_POST['username'], $_POST['new_username'], $_POST['password'], $_POST['email'])) {
    $username = $_POST['username'];
    $new_username = $_POST['new_username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Check if the new username already exists
    $check_username_query = $conn->prepare("SELECT username FROM users WHERE username = ?");
    $check_username_query->bind_param("s", $new_username);
    $check_username_query->execute();
    $username_result = $check_username_query->get_result();

    if ($username_result->num_rows > 0) {
        $_SESSION['error'] = "The new username is already taken. Please choose another.";
        header("Location: login.php");
        exit();
    }

    // Validate the current username, email, and password
    $query = $conn->prepare("SELECT password FROM users WHERE username = ? AND email = ?");
    $query->bind_param("ss", $username, $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $stored_hashed_password = $row['password'];

        if (password_verify($password, $stored_hashed_password)) {
            // Update the username in the database
            $update_query = $conn->prepare("UPDATE users SET username = ? WHERE username = ?");
            $update_query->bind_param("ss", $new_username, $username);

            if ($update_query->execute()) {
                $update_query = $conn->prepare("UPDATE gitagpt SET username = ? WHERE username = ?");
                $update_query->bind_param("ss", $new_username, $username);
                // Auto-submit form to my_profile.php
                if ($update_query->execute()) {
                    echo '<form id="profileForm" action="my_profile.php" method="POST">
                            <input type="hidden" name="username" value="' . htmlspecialchars($new_username) . '">
                            <input type="hidden" name="password" value="' . htmlspecialchars($password) . '">
                        </form>
                        <script>
                            document.getElementById("profileForm").submit();
                        </script>';
                    } 
                else {
            $_SESSION['error'] = "Failed to update username. Please try again.";
            header("Location: login.php");
            exit();}
                }else {
                $_SESSION['error'] = "Failed to update username. Please try again.";
                header("Location: login.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "Invalid password. Please try again.";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "User not found. Please try again.";
        header("Location: login.php");
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid access. Please try again.";
    header("Location: change_username.php");
    exit();
}
?>
