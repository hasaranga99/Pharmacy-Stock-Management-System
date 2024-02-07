<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="CSS/PurchaseOrder.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body style="background-image: url(images/medi1.jpg);">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php
include('connect/order.php');
include('connect/get_data.php');

?>
    <section id="header">
        <div class="header-container">
            <h1>Inventory Management System - Royal Medical Stores</h1>
        </div>
    </section>
    <section id="banner">
        <div class="container">
            <h1 class="inventory-header"><u>Purchase Order</u></h1>
            <br>
            <form id="purchase-order-form" action="<?php echo basename($_SERVER['PHP_SELF']) ?>" method="post">
                <div class="form-row">
                    <div class="form-column">
                        <label for="orderID">Order ID:</label>
                        <input type="text" id="orderID" readonly>
                    </div>
                    <div class="form-column">
                        <label for="date">Date:</label>
                        <input type="date" id="date" name="add_date">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-column">
                        <label for="supplier">Choose a Supplier:</label>
                        <select id="supplier" name="supplier">
                            <option value="<?php echo $record['suppliername']; ?>"><?php echo $record['suppliername']; ?></option>
                            
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                </div>
                <!-- Plus button above the table -->
                <button id="add-row-btn" type="button" class="plus-button"><i class="fas fa-plus"></i></button>

                <!-- Scrollable box for the table -->
                <div class="scrollable-box">
                    <table id="order-details-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Type</th>
                                <th>Dose</th>
                                <th>Quantity</th>
                                <th>Action</th> <!-- This is for the plus button column -->
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="product_name[]" value="<?php echo $record['medicineName']; ?>"></td>
                                <td><input type="text" name="product_type[]" value="<?php echo $record['product_type']; ?>"></td>
                                <td><input type="text" name="product_dose[]" value="<?php echo $record['product_dose']; ?>"></td>
                                <td><input type="number" name="product_quantity[]" value="<?php echo $record['quantity']; ?>"></td>
                                <td><button class="delete-button"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="button-container">
                    <button type="submit">Add Order</button>
                </div>
            </form>
        </div>
    </section>
    <script>
        // JavaScript to add rows to the table when the plus button is clicked
        const table = document.getElementById('order-details-table');
        const addRowButton = document.getElementById('add-row-btn');

        addRowButton.addEventListener('click', function () {
            // Add new row below the table headings
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
                    deleteButton.addEventListener('click', function () {
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
        });
    </script>
</body>
</html>
