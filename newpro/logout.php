<?php
session_start();

if (isset($_COOKIE["user"]) || isset($_COOKIE["designation"])) {
    if (isset($_COOKIE["user"])) {
        setcookie("user", "", time() - 3600, "/");
    }
}
session_destroy();

header("Location: /hiruni/newpro/index.php");
die();
