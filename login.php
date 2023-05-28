<?php

// Este archivo contiene la lógica detrás del inicio de sesión

// Función "parecida" a un import (énfasis en "parecida") | Alternativa: include
// ¿Por qué es parecida? Al igual que un import, include_once llamará al archivo que
// se le pase (en este caso, User.php) y solo se podrá utilizar una vez en todo el
// código, es decir, si colocamos otro include_once para User.php, no servirá.
// No obstante, es diferente de un import porque tiene "efecto" a partir del punto en que
// se llama, por lo que si utilizamos algún método de User.php antes de poner include_once,
// marcará error.
include_once('db\User.php');

// session_start inicia o reanuda una sesión
// En este caso, inicia una nueva sesión
// Las sesiones sirven para compartir información entre las páginas
session_start();

$err = ""; // Variable para saber si hay errores
$id = "";
$password = "";
$user = new User(); // Objeto que almacenará la información del usuario que inició sesión

// isset verifica que una variable sea diferente de null
// is set ...? = ¿Está asignado ...?
if (
	isset($_POST["txtId"]) &&
	isset($_POST["txtPass"])
) {
	$id = $_POST["txtId"]; // Recuperamos el id
	$password = $_POST["txtPass"]; // Recuperamos la contraseña
	$user->setId($id);
	$user->setPassword($password);
	try {

		// Verificamos que los datos sean correctos
		if ($user->existeCuentaAdmin()) { // Si es un administrador, entonces...
			$_SESSION["usuario"] = $user;
			$_SESSION["tipo"] = "admin";
		} else { // Si no es un administrador, puede ser un cliente...
			if ($user->existeCuentaCliente()) {  // Si es un cliente, entonces..
				$_SESSION["usuario"] = $user;
				$_SESSION["tipo"] = "cliente";
			} else {
				$err = "1";
			}
		}

		// $_SESSION almacena valores en la sesión actual
		// En los casos en donde los datos del usuario son válidos,
		// ya sea administrador o cliente, se almacenarán en
		// "usuario", mientras que en "tipo" se guardará si es
		// un administrador (admin) o un cliente (cliente) 

	} catch (Exception $e) {
		error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
		$err = "Error al acceder a la base de datos";
	}
} else
	$err = "Faltan datos";

// Si no hay errores, entonces vamos al menú principal
if ($err == "") {
	header("Location: mainMenu.php");
} else {
	if ($err == "1") {
		header("Location: index.php?msg=Usuario desconocido");
	} else {
		header("Location: error.php?error=" . $err);
	}
}
