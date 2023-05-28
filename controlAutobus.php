<?php

// Esta clase mostrará un formulario con el que se mostrarán los campos
// de un chofer, ya sea para verlos sin modificar (borrar o restaurar),
// verlos y poder modificar (actualizar) o para llenarlos (agregar)

// Función "parecida" a un import (énfasis en "parecida") | Alternativa: include
include_once("db\Autobus.php");

include_once("header.php");

// Carga las funciones de JS
include_once("funciones.html");

$pasa = true;
$entidad = new Autobus();

// Por defecto, la operación es eliminar, por lo que se bloquea la posibilidad de editar información
$boton = "Borrar";
$edicion = false;

$operacion = "";
$clave = "";

$error = ""; // Variable auxiliar para comprobar que todo esté bien

// isset verificar que una variable sea diferente de null (is set)
if (
    isset($_POST["clave"]) && !empty($_POST["clave"]) &&
    isset($_POST["operacion"]) && !empty($_POST["operacion"])
) {
    $operacion = $_POST["operacion"];
    $clave = $_POST["clave"];

    // Si la operación es eliminar, actualizar o restaurar, es necesario cargar la información del chofer
    if ($operacion != 'a') {
        $entidad->setId($clave);
        try {
            if (!$entidad->loadAutobus()) {
                $error = "No existe el autobús";
            }
        } catch (Exception $e) {
            error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
            $error = "Error en base de datos";
        }
    }

    // Habilitamos la opción de editar/agregar información si la operación es agregar (a) o modificar (m)
    if ($operacion == 'a') {
        $edicion = true;
        $boton = "Agregar";
    } else if ($operacion == 'm') {
        $edicion = true;
        $boton = "Actualizar";
    } else if ($operacion == 'r') {
        $boton = "Restaurar";
    }
} else {
    $aux1 = $_POST['clave'];
    $aux2 = $_POST['operacion'];
    $error = "Faltan datos: clave: $aux1, operación: $aux2";
}

if ($error == "") { // Si todo está bien, entonces...
?>

    <section>
        <article>
            <form name="form" id="form" action="modelo/consultaAutobus.php" method="post" class="form_registro">
                <div class="menu_header">
                    <div>
                        <h1> <?php echo ($operacion == 'a' ? 'Nuevo autobús' : ($operacion == 'm' ? 'Editar autobús' : ($operacion == 'b' ? 'Eliminar autobús' : 'Restaurar autobús'))); ?></h1>
                        <h5>Proporciona la siguiente información</h5>
                    </div>
                </div>

                <br>
                <br>

                <input type="hidden" name="operacion" value="<?php echo $operacion; ?>">
                <input type="hidden" name="clave" value="<?php echo $clave; ?>" />
                <table class="registro">

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtPlacas" type="text" pattern="\d{2}-[A-Z]{3}-\d{2}" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getPlacas(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>Placas</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <select name="txtTipoViaje" <?php echo ($edicion == true ? '' : ' disabled '); ?> onchange="paintAsientos('asientos', this.value)">
                                    <option value="-1" <?php echo ($operacion == 'a' ? 'selected' : ''); ?> disabled>Selecciona una opción...</option>
                                    <option value="1" <?php echo ($entidad->getTipoViaje() == '1' ? ' selected ' : ''); ?>>Hydrus Regular</option>
                                    <option value="2" <?php echo ($entidad->getTipoViaje() == '2' ? ' selected ' : ''); ?>>Hydrus Galaxy</option>
                                </select>
                                <label>Tipo de viaje</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div id="asientos"></div>
                        </td>
                    </tr>

                </table>
                <br />
                <div id="confirmacion">

                </div>
                <button class="btn_action" type="submit" <?php echo ($operacion == 'a' ? 'onclick="return txtTipoViaje.value != -1;"' : '') ?>>
                    <?php echo $boton; ?>
                </button>
                <a class="btn_action" href="menuAutobus.php">
                    Cancelar
                </a>
            </form>
        </article>
    </section>

<?php
    $tipoViaje = $entidad->getTipoViaje();

    if ($operacion != 'a') {
        if ($tipoViaje == '1') {
            echo '<script type="text/javascript">
                document.body.onload = paintAsientos("asientos", "1");
                </script>';
        } else if ($tipoViaje == '2') {
            echo '<script type="text/javascript">
            document.body.onload = paintAsientos("asientos", "2");
                </script>';
        }
    }
} else { // Si algo está mal, entonces...
    header("Location: error.php?error=$error");
}
include_once('footer.php');
?>