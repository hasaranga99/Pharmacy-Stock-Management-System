<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require 'connect.php';

  $db = new DatabaseConnection();

  $medicineType = isset($_POST['medicine_type']) ? (string)$_POST['medicine_type'] : '';
//   $medicineTypeID = isset($_POST['medicine_type_id']) ? (string)$_POST['medicine_type_id'] : '';

  if (isset($_POST['new_dose']) && is_array($_POST['new_dose'])) {
      $newDoses = $_POST['new_dose'];

      foreach ($newDoses as $newDose) {
          // Insert data into the database
          $sql = "INSERT INTO medicine_types (medicine_type, new_dose) VALUES (:medicineType, :newDose)";
          $stmt = $db->getConnection()->prepare($sql);
          $stmt->bindParam(':medicineType', $medicineType, PDO::PARAM_STR);
          $stmt->bindParam(':newDose', $newDose, PDO::PARAM_STR);

          if ($stmt->execute()) {
              // echo "New data added to the database.";
              $signup_success_msg = "
        <script>
        swal({
            title: 'Update successfull!',
            text: 'Happy Day!',
            icon: 'success'
          })
      </script>";
      echo $signup_success_msg;
          } else {
              // echo "Error: " . $stmt->errorInfo()[2];
              $registrationFailedMessage = " <script>
        swal({
            icon: 'error',
            title: 'Registration failed!',
            text: `$stmt->errorInfo()[2]`
            })
        </script>"; 

			echo $registrationFailedMessage;

          }

          $stmt->closeCursor();
      }
  }

  $db = null;
}

?>
