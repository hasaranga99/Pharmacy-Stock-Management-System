<?php
include 'connect.php';


$database = new DatabaseConnection();



// Function to fetch data from the database
function fetchDataFromDatabase() {
    global $database;
    $sql = "SELECT id, medicineName, product_type, product_dose, addiinfo, quantity, price, suppliername,reorderlevel,expdate, description FROM products";
    $stmt = $database->getConnection()->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


$data = fetchDataFromDatabase();


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/updatesells.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Update Inventory</title>
    <style>

        #header {
            display: flex;
            justify-content: space-between;
            align-items: left;
            padding: 10px;
        }

        #header h1 {
            margin: 0px 450px 0px 0px;
        }

        /* #header h2 {
            margin: 0px 50px;
        } */

        #header a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            padding: 5px 10px;
            background-color: #333;
            border-radius: 5px;
        }
    
    #search-form {
        display: flex;
        align-items: center;
        margin-top: 20px;
    }

    input[type="text"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .search-button {
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        padding: 10px 15px;
        margin-left: 10px;
        cursor: pointer;
    }

    #banner {
        /* background-color: #f5f5f5; */
        padding: 20px;
    }

    #order-details-table {
        width: 100%;
        border-collapse: collapse;
    }

    #order-details-table caption {
        text-align: left;
        font-weight: bold;
        margin-bottom: 10px;
    }

    #order-details-table th {
        background-color: #007bff;
        color: #fff;
        padding: 10px;
        text-align: left;
    }

    #order-details-table td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: left;
    }

    #order-details-table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .expired {
        background-color: red;
    }

    .low-quantity {
            background-color: yellow;
        }

    .button-container {
    white-space: nowrap;
    }

    .button {
    display: inline-block;
    padding: 8px 12px;
    background-color: #007bff; 
    color: #fff; 
    text-decoration: none; 
    border: none;
    border-radius: 5px;
    margin-right: 5px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.button:hover {
    background-color: #0056b3; 
}

.edit-button {
    background-color: #007bff; 
}

.purchase-order-button {
    background-color: red; 
}
</style>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@12"></script>

</head>
<body style="background-image: url(images/medi1.jpg);">
    <section id="header">
        <div class="header-container">
            <h1>Inventory Management System - Royal Medical Stores</h1>
        </div>
        <div></div>
        <div></div>
        <div>
            <h2><a href="login1st.php">Home</a></h2>
        </div>
    </section>
    <section id="banner" >
        <div class="container">
            <h2 class="inventory-header"><b><u>Inventory Update From Sales</u></b></h2>
            <form id="search-form" style="margin: 0 0 10px">
                <input type="text" id="search-input" placeholder="Search.." style="width: 300px" oninput="searchTable()">
                <button type="button" class="search-button" onclick="searchTable()"><i class="fas fa-search"></i></button>
            </form>
            <br><br>
            <div class="scrollable-box">
                <table id="order-details-table" >
                    <caption>Medicine Details <h4 style="color: red"> <br><?php
            $purchaseOrderRequired = false;
            foreach ($data as $row) {
                if ($row['quantity'] == 0 || $row['quantity'] <= $row['reorderlevel']) {
                    $purchaseOrderRequired = true;
                    break; 
                }
            }
            if ($purchaseOrderRequired) {
                echo '<span id="notification">Notification: Purchase Order Required</span>';
            }
            ?></h4></caption>
                    
                    <thead >
                        <tr>
                            <th>Product Name</th>
                            <th>Type</th>
                            <th>Dose</th>
                            <th>Additional Note</th>
                            <th>Current Quantity</th>
                            <th>Price</th>
                            <th>Supplier Name</th>
                            <th>Description</th>
                            <th>Reorder Level</th>
                            <th>Expdate</th>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row) { ?>
                            
                            <tr>
                                <td><?php echo $row['medicineName']; ?></td>
                                <td><?php echo $row['product_type']; ?></td>
                                <td><?php echo $row['product_dose']; ?></td>
                                <td><?php echo $row['addiinfo']; ?></td>
                                <td <?php
                                    if ($row['quantity'] == 0) {
                                        echo 'class="expired"';
                                    } elseif ($row['quantity'] <= $row['reorderlevel']) {
                                        echo 'class="low-quantity"';
                                    }
                                ?>>
                                    <?php echo $row['quantity']; ?>
                                </td>
                                <td><?php echo $row['price']; ?></td>
                                <td><?php echo $row['suppliername']; ?></td>
                                <td><?php echo $row['description']; ?></td>
                                <td><?php echo $row['reorderlevel']; ?></td>    
                                <td id="expdate-<?php echo $row['id']; ?>"><?php echo $row['expdate']; ?></td>
                                <td class="button-container">
                                <a href="update.php?id=<?php echo $row['id']; ?>" class="button edit-button">Edit</a> 
                                <?php if ($row['quantity'] == 0 || $row['quantity'] <= $row['reorderlevel']) { ?>
                                    <a href="purchaseOrder.php?id=<?php echo $row['id']; ?>" class="button purchase-order-button">Order</a>
                                <?php } else { ?>
                                    <a href="#" class="button edit-button"></a>
                                <?php } ?>
                                

                            </td>


                                
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script>
        function checkExpiration() {
            const today = new Date();
            const rows = <?php echo json_encode($data); ?>; // Convert PHP data to JavaScript array

            rows.forEach(row => {
                const expdate = new Date(row.expdate);
                const id = row.id;
                const expdateCell = document.getElementById(`expdate-${id}`);

                if (expdate < today) {
                    expdateCell.style.backgroundColor = 'red';
                }
                
            });
        }

        
        window.onload = checkExpiration;
    </script>

    <script>
         
        function searchTable() {
            var input, filter, table, tr, td, i, txtValue;
            input = document.getElementById('search-input');
            filter = input.value.toUpperCase();
            table = document.getElementById('order-details-table');
            tr = table.getElementsByTagName('tr');

            for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
                td = tr[i].getElementsByTagName('td');
                tr[i].style.display = 'none'; // Hide the row by default

                for (var j = 0; j < td.length; j++) {
                    if (td[j]) {
                        txtValue = td[j].textContent || td[j].innerText;

                        if (txtValue.toUpperCase().indexOf(filter) > -1) {
                            tr[i].style.display = '';
                            break; // Show the row if a match is found and break the loop
                        }
                    }
                }
            }
        }
    </script>
</body>
</html>
