<?php

// Esta clase ejecutará la operación (agregar, modificar o borrar) en la base de datos

include_once('..\db\Autobus.php');

$error = "";
$operacion = "";
$clave = "";

$entidad = new Autobus();

// Verificamos que la clave y la operación no sean null
if (
    isset($_POST["clave"]) && !empty($_POST["clave"]) &&
    isset($_POST["operacion"]) && !empty($_POST["operacion"])
) {
    $operacion = $_POST["operacion"];
    $clave = $_POST["clave"];
    $entidad->setId($clave);

    if ($operacion == "a" || $operacion == "m") {
        $entidad->setPlacas($_POST["txtPlacas"]);
        $entidad->setTipoViaje($_POST["txtTipoViaje"]);
        $entidad->setActivo("1");
    }
    try {
        $result = -1;
        if ($operacion == 'a')
            $result = $entidad->insertAutobus();
        else if ($operacion == 'b')
            $result = $entidad->deleteAutobus();
        else if ($operacion == 'r')
            $result = $entidad->restoreAutobus();
        else
            $result = $entidad->updateAutobus();

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
    header("Location: ..\menuAutobus.php");
else
    header("Location: ..\error.php?error=$error");
exit();
