<?php
include 'connect.php';


$database = new DatabaseConnection();



// Function to fetch data from the database
function fetchDataFromDatabase() {
    global $database;
    $sql = "SELECT id, add_date, supplier, product_name, product_type, product_dose, product_quantity, timestamp_column FROM order_table";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Update Inventory</title>

    <style>
      body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
}

section {
    margin: 20px 0;
}

.header-container {
    background-color: #333;
    color: white;
    padding: 10px;
}

h1, h2 {
    margin: 0;
}

.container {
    max-width: 800px;
    margin: auto;
}

.inventory-header {
    text-align: center;
    color: #333;
}

form {
    text-align: center;
}

#search-input {
    padding: 8px;
}

.search-button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
}

.scrollable-box {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

caption {
    font-size: 18px;
    margin-bottom: 10px;
}

th, td {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

/* ... Previous styles ... */

#search-form {
    display: flex;
    align-items: center;
    justify-content: flex-end; /* Align to the right */
    margin-left: 1000px; /* Add some margin to create space from the right edge */
}

#search-input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px 0 0 5px;
}

.search-button {
    background-color: #4CAF50;
    color: white;
    border: 1px solid #4CAF50;
    border-radius: 0 5px 5px 0;
    padding: 10px 15px;
    cursor: pointer;
}

/* Highlight the search input and button on focus */
#search-input:focus,
.search-button:focus {
    outline: none;
    border-color: #4CAF50;
    box-shadow: 0 0 5px rgba(76, 175, 80, 0.7);
}

/* ... Remaining styles ... */

#datetime-start, #datetime-end {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        #datetime-filter-btn {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
            border-radius: 5px;
            padding: 10px 15px;
            cursor: pointer;
        }


    </style>
    

       
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@12"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</head>
<body >
    <section id="header" style="margin: 0px 0px 0px 0px">
        <div class="header-container">
            <h1 style="margin-left: 10px">Royal Medical Stores <span style="color:white;"><a href="login1st.php" style="color:white; margin-left:  970px;">Home</a></span></h1>
        </div>

    </section>
    <section id="report-content" >
    <h4 style="margin-left:1057px">Filter What You Want :   <br></h4>
        <div class="container">
        
            <form id="search-form" style="margin-left: 1000px">
                <input type="text" id="search-input" placeholder="Search.." style="width: 300px" oninput="searchTable()">
                <button type="button" class="search-button" onclick="searchTable()"><i class="fas fa-search"></i></button>
             
                
            </form>
            <br><br>
            <form id="search-form" style="margin-left: 1000px">
              <div class="form-column">
                  <label for="datetime-start">Start Date:</label>
                  <input type="date" id="datetime-start" name="datetime-start">
              </div>

              <div class="form-column">
                  <label for="datetime-end">End Date:</label>
                  <input type="date" id="datetime-end" name="datetime-end">
              </div>

              <button type="button" id="datetime-filter-btn" onclick="filterByDatetime()" style="margin-top:15px;">Filter</button>
          </form>

            
            <br>
                <button onclick="printReport()" style="margin-left:954px; color:white; background-Color: blue; size: 20px; mouse-point:courser point;cursor:pointer;" >Print Report</button>
            <br><br>
            
            <section>
            
            <img src="images/logo1.jpg" alt="RMS Store Logo" class="logo">
            <h2 class="inventory-header" style="margin-bottom:100px;"><b><u>Stock on hand Report</u></b></h2>
            </section>
            <div class="scrollable-box">
                <table id="order-details-table" >
                    <caption >Medicine Details</caption>
                    
                    <thead >
                        <tr>
                            <th>Date</th>
                            <th>Supplier Name</th>
                            <th>Medicine Name</th>
                            <th>Type</th>
                            <th>Dose</th>
                            <th>Quantity</th>
                          
                       
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data as $row) { ?>
                            
                            <tr>
                                <td><?php echo $row['add_date']; ?></td>
                                <td><?php echo $row['supplier']; ?></td>
                                <td><?php echo $row['product_name']; ?></td>
                                <td>
                                    <?php echo $row['product_type']; ?>
                                </td>
                                <td><?php echo $row['product_dose']; ?></td>
                                <td><?php echo $row['product_quantity']; ?></td>
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
     <script>
        function downloadReport() {
            const element = document.getElementById('report-content'); // Set an ID for the report section
            html2pdf(element);
        }
    </script>
    <script>
        function printReport() {
            window.print();
        }
    </script>
      <script>
        // ... Your existing scripts ...

        function filterByDatetime() {
    var startInput = document.getElementById('datetime-start');
    var endInput = document.getElementById('datetime-end');
    var startDatetime = new Date(startInput.value);
    var endDatetime = new Date(endInput.value);

    var table = document.getElementById('order-details-table');
    var rows = table.getElementsByTagName('tr');

    for (var i = 1; i < rows.length; i++) {
        var td = rows[i].getElementsByTagName('td')[0]; // Assuming the date is in the first column

        if (td) {
            var rowDatetime = new Date(td.textContent || td.innerText);

            if (rowDatetime >= startDatetime && rowDatetime <= endDatetime) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }
    }
}

    </script>

 </body>
</html>