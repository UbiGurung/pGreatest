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

	if(isset($_SESSION['id']) or isset($_POST['user']))
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';

		if(isset($_POST['user']))
		{
			$id = $_POST['user'];
		}
		else
		{
			$id = $_SESSION['id'];
		}

		try
		{
			$sql = "SELECT id, username, displayPicture, dateJoin, profileInfo FROM user WHERE id = :id";
			$s = $pdo->prepare($sql);
			$s->bindValue(":id", $id);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not gather user details";
			include '../includes/error.html.php';
			exit();
		}
		
		$results = $s->fetch();

		$userId = $results['id'];

		if(isset($_POST['user']))
		{
			$username = $results['username'];
		}
		else
		{
			$username = $_SESSION['username'];
		}
		
		$dateJoin = $results['dateJoin'];
		$dp = $results['displayPicture'];
		$profileInfo = $results['profileInfo'];
		$dpDefault = '../uploads/displayPicture/default.png';

		try
		{
			$sql = "SELECT poll.id, poll.pollname, poll.userId, poll.polldate, poll.thumbnailURL, voted.voteDate FROM poll
			INNER JOIN voted
			ON poll.id = voted.pollid
			WHERE voted.userId = :id
			ORDER BY voted.voteDate DESC limit 5";
			$s = $pdo->prepare($sql);
			$s->bindValue(":id", $id);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not gather poll history for user." . $e;
			include '../includes/error.html.php';
			exit();
		}

		$history = $s->fetchAll();

		foreach($history as $row)
		{
			$pollHisSearch[] = array('id' => $row['id'], 'pollname' => $row['pollname'], 'thumbnailURL' => $row['thumbnailURL'], 'voteDate' => $row['voteDate']);
		}
	}
	else
	{
		header('Location: ../home/index.php');
		exit();
	}

	if (pollExist($userId))
		{
			include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
			try
			{
				$sql = "SELECT id, pollname, pollText, thumbnailURL, voters 
				FROM poll 
				WHERE userId = :userId AND visible = 1
				ORDER BY voters DESC
				limit 10";
				$s = $pdo->prepare($sql);
				$s->bindValue(":userId", $userId);
				$s->execute();
			}
			catch(PDOException $e)
			{
				$error = "Could not create the poll" . $e;
				include '../includes/error.html.php';
				exit();
			}
			
			$polls = $s->fetchAll();
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