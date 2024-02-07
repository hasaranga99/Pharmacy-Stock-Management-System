<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="CSS/UpdateInve.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body style="background-image: url(images/medi1.jpg);">
    <section id="header">
        <div class="header-container">
            <h1>Inventory Management System - Royal Medical Stores</h1>
        </div>
    </section>
    <section id="banner">
        <div class="container">
            <h1 class="inventory-header"><u>Update Inventory</u></h1>
            <br><br>
            <form id="updateinventoryform" method="post" action="connect/get_medicine_names.php">
                <div class="form-row">
                    <div class="form-column">
                        <label for="medicineName">Medicine Name:</label>
                        <select id="medicineName" name="medicineName"style="width: 300px;">
                        <?php
                             require_once('connect.php'); 

                            $db = new DatabaseConnection(); 
                            $sql = "SELECT medicineName FROM products"; 
                            $stmt = $db->getConnection()->query($sql);

                                    
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo '<option value="' . $row['medicineName'] . '">' . $row['medicineName'] . '</option>';
                            }
                        ?>
                        </select>
                    </div>
                    <!-- <div class="form-column">
                        <label for="medicineID">Medicine ID:</label>
                        <input type="text" id="medicineID" name="medicineID" placeholder=" ">
                    </div> -->
                </div>
                <div class="form-row">
                    <div class="form-column">
                        <label for="medicines" >Supply Medicine Names:</label>
                    <button id="add-row-btn"  type="button" class="plus-button"><i class="fas fa-plus"></i> </button>
                </div>
                </div>  
                <!-- Scrollable box for the table -->
                <div class="scrollable-box"> 
                    <table id="order-details-table">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Dose</th>
                                <th>Additional Info</th>
                                <th>Quantity</th>
                                <th>Supplier Name</th>
                                <th>Manufacturing Date</th>
                                <th>Expiry Date</th>
                                <th>Purchasing Price</th>
                                <th>Selling Price</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><select type="text" name="product_type[]">
                                <option value="Option 1">Select Type</option>
                                
                                <?php
                                    $typeQuery = $db->getConnection()->query('SELECT medicine_type FROM medicine_types');
                                    while ($typeRow = $typeQuery->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $typeRow['medicine_type'] . '">' . $typeRow['medicine_type'] . '</option>';
                                    }
                                ?>
    
                                </select>
                                </td>
                                <td><select type="text" name="product_dose[]">
                                <option value="Option 1">Select dose</option>
                                <?php
                                    $doseQuery = $db->getConnection()->query('SELECT new_dose FROM medicine_types');
                                    while ($doseRow = $doseQuery->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $doseRow['new_dose'] . '">' . $doseRow['new_dose'] . '</option>';
                                    }
                                ?>
                                </select>
                                </td>
                                <td><input type="text" name="product_AddNote[]"></td>
                                <td><input type="text" name="product_qty[]"></td>
                                <td><select type="text" name="supplier_name[]">
                                <option value="Option 1">Select supplier</option>
                                <?php
                                    $doseQuery = $db->getConnection()->query('SELECT SupplierName FROM supplier WHERE supplier_status = 1');
                                    while ($doseRow = $doseQuery->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $doseRow['SupplierName'] . '">' . $doseRow['SupplierName'] . '</option>';
                                    }
                                ?>
                                </select>
                                </td>
                                <td><input type="date" name="manu_date[]"></td>
                                <td><input type="date" name="exp_date[]"></td>
                                <td><input type="text" name="purch_price[]"></td>
                                <td><input type="text" name="sell_price[]"></td>
                                <td><input type="text" name="description[]"></td>
                                <td><button class="delete-button"><i class="fas fa-trash"></i></button></td>
                            </tr>
                        </tbody>
                    </table> 

                    </div>
                    <div class="button-container">
                        <button type="submit">Update Inventory</button>
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
    input.type = 'text'; // Change the input type to text in description column
    input.name = `product_${i}[]`;
    cell.appendChild(input);
}
 else if (i === columns - 1) {
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
                    if (i === columns - 5) {
                        input.type = 'date';
                    }
                    if (i === columns - 6) {
                        input.type = 'date';
                    }
                    if (i === columns - 3) {
                        input.type = 'text';
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
            const inputs = newRow.querySelectorAll('input[type="text"], input[type="date"]');
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
