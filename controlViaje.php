<?php

// Esta clase mostrará un formulario con el que se mostrarán los campos
// de un viaje, ya sea para verlos sin modificar (borrar o restaurar),
// verlos y poder modificar (actualizar) o para llenarlos (agregar)

// Función "parecida" a un import (énfasis en "parecida") | Alternativa: include
include_once("db\Viaje.php");

include_once("header.php");

$pasa = true;
$entidad = new Viaje();

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

    // Si la operación es eliminar, actualizar o restaurar, es necesario cargar la información del viaje
    if ($operacion != 'a') {
        $entidad->setId($clave);
        try {
            if (!$entidad->loadViaje()) {
                $error = "No existe el viaje";
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
    }
} else {
    if (
        isset($_REQUEST["clave"]) && !empty($_REQUEST["clave"]) &&
        isset($_REQUEST["operacion"]) && !empty($_REQUEST["operacion"])
    ) {
        $operacion = $_REQUEST["operacion"];
        $clave = $_REQUEST["clave"];
    
        // Si la operación es eliminar, actualizar o restaurar, es necesario cargar la información del viaje
        if ($operacion != 'a') {
            $entidad->setId($clave);
            try {
                if (!$entidad->loadViaje()) {
                    $error = "No existe el viaje";
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
        }
    } else {
        $aux1 = $_POST['clave'];
        $aux2 = $_POST['operacion'];
        $error = "Faltan datos: clave: $aux1, operación: $aux2";
    }
}

if ($error == "") { // Si todo está bien, entonces...
?>

    <section>
        <article>
            <form name="form" id="form" action="modelo/consultaViaje.php" method="post" class="form_registro">
                <div class="menu_header">
                    <div>
                        <h1> <?php echo ($operacion == 'a' ? 'Nuevo viaje' : ($operacion == 'm' ? 'Editar viaje' : ($operacion == 'b' ? 'Eliminar viaje' : 'Restaurar viaje'))); ?></h1>
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
                                <input name="txtOrigen" type="text" inputmode="numeric" pattern="[0-9]+" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getOrigen(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>Identificador de central de origen</label>
                            </div>
                            <h6 class="info_input" id="infoOrigen"><?php echo ((isset($_REQUEST["origen"])) ? $_REQUEST["origen"] : ""); ?></h6>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtDestino" type="text" inputmode="numeric" pattern="[0-9]+" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getDestino(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>Identificador de central de destino</label>
                            </div>
                            <h6 class="info_input" id="infoDestino"><?php echo ((isset($_REQUEST["destino"])) ? $_REQUEST["destino"] : ""); ?></h6>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtChofer" type="text" inputmode="numeric" pattern="[0-9]+" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getIdChofer(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>Identificador de chofer</label>
                            </div>
                            <h6 class="info_input" id="infoChofer"><?php echo ((isset($_REQUEST["chofer"])) ? $_REQUEST["chofer"] : ""); ?></h6>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <select name="txtTipoViaje" <?php echo ($edicion == true ? '' : ' disabled '); ?>>
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
                            <div class="input-container">
                                <input name="txtAutobus" type="text" inputmode="numeric" pattern="[0-9]+" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getIdAutobus(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>Identificador de autobús</label>
                            </div>
                            <h6 class="info_input" id="infoAutobus"><?php echo ((isset($_REQUEST["autobus"])) ? $_REQUEST["autobus"] : ""); ?></h6>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtSalida" type="datetime-local" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getSalida(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>Fecha y hora de salida</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtLlegada" type="datetime-local" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getLlegada(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>Fecha y hora (aproximada) de llegada</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtPrecio" type="text" inputmode="numeric" pattern="[0-9]+" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getPrecio(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>Precio</label>
                            </div>
                        </td>
                    </tr>

                </table>
                <?php
                    if (isset($_REQUEST['error'])) {
                        ?>
                        <h4><?php echo $_REQUEST['error']; ?></h4>
                        <br />
                        <?php
                    } else {
                        ?>
                        <br>
                        <?php
                    }
                ?>
                <div id="confirmacion">

                </div>
                <button class="btn_action" type="submit" <?php echo ($operacion == 'a' ? 'onclick="return datosValidos(txtTipoViaje.value, txtPrecio.value, txtSalida.value, txtLlegada.value);"' : '') ?> <?php echo ($operacion == 'b' ? 'onclick="return permiteEliminar(txtSalida.value);"' : '') ?>>
                    <?php echo $boton; ?>
                </button>
                <a class="btn_action" href="menuViaje.php">
                    Cancelar
                </a>
            </form>
        </article>
    </section>

    <script type="text/javascript">
        function datosValidos(tipoViaje, precio, fecha1, fecha2) {
            if (tipoViaje == -1) {
                return false;
            }

            if (precio == 0) {
                return false;
            }

            var date1 = new Date(fecha1);
            var date2 = new Date(fecha2);

            if (date1 >= date2) {
                return false;
            }

            var hoy = new Date();

            if (date1 <= hoy) {
                return false;
            }

            return true;
        }

        function permiteEliminar(fecha1) {
            let date1 = new Date(fecha1);
            let hoy = new Date();

            if (date1 <= hoy) {
                return false;
            }

            return true;
        }
    </script>
<?php
} else { // Si algo está mal, entonces...
    header("Location: error.php?error=$error");
}
include_once('footer.php');
?>