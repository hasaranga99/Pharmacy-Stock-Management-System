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