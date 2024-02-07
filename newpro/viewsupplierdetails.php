<?php session_start();
include "./sessions.php";

if (!isset($_SESSION["user"])) {
    header("Location: /login.php");
    die();
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="CSS/viewsupplierdetails.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body style="background-image: url(images/medi1.jpg);">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <?php
    include "./sessions.php";

    if ($_SESSION["designation"] !== "manager") {
        header("Location: login.php");
        die();
    }

    require_once "connect.php";

    $databaseManager = new DatabaseConnection();
    $suppliersInfo = $databaseManager->getAllOfAnEntiry("supplier");
    $medicineInfo = $databaseManager->getAllOfAnEntiry("medicine");
    $supplierInfo = new stdClass();
    $supplierInfo->supplier = null;

    if (
        isset($_GET['SupplierID'])
    ) {

        $getSupplierInfo = $databaseManager->getAllOfAnEntityColumnCondition("supplier", "SupplierID", $_GET['SupplierID']);
        if (!empty($getSupplierInfo)) {
            $getSupplierInfo = $getSupplierInfo[0];
        }
        if (!empty($getSupplierInfo)) {
            $supplierInfo->supplier = true;
            $supplierInfo->SupplierID = $getSupplierInfo->SupplierID;
            $supplierInfo->SupplierName = $getSupplierInfo->SupplierName;
            $supplierInfo->Address     = $getSupplierInfo->Address;
            $supplierInfo->E_mail     = $getSupplierInfo->E_mail;
            $supplierInfo->Contact     = $getSupplierInfo->Contact;
            $supplierInfo->AdditionalInfo     = $getSupplierInfo->AdditionalInfo;
        }
    }


    ?>
    <section id="header">
        <div class="header-container">
            <h1>Inventory Management System - Royal Medical Stores </h1>
        </div>
    </section>
    <section id="banner">

        <div class="container">
            <h2 class="inventory-header"><b>Supplier Details</b></h2>
            <form action="<?php echo basename($_SERVER['PHP_SELF']) ?>" method="get" id="search-form">
                <div class="form-row">
                    <div class="form-column">
                        <select name="SupplierID" id="Suppliername">
                            <option value='-'>--choose--</option>";
                            <?php if (!empty($suppliersInfo)) {
                                foreach ($suppliersInfo as $index => $row) {
                                    $selectionInfo = "";

                                    if ($supplierInfo->supplier) {
                                        if ($row->SupplierID == $supplierInfo->SupplierID) {
                                            $selectionInfo = 'selected="selected"';
                                        }
                                    }
                                    echo "<option " . $selectionInfo . " value='$row->SupplierID'>$row->SupplierName</option>";
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="form-column">
                        <!-- Add the search icon to the button -->
                        <button type="submit" class="search-button"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </form>
            <?php if (!empty($supplierInfo->supplier)) { ?>
                <br><br>
                <h2 class="inventory-header"><b><u>Results</u></b></h2>

                <form id="supplierform">
                    <div class="form-row">
                        <div class="form-column">
                            <label for="suppliername">Supplier Name:</label>
                            <input value="<?php echo $supplierInfo->SupplierName ?>" type="text" id="suppliername" readonly>
                        </div>
                        <div class="form-column">
                            <label for="Address">Address:</label>
                            <input value="<?php echo  $supplierInfo->Address ?>" type="text" id="Address" readonly>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-column">
                            <label for="Contact">Contact Phone:</label>
                            <input value="<?php echo  $supplierInfo->Contact ?>" type="text" id="suppliername" readonly>
                        </div>
                        <div class="form-column">
                            <label for="Address">Contact Email:</label>
                            <input value="<?php echo $supplierInfo->E_mail ?>" type="text" id="email" readonly>
                        </div>
                    </div>
                </form>


                <!-- Scrollable box for the table -->
                <div class="scrollable-box">
                    <table id="order-details-table">
                        <caption>Medicine Details</caption>
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Type</th>
                                <th>Dose</th>
                                <th>Aditional Note</th>

                            </tr>
                        </thead>
                        <tbody>
                        <?php
            // Replace with your database connection code
            // require 'connect.php';
            $db = new DatabaseConnection();

            // Replace with your SQL query to fetch product data
            $selectedSupplierName = ""; // Initialize with an empty string

                if (!empty($suppliersInfo)) {
                    // Check if a supplier is selected
                    if (isset($_GET['SupplierID']) && $_GET['SupplierID'] != '-') {
                        // Find the selected supplier name based on the SupplierID
                        $selectedSupplierID = $_GET['SupplierID'];
                        foreach ($suppliersInfo as $row) {
                            if ($row->SupplierID == $selectedSupplierID) {
                                $selectedSupplierName = $row->SupplierName;
                                break;
                            }
                        }
                    }
                }

                // Use the selected supplier name in the SQL query
                $query = $db->getConnection()->query("SELECT * FROM products WHERE suppliername = '$selectedSupplierID'");


            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>';
                echo '<td><input readonly type="text" name="product_name" value="' . $row['medicineName'] . '"></td>';
                echo '<td><input readonly type="text" name="product_type" value="' . $row['product_type'] . '"></td>';
                echo '<td><input readonly type="text" name="product_dose" value="' . $row['product_dose'] . '"></td>';
                echo '<td><input readonly type="text" name="additional_note" value="' . $row['addiinfo'] . '"></td>';
                echo '</tr>';
            }
            ?>
                            <!-- <tr>
                                <td><input readonly type="text" name="product_name"></td>
                                <td><input readonly type="text" name="product_name"></td>
                                <td><input readonly type="text" name="product_name"></td>
                                <td><input readonly type="text" name="product_name"></td>


                            </tr> -->
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <h2 class="inventory-header"><b><u>Choose a supplier</u></b></h2>
            <?php } ?>
        </div>
    </section>
</body>

</html>