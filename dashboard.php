<?php
// dashboard.php

session_start();

if (!isset($_SESSION["user"]) || empty($_SESSION["user"])) {
    header("Location: LoginPage.php");
    exit();
}

// Logout logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
    session_destroy();
    header("Location: LoginPage.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

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

        .dashboard {
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

        .btn-logout {
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

        .btn-logout:hover {
            background-color: #3E3CE9;
        }
    </style>
</head>

<body>

<div class="dashboard">

    <h2>Welcome to SecLogin!</h2>

    <form method="post">
        <button class="btn-logout" type="submit" name="logout">Logout</button>
    </form>

</div>

</body>
</html>
