<?php

/* 

Este archivo terminará la sesión actual

*/

session_start();
$sErr="";
$sCve="";
$sNom="";
	
	if (isset($_SESSION["usuario"])){
		session_destroy();
	}
	else
		$sErr = "Falta establecer el login";
	
	if ($sErr == "")
		header("Location: index.php");
	else
		header("Location: error.php?error=".$sErr);
	exit();
?>