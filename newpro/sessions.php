<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!(isset($_SESSION["user"]) && isset($_SESSION["designation"]))) {
    if ((isset($_COOKIE["user"])  && isset($_COOKIE["designation"]))) {
        require_once "connect.php";
        $databaseManager = new DatabaseConnection();
        $userInfo = $databaseManager->verifyUser($_COOKIE["user"]);
        if (!$userInfo) {
            header("Location: logout.php");
            die();
        } else {
            $_SESSION["user"] = $_COOKIE["user"];
            $_SESSION["designation"] = $_COOKIE["designation"];
        }
    } else {
        header("Location: login.php");
        die();
    }
}
