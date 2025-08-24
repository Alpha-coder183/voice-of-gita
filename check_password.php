<?php
session_start();
include('db_connection.php'); // Include the database connection

if (isset($_POST['username'], $_POST['password'], $_POST['confirm_password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 1) Check if passwords match
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match. Please try again.";
        header("Location: forgot_password.php");
        exit();
    }

    // 2) Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // 3) Update the password in the database for the given username
    $query = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    $query->bind_param("ss", $hashed_password, $username);
    if (!$query->execute()) {
        $_SESSION['error'] = "Failed to update password. Please try again.";
        header("Location: forgot_password.php");
        exit();
    }

    // 4) Auto-submit the form to welcome_back.php
    echo '<form id="welcomeBackForm" action="welcome_back.php" method="POST">
            <input type="hidden" name="username" value="' . htmlspecialchars($username) . '">
            <input type="hidden" name="password" value="' . htmlspecialchars($password) . '">
          </form>
          <script>
              document.getElementById("welcomeBackForm").submit();
          </script>';
} else {
    $_SESSION['error'] = "Invalid access. Please try again.";
    header("Location: forgot_password.php");
    exit();
}
?>
