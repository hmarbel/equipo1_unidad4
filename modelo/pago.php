<?php

// Esta página es la "parte 5" de la compra de boletos
// Aquí se ingresarán los datos de los boletos en la
// base de datos

include_once('..\db\Boleto.php');
include_once('..\db\Viaje.php');
include_once('..\db\User.php');

session_start();

$error = "";
$clave = "";
$user = new User();

$entidad = new Boleto();

// Verificamos que la clave no sea null
if (
    isset($_POST["clave"]) && !empty($_POST["clave"])
) {
    if (isset($_SESSION["usuario"])) {
        $user = $_SESSION["usuario"]; // Recuperamos al usuario que inició sesión
        $tipo = $_SESSION["tipo"]; // Recuperamos el tipo de usuario que inició sesión (admin/cliente)

        if ($tipo == "cliente") {
            //$nombre = $user->getCliente()->getNombre();

            $clave = $_POST["clave"];
            $adultos = $_POST["adulto"];
            $estudiantes = $_POST["estudiante"];
            $mayores = $_POST["mayor"];
            $general = 0;
            $viaje = new Viaje();
            $viaje->setId($clave);
            $viaje->loadViaje();
            $subtotal = intval($viaje->getPrecio());

            $aux = 0;
            while ($aux < $adultos) {
                $general = $general + 1;

                $entidad->setIdViaje($clave);
                $entidad->setIdCliente($user->getCliente()->getId());
                $entidad->setNombre($_POST["nombre$general"]);
                $entidad->setApellido($_POST["apellido$general"]);
                $entidad->setTipo("1");
                $entidad->setAsiento($_POST["asiento$general"]);
                $entidad->setPrecio($subtotal);
    
                try {
                    $result = -1;
                    $result = $entidad->insertBoleto();
    
                    if ($result != 1) {
                        $error = "Error en bd";
                    }
                } catch (Exception $e) {
                    error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
                    $error = "Error en base de datos, comunicarse con el administrador";
                }

                $aux = $aux + 1;
            }

            $aux = 0;
            while ($aux < $estudiantes) {
                $general = $general + 1;

                $entidad->setIdViaje($clave);
                $entidad->setIdCliente($user->getCliente()->getId());
                $entidad->setNombre($_POST["nombre$general"]);
                $entidad->setApellido($_POST["apellido$general"]);
                $entidad->setTipo("2");
                $entidad->setAsiento($_POST["asiento$general"]);
                $entidad->setPrecio(intval($subtotal * 0.75));
    
                try {
                    $result = -1;
                    $result = $entidad->insertBoleto();
    
                    if ($result != 1) {
                        $error = "Error en bd";
                    }
                } catch (Exception $e) {
                    error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
                    $error = "Error en base de datos, comunicarse con el administrador";
                }

                $aux = $aux + 1;
            }

            $aux = 0;
            while ($aux < $mayores) {
                $general = $general + 1;

                $entidad->setIdViaje($clave);
                $entidad->setIdCliente($user->getCliente()->getId());
                $entidad->setNombre($_POST["nombre$general"]);
                $entidad->setApellido($_POST["apellido$general"]);
                $entidad->setTipo("3");
                $entidad->setAsiento($_POST["asiento$general"]);
                $entidad->setPrecio(intval($subtotal * 0.6));
    
                try {
                    $result = -1;
                    $result = $entidad->insertBoleto();
    
                    if ($result != 1) {
                        $error = "Error en bd";
                    }
                } catch (Exception $e) {
                    error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
                    $error = "Error en base de datos, comunicarse con el administrador";
                }

                $aux = $aux + 1;
            }
        }
    }
} else {
    $error = "Faltan datos";
}

if ($error == "")
    header("Location: ..\compraParte1.php");
else
    header("Location: ..\error.php?error=$error");
exit();
