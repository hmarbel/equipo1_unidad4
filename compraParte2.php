<?php

// Esta página es la parte 2 de la compra de boletos
// Aquí se escogerá el viaje de acuerdo a los parámetros 
// de la parte 1

include_once("db\Viaje.php");
include_once("db\Central.php");
include_once("db\Autobus.php");

include_once("header.php");

$pasa = true;
$entidades = null;
$entidad = new Viaje();

$fechaViaje = $_POST["txtFechaViaje"];

$adulto = intval($_POST["txtAdulto"]);
$estudiante = intval($_POST["txtEstudiante"]);
$mayor = intval($_POST["txtMayor"]);
$totalBoletos = intval($adulto + $estudiante + $mayor);

$viajes = 0; // Variable para contar cuántos viajes se encontraron

$estadoOrigen = $_POST["txtEstadoOrigen"];
$ciudadOrigen = $_POST["txtCiudadOrigen"];

$estadoDestino = $_POST["txtEstadoDestino"];
$ciudadDestino = $_POST["txtCiudadDestino"];

$origenes = array();
$destinos = array();

// Recuperación de todos los viajes
try {
    $entidades = $entidad->getAllViajeActivo();
} catch (Exception $e) {
    error_log($e->getFile() . " " . $e->getLine() . " " . $e->getMessage(), 0);
    $pasa = false;
}

