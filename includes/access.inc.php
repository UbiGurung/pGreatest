<?php

if (isset($_POST['action']) and $_POST['action'] == 'logout')
{
		session_start();
		unset($_SESSION['email']);
		unset($_SESSION['loggedIn']);
		unset($_SESSION['password']);
		unset($_SESSION['username']);
		unset($_SESSION['id']);
		header('Location:.');
		exit();
}

if (isset($_POST['action']) and $_POST['action'] == 'login')
	{

		$password = $_POST['password'];
		
		if (databaseContainsAuthor($_POST['email'], $password))
		{
			include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
			
			try
			{
				$sql = "SELECT username, id FROM user WHERE email = :email";
				$s = $pdo->prepare($sql);
				$s->bindValue(':email', $_POST['email']);
				$s->execute();
			}
			catch(PDOException $e)
			{
				$error = 'Error searching for username.' . $e;
				include 'error.html.php';
				exit();
			}
			
			$results = $s->fetch();
			
			$username = $results['username'];
			$id = $results['id'];
				
			session_start();
			$_SESSION['loggedIn'] = TRUE;
			$_SESSION['email'] = $_POST['email'];
			$_SESSION['password'] = $password;
			$_SESSION['username'] = $username;
			$_SESSION['id'] = $id;
			header('Location: .');
			exit();
		}
		else
		{
			session_start();
			$_SESSION['error'] = "Invalid login";
			unset($_SESSION['loggedIn']);
			unset($_SESSION['email']);
			unset($_SESSION['password']);
			header('Location: index.php');
			exit();
		}
	}
	
	session_start();
	if(isset($_SESSION['loggedIn']))
	{
		return databaseContainsAuthor($_SESSION['email'],
			$_SESSION['password']);
	}

	
	function databaseContainsAuthor($email, $password)
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
		
		try
		{
			$sql = 'SELECT COUNT(*) FROM user
				WHERE email = :email AND password = :password';
			$s = $pdo->prepare($sql);
			$s->bindValue(':email', $email);
			$s->bindValue(':password', $password);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = 'Error searching for user.';
			include 'error.html.php';
			exit();
		}
		
		$row = $s->fetch();
		
		if ($row[0] > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	function userExists($username, $email)
	{
		include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
		
		try
		{
			$sql = "SELECT COUNT(*) FROM user WHERE email = :email OR username = :username";
			$s = $pdo->prepare($sql);
			$s->bindValue(":email", $email);
			$s->bindValue(":username", $username);
			$s->execute();
		}
		catch(PDOException $e)
		{
			$error = "Error retrieving request " . $e;
			include '../includes/error.html.php';
			exit();
		}
		
		$result = $s->fetch();
		
		if($result[0] > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	
	
		

