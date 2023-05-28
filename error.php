<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
</head>

<body>
    <center>
        <section>
            <h1>Error</h1>
            <h4><?php echo ((isset($_REQUEST["error"])) ? $_REQUEST["error"] : "Otro error"); ?></h4>
            <?php
            if (isset($_SESSION["usuario"])) {
            ?>
                <a href="mainMenu.php">Regresar al menú principal</a>
            <?php
            } else {
            ?>
                <a href="index.php">Regresar al inicio</a>
            <?php
            }
            ?>
        </section>
    </center>
</body>

</html>