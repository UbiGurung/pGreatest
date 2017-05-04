<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/magicquotes.inc.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/access.inc.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/pollMake.inc.php';

	if(userLoggedIn())
	{
		if (pollExist($_SESSION['id']))
		{
			include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
			try
			{
				$sql = "SELECT id, pollname, pollText, visible FROM poll WHERE userId = :userId";
				$s = $pdo->prepare($sql);
				$s->bindValue(":userId", $_SESSION['id']);
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
	}
	else
	{
		header('Location: ../home/index.php');
		exit();
	}

	if (isset($_GET['addPicks']))
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
		
		$pickName = $_POST['addTitle'];
		$pickText = $_POST['addText'];
		
		foreach ($pickName as $key => $n)
		{
			try
			{
				$sql = "INSERT INTO picks SET
					pickname = :title,
					picktext = :text,
					pollid = :pollid";
				$s = $pdo->prepare($sql);
				$s->bindValue(':title', $n);
				$s->bindValue(':text', $pickText[$key]);
				$s->bindValue(':pollid', $_SESSION['pollId']);
				$s->execute();
			}
			catch(PDOException $e)
			{
				$error = "Error submitting your picks" . $e;
				include '../includes/error.html.php';
				exit();
			}
		}
		
		if(isset($_POST['saveType']) and $_POST['saveType'] == '1')
		{
			try
			{
				$sql = "UPDATE poll SET visible = true WHERE id = :id";
				$s = $pdo->prepare($sql);
				$s->bindValue(":id", $_SESSION['pollId']);
				$s->execute();
			}
			catch(PDOException $e)
			{
				$error = 'Cannot not change poll visibility. ' . $e;
				include '../includes/error.html.php';
				exit();
			}
			header('Location: ../pickIndex/index.php');
			exit();
		}
		header('Location: .');
		exit();
	}
	
	
	if(isset($_GET['updatePoll']))
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
		$pickName = $_POST['addTitle'];
		$pickText = $_POST['addText'];
		$id = $_POST['pickId'];
		$pollId = $_POST['pollId'];
		
		foreach ($pickName as $key => $n)
		{
			if($id[$key] != 'new')
			{
				try
				{
					$sql = "UPDATE picks SET
						pickname = :title,
						picktext = :text,
						pollid = :pollid
						WHERE id = :id";
					$s = $pdo->prepare($sql);
					$s->bindValue(':title', $n);
					$s->bindValue(':text', $pickText[$key]);
					$s->bindValue(':pollid', $pollId);
					$s->bindValue(':id', $id[$key]);
					$s->execute();
				}
				catch(PDOException $e)
				{
					$error = "Error submitting your picks" . $e;
					include '../includes/error.html.php';
					exit();
				}
			}
			elseif($id[$key] == 'new')
			{
				try
				{
					$sql = "INSERT INTO picks SET
						pickname = :title,
						picktext = :text,
						pollid = :pollid";
					$s = $pdo->prepare($sql);
					$s->bindValue(':title', $n);
					$s->bindValue(':text', $pickText[$key]);
					$s->bindValue(':pollid', $pollId);
					$s->execute();
				}
				catch(PDOException $e)
				{
					$error = "Error inserting new picks into the database" . $e;
					include '../includes/error.html.php';
					exit();
				}
			}
		}
		
		if(isset($_POST['saveType']) and $_POST['saveType'] == '1')
		{
			try
			{
				$sql = "UPDATE poll SET visible = true WHERE id = :id";
				$s = $pdo->prepare($sql);
				$s->bindValue(":id", $_SESSION['pollId']);
				$s->execute();
			}
			catch(PDOException $e)
			{
				$error = 'Cannot not change poll visibility. ' . $e;
				include '../includes/error.html.php';
				exit();
			}
			header('Location: ..');
			exit();
		}
		header('Location: .');
		exit();
	}
	

	
	if(isset($_POST['deletePick']))
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
		
		$pickId = $_POST['deletePick'];
		
		try
		{
			$sql = "UPDATE poll SET visible = true WHERE id = :id";
			$s = $pdo->prepare($sql);
			$s->bindValue(":id", $_SESSION['pollId']);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Error deleting pick from database" . $e;
			include '../includes/error.html.php';
			exit();
		}
		header('Refresh: 0');
		exit();
	}
	
	if(picksExist($_SESSION['pollId']))
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
		
		try
		{
			$sql = "SELECT id, pickname, picktext, pollid FROM picks WHERE pollid = :pollid";
			$s = $pdo->prepare($sql);
			$s->bindValue(":pollid", $_SESSION['pollId']);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not collect picks from database";
			include '../includes/error.html.php';
			exit();
		}
		
		$picks = $s->fetchAll();
	}
	
include 'create.html.php';