if ($pasa) {
?>
    <section>

        <article>
            <form action="compraParte3.php" method="post">
                <input type="hidden" name="clave"> <!-- Este campo invisible guardará la clave (id) del viaje escogido (-1 si es nuevo) -->
                <input type="hidden" name="adulto">
                <input type="hidden" name="estudiante">
                <input type="hidden" name="mayor">
                <div class="menu_header">
                    <div>
                        <h1>Elige un viaje</h1>
                        <h5>Mostrando los viajes de <span class="span"><?php echo "$ciudadOrigen, $estadoOrigen"; ?></span> a <span class="span"><?php echo "$ciudadDestino, $estadoDestino"; ?></span> el <span class="span"><?php echo $fechaViaje; ?></span></h5>
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
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Fecha</th>
                                <th>Tipo de viaje</th>
                                <th>Total</th>
                                <th>Acción</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            foreach ($entidades as $entidad) {
                                $fechaAux = new DateTime($entidad->getSalida());
                                $fechaAux = $fechaAux->format('Y-m-d');

                                //echo $fechaViaje . "vs " . $fechaAux;
                                if ($fechaAux == $fechaViaje) {
                                    $origen = new Central();
                                    $origen->getCentralById($entidad->getOrigen());

                                    $destino = new Central();
                                    $destino->getCentralById($entidad->getDestino());

                                    if (
                                        $ciudadOrigen == $origen->getCiudad() && $estadoOrigen == $origen->getEstado() &&
                                        $ciudadDestino == $destino->getCiudad() && $estadoDestino == $destino->getEstado()
                                    ) {
                                        $viajes++;
                                        array_push($origenes, $origen->getCiudad());
                                        array_push($destinos, $destino->getCiudad());
                                        $autobusAux = new Autobus();
                                        $autobusAux->setId($entidad->getIdAutobus());
                                        $autobusAux->loadAutobus();
                                        $asientos = $autobusAux->getCantidadAsientos();
                                        $disponibles = $entidad->asientosDisponibles($entidad->getId(), $asientos);
                            ?>
                                        <tr style="overflow:hidden;">
                                            <td style="border-top-left-radius: 8px; border-bottom-left-radius: 8px;">
                                                <div class="weather_container">
                                                    <div class="weather_icon_container">
                                                        <img src="" alt="" id=<?php echo "imagenOrigen$viajes" ?> class="weather_icon">
                                                    </div>

                                                    <div class="weather">
                                                        <div>
                                                            <?php
                                                            echo $origen->getNombre();
                                                            ?>
                                                        </div>
                                                        <div id=<?php echo "tiempoOrigen$viajes" ?>></div>
                                                        <div id=<?php echo "climaOrigen$viajes" ?>></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="weather_container">
                                                    <div class="weather_icon_container">
                                                        <img src="" alt="" id=<?php echo "imagenDestino$viajes" ?> class="weather_icon">
                                                    </div>

                                                    <div class="weather">
                                                        <div>
                                                            <?php
                                                            echo $destino->getNombre();
                                                            ?>
                                                        </div>
                                                        <div id=<?php echo "tiempoDestino$viajes" ?>></div>
                                                        <div id=<?php echo "climaDestino$viajes" ?>></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?php echo $entidad->getSalida(); ?></td>
                                            <td><?php echo ($entidad->getTipoViaje() == "1" ? "Hydrus Regular" : ($entidad->getTipoViaje() == "2" ? "Hydrus Galaxy" : "?")); ?></td>
                                            <td>
                                                <?php
                                                $precio = intval($entidad->getPrecio());
                                                $tA = $adulto * $precio;
                                                $tE = $estudiante * ($precio * 0.75);
                                                $tE = intval($tE);
                                                $tM = $mayor * ($precio * 0.6);
                                                $tM = intval($tM);
                                                $total = $tA + $tE + $tM;
                                                echo "$ " . $total . " MXN";
                                                ?>
                                            </td>
                                            <td style="border-radius: 0 8px 8px 0%;">
                                                <?php
                                                if ($disponibles >= $totalBoletos) {
                                                ?>
                                                    <table style="border-collapse: collapse; border-spacing: 0;  margin: 0 auto;">
                                                        <tr style="text-align: center;">
                                                            <td style="padding: 0 4px;">
                                                                <button class="btn_action" type="submit" name="btnRestaurar" onClick="clave.value=<?php echo $entidad->getId(); ?>;adulto.value=<?php echo $adulto; ?>;estudiante.value=<?php echo $estudiante; ?>;mayor.value=<?php echo $mayor; ?>;">
                                                                    Elegir
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                <?php
                                                } else {
                                                    ?>
                                                    <h5>Asientos insuficientes</h5>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                            <?php
                                    }
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <?php
                    if ($viajes == 0) {
                    ?>
                        <h4>Aún no hay viajes</h4>
                    <?php
                    }
                } else {
                    ?>
                    <h4>Aún no hay viajes</h4>
                <?php
                }
                ?>
            </form>
            <br>
            <a class="btn_action" href="compraParte1.php">
                Regresar
            </a>
            <br>
            <br>
        </article>

    </section>

<?php
} else {
    header("Location: error.php?error=Error en la base de datos");
}
include_once('footer.php');
?>

<script type="text/javascript">
    var origenes = <?php echo json_encode($origenes); ?>;
    var destinos = <?php echo json_encode($destinos); ?>;
    var count = 0;

    const key = 'pqRLJKP4kLQzMXAmSfGghv5BAF89jd27';

    const getCity = async (city) => {
        const base = 'http://dataservice.accuweather.com/locations/v1/cities/search';
        const query = `?apikey=${key}&q=${city}`;

        const response = await fetch(base + query);
        const data = await response.json();

        return data[0];
    };

    const getWeather = async (id) => {
        const base = 'http://dataservice.accuweather.com/currentconditions/v1/';
        const query = `${id}?apikey=${key}`;

        const response = await fetch(base + query);
        const data = await response.json();

        return data[0];
    };

    const setInfo = async (city) => {
        const cityDets = await getCity(city);
        const weather = await getWeather(cityDets.Key);

        return {
            cityDets,
            weather
        };
    };

    const agregaInfoOrigen = (data) => {
        const cityDets = data.cityDets;
        const weather = data.weather;
        count++;

        let imagen1 = document.getElementById("imagenOrigen" + count);
        imagen1.setAttribute('src', `img/icons/${weather.WeatherIcon}.svg`);

        let tiempo1 = document.getElementById("tiempoOrigen" + count);
        tiempo1.innerHTML = `${weather.WeatherText}`;

        let clima1 = document.getElementById("climaOrigen" + count);
        clima1.innerHTML = `${weather.Temperature.Metric.Value} °C`;
    };

    const agregaInfoDestino = (data) => {
        const cityDets = data.cityDets;
        const weather = data.weather;

        let imagen1 = document.getElementById("imagenDestino" + count);
        imagen1.setAttribute('src', `img/icons/${weather.WeatherIcon}.svg`);

        let tiempo1 = document.getElementById("tiempoDestino" + count);
        tiempo1.innerHTML = `${weather.WeatherText}`;

        let clima1 = document.getElementById("climaDestino" + count);
        clima1.innerHTML = `${weather.Temperature.Metric.Value} °C`;
    };

    for (let i = 0; i < origenes.length; i++) {
        setInfo(origenes[0])
            .then(data => agregaInfoOrigen(data))
            .catch(err => console.log(err));

        setInfo(destinos[0])
            .then(data => agregaInfoDestino(data))
            .catch(err => console.log(err));
    }
</script>