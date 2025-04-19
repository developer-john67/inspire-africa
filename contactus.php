<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "frewsie";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name    = $_POST["name"];
    $email   = $_POST["email"];
    $message = $_POST["message"];

    // Insert into database
    $sql = "INSERT INTO ecosprout (NAME, EMAIL, MESSAGE) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param('sss', $name, $email, $message);

    if ($stmt->execute()) {
        echo "Response saved successfully.<br>";

        // Send email
        $to = "jk2436471@gmail.com"; // Replace with your destination email
        $subject = "New Message from $name via Ecosprout";
        $email_message = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: $email";

        if (mail($to, $subject, $email_message, $headers)) {
            echo "Message sent to your email successfully.";
        } else {
            echo "Message saved, but failed to send email.";
        }

    } else {
        echo "Error saving your response: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
