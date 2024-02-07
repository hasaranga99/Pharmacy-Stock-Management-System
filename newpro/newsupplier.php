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
    <title>Add new supplier</title>
    <link rel="stylesheet" href="CSS/newsupplier.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body style="background-image: url(images/medi1.jpg);">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <?php
    include "./sessions.php";

    // if ($_SESSION["designation"] !== "manager") {
    //     header("Location: /login.php"); 
    //     die();
    // }
    if ($_SESSION["designation"] !== "manager") {
        echo "You do not have permission to access this page.";
        die();
    }

    if (
        isset($_POST['SupplierName']) &&
        isset($_POST['Contact']) &&
        isset($_POST['Address']) &&
        isset($_POST['E_mail']) &&
        isset($_POST['AdditionalInfo'])
    ) {

        $signup_success_msg = "
    <script>
    swal({
        title: 'Adding successfull!',
        text: 'Supplier was saved!',
        icon: 'success'
      }).then(()=>{window.location.href = 'newsupplier.php';})
  </script>";

        require_once "connect.php";
        $databaseManager = new DatabaseConnection();
        $supplierInfo = $databaseManager->createSupplier($_POST["SupplierName"], $_POST["Contact"], $_POST["E_mail"], $_POST["AdditionalInfo"], $_POST["Address"]);
        if ($supplierInfo->validation && $supplierInfo->success) {
            echo $signup_success_msg;
        } else if (!$supplierInfo->validation) {
            $registrationFailedMessage = " <script>
    swal({
        icon: 'error',
        title: 'Registration failed!',
        text: `$supplierInfo->insertion_errors`
        })
    </script>";

            echo $registrationFailedMessage;
        }
    }


    ?>
    <section id="header">
        <div class="header-container">
            <h1>Inventory Management System - Royal Medical Stores</h1>
        </div>
    </section>
    <section id="banner">
        <div class="container">
            <h1 class="inventory-header"><u>Add a New Supplier</u></h1>
            <br>
            <form method="post" action="<?php echo basename($_SERVER['PHP_SELF']) ?>" id="newsupplierform">
               
                <div class="form-row">
                    <!-- <div class="form-column">
                        <label for="supplierID">Supplier ID:</label>
                        <input required type="text" id="supplierID" placeholder="Enter Supplier ID">
                    </div> -->
                    <div class="form-column">
                        <label for="Suppliername">Supplier Name:</label>
                        <input name="SupplierName" required type="text" id="contact" placeholder="Enter the Supplier name">

                    </div>
                </div>

                <div class="form-row">
                    <div class="form-column">
                        <label for="contact">Contact Number: </label>
                        <input required name="Contact" type="tel" id="contact" placeholder="Enter the Contact Number">
                    </div>
                    <div class="form-column">
                        <label for="address">Address:</label>
                        <input name="Address" required type="text" id="address" placeholder="Enter the Supplier Address">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-column">
                        <label for="email">Email:</label>
                        <input name="E_mail" required type="email" id="email" placeholder="Enter the E-mail">
                    </div>
                    <div class="form-column">
                        <label for="note">Additional Info:</label>
                        <input name="AdditionalInfo" required type="text" id="note" placeholder="Enter the Additional Information">
                    </div>
                </div>

                <!--  <div class="form-row">
                    <div class="form-column">
                        <label for="medicines">Supply Medicine Details:</label>
                        <button id="add-row-btn" type="button" class="plus-button"><i class="fas fa-plus"></i></button>

                    </div>
                </div> -->

                <!-- <div class="scrollable-box">
                    <table id="order-details-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Type</th>
                                <th>Dose</th>
                                <th>Aditional Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="product_name[]"></td>
                                <td><input type="text" name="product_type[]"></td>
                                <td><input type="text" name="product_dose[]"></td>
                                <td><input type="text" name="product_AddNote[]"></td>
                                <td><button class="delete-button"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div> -->
                <div class="button-container">
                    <button type="submit">Add Supplier</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        /* const table = document.getElementById('order-details-table');
        const addRowButton = document.getElementById('add-row-btn');

        addRowButton.addEventListener('click', function() {
            const newRow = table.insertRow(1); // Insert below the table headings
            const columns = 5; // Number of columns in the table

            for (let i = 0; i < columns; i++) {
                const cell = newRow.insertCell(i);
                const input = document.createElement('input');
                if (i === columns - 2) {
                    const input = document.createElement('input');
                    input.type = 'text'; // Change the input type to text
                    input.name = `product_${i}[]`;
                    cell.appendChild(input);
                } else if (i === columns - 1) {
                    const deleteButton = document.createElement('button');
                    deleteButton.className = 'delete-button';
                    deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
                    deleteButton.addEventListener('click', function() {
                        // Delete the row when the delete button is clicked
                        table.deleteRow(newRow.rowIndex);
                    });
                    cell.appendChild(deleteButton);
                } else {
                    input.type = 'text';
                    if (i === columns - 3) {
                        input.type = 'text';
                    }
                    input.name = `product_${i}[]`;
                    cell.appendChild(input);
                }
            }
        }); */
    </script>

</body>

</html>