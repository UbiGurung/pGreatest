<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/magicquotes.inc.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/pollMake.inc.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/access.inc.php';

	if(isset($_POST['name']) and !userVoted($_POST['name'], $_SERVER['REMOTE_ADDR']))
	{
			include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
		try
		{
			$sql = "SELECT id, pickname, picktext, points FROM picks WHERE pollid = :pollId";
			$s = $pdo->prepare($sql);
			$s->bindValue(':pollId', $_POST['name']);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not find the selected pollId";
			include '../includes/error.html.php';
			exit();
		}
		$picks = $s->fetchAll();
		$pollId = $_POST['name'];
	}
	else
	{
		$pollId = $_POST['name'];
		header("Location: ../result/index.php?pollId=$pollId");
		exit();
	}
include '../pickTable/picks.html.php';



	