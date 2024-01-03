<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "1234";
$database = "seclogin_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $hashedPassword = $user["password"];

        if (password_verify($password, $hashedPassword)) {
            $_SESSION["user"] = $user;
            header("Location: dashboard.html");
            exit();
        } else {
            echo "Invalid password. Debug: Passwords do not match. Password entered: $password, Hashed Password in DB: $hashedPassword";
        }
    } else {
        echo "Invalid username. Debug: User not found.";
    }
}

$conn->close();
?>
