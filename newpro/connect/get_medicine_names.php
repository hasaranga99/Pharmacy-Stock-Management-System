<?php
require '../connect.php';  

$medicineNames = array();


$db = new DatabaseConnection();


$query = $db->getConnection()->query('SELECT medicineName FROM products');
while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
    $medicineNames[] = $row['medicineName'];
}


echo json_encode($medicineNames);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  

    
    $medicineName = isset($_POST['medicineName']) ? $_POST['medicineName'] : null;
    // $medicineID = isset($_POST['medicineID']) ? $_POST['medicineID'] : null;

    
    if ($medicineName !== null) {
       
        $productTypes = $_POST['product_type'];
        $productDoses = $_POST['product_dose'];
        $productAddNotes = $_POST['product_AddNote'];
        $productQtys = $_POST['product_qty'];
        $supplierNames = $_POST['supplier_name'];
        $manuDates = $_POST['manu_date'];
        $expDates = $_POST['exp_date'];
        $purchPrices = $_POST['purch_price'];
        $sellPrices = $_POST['sell_price'];
        $descriptions = $_POST['description'];

        
        $numRows = count($productTypes);

       
        for ($i = 0; $i < $numRows; $i++) {
           
            $productType = $productTypes[$i];
            $productDose = $productDoses[$i];
            $productAddNote = $productAddNotes[$i];
            $productQty = $productQtys[$i];
            $supplierName = $supplierNames[$i];
            $manuDate = $manuDates[$i];
            $expDate = $expDates[$i];
            $purchPrice = $purchPrices[$i];
            $sellPrice = $sellPrices[$i];
            $description = $descriptions[$i];

           
            $sql = "INSERT INTO update_inve (medicineName, productType, productDose, productAddNote, productQty, supplierName, manuDate, expDate, purchPrice, sellPrice, description) VALUES (:medicineName, :productType, :productDose, :productAddNote, :productQty, :supplierName, :manuDate, :expDate, :purchPrice, :sellPrice, :description)";
            $stmt = $db->getConnection()->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':medicineName', $medicineName, PDO::PARAM_STR);
            $stmt->bindParam(':productType', $productType, PDO::PARAM_STR);
            $stmt->bindParam(':productDose', $productDose, PDO::PARAM_STR);
            $stmt->bindParam(':productAddNote', $productAddNote, PDO::PARAM_STR);
            $stmt->bindParam(':productQty', $productQty, PDO::PARAM_STR);
            $stmt->bindParam(':supplierName', $supplierName, PDO::PARAM_STR);
            $stmt->bindParam(':manuDate', $manuDate, PDO::PARAM_STR);
            $stmt->bindParam(':expDate', $expDate, PDO::PARAM_STR);
            $stmt->bindParam(':purchPrice', $purchPrice, PDO::PARAM_STR);
            $stmt->bindParam(':sellPrice', $sellPrice, PDO::PARAM_STR);
            $stmt->bindParam(':description', $description, PDO::PARAM_STR);

            // Execute the query
            if ($stmt->execute()) {
               
            } else {
               
                echo "Error: " . $stmt->errorInfo();
            }
        }
    } else {
        echo "Medicine name and ID are required.";
    }
} else {
    echo "Invalid request.";
}


?>
