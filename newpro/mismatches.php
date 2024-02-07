<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="CSS/mismatches.css">
</head>
<body style="background-image: url(images/medi1.jpg);">
    <section id="header">
        <div class="header-container">
            <h1>Inventory Management System - Royal Medical Stores</h1>
        </div>
    </section>
    <section id="banner">
        <div class="container">
            <h1 class="inventory-header"><u>Drug Missmatches</u></h1>
            <p class=" subtitle"> You can use this interface to record missmatches of the drugs while checking a lot. <br><br> Ex. for missmatches: <br><li><b>Expiry Medicine , Wrong drug quantity , etc. </b></li></p>
            <form id="drugmismatches">
<div class="form-row">
    <div class="form-column">
        <label for="missmatchID" >Missmatch ID:</label>
        <input type="text" id="missmatchID" readonly>
    </div>
    
</div>

<div class="form-row">
    <div class="form-column">
        <label for="medicineID" >Medicine ID: </label>
        <input type="text" id="medicineID" placeholder="Enter the Medicine ID">
    </div>
    <div class="form-column">
        <label for="medicinename" >Medicine Name:</label>
        <select id="medicinename">
            <option value="medicinename"></option>
            <option value="medicinename"></option>
            <option value="medicinename"></option>
            <option value="medicinename"></option>
        </select>
    </div>
</div>

<div class="form-row">
    <div class="form-column">
        <label for="type" >Type:</label>
        <select id="type">
            <option value="type"></option>
            <option value="type"></option>
            <option value="type"></option>
            <option value="type"></option>
        </select>
    </div>
    <div class="form-column">
        <label for="dose" >Dose:</label>
        <select id="dose">
            <option value="dose"></option>
            <option value="dose"></option>
            <option value="dose"></option>
            <option value="dose"></option>
        </select>
    </div>
    </div>
    
<div class="form-row">
    <div class="form-column">
        <label for="suppliername" >Supplier Name:</label>
        <select id="suppliername">
            <option value="suppliername"></option>
            <option value="suppliername"></option>
            <option value="suppliername"></option>
            <option value="suppliername"></option>
        </select>
    </div>
    <div class="form-column">
        <label for="date" >Date:</label>
        <input type="date" id="date" >
    </div>
    </div>

    <div class="form-row">
        <div class="form-column">
            <label for="reason">Mismatch reason:</label><br>
            <textarea id="reason" rows="3" cols="90"></textarea>
        </div>
       
        </div>

<div class="button-container">
    <button type="submit">Submit</button>
</div>
            </form>
        </div>
    </section>


</body>
</html>
