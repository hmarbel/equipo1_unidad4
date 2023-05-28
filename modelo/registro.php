<?php

// Esta clase ejecutará la operación (agregar, modificar o borrar) en la base de datos

include_once('..\db\Cliente.php');

$error = "";
$operacion = "";
$clave = "";

$entidad = new Cliente();

// Verificamos que la clave y la operación no sean null
$entidad->setId($clave);
$entidad->setNombre($_POST["txtNombre"]);
$entidad->setApellido($_POST["txtApellido"]);
$entidad->setEmail($_POST["txtEmail"]);
$entidad->setPassword($_POST["txtPass"]);
$entidad->setActivo("1");

try {
    $result = -1;
    $result = $entidad->insertCliente();

    if ($result != 1) {
        $error = "Error en bd";
    }
} catch (Exception $e) {
    error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
    $error = "Error en base de datos, comunicarse con el administrador";
}

if ($error == "")
    header("Location: ..\index.php");
else
    header("Location: error.php?error=$error");
exit();
