<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/magicquotes.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/pollMake.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/access.inc.php';

if(userLoggedIn())
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';

		try
		{
			$sql = "SELECT DISTINCT messages.fromId, messages.message, messages.messageStamp, user.username, user.displayPicture 
			FROM messages
			INNER JOIN user ON messages.fromId = user.id
			WHERE messages.toId = :userId
			ORDER BY messages.messageStamp DESC";
			$s = $pdo->prepare($sql);
			$s->bindValue(':userId', $_SESSION['id']);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not gather all message for user " . $e;
			include '../includes/error.html.php';
			exit();
		}

		$messageAll = $s->fetchAll();
	}
	else
	{
		header('Location: ../home/index.php');
		exit();
	}

include 'message.html.php';