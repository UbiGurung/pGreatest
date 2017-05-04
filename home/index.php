<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/magicquotes.inc.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/pollMake.inc.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/access.inc.php';



	function getRandPoll($cat)
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
		
		try
		{
			$sql = "SELECT poll.id, poll.pollname, poll.pollText, poll.thumbnailURL FROM poll 
			INNER JOIN pollcategory
			ON poll.id = pollcategory.pollid
			WHERE pollcategory.categoryid = :cat AND poll.visible = 1
			GROUP BY poll.id
			ORDER BY RAND() limit 5";
			$s = $pdo->prepare($sql);
			$s->bindValue(":cat", $cat);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not retrieve id from database";
			include '../includes/error.html.php';
			exit();
		}
		
		$results = $s->fetchAll();
		
		foreach($results as $row)
		{
			$polls[] = array('id' => $row['id'], 'pollname' => $row['pollname'], 'pollText' => $row['pollText'], 'thumbnailURL' => $row['thumbnailURL']);
		}
		
		return $polls;
	}
	
	include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
	
	try
	{
		$sql = "SELECT id, pollname, pollText, thumbnailURL FROM poll ORDER BY voters DESC LIMIT 3";
		$s = $pdo->query($sql);
	}
	catch(PDOException $e)
	{
		$error = "Could not retrieve top polls from database " . $e;
		include '../includes.error.html.php';
		exit();
	}
	
	$results = $s->fetchAll();
	
	foreach($results as $row)
	{
		$topPolls[] = array('id' => $row['id'], 'pollname' => $row['pollname'], 'pollText' => $row['pollText'], 'thumbnailURL' => $row['thumbnailURL']);
	}


include 'home.html.php';