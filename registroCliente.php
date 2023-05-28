<!DOCTYPE html>
<html lang="en">

<!-- Menú de Inicio: Registro de cliente -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hydrus - Registro</title>

    <link rel="stylesheet" href="css/styles.css">

    <?php
        include_once('funciones.html');
    ?>
</head>

<body>
    <!-- Div para el fondo de estrellas -->
    <div class="login_container">
        <div class="login_background">

            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
            <span class="star"></span>
        </div>
    </div>

    <!-- Div para el formulario de Registro de cliente -->
    <div class="login_form">
        <div class="form">
            <img src="img/logoA.png" alt="logo" class="logo">
            <h3>Viajes de otro mundo</h3>
            <br>
            <br>

            <!-- Al presionar Registrarse, se dirigirá a "registro.php" -->
            <form action="modelo/registro.php" method="post">
                <div class="input-container">
                    <input name="txtNombre" type="text" required />
                    <label>Nombre(s)</label>
                </div>
                <div class="input-container">
                    <input name="txtApellido" type="text" required />
                    <label>Apellido(s)</label>
                </div>
                <div class="input-container">
                    <input name="txtEmail" type="text" required />
                    <label>Correo electrónico (Identificador)</label>
                </div>
                <div class="input-container">
                    <input name="txtPass" type="password" required />
                    <label>Contraseña</label>
                </div>
                <div class="input-container">
                    <input name="txtCPass" type="password" required />
                    <label>Repite contraseña</label>
                </div>

                <center>
                    <button class="btn" role="button" onclick="return sonIguales(txtPass.value, txtCPass.value)"><span class="text">Registrarse</span></button>
                    <br>
                    <br>
                    <a href="index.php">¿Ya tienes una cuenta? ¡Inicia sesión!</a>
                </center>
            </form>
        </div>
    </div>
</body>

</html>