<?php

// Esta página es la parte 3 de la compra de boletos
// Aquí se escogerán tantos asientos como boletos se
// hayan establecido en la parte 1

// Función "parecida" a un import (énfasis en "parecida") | Alternativa: include
include_once("db\Viaje.php");

include_once("header.php");

// Carga las funciones de JS
include_once("funciones.html");

$pasa = true;
$entidad = new Viaje();
$ocupados = array();

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
        } else {
            $ocupados = $entidad->getBoletosByViaje();
        }
    } catch (Exception $e) {
        error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
        $error = "Error en base de datos";
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
            <form name="form" id="form" action="compraParte4.php" method="post" class="form_registro">
                <div class="menu_header">
                    <div>
                        <h1>Selecciona tus asientos</h1>
                        <h5>Proporciona el número de asiento y nombre de cada pasajero. Los azules están ocupados</h5>
                    </div>
                </div>

                <br>
                <br>

                <input type="hidden" name="clave" value="<?php echo $clave; ?>" />
                <input type="hidden" name="adulto" value="<?php echo $adulto; ?>">
                <input type="hidden" name="estudiante" value="<?php echo $estudiante; ?>">
                <input type="hidden" name="mayor" value="<?php echo $mayor; ?>">
                <table class="registro">

                    <tr>
                        <td>
                            <div id="asientos"></div>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <br>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <h1>Información de pasajeros</h1>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <br>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <table class="table_viaje">
                                <tbody>
                                    <?php
                                    $aux = 0;
                                    while ($aux < $adulto) {
                                        $general = $general + 1;
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="input-container">
                                                    <input <?php echo "name=txtAsiento$general" ?> <?php echo "id=txtAsiento$general" ?> type="text" required />
                                                    <label>Asiento</label>
                                                </div>
                                            </td>

                                            <td>
                                                <div style="display: flex; align-items: center; justify-content: center;">
                                                    <p style="margin-top: -1.5rem;">Adulto</p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="input-container">
                                                    <input <?php echo "name=txtNombre$general" ?> type="text" required />
                                                    <label>Nombre(s)</label>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="input-container">
                                                    <input <?php echo "name=txtApellido$general" ?> type="text" required />
                                                    <label>Apellido(s)</label>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                        $aux = $aux + 1;
                                    }
                                    ?>

                                    <?php
                                    $aux = 0;
                                    while ($aux < $estudiante) {
                                        $general = $general + 1;
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="input-container">
                                                    <input <?php echo "name=txtAsiento$general" ?> <?php echo "id=txtAsiento$general" ?> type="text" required />
                                                    <label>Asiento</label>
                                                </div>
                                            </td>

                                            <td>
                                                <div style="display: flex; align-items: center; justify-content: center;">
                                                    <p style="margin-top: -1.5rem;">Estudiante</p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="input-container">
                                                    <input <?php echo "name=txtNombre$general" ?> type="text" required />
                                                    <label>Nombre(s)</label>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="input-container">
                                                    <input <?php echo "name=txtApellido$general" ?> type="text" required />
                                                    <label>Apellido(s)</label>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                        $aux = $aux + 1;
                                    }
                                    ?>

                                    <?php
                                    $aux = 0;
                                    while ($aux < $mayor) {
                                        $general = $general + 1;
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="input-container">
                                                    <input <?php echo "name=txtAsiento$general" ?> <?php echo "id=txtAsiento$general" ?> type="text" required />
                                                    <label>Asiento</label>
                                                </div>
                                            </td>

                                            <td>
                                                <div style="display: flex; align-items: center; justify-content: center;">
                                                    <p style="margin-top: -1.5rem;">3ra. Edad</p>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="input-container">
                                                    <input <?php echo "name=txtNombre$general" ?> type="text" required />
                                                    <label>Nombre(s)</label>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="input-container">
                                                    <input <?php echo "name=txtApellido$general" ?> type="text" required />
                                                    <label>Apellido(s)</label>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                        $aux = $aux + 1;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                </table>
                <br />
                <div id="confirmacion">

                </div>
                <button class="btn_action" type="submit" onclick="return compruebaOcupados();">
                    Continuar
                </button>
            </form>
        </article>
    </section>

<?php
    $tipoViaje = $entidad->getTipoViaje();

    if ($tipoViaje == '1') {
        echo '<script type="text/javascript">
            document.body.onload = paintAsientos("asientos", "1");
            </script>';
    } else if ($tipoViaje == '2') {
        echo '<script type="text/javascript">
        document.body.onload = paintAsientos("asientos", "2");
            </script>';
    }
} else { // Si algo está mal, entonces...
    header("Location: error.php?error=$error");
}
include_once('footer.php');
?>

<script type="text/javascript">
    var arreglo = <?php echo json_encode($ocupados); ?>;

    for (let i = 0; i < arreglo.length; i++) {
        let asiento = document.getElementById("asiento" + arreglo[i]);
        asiento.style = 'background-image: url("img/seatB.png"); background-size: 3rem; width: 3rem; height: 3rem; text-align: center; padding-left: 0.65rem; display: flex; align-items: center; justify-content: center;';
    }

    function compruebaOcupados() {
        let boletos = <?php echo $general; ?>;

        for (let j = 1; j <= boletos; j++) {
            let numero = document.getElementById("txtAsiento" + j).value;
            for (let k = 0; k < arreglo.length; k++) {
                if (numero == arreglo[k]) {
                    return false;
                }
            }
        }

        return true;
    }
</script>