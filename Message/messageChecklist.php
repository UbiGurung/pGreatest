<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/magicquotes.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/pollMake.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/access.inc.php';

if($_GET['toName'])
	{
		$name = $_GET['toName'];

		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';

		try
		{
			$sql = "SELECT COUNT(*) FROM user WHERE username = :name";
			$s = $pdo->prepare($sql);
			$s->bindValue(":name", $name);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not check if username is valid";
			include '../includes/error.html.php';
			exit();
		}

		$count = $s->fetch();

		if($count[0] > 0)
		{
			$userExistsError = "";
		}
		else
		{
			$userExistsError = "Username is invalid or user does not exist";
		}
	}

	echo $userExistsError;