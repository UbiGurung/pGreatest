<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/magicquotes.inc.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/access.inc.php';

include_once $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/pollMake.inc.php';


if (pollExist($_SESSION['id']))
{
	include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
	try
	{
		$sql = "SELECT id, pollname, pollText FROM poll WHERE userId = :userId";
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


	if (isset($_POST['action']) and $_POST['action'] == 'upload')
	{
		
		$pollName = $_POST['addTitle'];
		$pollText = $_POST['addText'];
		$pollCat = $_POST['category'];
		$userId = $_SESSION['id'];
		
		if (preg_match('/^image\/p?jpeg$/i', $_FILES['upload']['type']))
		{
		  $ext = '.jpg';
		}
		elseif (preg_match('/^image\/p?jpg$/i', $_FILES['upload']['type']))
		{
			$ext = '.jpg';
		}
		else if (preg_match('/^image\/gif$/i', $_FILES['upload']['type']))
		{
		  $ext = '.gif';
		}
		else if (preg_match('/^image\/(x-)?png$/i', $_FILES['upload']['type']))
		{
		  $ext = '.png';
		}
		else
		{
			$error = 'Please submit a JPEG, GIF, or PNG image file.';
			include '../includes/error.html.php';
			exit();
		}
			$filename = 'C:/wamp64/www/pGreatest/uploads/' . time() . $_SERVER['REMOTE_ADDR'] . $ext;
			
		if (!is_uploaded_file($_FILES['upload']['tmp_name']) or !copy($FILES['upload']['tmp_name'], $filename))
		{
			$error =  "Could not save file as $filename";
			include '../includes/error.html.php';
			exit();
		}
		
		
		// $uploadfile = new Imagick($_FILES['upload']['tmp_name']);
		// $uploadfile->thumbnailImage(180, 100);
		$uploadfile = $_FILES['upload']['tmp_name'];
		$uploadname = $_FILES['upload']['name'];
		$uploadtype = $_FILES['upload']['type'];
		$uploaddesc = 'Thumbnail';
		$uploaddata = file_get_contents($uploadfile);
		
		include '../filestore/db.inc.php';
		
		try
		{
			$sql = "INSERT INTO filestore SET
				filename = :filename,
				mimetype = :mimetype,
				description = :description,
				filedata = :filedata";
			$s = $pdo->prepare($sql);
			$s->bindValue(':filename', $uploadname);
			$s->bindValue(':mimetype', $uploadtype);
			$s->bindValue(':description', $uploaddesc);
			$s->bindValue(':filedata', $uploaddata);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = 'Unable to store file' . $e;
			include '../include/error.html.php';
			exit();
		}
		
		$thumbnailId = $pdo->lastInsertId();
		
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
		
		foreach ($pollName as $key => $n)
		{
			try
			{
				$sql = "INSERT INTO poll SET
					pollname = :title,
					pollText = :text,
					polldate = CURDATE(),
					userId = :userId,
					thumbnailId = :thumbnailId";
				$s = $pdo->prepare($sql);
				$s->bindValue(':title', $n);
				$s->bindValue(':text', $pollText[$key]);
				$s->bindValue(':userId', $userId);
				$s->bindValue(':thumbnailId', $thumbnailId);
				$s->execute();
			}
			catch(PDOException $e)
			{
				$error = "Error submitting your picks" . $e;
				include '../includes/error.html.php';
				exit();
			}
		}
		
		$_SESSION['pollId'] = $pdo->lastInsertId();
		
		try
		{
			$sql = "INSERT INTO pollcategory SET
					pollid = :pollid,
					categoryid = :categoryid";
			$s = $pdo->prepare($sql);
			$s->bindValue(':pollid', $_SESSION['pollId']);
			$s->bindValue(':categoryid', $pollCat);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Error assigning category to the poll";
			include '../includes/error.html.php';
			exit();
		}
		
		
		header('Location: ../picks/index.php');
		exit();
}
	if(isset($_POST['editPoll']))
	{
		$_SESSION['pollId'] = $_POST['editPoll'];
		
		header('Location: ../picks/index.php');
		exit();
	}

	if(isset($_POST['deletePoll']))
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
		$pollId = $_POST['deletePoll'];
		try
		{
			$sql = "DELETE FROM pollcategory WHERE pollid = :id";
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $pollId);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Error deleting poll from category" . $e;
			include '../includes/error.html.php';
			exit();
		}
		
		try
		{
			$sql = "DELETE FROM picks WHERE pollid = :pollid";
			$s = $pdo->prepare($sql);
			$s->bindValue(':pollid', $pollId);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not delete picks for given poll" . $e;
			include '../includes/error.html.php';
			exit();
		}
		
		try
		{
			$sql = "SELECT thumbnailId FROM poll WHERE id = :pollId";
			$s = $pdo->prepare($sql);
			$s->bindValue(":pollId", $pollId);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Could not get thumbnailID from database";
			include '../includes/error.html.php';
			exit();
		}
		$result = $s->fetch();
		$thumbId = $result['thumbnailId'];
		
		include '../filestore/db.inc.php';
		try
		{
			$sql = "DELETE FROM filestore WHERE id = :id";
			$s = $pdo->prepare($sql);
			$s->bindValue(":id", $thumbId);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Error deleting thumbnail from FILESTORE database";
			include '../includes/error.html.php';
			exit();
		}
		
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
		
		try
		{
			$sql = "DELETE FROM poll WHERE id = :id";
			$s = $pdo->prepare($sql);
			$s->bindValue(':id', $pollId);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Error deleting poll from the database" . $e;
			include '../includes/error.html.php';
			exit();
		}
		
		header('Refresh:0');
		exit();
	}
	
include 'createIndex.html.php';

