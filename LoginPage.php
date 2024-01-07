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
            header("Location: Dashboard.php");
            exit();
        } else {
            echo "Invalid password. Debug: Passwords do not match. Password entered: $password, Hashed Password in DB: $hashedPassword";
        }
    } else {
        echo "Invalid username.User not found.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Stylesheet -->
    <style>
        /* Dark theme colors */
        :root {
            --bg-color: #1F2937;
            --text-color: #E5E7EB;
            --primary-color: #4F46E5;
        }

        /* Minimalist layout */
        body {
            display: grid;
            place-items: center;
            height: 100vh;
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'IBM Plex Sans', sans-serif;
        }

        .login-card {
            padding: 2rem;
            max-width: 350px;
            text-align: center;
            border-radius: 1rem;
            background-color: #27272A;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.25);
        }

        h2 {
            font-size: 1.5rem;
            font-weight: 600;
            font-family: 'IBM Plex Mono', monospace;
        }

        /* Input fields */
        .form-control {
            width: 100%;
            padding: 0.5rem 0;
            border: none;
            border-bottom: 2px solid #4F46E5;
            background-color: transparent;
            color: var(--text-color);
            margin-bottom: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-bottom-color: #fff;
        }

        .form-control::placeholder {
            color: #a8a8a8;
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Buttons */
        .btn-login,
        .btn-signup {
            width: calc(50% - 0.5rem); /* Each button takes up 50% with a small gap in between */
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: none;
            background-color: var(--primary-color);
            color: #fff;
            font-size: 0.9rem;
            letter-spacing: 0.1rem;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-login:hover,
        .btn-signup:hover {
            background-color: #3E3CE9;
        }

        /* Margin between buttons */
        .btn-signup {
            margin-left: 1rem;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <h2>Login</h2>
        <form action="LoginPage.php" method="POST">
            <input type="text" class="form-control" name="username" placeholder="Username">
            <input type="password" class="form-control" name="password" placeholder="Password">
            <button type="submit" class="btn-login">Log In</button>
            <a href="SignUpPage.php" class="btn-signup">Sign Up</a>
        </form>
    </div>
</body>

</html>


