<?php

include_once("db\User.php");

// session_start inicia o reanuda una sesión
// Las sesiones pueden almacenar información (GET/POST/cookies) y esta puede utilizarse en varias páginas
session_start();

$user = new User();
$tipo = "";
$nombre = "";
$pasa = true;

if (isset($_SESSION["usuario"])) {
    $user = $_SESSION["usuario"]; // Recuperamos al usuario que inició sesión
    $tipo = $_SESSION["tipo"]; // Recuperamos el tipo de usuario que inició sesión (admin/cliente)

    // Es necesario conocer el nombre de quien inició sesión, así que lo recuperamos:
    if ($tipo == "admin") {
        $nombre = $user->getAdmin()->getNombre();
    } else if ($tipo == "cliente") {
        $nombre = $user->getCliente()->getNombre();
    }
} else {
    $pasa = false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hydrus</title>

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="cute-alert-master/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

<body>
    <?php
    if ($pasa) {
        // Alterando al DOM...


        // Esta función importará el script para las alertas personalizadas "cute-alert"
        // También importará jQuery y main, ambos en la carpeta js

        // Además, este script pintará la opción del menú que se haya seleccionado
        // e.g. Si estamos en alguna sección del menú de administradores, entonces
        // en la barra de navegación el botón de "Administradores" estará "brillando"

        echo '<script type="text/javascript">
var script = document.createElement("script");
script.type = "text/javascript";
script.src = "cute-alert-master/cute-alert.js";
document.body.appendChild(script); 

var jquery = document.createElement("script");
jquery.type = "text/javascript";
jquery.src = "js/jquery-3.6.4.min.js";
document.body.appendChild(jquery);

var script2 = document.createElement("script");
script2.type = "text/javascript";
script2.src = "js/main.js";
document.body.appendChild(script2);
    
</script>';
    ?>
        <hgroup class="header_container" style="z-index: 999;">
            <header class="header">
                <div class="header_part">
                    <img src="img/logoA.png" alt="logo" class="logo_mini">
                    <div class="nombre">
                        <h6>Hola de nuevo,</h6>
                        <h2> <?php echo $nombre; ?> </h2>
                    </div>
                </div>

                <div class="header_part">
                    <button class="button" onclick="return confirmDialog()">
                        <div class="button__line"></div>
                        <div class="button__line"></div>
                        <span class="button__text">Cerrar sesión</span>
                        <div class="button__drow1"></div>
                        <div class="button__drow2"></div>
                    </button>
                </div>
            </header>

            <aside style="z-index: 999;">
                <nav class="nav-bar">
                    <?php
                    // Mostraremos solo las opciones que le corresponde a cada tipo de usuario
                    if ($tipo == "admin") {
                    ?>
                        <ul>
                            <?php
                            if ($user->getAdmin()->getSuper() == "1") {
                            ?>
                                <li><a href="menuAdmin.php" class="menu_item" id="menu_admin">Administradores</a></li>
                            <?php
                            }
                            ?>
                            <li><a href="menuChofer.php" class="menu_item" id="menu_chofer">Choferes</a></li>
                            <li><a href="menuAutobus.php" class="menu_item" id="menu_autobus">Autobuses</a></li>
                            <li><a href="menuCentral.php" class="menu_item" id="menu_central">Centrales</a></li>
                            <li><a href="menuViaje.php" class="menu_item" id="menu_viaje">Viajes</a></li>
                        </ul>
                    <?php
                    } else if ($tipo == "cliente") {
                    ?>
                        <ul>
                            <li><a href="compraParte1.php" class="menu_item" id="menu_compra">Comprar boletos</a></li>
                            <!--<li><a href="" class="menu_item">Mis viajes</a></li>-->
                            <!--<li><a href="" class="menu_item">Cuenta</a></li>-->
                        </ul>
                    <?php
                    }
                    ?>
                </nav>
            </aside>
        </hgroup>
    <?php
    }
    ?>
</body>

</html>

<?php

// Alterando al DOM...


// Esta función importará el script para las alertas personalizadas "cute-alert"
// También importará jQuery y main, ambos en la carpeta js

// Además, este script pintará la opción del menú que se haya seleccionado
// e.g. Si estamos en alguna sección del menú de administradores, entonces
// en la barra de navegación el botón de "Administradores" estará "brillando"

echo '<script type="text/javascript">
const url = window.location.href;
const urlFilename = url.substring(url.lastIndexOf("/")+1);
console.log(urlFilename);

if (urlFilename.includes("Admin")) {
    document.getElementById("menu_admin").classList.add("active");
}
else if (urlFilename.includes("Chofer")) {
    document.getElementById("menu_chofer").classList.add("active");
}
else if (urlFilename.includes("Autobus")) {
    document.getElementById("menu_autobus").classList.add("active");
}
else if (urlFilename.includes("Central")) {
    document.getElementById("menu_central").classList.add("active");
}
else if (urlFilename.includes("Viaje")) {
    document.getElementById("menu_viaje").classList.add("active");
}
else if (urlFilename.includes("compra")) {
    document.getElementById("menu_compra").classList.add("active");
}

</script>';
?>