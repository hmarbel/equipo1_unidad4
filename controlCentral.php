<?php

// Esta clase mostrará un formulario con el que se mostrarán los campos
// de una central, ya sea para verlos sin modificar (borrar o restaurar),
// verlos y poder modificar (actualizar) o para llenarlos (agregar)

// Función "parecida" a un import (énfasis en "parecida") | Alternativa: include
include_once("db\Central.php");

include_once("header.php");

$pasa = true;
$entidad = new Central();

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
            if (!$entidad->loadCentral()) {
                $error = "No existe la central";
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
            <form name="form" id="form" action="modelo/consultaCentral.php" method="post" class="form_registro">
                <div class="menu_header">
                    <div>
                        <h1> <?php echo ($operacion == 'a' ? 'Nueva central' : ($operacion == 'm' ? 'Editar central' : ($operacion == 'b' ? 'Eliminar central' : 'Restaurar central'))); ?></h1>
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
                                <select name="txtEstado" <?php echo ($edicion == true ? '' : ' disabled '); ?>>
                                    <option value="Aguascalientes" <?php echo ($entidad->getEstado() == 'Aguascalientes' ? ' selected ' : ''); ?> >Aguascalientes</option>
                                    <option value="Baja California" <?php echo ($entidad->getEstado() == 'Baja California' ? ' selected ' : ''); ?> >Baja California</option>
                                    <option value="Baja California Sur" <?php echo ($entidad->getEstado() == 'Baja California Sur' ? ' selected ' : ''); ?> >Baja California Sur</option>
                                    <option value="Campeche" <?php echo ($entidad->getEstado() == 'Campeche' ? ' selected ' : ''); ?> >Campeche</option>
                                    <option value="Chiapas" <?php echo ($entidad->getEstado() == 'Chiapas' ? ' selected ' : ''); ?> >Chiapas</option>
                                    <option value="Chihuahua" <?php echo ($entidad->getEstado() == 'Chihuahua' ? ' selected ' : ''); ?> >Chihuahua</option>
                                    <option value="CDMX" <?php echo ($entidad->getEstado() == 'CDMX' ? ' selected ' : ''); ?> >Ciudad de México</option>
                                    <option value="Coahuila" <?php echo ($entidad->getEstado() == 'Coahuila' ? ' selected ' : ''); ?> >Coahuila</option>
                                    <option value="Colima" <?php echo ($entidad->getEstado() == 'Colima' ? ' selected ' : ''); ?> >Colima</option>
                                    <option value="Durango" <?php echo ($entidad->getEstado() == 'Durango' ? ' selected ' : ''); ?> >Durango</option>
                                    <option value="Estado de México" <?php echo ($entidad->getEstado() == 'Estado de México' ? ' selected ' : ''); ?> >Estado de México</option>
                                    <option value="Guanajuato" <?php echo ($entidad->getEstado() == 'Guanajuato' ? ' selected ' : ''); ?> >Guanajuato</option>
                                    <option value="Guerrero" <?php echo ($entidad->getEstado() == 'Guerrero' ? ' selected ' : ''); ?> >Guerrero</option>
                                    <option value="Hidalgo" <?php echo ($entidad->getEstado() == 'Hidalgo' ? ' selected ' : ''); ?> >Hidalgo</option>
                                    <option value="Jalisco" <?php echo ($entidad->getEstado() == 'Jalisco' ? ' selected ' : ''); ?> >Jalisco</option>
                                    <option value="Michoacán" <?php echo ($entidad->getEstado() == 'Michoacán' ? ' selected ' : ''); ?> >Michoacán</option>
                                    <option value="Morelos" <?php echo ($entidad->getEstado() == 'Morelos' ? ' selected ' : ''); ?> >Morelos</option>
                                    <option value="Nayarit" <?php echo ($entidad->getEstado() == 'Nayarit' ? ' selected ' : ''); ?> >Nayarit</option>
                                    <option value="Nuevo León" <?php echo ($entidad->getEstado() == 'Nuevo León' ? ' selected ' : ''); ?> >Nuevo León</option>
                                    <option value="Oaxaca" <?php echo ($entidad->getEstado() == 'Oaxaca' ? ' selected ' : ''); ?> >Oaxaca</option>
                                    <option value="Puebla" <?php echo ($entidad->getEstado() == 'Puebla' ? ' selected ' : ''); ?> >Puebla</option>
                                    <option value="Querétaro" <?php echo ($entidad->getEstado() == 'Querétaro' ? ' selected ' : ''); ?> >Querétaro</option>
                                    <option value="Quintana Roo" <?php echo ($entidad->getEstado() == 'Quintana Roo' ? ' selected ' : ''); ?> >Quintana Roo</option>
                                    <option value="San Luis Potosí" <?php echo ($entidad->getEstado() == 'San Luis Potosí' ? ' selected ' : ''); ?> >San Luis Potosí</option>
                                    <option value="Sinaloa" <?php echo ($entidad->getEstado() == 'Sinaloa' ? ' selected ' : ''); ?> >Sinaloa</option>
                                    <option value="Sonora" <?php echo ($entidad->getEstado() == 'Sonora' ? ' selected ' : ''); ?> >Sonora</option>
                                    <option value="Tabasco" <?php echo ($entidad->getEstado() == 'Tabasco' ? ' selected ' : ''); ?> >Tabasco</option>
                                    <option value="Tamaulipas" <?php echo ($entidad->getEstado() == 'Tamaulipas' ? ' selected ' : ''); ?> >Tamaulipas</option>
                                    <option value="Tlaxcala" <?php echo ($entidad->getEstado() == 'Tlaxcala' ? ' selected ' : ''); ?> >Tlaxcala</option>
                                    <option value="Veracruz" <?php echo ($entidad->getEstado() == 'Veracruz' ? ' selected ' : ''); ?> >Veracruz</option>
                                    <option value="Yucatán" <?php echo ($entidad->getEstado() == 'Yucatán' ? ' selected ' : ''); ?> >Yucatán</option>
                                    <option value="Zacatecas" <?php echo ($entidad->getEstado() == 'Zacatecas' ? ' selected ' : ''); ?> >Zacatecas</option>
                                </select>
                                <label>Estado</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtCiudad" type="text" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getCiudad(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>Ciudad</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtCalle" type="text" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getCalle(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>Calle</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtColonia" type="text" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getColonia(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>Colonia</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtNoEdificio" type="text" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getNoEdificio(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>No. Edificio</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtCP" type="text" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getCP(); ?>" <?php echo ($operacion == 'a' || $operacion == 'm' ? ' required ' : ''); ?> />
                                <label>Código postal</label>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <div class="input-container">
                                <input name="txtNombre" type="text" <?php echo ($edicion == true ? '' : ' disabled '); ?> value="<?php echo $entidad->getNombre(); ?>" />
                                <label>Nombre (opcional)</label>
                            </div>
                        </td>
                    </tr>

                </table>
                <br />
                <div id="confirmacion">

                </div>
                <button class="btn_action" type="submit">
                    <?php echo $boton; ?>
                </button>
                <a class="btn_action" href="menuCentral.php">
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