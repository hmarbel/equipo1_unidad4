<?php

// Esta página es la parte 1 de la compra de boletos
// Aquí se escogerá la ciudad de origen y destino, además
// de la fecha de salida

include_once("db\Central.php");

include_once("header.php");

// Carga las funciones de JS
// include_once("funciones.html");

$pasa = true;
$estados = null;
$estado = "";
$ciudades = null;
$ciudad = "";

$centralAux = new Central();

// Recuperación de todos los estados
try {
    $estados = $centralAux->getEstados();
} catch (Exception $e) {
    error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
    $pasa = false;
}

if ($pasa) {
?>
    <section>
        <article>
            <form action="compraParte2.php" method="post">
                <input type="hidden" name="clave"> <!-- Este campo invisible guardará la clave (id) del chofer escogido (-1 si es nuevo) -->
                <input type="hidden" name="operacion"> <!-- Este campo invisible guardará la operación a realizar (a: agregar, m: modificar, b: borrar) -->
                <div class="menu_header">
                    <div>
                        <h1>¿A dónde te vamos a llevar?</h1>
                        <h5>Especifica el lugar de salida, llegada y fecha de salida</h5>
                    </div>
                </div>
                <br>
                <?php
                // Si estados es diferente de null, significa que hay al menos un chofer
                if ($estados != null) {
                ?>
                    <br>
                    <table class="table_viaje">
                        <tbody>
                            <tr style="overflow:hidden;">
                                <td>
                                    <div class="input-container">
                                        <select name="txtEstadoOrigen" id="txtEstadoOrigen" required>
                                            <?php
                                            foreach ($estados as $estado) {
                                            ?>
                                                <option <?php echo "value=" . $estado; ?>><?php echo $estado ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label>Estado de origen</label>
                                    </div>

                                    <div class="input-container">
                                        <div class="input-container">
                                            <input name="txtCiudadOrigen" type="text" required/>
                                            <label>Ciudad de origen</label>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="input-container">
                                        <select name="txtEstadoDestino" id="txtEstadoDestino" required>
                                            <?php
                                            foreach ($estados as $estado) {
                                            ?>
                                                <option <?php echo "value=" . $estado; ?>><?php echo $estado ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label>Estado de desetino</label>
                                    </div>

                                    <div class="input-container">
                                        <div class="input-container">
                                            <input name="txtCiudadDestino" type="text" required/>
                                            <label>Ciudad de destino</label>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="input-container">
                                        <div class="input-container">
                                            <input name="txtFechaViaje" type="date" required/>
                                            <label>Fecha de salida</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <br>
                                </td>

                                <td>
                                    <br>
                                </td>

                                <td>
                                    <br>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <br>
                                </td>

                                <td>
                                    <br>
                                </td>

                                <td>
                                    <br>
                                </td>
                            </tr>

                            <tr>
                                <td>
                                    <div class="input-container">
                                        <div class="input-container">
                                            <input name="txtAdulto" type="text" inputmode="numeric" pattern="[0-9]+" value="1" required/>
                                            <label>Cantidad de boletos de adulto</label>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="input-container">
                                        <div class="input-container">
                                            <input name="txtEstudiante" type="text" inputmode="numeric" pattern="[0-9]+" value="0" required/>
                                            <label>Cantidad de boletos de estudiante</label>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="input-container">
                                        <div class="input-container">
                                            <input name="txtMayor" type="text" inputmode="numeric" pattern="[0-9]+" value="0" required/>
                                            <label>Cantidad de boletos de 3ra edad</label>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <button class="btn_action" type="submit">
                        Buscar viajes
                    </button>
                <?php
                } else {
                ?>
                    <h4>Aún no hay viajes</h4>
                <?php
                }
                ?>
            </form>
        </article>

    </section>

<?php
} else {
    header("Location: error.php?error=Error en la base de datos");
}
include_once('footer.php');
?>