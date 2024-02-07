


<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/updatesells.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
    <title>Update Inventory</title>
    <style>
 body {
    font-family: Arial, sans-serif;
    background-color: #f5f5f5;
    margin: 0;
    padding: 0;
}

.container {
    width: 80%;
    max-width: 800px;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

h1 {
    text-align: center;
    color: #007bff;
}

form {
    display: grid;
    gap: 10px;
    margin: 10px 0 0 500px;
    width: 350px;
}

label {
    font-weight: bold;
}

input[type="text"],
input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin: 5px 0;
}

input[type="submit"] {
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 10px 15px;
    cursor: pointer;
    margin-top: 10px;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

.container form {
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

/* Style the table if needed */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    float: left;
}

table th {
    background-color: #007bff;
    color: #fff;
    padding: 10px;
    text-align: left;
}

table td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: left;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}
/* .second_form{
  display:block;

} */
.form1{
  display:block;
  float: left;
  margin:10px 100px 50px 100px

}

.form2{
  margin:100px 100px 50px 100px
}

.button {
            background-color: #f44336;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }

   
        .button:hover {
            background-color: #ff5733;
        }
   
.button {
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 8px 12px;
    margin-right: 5px;
    cursor: pointer;
}


input[type="button"] {
    color: black;
    text-decoration: none;
    background: none;
    border: none;
    cursor: pointer;
}


.button:hover {
    background-color: #0056b3;
}

</style>

</head>
<body style="background-image: url(images/medi1.jpg);">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
include 'connect.php';

$database = new DatabaseConnection();

if  (isset($_GET['SupplierID'])) {
    // Retrieve the SupplierID from the URL parameter
    $supplierID = $_GET["SupplierID"];
    
    // Fetch the supplier's information based on SupplierID
    $sql = "SELECT * FROM supplier WHERE SupplierID = :supplierID";
    $stmt = $database->getConnection()->prepare($sql);
    $stmt->bindParam(':supplierID', $supplierID, PDO::PARAM_INT);
    $stmt->execute();
    
    // Check if the supplier exists
    if ($stmt->rowCount() == 1) {
        $supplier = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Handle the case where the supplier doesn't exist
        echo "Supplier not found.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process the form data and update the database
    $updatedSupplierName = $_POST['SupplierName'];
    $updatedAddress = $_POST['Address'];
    $updatedEmail = $_POST['E_mail'];
    $updatedContact = $_POST['Contact'];
    $updatedAdditionalInfo = $_POST['AdditionalInfo'];
    $updatedsupplier_status = $_POST['supplier_status'];

    $sql = "UPDATE supplier SET SupplierName = :supplierName, Address = :address, E_mail = :email, Contact = :contact, AdditionalInfo = :additionalInfo, supplier_status = :status WHERE SupplierID = :supplierID";


    

    $stmt = $database->getConnection()->prepare($sql);
    $stmt->bindParam(':supplierName', $updatedSupplierName, PDO::PARAM_STR);
    $stmt->bindParam(':address', $updatedAddress, PDO::PARAM_STR);
    $stmt->bindParam(':email', $updatedEmail, PDO::PARAM_STR);
    $stmt->bindParam(':contact', $updatedContact, PDO::PARAM_STR);
    $stmt->bindParam(':additionalInfo', $updatedAdditionalInfo, PDO::PARAM_STR);
    $stmt->bindParam(':status', $updatedsupplier_status, PDO::PARAM_STR);
    $stmt->bindParam(':supplierID', $supplierID, PDO::PARAM_INT);
    
    if ($stmt->execute()) {
        // Redirect to the supplier list page or any other appropriate page
        // header("Location: supplier_list.php"); // Change to the appropriate page
        // exit;
        echo "Update Succesfully.";
    } else {
        // Handle the case where the update fails
        echo "Update failed.";
    }
}
?>
    <!-- Create a form to edit the record -->
    
    <form method="post" class="form1">
        <input type="text" name="SupplierName" value="<?php echo $supplier['SupplierName']; ?>">
        <input type="text" name="Address" value="<?php echo $supplier['Address']; ?>">
        <input type="text" name="E_mail" value="<?php echo $supplier['E_mail']; ?>">
        <input type="text" name="Contact" value="<?php echo $supplier['Contact']; ?>">
        <input type="text" name="AdditionalInfo" value="<?php echo $supplier['AdditionalInfo']; ?>">
        <input type="text"  name="supplier_status" value="<?php echo $supplier['supplier_status'];?>">
        <input type="submit" name="update" value="Update">
    </form>
    
     
    <form method="post" class="form2">
      
        <br><br><hr>
        <button class="button">
    <input id="blockSupplierLink" type="button" value="Block Supplier" style="color: black; text-decoration: none;">
</button>
<button>
    <input id="activeSupplierLink" type="button" value="Active Supplier" style="color: black; text-decoration: none;">
</button>



      
        
        
        
    </form>
   <script>
$(document).ready(function() {
    // Block Supplier Link Click Event
    $('#blockSupplierLink').click(function(e) {
        e.preventDefault(); // Prevent the default link behavior
        updateSupplierStatus(0);
    });

    // Active Supplier Link Click Event
    $('#activeSupplierLink').click(function(e) {
        e.preventDefault(); // Prevent the default link behavior
        updateSupplierStatus(1);
    });

    function updateSupplierStatus(newStatus) {
        // Update the input field directly
        $('input[name="supplier_status"]').val(newStatus);
    }
});
</script>


          </body>
          </html>
          
