<?php

// Esta página es el menú de los viajes: muestra a todos los viajes (si es que hay), permitiendo
// agregar uno nuevo o modificar y eliminar a los que ya existen

include_once("db\Viaje.php");
include_once("db\Central.php");

include_once("header.php");

$pasa = true;
$entidades = null;
$entidad = new Viaje();

// Recuperación de todos los viajes
try {
    $entidades = $entidad->getAllViaje();
} catch (Exception $e) {
    error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
    $pasa = false;
}

if ($pasa) {
?>
    <section>

        <article>
            <form action="controlViaje.php" method="post">
                <input type="hidden" name="clave"> <!-- Este campo invisible guardará la clave (id) del viaje escogido (-1 si es nuevo) -->
                <input type="hidden" name="operacion"> <!-- Este campo invisible guardará la operación a realizar (a: agregar, m: modificar, b: borrar) -->
                <div class="menu_header">
                    <div>
                        <h1>Viajes</h1>
                        <h5>Gestiona a todos los viajes o agrega a uno nuevo</h5>
                    </div>
                    <div>
                        <button class="btn_action" onClick="clave.value='-1';operacion.value='a'">
                            <i class="fa-solid fa-circle-plus" style="margin-right: 0.5rem;"></i>
                            Agregar nuevo
                        </button>
                    </div>
                </div>
                <br>
                <?php
                // Si entidades es diferente de null, significa que hay al menos un viaje
                if ($entidades != null) {
                ?>
                    <table class="table_content">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Fecha</th>
                                <th>Tipo de viaje</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($entidades as $entidad) {
                            ?>
                                <tr style="overflow:hidden;">
                                    <td class="llave" style="border-top-left-radius: 8px; border-bottom-left-radius: 8px;"><?php echo $entidad->getId(); ?></td>
                                    <td>
                                        <?php
                                        $origen = new Central();
                                        $origen->getCentralById($entidad->getOrigen());
                                        echo $origen->getCiudad() . ", " . $origen->getEstado();
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        $destino = new Central();
                                        $destino->getCentralById($entidad->getDestino());
                                        echo $destino->getCiudad() . ", " . $destino->getEstado();
                                        ?>
                                    </td>
                                    <td><?php echo $entidad->getSalida(); ?></td>
                                    <td><?php echo ($entidad->getTipoViaje() == "1" ? "Hydrus Regular" : ($entidad->getTipoViaje() == "2" ? "Hydrus Galaxy" : "?")); ?></td>
                                    <td><?php echo "$ " . $entidad->getPrecio() . " MXN"; ?></td>
                                    <td style="border-radius: 0 8px 8px 0%;">
                                        <table style="border-collapse: collapse; border-spacing: 0;  margin: 0 auto;">
                                            <tr style="text-align: center;">
                                                <td style="padding: 0 4px;">
                                                    <button class="btn_action" type="submit" name="btnEditar" onClick="clave.value=<?php echo $entidad->getId(); ?>; operacion.value='m'">
                                                        <i class="fa-solid fa-pen"></i>
                                                    </button>
                                                </td>
                                                <td style="padding: 0 4px;">
                                                    <button class="btn_action" type="submit" name="btnBorrar" onClick="clave.value=<?php echo $entidad->getId(); ?>; operacion.value='b'">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
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