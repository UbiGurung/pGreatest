<?php

try
{
	$pdo = new PDO('mysql:host=localhost; dbname=pgreatest', 'pguser', 'biggie2mc');
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec('SET NAMES "utf8"');
}
catch(PDOExecption $e)
{
	$error = "Unable to connect to the database server.";
	include 'error.html.php';
	exit();
}