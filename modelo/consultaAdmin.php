<?php

// Esta clase ejecutará la operación (agregar, modificar o borrar) en la base de datos

include_once('..\db\Admin.php');

$error = "";
$operacion = "";
$clave = "";

$admin = new Admin();

// Verificamos que la clave y la operación no sean null
if (
    isset($_POST["clave"]) && !empty($_POST["clave"]) &&
    isset($_POST["operacion"]) && !empty($_POST["operacion"])
) {
    $operacion = $_POST["operacion"];
    $clave = $_POST["clave"];
    $admin->setId($clave);

    if ($operacion != "b") {
        $admin->setUser($_POST["txtUser"]);
        $admin->setNombre($_POST["txtNombre"]);
        $admin->setApellido($_POST["txtApellido"]);
        $admin->setEmail($_POST["txtEmail"]);
        $admin->setTelefono($_POST["txtTelefono"]);
        $date = DateTime::createFromFormat('Y-m-d', $_POST["txtFechaN"]);
        $admin->setFechaN($date->format('Y-m-d'));
        $admin->setPassword($_POST["txtPassword"]);
        $admin->setSexo($_POST["rbSexo"]);
        $super = ($_POST["checkSuper"] == "on" ? "1" : "0");
        $admin->setSuper($super);
    }
    try {
        $result = -1;
        if ($operacion == 'a')
            $result = $admin->insertAdmin();
        else if ($operacion == 'b')
            $result = $admin->deleteAdmin();
        else
            $result = $admin->updateAdmin();

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
    header("Location: ..\menuAdmin.php");
else
    header("Location: error.php?error=$error");
exit();
