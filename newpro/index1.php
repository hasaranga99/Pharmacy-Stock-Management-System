<?php
session_start();
include "./sessions.php";

if (isset(($_SESSION["user"]))) {
    header("Location: login.php");
    die();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pharmacy Inventory Management System</title>
    <link rel="stylesheet" href="CSS/stylee.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <section id="header">
        <div class="header-container">
            <h1>Inventory Management System - Royal Medical Stores</h1>
        </div>
    </section>
    <section id="banner">
        <div class="container">
            <h2 class="banner-subheading">WELCOME TO</h2>
            <h1 class="banner-heading">OUR STORES</h1>
            <a href="login.php" class="login-button">Login</a>
            <a href="SignUp.php" class="login-button">SignUp</a>

        </div>
        </div>
    </section>
</body>

</html>