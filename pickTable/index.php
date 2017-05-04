<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/magicquotes.inc.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/access.inc.php';


	if(isset($_POST['searchPoll']))
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
		
		$search = $_POST['searchPoll'];
		
		try
		{
			$sql = "SELECT * FROM poll WHERE pollname LIKE :search AND visible = 1";
			$s = $pdo->prepare($sql);
			$s->bindValue(':search', '%'.$search.'%');
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not search for the pollname " . $e;
			include '../includes/error.html.php';
			exit();
		}
	}
	else
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
	
		try
		{
			
			include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
			$sql = "SELECT pollname, pollText, id FROM poll WHERE visible = 1";
			$s = $pdo->prepare($sql);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not create the poll" . $e;
			include '../includes/error.html.php';
			exit();
		}
	}
	
	$polls = $s->fetchAll();
			
			
include 'pollIndex.html.php';

