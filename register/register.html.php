<?php include $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Create Picks</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/47585/slip.js"></script>
	<script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
	<script src="../includes/jquery.redirect.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Satisfy" rel="stylesheet">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="../css/mainCss.css">
	<link rel="stylesheet" type="text/css" href="../css/register.css">
	<link rel = "icon" href = "images/pgLogo2.jpg">
	
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