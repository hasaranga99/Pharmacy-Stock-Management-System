<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'connect.php';

    $db = new DatabaseConnection();

    $medicineName = (string)$_POST['medicineName'];

    $fieldsToCheck = [
        'product_type',
        'product_dose',
        'addiinfo',
        'manudate',
        'expdate',
        'quantity',
        'price',
        'suppliername',
        'reorderlevel',
        'description'
    ];

    $allFieldsAreArrays = true;
    foreach ($fieldsToCheck as $field) {
        if (!isset($_POST[$field]) || !is_array($_POST[$field])) {
            $allFieldsAreArrays = false;
            break;
        }
    }

    if ($allFieldsAreArrays) {
        $product_types = $_POST['product_type'];
        $product_doses = $_POST['product_dose'];
        $addiinfo = $_POST['addiinfo'];
        $manudate = $_POST['manudate'];
        $expdate = $_POST['expdate'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $suppliername = $_POST['suppliername'];
        $reorderlevel = $_POST['reorderlevel'];
        $description = $_POST['description'];

        if (count($product_types) > 0) {
            for ($i = 0; $i < count($product_types); $i++) {
                $product_type = (string)$product_types[$i];
                $product_dose = (string)$product_doses[$i];
                $additionalInfo = (string)$addiinfo[$i];
                $manufactureDate = (string)$manudate[$i];
                $expiryDate = (string)$expdate[$i];
                $productQuantity = (string)$quantity[$i];
                $productPrice = (string)$price[$i];
                $supplierName = (string)$suppliername[$i];
                $reorderLevel = (string)$reorderlevel[$i];
                $productDescription = (string)$description[$i];

                $sql = "INSERT INTO products (medicineName, product_type, product_dose, addiinfo, manudate, expdate, quantity, price, suppliername, reorderlevel, description) VALUES (:medicineName, :product_type, :product_dose, :additionalInfo, :manufactureDate, :expiryDate, :productQuantity, :productPrice, :supplierName, :reorderLevel, :productDescription)";
                $stmt = $db->getConnection()->prepare($sql);
                $stmt->bindParam(':medicineName', $medicineName, PDO::PARAM_STR);
                $stmt->bindParam(':product_type', $product_type, PDO::PARAM_STR);
                $stmt->bindParam(':product_dose', $product_dose, PDO::PARAM_STR);
                $stmt->bindParam(':additionalInfo', $additionalInfo, PDO::PARAM_STR);
                $stmt->bindParam(':manufactureDate', $manufactureDate, PDO::PARAM_STR);
                $stmt->bindParam(':expiryDate', $expiryDate, PDO::PARAM_STR);
                $stmt->bindParam(':productQuantity', $productQuantity, PDO::PARAM_STR);
                $stmt->bindParam(':productPrice', $productPrice, PDO::PARAM_STR);
                $stmt->bindParam(':supplierName', $supplierName, PDO::PARAM_STR);
                $stmt->bindParam(':reorderLevel', $reorderLevel, PDO::PARAM_STR);
                $stmt->bindParam(':productDescription', $productDescription, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    // echo "New medicine added to the database.";
                    $signup_success_msg = "
        <script>
          swal({
            title: 'New medicine added to the database!',
            text: 'Happy Day!',
            icon: 'success'
          }).then(() => {
            window.location.href ='newproduct.php';
          });
        </script>";
      
      echo $signup_success_msg;
                } else {
                    // echo "Error: " . $stmt->errorInfo()[2];
                    $registrationFailedMessage = " <script>
                    swal({
                        icon: 'error',
                        title: 'Record updated failed!',
                        text: `$stmt->errorInfo()[2]`
                        })
                    </script>"; 
            
                        echo $registrationFailedMessage;
                }

                $stmt->closeCursor();
            }
        } else {
            // echo "No product data submitted.";
            $registrationFailedMessage = " <script>
            swal({
                icon: 'error',
                title: 'No product data submitted!',
                text: 'Record updated failed!',
                })
            </script>"; 
    
                echo $registrationFailedMessage;
        }
    } else {
        // echo "Product data is missing or not in the correct format.";
        $registrationFailedMessage = " <script>
        swal({
            icon: 'error',
            title: 'Record updated failed!',
            text: 'Product data is missing or not in the correct format',
            })
        </script>"; 

            echo $registrationFailedMessage;
    }

    $db = null;
}
?>
