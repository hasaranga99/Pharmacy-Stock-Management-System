
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="CSS/AddaNewMedicineType.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body style="background-image: url(images/medi1.jpg);">
<?php
include('connect/insert_medicine_type.php');

?>
    <section id="header">
        <div class="header-container">
            <h2>Inventory Management System - Royal Medical Stores</h2>
        </div>
    </section>
    <section id="banner">
        <div class="container">
            <h1><u>Add New Medicine Type</u></h1>
            <br>
            <form id="AddaNewMedicineType" action="<?php echo basename($_SERVER['PHP_SELF']) ?>" method="POST">
                <div class="form-row">
                    <div class="form-column">
                        <label for="MedicineType">New Medicine Type:</label>
                        <input type="text" id="MedicineType" name="medicine_type" placeholder="Enter The New Medicine Type">
                    </div>
                    <!-- <div class="form-column">
                        <div class="form-column">
                            <label for="MedicineTypeID">Medicine Type ID:</label>
                            <input type="text" id="MedicineTypeID" name="medicine_type_id" placeholder="">
                        </div>
                    </div> -->
                </div>
                <br>
                <div class="form-row">
                    <div class="form-column">
                        <label for="NewDose">New Dose is Available?</label>
                        <!-- Use a Font Awesome icon for the plus button -->
                        <br/><button id="toggleNewDose" class="plus" type="button"><i class="fas fa-plus"></i></button>
                    </div>
                </div>
                <div id="newDoseInput" class="scrollable-box"></div>
                <div class="button-container">
                    <button type="submit">Add Product</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        // JavaScript to dynamically add a new dose input field
        const toggleNewDoseButton = document.getElementById('toggleNewDose');
        const newDoseContainer = document.getElementById('newDoseInput');

        let doseCount = 0;

        toggleNewDoseButton.addEventListener('click', function() {
            doseCount++;

            const newDoseInput = document.createElement('div');
            newDoseInput.className = 'dose-input';

            newDoseInput.innerHTML = `
                <div class="dose-row">
                    <input type="text" id="NewDoseInput${doseCount}" name="new_dose[]" placeholder="Enter The New Dose">
                    <button type="button" class="delete-dose"><i class="fas fa-trash"></i></button>
                </div>
            `;

            // Add an event listener to the delete button
            const deleteButton = newDoseInput.querySelector('.delete-dose');
            deleteButton.addEventListener('click', function() {
                newDoseContainer.removeChild(newDoseInput);
            });

            newDoseContainer.appendChild(newDoseInput);
        });
    </script>
</body>
</html>
