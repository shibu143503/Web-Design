<?php
// Connect to the database
$servername = "localhost";
$username = "root"; // replace with your DB username
$password = ""; // replace with your DB password
$dbname = "e_learning"; // replace with your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input
    $user_username = $_POST['username'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];

    // Validate input (basic validation)
    if (empty($user_username) || empty($user_email) || empty($user_password)) {
        echo "All fields are required.";
    } else {
        // Hash password
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO signup (username,email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user_username, $user_email, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: home.html");
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close statement
        $stmt->close();
    }
}

$conn->close();
?>