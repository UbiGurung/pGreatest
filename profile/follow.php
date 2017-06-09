<?php

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/magicquotes.inc.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/pollMake.inc.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/access.inc.php';

include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';

	if($_GET['follow'] === '1')
		{
			try
			{
				$sql = "INSERT INTO friends SET 
				userId = :userId,
				friendId = :friendId";
				$s = $pdo->prepare($sql);
				$s->bindValue(':userId', $_SESSION['id']);
				$s->bindValue(':friendId', $_GET['followId']);
				$s->execute();
			}
			catch(PDOException $e)
			{
				$error = "Error trying to add friend " . $e;
				include '../includes/error.html.php';
				exit();
			}
			$followButton = "UnFollow";
		}
		elseif($_GET['follow'] === '0')
		{
			try
			{
				$sql = "DELETE FROM friends
				WHERE userId = :userId AND friendId = :friendId";
				$s = $pdo->prepare($sql);
				$s->bindValue(':userId', $_SESSION['id']);
				$s->bindValue(':friendId', $_GET['followId']);
				$s->execute();
			}
			catch(PDOException $e)
			{
				$error = "Could not unfollow friend from user " . $e;
				include '../includes/error.html.php';
				exit();
			}
			$followButton = "Follow";
		}
	echo $followButton;
?>