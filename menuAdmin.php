<?php

// Esta clase es el menú principal de los administradores:
// Aquí se podrán ver todos los que están registrados en la BD,
// permitiendo editarlos o eliminarlos, además, se podrán
// agregar nuevos administradores

include_once("db\User.php");
include_once("db\Admin.php");

include_once("header.php");

$pasa = true;
$admins = null;
$admin = new Admin();
$usuario = new User();
$usuario = $_SESSION["usuario"];


// Recuperamos a todas las entidades : En este caso, administradores
try {
    $admins = $admin->getAllAdmin();
} catch (Exception $e) {
    error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
    $pasa = false;
}

if ($pasa) {
?>
    <section>

        <article>
            <form action="controlAdmin.php" method="post">
                <input type="hidden" name="clave">
                <input type="hidden" name="operacion">
                <div class="menu_header">
                    <div>
                        <h1>Administradores</h1>
                        <h5>Gestiona a todos los administradores o agrega a uno nuevo</h5>
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
                // Si el vector que almacena las entidades es diferente de null, entonces...
                if ($admins != null) {
                    // Si solo hay una entidad, significa que se trata del usuario que inició sesión
                    // y esta cuenta NO se debe mostrar en el listado, así que imaginamos que aún no
                    // hay administradores
                    if (count($admins) == 1) {
                ?>
                        <h4>Aún no hay administradores</h4>
                    <?php
                    // Si hay más de 2 administradores, los mostramos, con excepción del que inició sesión
                    } else {
                    ?>
                        <table class="table_content">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Nombre(s)</th>
                                    <th>Apellido(s)</th>
                                    <th>E-mail</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($admins as $admin) {
                                    if ($usuario->getAdmin()->getId() != $admin->getId()) {
                                ?>
                                        <tr style="overflow:hidden;">
                                            <td class="llave" style="border-top-left-radius: 8px; border-bottom-left-radius: 8px;"><?php echo $admin->getUser(); ?></td>
                                            <td><?php echo $admin->getNombre(); ?></td>
                                            <td><?php echo $admin->getApellido(); ?></td>
                                            <td><?php echo $admin->getEmail(); ?></td>
                                            <td style="border-radius: 0 8px 8px 0%;">
                                                <table style="border-collapse: collapse; border-spacing: 0;">
                                                    <tr>
                                                        <td style="padding: 0 4px;"><button class="btn_action" type="submit" name="btnEditar" onClick="clave.value=<?php echo $admin->getId(); ?>; operacion.value='m'">
                                                                <i class="fa-solid fa-pen"></i>
                                                            </button>
                                                        </td>
                                                        <td style="padding: 0 4px;"><button class="btn_action" type="submit" name="btnBorrar" onClick="clave.value=<?php echo $admin->getId(); ?>; operacion.value='b'">
                                                                <i class="fa-solid fa-trash"></i>
                                                            </button></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    <?php
                    }
                } else {
                    ?>
                    <h4>Aún no hay administradores</h4>
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