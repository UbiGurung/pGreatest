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
	
	if(isset($_POST['action']) and $_POST['action'] == 'register')
	{
		$name = $_POST['username'];
		$mail = $_POST['email'];
		$pass = $_POST['password'];
		
		if(!userExists($name, $mail))
		{
			include $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/includes/db.inc.php';
			
			try
			{
				$sql = "INSERT INTO user SET
					username = :username,
					email = :email,
					password = :password,
					dateJoin = CURDATE()";
					
				$s = $pdo->prepare($sql);
				$s->bindValue(":username", $name);
				$s->bindValue(":email", $mail);
				$s->bindValue(":password", $pass);
				$s->execute();
			}
			catch(PDOException $e)
			{
				$error = "Could not register new user " . $e;
				include '../includes/error.html.php';
				exit();
			}
			
			$id = $pdo->lastInsertId();
			
			try
			{
				$sql = "SELECT username, email, password FROM user WHERE id = :id";
				$s = $pdo->prepare($sql);
				$s->bindValue(":id", $id);
				$s->execute();
			}
			catch(PDOException $e)
			{
				$error = "Error establishing new user " . $e;
				include '../includes/error.html.php';
				exit();
			}
			
			$results = $s->fetch();
			
			$username = $results['username'];
			$password = $results['password'];
			$email = $results['email'];
			
			session_start();
			$_SESSION['loggedIn'] = TRUE;
			$_SESSION['email'] = $email;
			$_SESSION['password'] = $password;
			$_SESSION['username'] = $username;
			$_SESSION['id'] = $id;
			header('Location: ../home/index.php');
			exit();
		}
		else
		{
			session_start();
			$_SESSION['error'] = "Username or Email is already taken";
			unset($_SESSION['loggedIn']);
			unset($_SESSION['email']);
			unset($_SESSION['password']);
			header('Location: .');
			exit();
		}
	}

include 'register.html.php';