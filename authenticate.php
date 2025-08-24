<?php
session_start();
include('db_connection.php'); // Database connection

if (isset($_POST['otp'], $_POST['username'], $_POST['password'])) {
    $username = $_POST['username'];
    $entered_otp = $_POST['otp'];

    // 1) Fetch OTP for the given username
    $query = $conn->prepare("SELECT OTP FROM users WHERE username = ?");
    $query->bind_param("s", $username);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $stored_hashed_otp = $row['OTP'];

        // Verify the entered OTP
        if (password_verify($entered_otp, $stored_hashed_otp)) {
            // 2) Update 'checked' status
            $update_query = $conn->prepare("UPDATE users SET checked = 1 WHERE username = ?");
            $update_query->bind_param("s", $username);
            $update_query->execute();

            // 3) Generate a new OTP
            $new_otp = rand(100000, 999999);

            // 4) Hash the new OTP
            $hashed_new_otp = password_hash($new_otp, PASSWORD_BCRYPT);

            // 5) Update the database with the new hashed OTP
            $update_otp_query = $conn->prepare("UPDATE users SET OTP = ? WHERE username = ?");
            $update_otp_query->bind_param("ss", $hashed_new_otp, $username);
            $update_otp_query->execute();

            // 6) Auto-submit the form to home.php
            echo '<form id="homeForm" action="home.php" method="POST">
                    <input type="hidden" name="username" value="' . htmlspecialchars($username) . '">
                    <input type="hidden" name="password" value="' . htmlspecialchars($_POST['password']) . '">
                  </form>
                  <script>
                    document.getElementById("homeForm").submit();
                  </script>';
            exit();
        } else {
            // 7) If OTP is invalid
            $_SESSION['error'] = "Invalid OTP. Please try again.";
            header("Location: signup.php");
            exit();
        }
    } else {
        // User not found
        $_SESSION['error'] = "Invalid username. Please try again.";
        header("Location: signup.php");
        exit();
    }
} else {
    // 8) If required data is missing
    $_SESSION['error'] = "Something went wrong. Please try again.";
    header("Location: signup.php");
    exit();
}
?>
