<?php session_start(); 
 include "./sessions.php";

 if (!isset($_SESSION["user"])) {
     header("Location: login.php");
     die();
 }
?>
<!DOCTYPE html>

<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="CSS/login1st.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
          body {
            background-image: url('../images/medi1.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }

        #header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
        }

        #header h1 {
            margin: 0px 250px;
        }

        #header a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            padding: 5px 10px;
            background-color: #333;
            border-radius: 5px;
        }

        /* Move the logout link to the right side */
        #header a {
            float: right;
        }
    </style>

</head>

<body style="background-image: url(images/medi1.jpg);">
    <section id="header">
        <div class="header-container">
            <h1>Royal Medical Stores</h1>
        </div>
        <div>
            <h1><a href="logout.php">Logout</a></h1>
            <span></span>
        </div>
    </section>
    <section id="banner">
        <div class="card-container">
            <div class="row">
                <div class="column">
                    <div class="card">
                        <a href="newproduct.php">
                            <i class="fas fa-pills fa-3x "></i>
                            <p>Add New Medicine</p>
                        </a>
                    </div>
                </div>
                <div class="column">
                    <div class="card">
                        <a href="AddaNewMedicineType.php">
                            <i class="fas fa-capsules fa-3x"></i>
                            <p>Add New Type</p>
                        </a>
                    </div>
                </div>
                <div class="column">
                    <div class="card">
                        <a href="inventory1.php">
                            <i class="fas fa-warehouse fa-3x"></i>
                            <p>Stock</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <div class="card">
                        <a href="supplier2.php">
                            <i class="fas fa-truck fa-3x"></i>
                            <p>Suppliers</p>
                        </a>
                    </div>
                </div>
                <div class="column">
                    <div class="card">
                        <a href="PurchaseOrder1.php">
                            <i class="fas fa-file-invoice-dollar fa-3x"></i>
                            <p>Purchase Order</p>
                        </a>
                    </div>
                </div>
                <div class="column">
                    <div class="card">
                        <a href="AllReport.php">
                            <i class="fas fa-chart-bar fa-3x"></i>
                            <p>Reports</p>
                        </a>
                    </div>
                </div>
                <div class="column">
                    <div class="card">
                        <a href="report.php">
                            <i class="fas fa-search fa-3x"></i>
                            <p>View</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </section>
</body>

</html>