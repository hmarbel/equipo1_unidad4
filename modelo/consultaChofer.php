<?php

// Esta clase ejecutará la operación (agregar, modificar o borrar) en la base de datos

include_once('..\db\Chofer.php');

$error = "";
$operacion = "";
$clave = "";

$entidad = new Chofer();

// Verificamos que la clave y la operación no sean null
if (
    isset($_POST["clave"]) && !empty($_POST["clave"]) &&
    isset($_POST["operacion"]) && !empty($_POST["operacion"])
) {
    $operacion = $_POST["operacion"];
    $clave = $_POST["clave"];
    $entidad->setId($clave);

    if ($operacion == "a" || $operacion == "m") {
        $entidad->setNombre($_POST["txtNombre"]);
        $entidad->setApellido($_POST["txtApellido"]);
        $entidad->setEmail($_POST["txtEmail"]);
        $entidad->setTelefono($_POST["txtTelefono"]);
        $date = DateTime::createFromFormat('Y-m-d', $_POST["txtFechaN"]);
        $entidad->setFechaN($date->format('Y-m-d'));
        $entidad->setSexo($_POST["rbSexo"]);
        $entidad->setActivo("1");
    }
    try {
        $result = -1;
        if ($operacion == 'a')
            $result = $entidad->insertChofer();
        else if ($operacion == 'b')
            $result = $entidad->deleteChofer();
        else if ($operacion == 'r')
            $result = $entidad->restoreChofer();
        else
            $result = $entidad->updateChofer();

        if ($result != 1) {
            $error = "Error en bd";
        }
    } catch (Exception $e) {
        error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
        $error = "Error en base de datos, comunicarse con el administrador";
    }
} else {
    $error = "Faltan datos";
}

if ($error == "")
    header("Location: ..\menuChofer.php");
else
    header("Location: error.php?error=$error");
exit();
