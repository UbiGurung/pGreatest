<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/magicquotes.inc.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/pollMake.inc.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/access.inc.php';

	function random_pic($dir = 'bg')
	{
		$files = glob($dir . '/*.*');
		$file = array_rand($files);
		return $files[$file];
	}
	
	if($_SESSION['loggedIn'])
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
		
		try
		{
			$sql = "SELECT displayPicture, dateJoin, profileInfo FROM user WHERE id = :id";
			$s = $pdo->prepare($sql);
			$s->bindValue(":id", $_SESSION['id']);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not gather user details";
			include '../includes/error.html.php';
			exit();
		}
		
		$results = $s->fetch();
		
		$dateJoin = $results['dateJoin'];
		$dp = $results['displayPicture'];
		$profileInfo = $results['profileInfo'];
		$dpDefault = '../uploads/displayPicture/default.png';
	}
	else
	{
		header('Location: ../home/index.php');
		exit();
	}

	if(isset($_POST['action']) and $_POST['action'] == 'Change')
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';

		try
		{
			$sql = "UPDATE user SET profileInfo = :newInfo WHERE id = :id";
			$s = $pdo->prepare($sql);
			$s->bindValue(":id", $_SESSION['id']);
			$s->bindValue(":newInfo", $_POST['newInfo']);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not gather user details";
			include '../includes/error.html.php';
			exit();
		}
		header('Refresh:0');
		exit();
	}

include 'profile.html.php';