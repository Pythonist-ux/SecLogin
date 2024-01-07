<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

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

// Signup logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["signup"])) {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = password_hash(trim($_POST["password"]), PASSWORD_BCRYPT); // Hashing the password

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Username or email already exists. Please choose a different one.";
    } else {
        // Insert new user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $password);
        $stmt->execute();
        $stmt->close();

        // Simulate 2FA via email (you would implement a real email sending mechanism here)
        $verificationCode = mt_rand(100000, 999999);
        $_SESSION['verification_code'] = $verificationCode;
        $_SESSION['signup_username'] = $username;
        $_SESSION['signup_email'] = $email;

        // Use PHPMailer to send the email using Mailtrap SMTP server
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '13ac1f96bb5d83';
            $mail->Password = '35f28933f5a75b';
            $mail->SMTPSecure = 'tls'; // You can use 'ssl' instead if needed
            $mail->Port = 2525; // You should use the port provided by Mailtrap

            $mail->setFrom('sahil.chintan.pancholi@gmail.com', 'SAHIL');
            $mail->addAddress($email, $username);
            $mail->Subject = 'Account Verification Code';
            $mail->Body = "Your verification code is: $verificationCode";
            $mail->send();

            // Redirect to 2FA verification page
            header("Location: VerificationPage.php");
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>

    <!-- Stylesheet -->
    <style>
        /* Reuse LoginPage theme */
        :root {
            --bg-color: #1F2937;
            --text-color: #E5E7EB;
            --primary-color: #4F46E5;
        }

        body {
            display: grid;
            place-items: center;
            height: 100vh;
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'IBM Plex Sans', sans-serif;
        }

        .signup-card {
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

        .btn-signup {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            border: none;
            background-color: var(--primary-color);
            color: #fff;
            font-size: 0.9rem;
            letter-spacing: 0.1rem;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-signup:hover {
            background-color: #3E3CE9;
        }
    </style>
</head>

<body>

<div class="signup-card">
    <h2>Signup</h2>
    <form method="post">
        <input type="text" class="form-control" name="username" placeholder="Username" required>
        <input type="email" class="form-control" name="email" placeholder="Email" required>
        <input type="password" class="form-control" name="password" placeholder="Password" required>
        <button type="submit" class="btn-signup" name="signup">Sign Up</button>
    </form>
</div>

</body>
</html>
