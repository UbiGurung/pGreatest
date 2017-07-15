<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/magicquotes.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/pollMake.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/access.inc.php';

if(userLoggedIn())
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';

		try
		{
			$sql = "SELECT DISTINCT messages.id, messages.subject, messages.fromId, messages.message, messages.messageStamp, user.username, user.displayPicture 
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

	$preSend = false;

	if(isset($_POST['toName']))
	{
		$preSend = true;
		$toName = $_POST['toName'];
	}

	if(isset($_GET['messageSend']))
	{
		$fromId = $_SESSION['id'];
		$toName = $_POST['username'];
		$subject = $_POST['subject'];
		$messageContent = $_POST['messageContent'];

		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';

		try
		{
			$sql = "SELECT id FROM user WHERE username = :username";
			$s = $pdo->prepare($sql);
			$s->bindValue(":username", $toName);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Failure in getting username of recipient " . $e;
			include '../includes/error.html.php';
			exit();
		}

		$results = $s->fetch();

		$toId = $results['id'];

		try
		{
			$sql = "INSERT INTO messages SET
				subject = :subject,
				message = :message,
				fromId = :fromId,
				toId = :toId,
				messageStamp = CURDATE()";
			$s = $pdo->prepare($sql);
			$s->bindValue(":subject", $subject);
			$s->bindValue(":message", $messageContent);
			$s->bindValue(":fromId", $fromId);
			$s->bindValue(":toId", $toId);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Failed inserting message into the database " . $e;
			include '../includes/error.html.php';
			exit();
		}
	}

include 'message.html.php';