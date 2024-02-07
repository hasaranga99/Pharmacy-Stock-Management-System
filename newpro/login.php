<?php session_start(); ?>

<!DOCTYPE html>
<html>

<head>
	<title>Log into the system</title>
	<link rel="stylesheet" href="CSS/Login page.css">
	<style>
		.container button {
			width: 100%;
		}
	</style>
</head>

<body style="background-image: url(images/medi1.jpg);">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

	<?php
	if ((isset($_SESSION["user"]))) {
		header("Location: login1st.php");
		die();
	}

	require_once "connect.php";

	if (isset($_POST["username"]) && isset($_POST["yourPass"])) {
		if ((trim($_POST["username"]) || null) && (trim($_POST["yourPass"]) || null)) {

			$databaseManager = new DatabaseConnection();

			$invalid_credentials_msg = '
                <script>
                swal({
					title: "Failed to log in",
					text: "Invalid credentials or user does not exist",
					icon: "error",
				  }).then(function() {
					window.location = "' . basename($_SERVER['PHP_SELF']) . '";
				});
                </script>
                            ';

			$password = $_POST["yourPass"];
			$username = $_POST["username"];
			$rememberme = isset($_POST["rememberme"]) ? $_POST["rememberme"] : false;

			$userInfo = $databaseManager->getUserInfo($username);

			if ($userInfo) {
				if (password_verify($password, $userInfo->Password)) {
					$_SESSION['user'] = $userInfo->UserID;
					$_SESSION['designation'] = $userInfo->Designation;

					if ($rememberme) {
						$expiration = time() + 30 * 24 * 60 * 60;
						setcookie("user", "$userInfo->UserID", $expiration, "/", "", false, true);
						setcookie("designation", "$userInfo->Designation", $expiration, "/", "", false, true);
					}
					header("Location: login1st" . $location . ".php");
					die();
				}
				echo $invalid_credentials_msg;
			} else {
				echo $invalid_credentials_msg;
			}
		}
	}
	?>

	<!-- <section id="header">
		<div class="header-container">
			<h1>Inventory Management System - Royal Medical Stores</h1>
		</div>
	</section> -->
	<section id="banner">
		<div class="container">
			<nav>
				<div class="dashboard">
					<form method="POST" action="<?php echo basename($_SERVER['PHP_SELF']) ?>">

						<input required name="username" type="Username" placeholder="Username">
						<input required name="yourPass" type="password" placeholder="Password">
						<button type="submit" value="LOG IN">LOG IN</button>
						<div class="options">
							<a href="ForgotPass.php">Forgot Password</a>
							<a href="SignUp.php">Register</a>
							<label> <input type="checkbox" name="rememberme" id="remember_me" class="remember-me" value="1">
								Remember Me</label>
						</div>
				</div>
			</nav>
	</section>
</body>

</html>