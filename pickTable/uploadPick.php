<?php


include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/magicquotes.inc.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/access.inc.php';

	
	if(isset($_POST['uploadPoll']))
	{
		
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
		$pollId = $_POST['uploadPoll'];
		$pos = $_POST['data'];
		foreach($pos as $row)
		{
			foreach($row as $key => $value)
			{
				if($key == 'id')
				{
					$valueId = $row['id'];
				}
				
				if($key == 'points')
				{
					$valuePoints = $row['points'];
					
				 $picks[] = array('id' => $valueId, 'points' => $valuePoints);
				}
			}
		}
	
		foreach ($picks as $pick)
		{
			try
			{
				$sql = "SELECT points FROM picks WHERE 	id = :pollId";
				$s = $pdo->prepare($sql);
				$s->bindValue(':pollId', $pick['id']);
				$s->execute();
			}
			catch(PDOException $e)
			{
				$error = "Could not get points from pick";
				include '../includes/error.html.php';
				exit();
			}
			$results = $s->fetch();
			$points = (int)$results['points'];
			$pickPoints = (int)$pick['points'];
			
			$newPoints = $points + $pickPoints;
			
			try
			{
				$sql = "UPDATE picks SET points = :points WHERE id = :pollId";
				$s = $pdo->prepare($sql);
				$s->bindValue(':pollId' , $pick['id']);
				$s->bindValue(':points' , $newPoints);
				$s->execute();
			}
			catch(PDOException $e)
			{
				$error = "Could not update the points to the selected pick";
				include '../includes/error.html.php';
				exit();
			}
		}
		
		try
		{
			$sql = "SELECT voters FROM poll WHERE id = :pollid";
			$s = $pdo->prepare($sql);
			$s->bindValue(":pollid", $pollId);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not acquire voters from the database " . $e;
			include '../includes/error.html.php';
			exit();
		}
		
		$results = $s->fetch();
		$addVote = (int)$results['voters'] + 1;
		
		try
		{
			$sql = "UPDATE poll SET
				voters = :votes
				WHERE id = :pollid";
			$s = $pdo->prepare($sql);
			$s->bindValue(":pollid", $pollId);
			$s->bindValue(":votes", $addVote);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not add votes to the database " . $e;
			include '../includes/error.html.php';
			exit();
		}
		
		try
		{
			if($_SESSION['loggedIn'])
			{
				$sql = "INSERT INTO voted SET
					pollid = :pollid,
					ip = :ip,
					userId = :id,
					voteDate = CURDATE()";
				$s = $pdo->prepare($sql);
				$s->bindValue(":pollid", $pollId);
				$s->bindValue(":ip", $_SERVER['REMOTE_ADDR']);
				$s->bindValue(":id", $_SESSION['id']);
				$s->execute();
			}
			else
			{
				$sql = "INSERT INTO voted SET
					pollid = :pollid,
					ip = :ip";
				$s = $pdo->prepare($sql);
				$s->bindValue(":pollid", $pollId);
				$s->bindValue(":ip", $_SERVER['REMOTE_ADDR']);
				$s->execute();
			}
		}
		catch(PDOException $e)
		{
			$error = "Could not add vote registration to the database " . $e;
			include '../includes/error.html.php';
			exit();
		}

		
		header("Location: http://localhost/pGreatest/result/index.php?pollId=$pollId");
		exit();
	}