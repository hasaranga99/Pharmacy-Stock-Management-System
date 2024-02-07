<?php
session_start() ?>

<!DOCTYPE html>
<html>

<head>
	<link rel="stylesheet" href="CSS/SignUp.css">
	<title>Sign up</title>
</head>

<body style="background-image: url(images/medi1.jpg);">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<?php
	if (isset($_SESSION["user"])) {
		header("Location: /");
		die();
	}
	if (
		isset($_POST["fullname"]) &&
		isset($_POST["username"]) &&
		isset($_POST["email"]) &&
		isset($_POST["pass"]) &&
		isset($_POST["re_pass"]) &&
		isset($_POST["designation"]) &&
		isset($_POST["phone"])
	) {

		$signup_success_msg = "
        <script>
        swal({
            title: 'Registration successfull!',
            text: 'Now sign into your account!',
            icon: 'success'
          }).then(() => {
            
              window.location.href = 'login.php';
            
          });
      </script>";

		require_once "connect.php";
		$databaseManager = new DatabaseConnection();
		$userInfo = $databaseManager->createUser(
			$_POST["username"],
			$_POST["fullname"],
			$_POST["email"],
			$_POST["pass"],
			$_POST["re_pass"],
			$_POST["phone"],
			$_POST["designation"]

		);
		if ($userInfo->validation && $userInfo->success) {
			echo $signup_success_msg;
		} else if (!$userInfo->validation) {
			$registrationFailedMessage = " <script>
        swal({
            icon: 'error',
            title: 'Registration failed!',
            text: `$userInfo->insertion_errors`
            })
        </script>";

			echo $registrationFailedMessage;
		}
	} ?>
	<section id="header">
		<div class="header-container">
			<h1>Inventory Management System - Royal Medical Stores </h1>
		</div>
	</section>
	<section id="banner">
		<form action="<?php echo basename($_SERVER['PHP_SELF']) ?>" method="post">
			<div class="container">
				<input name="username" required type="text" placeholder="UserName">
				<input name="fullname" required type="text" placeholder="Full Name">
				<input name="email" required type="email" placeholder="email">
				<input pattern="[0-9]{10}" title="Please enter a 10-digit phone number." name="phone" required type="tel" placeholder="mobile number">
				<select required name="designation">
					<option value="">--Designation--</option>
					<option value="storekeeper">Storekeeper</option>
					<option value="pharmacist">Pharmacist</option>
					<option value="manager">Manager</option>
				</select> <input name="pass" required type="password" placeholder="Create Password">
				<input name="re_pass" required type="password" placeholder="Comfrim Password">
				<button type="submit">SIGN UP</button>
			</div>
		</form>
	</section>
</body>

</html>