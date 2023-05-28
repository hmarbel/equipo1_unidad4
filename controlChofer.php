<?php

// Esta clase mostrará un formulario con el que se mostrarán los campos
// de un chofer, ya sea para verlos sin modificar (borrar o restaurar),
// verlos y poder modificar (actualizar) o para llenarlos (agregar)

// Función "parecida" a un import (énfasis en "parecida") | Alternativa: include
include_once("db\Chofer.php");

include_once("header.php");

$pasa = true;
$entidad = new Chofer();

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
            if (!$entidad->loadChofer()) {
                $error = "No existe el chofer";
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
            <form name="form" id="form" action="modelo/consultaChofer.php" method="post" class="form_registro">
                <div class="menu_header">
                    <div>
                        <h1> <?php echo ($operacion == 'a' ? 'Nuevo chofer' : ($operacion == 'm' ? 'Editar chofer' : ($operacion == 'b' ? 'Eliminar chofer' : 'Restaurar chofer'))); ?></h1>
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
                                <input name="txtNombre" type="text" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getNombre(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>Nombre(s)</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtApellido" type="text" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getApellido(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>Apellido(s)</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtEmail" type="text" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getEmail(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>E-mail</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtTelefono" type="text" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getTelefono(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>Celular</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtFechaN" type="date" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $operacion == 'a' ? '' : $entidad->getFechaN()->format('Y-m-d'); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?>  />
                                <label>Fecha de nacimiento</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-special">
                                <h1 style="font-size:12px; font-family: 'Montserrat-Bold', sans-serif;">Sexo</h1>
                                <input type="radio" name="rbSexo" value="F" <?php echo ($edicion == true ? '' : ' disabled '); ?> <?php echo ($entidad->getSexo() == 'F' ? 'checked="true"' : ''); ?> style="margin-right: 0.5rem;" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />Femenino
                                <input type="radio" name="rbSexo" value="M" <?php echo ($edicion == true ? '' : ' disabled '); ?> <?php echo ($entidad->getSexo() == 'M' ? 'checked="true"' : ''); ?> style="margin-right: 0.5rem; margin-left: 1rem;"/>Masculino
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td><br></td>
                    </tr>

                </table>
                <br />
                <div id="confirmacion">

                </div>
                <button class="btn_action" type="submit">
                    <?php echo $boton; ?>
                </button>
                <a class="btn_action" href="menuChofer.php">
                    Cancelar
                </a>
            </form>
        </article>
    </section>

<?php

} else { // Si algo está mal, entonces...
    header("Location: error.php?error=$error");
}
include_once('footer.php');
?>