<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="CSS/newproduct.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body style="background-image: url(images/medi1.jpg);">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
include('connect/insert_product.php');
?>
    <section id="header">
        <div class="header-container">
            <h1>Inventory Management System - Royal Medical Stores</h1>
        </div>
    </section>
    <section id="banner">
        <div class="container">
            <h1 class="inventory-header"><u>Add a New Product</u></h1>
            <br>
            <form id="newproductform" method="POST">
                <div class="form-row">
                    <div class="form-column">
                        <label for="medicineName">Medicine Name:</label>
                        <input type="text" id="medicineName" name="medicineName" placeholder="Enter Medicine Name">
                    </div>
                </div>
                <!-- Plus button above the table -->
                <button id="add-row-btn" type="button" class="plus-button" ><i class="fas fa-plus"></i></button>

                <!-- Scrollable box for the table -->
                <div class="scrollable-box">
                    <table id="order-details-table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Dose</th>
                                <th>Additional Info</th>
                                <th>Manuf. Date</th>
                                <th>Exp. Date</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Supplier</th>
                                <th>Reorder level</th>
                                <th>Description</th>
                                <th>Action</th>   <!--This is for the plus button column -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><select type="text" name="product_type[]">
                                <option value="Option 1">Select Type</option>
                                <?php
                                   
                                    require 'connect.php';  
                                    $db = new DatabaseConnection();
                                    $query = $db->getConnection()->query('SELECT medicine_type FROM medicine_types');
                                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $row['medicine_type'] . '">' . $row['medicine_type'] . '</option>';
                                    }
                                ?>
                                </select>
                                </td>
                                <td><select type="text" name="product_dose[]">
                                <option value="Option 1">Select Dose</option>
                                <?php
                                    $doseQuery = $db->getConnection()->query('SELECT new_dose FROM medicine_types');
                                    while ($doseRow = $doseQuery->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $doseRow['new_dose'] . '">' . $doseRow['new_dose'] . '</option>';
                                    }
                                ?>
                                </select>
                                </td>
                                <td><input type="text" name="addiinfo[]"></td>
                                <td><input type="date" name="manudate[]"></td>
                                <td><input type="date" name="expdate[]"></td>
                                <td><input type="number" name="quantity[]"></td>
                                <td><input type="number" name="price[]"></td>
                                <td><select type="text" name="suppliername[]">
                                <option value="Option 1">Select SupplierName</option>
                                <?php
                                    $doseQuery = $db->getConnection()->query('SELECT SupplierName,SupplierID FROM supplier WHERE supplier_status = 1');
                                    while ($doseRow = $doseQuery->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $doseRow['SupplierID'] . '">' . $doseRow['SupplierName'] . '</option>';
                                    }
                                ?>
                                </select>
                                </td>
                                <td><input type="number" name="reorderlevel[]"></td>
                                <td><input type="text" name="description[]"></td>
                                <td><button class="delete-button"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="button-container">
                    <button type="submit">Add New Medicine</button>
                </div>
            </form>
        </div>
    </section>
    <!-- <script>
        // JavaScript to add rows to the table when the plus button is clicked
        const table = document.getElementById('order-details-table');
        const addRowButton = document.getElementById('add-row-btn');

        addRowButton.addEventListener('click', function () {
            // Add new row below the table headings
            const newRow = table.insertRow(1); // Insert below the table headings
            const columns = 11; // Number of columns in the table

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
                    deleteButton.addEventListener('click', function () {
                        // Delete the row when the delete button is clicked
                        table.deleteRow(newRow.rowIndex);
                    });
                    cell.appendChild(deleteButton);
                } else {
                    input.type = 'text';
                    if (i === columns - 7) {
                        input.type = 'date';
                    }if (i === columns - 8) {
                        input.type = 'date';
                    }
                    input.name = `product_${i}[]`;
                    cell.appendChild(input);
                }
            }
        });
    </script> -->
    <script>
        // JavaScript to add rows to the table when the plus button is clicked
        const table = document.getElementById('order-details-table');
        const addRowButton = document.getElementById('add-row-btn');
        const firstRow = table.querySelector('tbody tr');

        addRowButton.addEventListener('click', function () {
            // Clone the first row
            const newRow = firstRow.cloneNode(true);

            // Clear the selected values in the cloned row
            const selects = newRow.querySelectorAll('select');
            selects.forEach(select => {
                select.selectedIndex = 0;
            });

            // Clear the values in input fields
            const inputs = newRow.querySelectorAll('input[type="text"], input[type="date"], input[type="number"]');
            inputs.forEach(input => {
                input.value = "";
            });

            // Add the new row to the table
            table.querySelector('tbody').appendChild(newRow);

            const deleteButton = newRow.querySelector('.delete-button');
            deleteButton.addEventListener('click', function () {
                table.querySelector('tbody').removeChild(newRow);
            });
        });
    </script>
</body>
</html>
