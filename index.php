<?php require_once('./database/connection.php') ?>

<?php
session_start();
if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
	header('location: ./show-tasks.php');
}
$email = "";

if (isset($_POST['submit'])) {
	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);

	if (empty($email)) {
		$error = "Enter the email!";
	} elseif (empty($password)) {
		$error = "Enter the password!";
	} else {
		$hashed_password = sha1($password);
		$sql = "SELECT * FROM `users` WHERE `email` = '$email' AND `password` = '$hashed_password'";
		$result = $conn->query($sql);

		if ($result->num_rows == 1) {
			$user = $result->fetch_assoc();
			$_SESSION['user'] = $user;
			header('location: ./show-tasks.php');
		} else {
			$error = "Invalid combination!";
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link rel="shortcut icon" href="./assets/img/icons/icon-48x48.png" />

	<link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

	<title>Sign In</title>
	
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
	<link href="./assets/css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">

						<div class="text-center mt-4">
							<h1 class="h2">Welcome back, Shoppers</h1>
							<p class="lead">
								Sign in to your account to continue
							</p>
						</div>

						<div class="card">
							<div class="card-body">
								<div class="m-sm-4">

									<?php require_once('./partials/alerts.php'); ?>

									<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
										<div class="mb-3">
											<label for="email" class="form-label">Email</label>
											<input type="email" class="form-control" name="email" id="email" placeholder="Enter your email!" value="<?php echo $email ?>">
										</div>

										<div class="mb-3">
											<label for="password" class="form-label">Password</label>
											<input type="password" class="form-control" name="password" id="password" placeholder="Enter your password!">
										</div>

										<div class="mb-3">
											<input type="submit" name="submit" value="Login" class="btn btn-primary">
											<input type="reset" value="Reset" class="btn btn-dark">
										</div>

										<div>
											Do not have an account? <a href="./register.php">Register</a>
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</main>

	<script src="./assets/js/app.js"></script>

</body>

</html>