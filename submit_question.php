<?php
include 'db_connection.php';
function generateText($query) {
    $url = "https://api.edenai.run/v2/text/generation";
    $headers = [
        "Authorization: Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2lkIjoiODliMDIyYjctZjljMC00YWUyLTkwMGUtYzBmMGQwZGI1ZmZlIiwidHlwZSI6ImFwaV90b2tlbiJ9.uQMl2tLml-RIXZs-x9_4gAPlSnm4fIuC3qDMQKuRlkw",
        "Content-Type: application/json"
    ];

    $payload = json_encode([
        "providers" => "openai",
        "text" => $query,
        "temperature" => 0.2,
        "max_tokens" => 250,
        "fallback_providers" => "cohere"
    ]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    curl_close($ch);

    if ($response !== false) {
        $result = json_decode($response, true);
        return $result['openai']['generated_text'] ;//?? 'No text generated from OpenAI';
    } else {
        return "Sorry, I didn't get you";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Get the question and username from the POST request
    $question = $_POST['question'];
    $username = $_POST['username'];
    $password = $_POST['password'];

// Example usage
$query = $question. " answer this in the context of Bhagavat gita try to mention the chapter and verse if possible write like you are addressing ".$username." as a guy named Sanjay and must answer in 100 words";
$answer = generateText($query);
$stmt = $conn->prepare("INSERT INTO gitagpt (question, answer, username, datetimee) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("sss", $question, $answer, $username);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Question submitted successfully.";
    } else {
        $_SESSION['error'] = "Error submitting question. Please try again.";
    }
    
    // Close statement and connection
    $stmt->close();
    $conn->close();
    
    // Redirect back to the main content page
?>
<form action="sanjay.php" method="POST" id="postForm">
    <input type="hidden" name="username" value="<?php echo $username; ?>">
    <input type="hidden" name="password" value="<?php echo $password; ?>">
</form>
<script>
    // Automatically submit the form
    document.getElementById("postForm").submit();
</script>
<?php

}
?>
