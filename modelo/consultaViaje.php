<?php

// Esta clase ejecutará la operación (agregar, modificar o borrar) en la base de datos

include_once('..\db\Viaje.php');
include_once("..\db\Central.php");
include_once("..\db\Chofer.php");
include_once("..\db\Autobus.php");

$error = "";
$operacion = "";
$clave = "";

$mensaje = "";

$entidad = new Viaje();

// Verificamos que la clave y la operación no sean null
if (
    (isset($_POST["clave"]) && !empty($_POST["clave"]) &&
    isset($_POST["operacion"]) && !empty($_POST["operacion"]))
) {
    $operacion = $_POST["operacion"];
    $clave = $_POST["clave"];
    $entidad->setId($clave);

    if ($operacion == "a" || $operacion == "m") {
        $entidad->setOrigen($_POST["txtOrigen"]);
        $entidad->setDestino($_POST["txtDestino"]);
        $entidad->setIdChofer($_POST["txtChofer"]);
        $entidad->setIdAutobus($_POST["txtAutobus"]);
        $entidad->setSalida($_POST["txtSalida"]);
        $entidad->setLlegada($_POST["txtLlegada"]);
        $entidad->setTipoViaje($_POST["txtTipoViaje"]);
        $entidad->setPrecio($_POST["txtPrecio"]);

        // Verificación para saber si la central de origen existe
        $origen = new Central();
        if ($origen->existeCentral($entidad->getOrigen()) == false) {
            $var1 = $entidad->getOrigen();
            $mensaje = "El ID de la central de origen ($var1) no existe o está inhabilitado";
            $error = "x";
        }

        // Verificación para saber si la central de destino existe
        $destino = new Central();
        if ($destino->existeCentral($entidad->getDestino()) == false) {
            $var2 = $entidad->getDestino();
            $mensaje = $mensaje . " | El ID de la central de destino ($var2) no existe o está inhabilitado";
            $error = "x";
        }

        // Verificación para saber si el chofer existe
        $chofer = new Chofer();
        if ($chofer->existeChofer($entidad->getIdChofer()) == false) {
            $var3 = $entidad->getIdChofer();
            $mensaje = $mensaje . " | El ID del chofer ($var3) no existe o está inhabilitado";
            $error = "x";
        }

        // Verificación para saber si el autobús existe
        $autobus = new Autobus();
        if ($autobus->existeAutobus($entidad->getIdAutobus()) == false) {
            $var4 = $entidad->getIdAutobus();
            $mensaje = $mensaje . " | El ID del autobús ($var4) no existe o está inhabilitado";
            $error = "x";
        }

    }
    try {
        if ($error != "x") {
            $result = -1;
            if ($operacion == 'a')
                $result = $entidad->insertViaje();
            else if ($operacion == 'b')
                $result = $entidad->deleteViaje();
            else
                $result = $entidad->updateViaje();
    
            if ($result != 1) {
                $error = "Error en bd";
            }
        }
    } catch (Exception $e) {
        error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
        $error = "Error en base de datos, comunicarse con el administrador";
    }
} else {
    $error = "Faltan datos";
}

if ($error == "")
    header("Location: ..\menuViaje.php");
else {
    if ($error == "x") {
        header("Location: ..\controlViaje.php?error=$mensaje&clave=$clave&operacion=$operacion");
    } else {
        header("Location: ..\error.php?error=$error");
    }
}
    
exit();
