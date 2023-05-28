<?php

// Esta página es la parte 4 de la compra de boletos
// Aquí se escogerán tantos asientos como boletos se
// hayan establecido en la parte 1

// Función "parecida" a un import (énfasis en "parecida") | Alternativa: include
include_once("db\Viaje.php");

include_once("header.php");

// Carga las funciones de JS
include_once("funciones.html");

$pasa = true;
$entidad = new Viaje();

$adulto = intval($_POST["adulto"]);
$estudiante = intval($_POST["estudiante"]);
$mayor = intval($_POST["mayor"]);
$general = 0;

$clave = "";

$error = ""; // Variable auxiliar para comprobar que todo esté bien

// isset verificar que una variable sea diferente de null (is set)
if (
    isset($_POST["clave"]) && !empty($_POST["clave"])
) {
    $clave = $_POST["clave"];

    $entidad->setId($clave);
    try {
        if (!$entidad->loadViaje()) {
            $error = "No existe el viaje";
        }
    } catch (Exception $e) {
        error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
        $error = "Error en base de datos";
    }
} else {
    $aux1 = $_POST['clave'];
    $error = "Faltan datos: clave: $aux1";
}

if ($error == "") { // Si todo está bien, entonces...
?>

    <section>
        <article>
            <form name="form" id="form" action="modelo/pago.php" method="post" class="form_registro">
                <div class="menu_header">
                    <div>
                        <h1>Compra tus boletos</h1>
                        <h5>Proporciona los siguientes datos para finalizar la compra</h5>
                    </div>
                </div>

                <br>
                <br>

                <input type="hidden" name="clave" value="<?php echo $clave; ?>" />
                <input type="hidden" name="adulto" value="<?php echo $adulto; ?>">
                <input type="hidden" name="estudiante" value="<?php echo $estudiante; ?>">
                <input type="hidden" name="mayor" value="<?php echo $mayor; ?>">
                <?php
                $aux = 0;
                while ($aux < $adulto) {
                    $general = $general + 1;
                    $dato = $_POST["txtAsiento$general"];
                    $nombre = $_POST["txtNombre$general"];
                    $apellido = $_POST["txtApellido$general"];
                ?>
                    <input type="hidden" <?php echo "name=asiento$general" ?> <?php echo "value=$dato" ?>>
                    <input type="hidden" <?php echo "name=nombre$general" ?> <?php echo "value=$nombre" ?>>
                    <input type="hidden" <?php echo "name=apellido$general" ?> <?php echo "value=$apellido" ?>>
                <?php
                $aux = $aux + 1;
                }
                ?>

                <?php
                $aux = 0;
                while ($aux < $estudiante) {
                    $general = $general + 1;
                    $dato = $_POST["txtAsiento$general"];
                    $nombre = $_POST["txtNombre$general"];
                    $apellido = $_POST["txtApellido$general"];
                ?>
                    <input type="hidden" <?php echo "name=asiento$general" ?> <?php echo "value=$dato" ?>>
                    <input type="hidden" <?php echo "name=nombre$general" ?> <?php echo "value=$nombre" ?>>
                    <input type="hidden" <?php echo "name=apellido$general" ?> <?php echo "value=$apellido" ?>>
                <?php
                $aux = $aux + 1;
                }
                ?>

                <?php
                $aux = 0;
                while ($aux < $mayor) {
                    $general = $general + 1;
                    $dato = $_POST["txtAsiento$general"];
                    $nombre = $_POST["txtNombre$general"];
                    $apellido = $_POST["txtApellido$general"];
                ?>
                    <input type="hidden" <?php echo "name=asiento$general" ?> <?php echo "value=$dato" ?>>
                    <input type="hidden" <?php echo "name=nombre$general" ?> <?php echo "value=$nombre" ?>>
                    <input type="hidden" <?php echo "name=apellido$general" ?> <?php echo "value=$apellido" ?>>
                <?php
                $aux = $aux + 1;
                }
                ?>
                <table class="registro">
                    <tr>
                        <td>
                            <table class="table_viaje">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="input-container">
                                                <input name="txtTarjeta" type="text" required />
                                                <label>Número de tarjeta</label>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="input-container">
                                                <select name="txtMes" id="txtMes" required>
                                                    <?php
                                                    $mesCount = 1;
                                                    while ($mesCount <= 12) {
                                                        $mes = str_pad($mesCount, 2, '0', STR_PAD_LEFT);
                                                    ?>
                                                        <option <?php echo "value=" . $mes; ?>><?php echo $mes ?></option>
                                                    <?php
                                                    $mesCount = $mesCount + 1;
                                                    }
                                                    ?>
                                                </select>
                                                <label>Mes de expiración</label>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="input-container">
                                                <select name="txtYear" id="txtYear" required>
                                                    <?php
                                                    $year = date("Y"); 
                                                    $yearCount = intval($year);
                                                    $tope = $yearCount + 10;
                                                    while ($yearCount <= $tope) {
                                                        $year = str_pad($yearCount, 4, '0', STR_PAD_LEFT);
                                                    ?>
                                                        <option <?php echo "value=" . $year; ?>><?php echo $year ?></option>
                                                    <?php
                                                    $yearCount = $yearCount + 1;
                                                    }
                                                    ?>
                                                </select>
                                                <label>Mes de expiración</label>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="input-container">
                                                <input name="txtCVV" type="text" required />
                                                <label>CVV</label>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                </table>
                <br />
                <div id="confirmacion">

                </div>
                <button class="btn_action" type="submit">
                    Pagar
                </button>
            </form>

        </article>
    </section>

<?php
} else { // Si algo está mal, entonces...
    header("Location: error.php?error=$error");
}
include_once('footer.php');
?>