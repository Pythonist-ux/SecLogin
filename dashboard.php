<?php
session_start();

if (isset($_SESSION["user"])) {
    $user = $_SESSION["user"];
    echo "Welcome " . $user["username"] . "!";
} else {
    header("Location: login.php");
    exit();
}
?>
