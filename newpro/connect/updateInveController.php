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
