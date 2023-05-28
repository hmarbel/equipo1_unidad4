<!DOCTYPE html>
<html lang="en">

<!-- Página de inicio: Inicio de sesión -->

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hydrus - Login</title>

    <link rel="stylesheet" href="css/styles.css">
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

    <!-- Div para el formulario de Inicio de sesión -->
    <div class="login_form">
        <div class="form">
            <img src="img/logoA.png" alt="logo" class="logo">
            <h3>Viajes de otro mundo</h3>
            <br>
            <br>

            <!-- Al presionar Iniciar sesión, se dirigirá a "login.php" -->
            <form action="login.php" method="post">
                <div class="input-container">
                    <input name="txtId" type="text" required />
                    <label>Identificador</label>
                </div>
                <div class="input-container">
                    <input name="txtPass" type="password" required />
                    <label>Contraseña</label>
                </div>

                <?php
                if (isset($_REQUEST["msg"])) {
                    $texto = $_REQUEST["msg"];
                ?>
                <h4 style="text-align: left;"><?php echo $texto; ?></h4>
                <br>
                <?php
                }
                ?>
                <center>
                    <button class="btn" role="button"><span class="text">Iniciar sesión</span></button>
                    <br>
                    <br>
                    <a href="registroCliente.php">¿No tienes una cuenta? ¡Crea una!</a>
                </center>
            </form>
        </div>
    </div>
</body>

</html>