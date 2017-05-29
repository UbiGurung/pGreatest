<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Create Picks</title>
	<?php include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/head.html.php'; ?>
	<link rel="stylesheet" type="text/css" href="../css/register.css">
	
	<style>
		body{
			background: url(<?php htmlout(random_pic()); ?>);
			background-size: cover;
		}
	</style>
</head>



<body>
		<form class="register" method="post" action="">
			<div class="heading"><h1>Sign Up</h1></div>
			<div class="element"><span class="glyphicon glyphicon-envelope"></span><input type="email" name="email" class="signUp" placeholder="Email"></div></br>
			<div class="element"><span class="glyphicon glyphicon-user"></span><input type="text" name="username" class="signUp" placeholder="Username"></div></br>
			<div class="element"><span class="glyphicon glyphicon-lock"></span><input type="password" name="password" class="signUp" placeholder="Password"></div>
			<input type="hidden" name="action" value="register">
			<input type="submit" value="Register" class="registerBtn">
			<?php if(!empty($_SESSION['error'])) {echo $_SESSION['error']; unset($_SESSION['error']);} ?>
		</form>
</body>
</html>