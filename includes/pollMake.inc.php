<?php 

function userLoggedIn()
{
	if($_SESSION['loggedIn'])
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

function pollExist($userId)
{
	include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
	try
	{
		$sql = "SELECT COUNT(*) FROM poll WHERE userId = :userId";
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
	
	$counts = $s->fetch();
		
	if ($counts[0] > 0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

function picksExist($pollId)
{
	include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
	try
	{
		$sql = "SELECT COUNT(*) FROM picks WHERE pollid = :id";
		$s = $pdo->prepare($sql);
		$s->bindValue(":id", $pollId);
		$s->execute();
	}
	catch(PDOException $e)
	{
		$error = "Could not get count for picks". $e;
		include "../includes/error.html.php";
		exit();
	}
	
	$counts = $s->fetch();
	
	if ($counts[0] > 0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

function pollCount($id)
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
		
		try
		{
			$sql = "SELECT COUNT(*) FROM poll WHERE userId = :id";
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
		
		$count = $results[0];
		return $count;
	}


function userVoted($pollid, $ip)
{
	include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';

	try
	{
		if($_SESSION['loggedIn'])
		{
			$sql = "SELECT COUNT(*) FROM voted WHERE pollid = :pollid AND userId = :id";
			$s = $pdo->prepare($sql);
			$s->bindValue(":pollid", $pollid);
			$s->bindValue(":id", $_SESSION['id']);
			$s->execute();
		}
		else
		{
			$sql = "SELECT COUNT(*) FROM voted WHERE pollid = :pollid AND ip = :ip";
			$s = $pdo->prepare($sql);
			$s->bindValue(":pollid", $pollid);
			$s->bindValue(":ip", $ip);
			$s->execute();
		}
	}
	catch(PDOException $e)
	{
		$error = "Could not check if user has already voted on this poll " . $e;
		include '../includes/error.html.php';
		exit();
	}
	
	$results = $s->fetch();
	
	if($results[0] > 0)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}
	
