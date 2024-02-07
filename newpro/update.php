


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

        /* Hover state */
        .button:hover {
            background-color: #ff5733;
        }
</style>

</head>
<body style="background-image: url(images/medi1.jpg);">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
include 'connect.php'; 


$database = new DatabaseConnection();


if (isset($_GET['id'])) {
    $id = $_GET['id'];

  
    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $database->getConnection()->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$record) {
        
        // echo "Record not found.";
        // exit;
    }
} else {
    
    // echo "ID not provided.";
    // exit;
}


if (isset($_POST['update'])) {
    $newProductName = $_POST['product_name'];
    $newProductType = $_POST['product_type'];
    $newProductDose = $_POST['product_dose'];
    $newProductAddNote = $_POST['product_AddNote'];
    $newProductQuantity = $_POST['product_quantity'];
    $newProductPrice = $_POST['product_price'];
    $newProductSupplier = $_POST['product_supplier'];
    $newProductDescription = $_POST['product_description'];
    $newSupplierStatus = $_POST['supplier_status'];

    
    $sql = "UPDATE products SET 
            medicineName = :name, 
            product_type = :type, 
            product_dose = :dose, 
            addiinfo = :addnote, 
            quantity = :quantity, 
            price = :price, 
            suppliername = :supplier, 
            description = :description,
            supplier_status = :status
            WHERE id = :id";
    
    $stmt = $database->getConnection()->prepare($sql);
    $stmt->bindParam(':name', $newProductName, PDO::PARAM_STR);
    $stmt->bindParam(':type', $newProductType, PDO::PARAM_STR);
    $stmt->bindParam(':dose', $newProductDose, PDO::PARAM_STR);
    $stmt->bindParam(':addnote', $newProductAddNote, PDO::PARAM_STR);
    $stmt->bindParam(':quantity', $newProductQuantity, PDO::PARAM_INT);
    $stmt->bindParam(':price', $newProductPrice, PDO::PARAM_STR);
    $stmt->bindParam(':supplier', $newProductSupplier, PDO::PARAM_STR);
    $stmt->bindParam(':description', $newProductDescription, PDO::PARAM_STR);
    $stmt->bindParam(':status', $newSupplierStatus, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        
        // echo "Record updated successfully.";
        $signup_success_msg = "
        <script>
          swal({
            title: 'Record updated successfully!',
            text: 'Happy Day!',
            icon: 'success'
          }).then(() => {
            window.location.href ='updatesells.php';
          });
        </script>";
      
      echo $signup_success_msg;
    } else {
       
        // echo "Error updating record: " . $stmt->errorInfo();
        $registrationFailedMessage = " <script>
        swal({
            icon: 'error',
            title: 'Record updated failed!',
            text: `$stmt->errorInfo()`
            })
        </script>"; 

			echo $registrationFailedMessage;
    }
}
?>
    <!-- Create a form to edit the record -->
    
    <form method="post" class="form1">
        <input type="text" name="product_name" value="<?php echo $record['medicineName']; ?>">
        <input type="text" name="product_type" value="<?php echo $record['product_type']; ?>">
        <input type="text" name="product_dose" value="<?php echo $record['product_dose']; ?>">
        <input type="text" name="product_AddNote" value="<?php echo $record['addiinfo']; ?>">
        <input type="number" id="net_amount" name="product_quantity" value="<?php echo $record['quantity']; ?>">
        <input type="text" name="product_price" value="<?php echo $record['price']; ?>">
        <input type="text" name="product_supplier" value="<?php echo $record['suppliername']; ?>">
        <input type="text" name="product_description" value="<?php echo $record['description'];?>">
        <input type="text"  name="supplier_status" value="<?php echo $record['supplier_status'];?>">
        <input type="submit" name="update" value="Update">
    </form>
    
     
    <form method="post" class="form2">
        <label for="product_quantity">Current Quantity</label>
        <input type="number" name="product_quantity" id="product_quantity" value="<?php echo $record['quantity']; ?>">
        
        <label for="decrease_amount">Decrease Amount</label>
        <input type="number" name="decrease_amount" id="decrease_amount">

        <br><br><hr>
        
        <!-- <button class="button"><a href="#" id="blockSupplierLink" style="color: black; text-decoration: none;">Block Supplier</a></button> -->
<button><a href="suplier_view.php" style="color: black; text-decoration: none;"> Supplier Details</a></button>


      
        
        
        
    </form>
  
   

    <script>
        const productQuantityInput = document.getElementById("product_quantity");
        const decreaseAmountInput = document.getElementById("decrease_amount");
        const netAmountOutput = document.getElementById("net_amount");

        productQuantityInput.addEventListener("input", updateNetAmount);
        decreaseAmountInput.addEventListener("input", updateNetAmount);

        function updateNetAmount() {
            const initialQuantity = parseInt(productQuantityInput.value) || 0;
            const decreaseAmount = parseInt(decreaseAmountInput.value) || 0;
            const netAmount = initialQuantity - decreaseAmount;
            netAmountOutput.value = netAmount;
        }
    </script>
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
          
          