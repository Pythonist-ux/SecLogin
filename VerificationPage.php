<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["verify"])) {
    $enteredCode = $_POST["verification_code"];
    $storedCode = $_SESSION['verification_code'];

    if ($enteredCode == $storedCode) {
        // Verification successful, you can proceed to further actions (e.g., allow user access)
        echo "Verification successful!";
        header("Location: LoginPage.php");
        exit();
    } else {
        // Verification failed, you can redirect or display an error message
        echo "Verification failed. Please enter the correct code.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>

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
            margin: 0;
        }

        .verification-card {
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
            margin-bottom: 1rem;
        }

        .form-control {
            width: 100%;
            padding: 0.5rem 0;
            border: none;
            border-bottom: 2px solid #4F46E5;
            background-color: transparent;
            color: var(--text-color);
            margin-bottom: 1rem;
            text-align: center; /* Center the text in the input */
        }

        .form-control:focus {
            outline: none;
            border-bottom-color: #fff;
        }

        .btn-verify {
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

        .btn-verify:hover {
            background-color: #3E3CE9;
        }

        @media screen and (max-width: 768px) {
            .verification-card {
                max-width: 80%;
            }
        }
    </style>
</head>

<body>

    <div class="verification-card">
        <h2>Verification</h2>
        <form method="post">
            <input type="text" class="form-control" name="verification_code" placeholder="Verification Code" required>
            <button type="submit" class="btn-verify" name="verify">Verify</button>
        </form>
    </div>

</body>

</html>

