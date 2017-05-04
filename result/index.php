<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/magicquotes.inc.php';

require_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/access.inc.php';

	$poll = $_GET['pollId'];
		try
		{
			
			include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';

			$sql = "SELECT pickname, picktext, points FROM picks WHERE pollid = :pollId ORDER BY points DESC";
			$d = $pdo->prepare($sql);
			$d->bindValue(':pollId', $poll);
			$d->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not retrieve the top picks for this poll";
			include '../includes/error.html.php';
			exit();
		}
		$topPicks = $d->fetchAll();
	
include 'result.html.php';

