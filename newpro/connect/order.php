<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'connect.php';

    $db = new DatabaseConnection();

    $supplier = (string)$_POST['supplier'];
    $add_date = (string)$_POST['add_date'];

    $fieldsToCheck = [
        'product_name',
        'product_type',
        'product_dose',
        'product_quantity',
    ];

    $allFieldsAreArrays = true;
    foreach ($fieldsToCheck as $field) {
        if (!isset($_POST[$field]) || !is_array($_POST[$field])) {
            $allFieldsAreArrays = false;
            break;
        }
    }

    if ($allFieldsAreArrays) {
        $product_names = $_POST['product_name'];
        $product_types = $_POST['product_type'];
        $product_doses = $_POST['product_dose'];
        $product_quantities = $_POST['product_quantity'];

        // Check if there is any product data submitted
        if (count($product_names) > 0) {
            for ($i = 0; $i < count($product_names); $i++) {
                $product_name = (string)$product_names[$i];
                $product_type = (string)$product_types[$i];
                $product_dose = (string)$product_doses[$i];
                $product_quantity = (string)$product_quantities[$i];

                $sql = "INSERT INTO order_table (supplier, add_date, product_name, product_type, product_dose, product_quantity) 
                        VALUES (:supplier, :add_date, :product_name, :product_type, :product_dose, :product_quantity)";
                $stmt = $db->getConnection()->prepare($sql);
                $stmt->bindParam(':supplier', $supplier, PDO::PARAM_STR);
                $stmt->bindParam(':add_date', $add_date, PDO::PARAM_STR);
                $stmt->bindParam(':product_name', $product_name, PDO::PARAM_STR);
                $stmt->bindParam(':product_type', $product_type, PDO::PARAM_STR);
                $stmt->bindParam(':product_dose', $product_dose, PDO::PARAM_STR);
                $stmt->bindParam(':product_quantity', $product_quantity, PDO::PARAM_STR);

                if ($stmt->execute()) {
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
                title: 'Record updated failed!',
                text: 'No product data submitted'
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
            text: 'Product data is missing or not in the correct format'
            })
        </script>"; 

      echo $registrationFailedMessage;
    }

    $db = null;
}
?>
