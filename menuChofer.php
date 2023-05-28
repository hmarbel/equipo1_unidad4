<?php

// Esta página es el menú de los choferes: muestra a todos los choferes (si es que hay), permitiendo
// agregar uno nuevo o modificar y eliminar a los que ya existen

include_once("db\Chofer.php");

include_once("header.php");

$pasa = true;
$entidades = null;
$entidad = new Chofer();

// Recuperación de todos los choferes
try {
    $entidades = $entidad->getAllChofer();
} catch (Exception $e) {
    error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
    $pasa = false;
}

if ($pasa) {
?>
    <section>

        <article>
            <form action="controlChofer.php" method="post">
                <input type="hidden" name="clave"> <!-- Este campo invisible guardará la clave (id) del chofer escogido (-1 si es nuevo) -->
                <input type="hidden" name="operacion"> <!-- Este campo invisible guardará la operación a realizar (a: agregar, m: modificar, b: borrar) -->
                <div class="menu_header">
                    <div>
                        <h1>Choferes</h1>
                        <h5>Gestiona a todos los choferes o agrega a uno nuevo</h5>
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
                // Si entidades es diferente de null, significa que hay al menos un chofer
                if ($entidades != null) {
                ?>
                    <table class="table_content">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre(s)</th>
                                <th>Apellido(s)</th>
                                <th>E-mail</th>
                                <th>Activo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($entidades as $entidad) {
                            ?>
                                <tr style="overflow:hidden;">
                                    <td class="llave" style="border-top-left-radius: 8px; border-bottom-left-radius: 8px;"><?php echo $entidad->getId(); ?></td>
                                    <td><?php echo $entidad->getNombre(); ?></td>
                                    <td><?php echo $entidad->getApellido(); ?></td>
                                    <td><?php echo $entidad->getEmail(); ?></td>
                                    <td><?php echo ($entidad->getActivo() == "1" ? "Sí" : "No"); ?></td>
                                    <td style="border-radius: 0 8px 8px 0%;">
                                        <table style="border-collapse: collapse; border-spacing: 0;  margin: 0 auto;">
                                            <tr style="text-align: center;">
                                                <?php
                                                if ($entidad->getActivo() == "1") {
                                                ?>
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
                                                <?php
                                                } else {
                                                ?>

                                                    <td style="padding: 0 4px;">
                                                        <button class="btn_action" type="submit" name="btnRestaurar" onClick="clave.value=<?php echo $entidad->getId(); ?>; operacion.value='r'">
                                                        <i class="fa-solid fa-trash-arrow-up"></i>
                                                        </button>
                                                    </td>

                                                <?php
                                                }
                                                ?>
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
                    <h4>Aún no hay choferes</h4>
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