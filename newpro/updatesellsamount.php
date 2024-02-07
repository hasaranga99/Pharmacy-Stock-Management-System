<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href= "CSS/updatesellsamount.css">
    <title>Update Sells Amount</title>
</head>
<body style="background-image: url(images/medi1.jpg);">
    <section id="header">
        <div class="header-container">
            <h1>Inventory Management System - Royal Medical Stores</h1>
        </div>
    </section>
    <section id="banner">
        <div class="container">
            <h1><u>Update Inventory</u></h1><br>
            <form id="updateInventoryForm">
                <div class="form-row">
                    <div class="form-column">
                        <label for="currentAmount">Current Amount:</label>
                        <input type="text" id="currentAmount" readonly><br>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-column">
                        <label for="taken">Taken:</label>
                        <input type="number" id="taken" name="taken" required><br>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-column">
                        <label for="netAmount">Net Amount:</label>
                        <input type="text" id="netAmount" readonly>
                    </div>
                </div> 
                <div class="button-container">
                    <button type="submit">Update Inventory</button>
                </div>
            </form>
        </div>
    </section>
<!--
    <script>
        // JavaScript to calculate and populate current amount and net amount
        const takenInput = document.getElementById('taken');
        const currentAmountInput = document.getElementById('currentAmount');
        const netAmountInput = document.getElementById('netAmount');

        takenInput.addEventListener('input', function() {
            const taken = parseFloat(takenInput.value) || 0; // Ensure it's a number
            const currentAmount = 50; // Set your current amount here (you can fetch it from your data)
            const netAmount = currentAmount - taken;
            
            currentAmountInput.value = currentAmount;
            netAmountInput.value = netAmount;
        });
    </script>
-->
</body>
</html>