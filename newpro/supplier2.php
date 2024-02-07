<?php session_start();
include "./sessions.php";

if (!isset($_SESSION["user"])) {
    header("Location: /login.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose Your Action</title>
    <link rel="stylesheet" href="CSS/supplier2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body style="background-image: url(images/medi1.jpg);">
    <section id="header">
        <div class="header-container">
            <h1>Inventory Management System - Royal Medical Stores</h1>
        </div>
    </section>
    <section id="banner">
        <div class="card-container">
            <div class="row">
                <div class="column">
                    <div class="card">
                        <a href="newsupplier.php">
                            <i class="fas fa-user-plus fa-3x "></i>
                            <p>Add New Supplier</p>
                        </a>
                    </div>
                </div>
                <div class="column">
                    <div class="card">
                        <a href="viewsupplierdetails.php">
                            <i class="fas fa-users fa-3x"></i>
                            <p>Supplier Details</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="column">
                    <div class="card">
                        <a href="suplier_view.php">
                            <i class="fas fa-users fa-3x"></i>
                            <p>Supplier Edit</p>
                        </a>
                    </div>
                </div>
        </div>
        

    </section>
</body>

</html>
