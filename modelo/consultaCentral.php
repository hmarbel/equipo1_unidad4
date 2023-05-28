<?php

// Esta clase ejecutará la operación (agregar, modificar o borrar) en la base de datos

include_once('..\db\Central.php');

$error = "";
$operacion = "";
$clave = "";

$entidad = new Central();

// Verificamos que la clave y la operación no sean null
if (
    isset($_POST["clave"]) && !empty($_POST["clave"]) &&
    isset($_POST["operacion"]) && !empty($_POST["operacion"])
) {
    $operacion = $_POST["operacion"];
    $clave = $_POST["clave"];
    $entidad->setId($clave);

    if ($operacion == "a" || $operacion == "m") {
        $entidad->setEstado($_POST["txtEstado"]);
        $entidad->setCiudad($_POST["txtCiudad"]);
        $entidad->setCalle($_POST["txtCalle"]);
        $entidad->setColonia($_POST["txtColonia"]);
        $entidad->setNoEdificio($_POST["txtNoEdificio"]);
        $entidad->setCP($_POST["txtCP"]);
        $aux = $_POST["txtNombre"];
        $aux = ($aux == "" ? $entidad->getCiudad() : $aux);
        $entidad->setNombre($aux);
        $entidad->setActivo("1");
    }
    try {
        $result = -1;
        if ($operacion == 'a')
            $result = $entidad->insertCentral();
        else if ($operacion == 'b')
            $result = $entidad->deleteCentral();
        else if ($operacion == 'r')
            $result = $entidad->restoreCentral();
        else
            $result = $entidad->updateCentral();

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
    header("Location: ..\menuCentral.php");
else
    header("Location: error.php?error=$error");
exit();
