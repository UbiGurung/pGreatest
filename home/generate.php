<?php 

	$srcurl = 'http://localhost/pGreatest/home/controller.php';
	$tempfilename = $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/home/tempindex.html';
	$targetfilename = $_SERVER['DOCUMENT_ROOT'] . '/pGreatest/home/index.html';
	
	if (file_exists($tempfilename))
	{
		unlink($tempfilename);
	}
	
	$html = file_get_contents($srcurl);
	
	if(!$html)
	{
		$error = "Unable to load $srcurl. Static page update aborted!";
		include '../includes/error.html.php';
		exit();
	}
	
	if(!file_put_contents($tempfilename, $html))
	{
		$error = "Unable to write $tempfilename. Static page update aborted!";
		include '../includes/error.html.php';
		exit();
	}
	
	copy($tempfilename, $targetfilename);
	unlink($tempfilename);