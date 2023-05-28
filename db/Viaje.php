<?php

include_once("Conexion.php");

class Viaje
{
    private $id = "";
    private $origen = "";
    private $destino = "";
    private $idChofer = "";
    private $idAutobus = "";
    private $salida = "";
    private $llegada = "";
    private $tipoViaje = "";
    private $precio = "";

    function setId($valor)
    {
        $this->id = $valor;
    }

    function getId()
    {
        return $this->id;
    }

    function setOrigen($valor)
    {
        $this->origen = $valor;
    }

    function getOrigen()
    {
        return $this->origen;
    }

    function setDestino($valor)
    {
        $this->destino = $valor;
    }

    function getDestino()
    {
        return $this->destino;
    }

    function setIdChofer($valor)
    {
        $this->idChofer = $valor;
    }

    function getIdChofer()
    {
        return $this->idChofer;
    }

    function setIdAutobus($valor)
    {
        $this->idAutobus = $valor;
    }

    function getIdAutobus()
    {
        return $this->idAutobus;
    }

    function setSalida($valor)
    {
        $this->salida = $valor;
    }

    function getSalida()
    {
        return $this->salida;
    }

    function setLlegada($valor)
    {
        $this->llegada = $valor;
    }

    function getLlegada()
    {
        return $this->llegada;
    }

    function setTipoViaje($valor)
    {
        $this->tipoViaje = $valor;
    }

    function getTipoViaje()
    {
        return $this->tipoViaje;
    }

    function setPrecio($valor)
    {
        $this->precio = $valor;
    }

    function getPrecio()
    {
        return $this->precio;
    }


    // Método para cargar la información del viaje actual
    function loadViaje()
    {
        $conexion = new ConexionDB();
        $cargado = false;
        if ($this->id == 0)
            throw new Exception("Autobus->loadAutobus(): Faltan 'idautobus'");
        else {
            $sQuery = " SELECT * 
                                FROM viaje 
                                WHERE idviaje = $this->id;";
            $result = $conexion->ejecutarSelect($sQuery);
            if ($result) {
                $this->id = $result[0][0];
                $this->origen = $result[0][1];
                $this->destino = $result[0][2];
                $this->idChofer = $result[0][3];
                $this->idAutobus = $result[0][4];
                $this->salida = $result[0][5];
                $this->llegada = $result[0][6];
                $this->tipoViaje = $result[0][7];
                $this->precio = $result[0][8];
                $cargado = true;
            }
        }
        return $cargado;
    }

    // Método para recuperar a todos los viajes
    function getAllViaje()
    {
        $conexion = new ConexionDB();

        $result = null;
        $row = null;
        $j = 0;
        $lista = false;
        $query = "SELECT *
                    FROM viaje 
                    ORDER BY idviaje";
        $result = $conexion->ejecutarSelect($query);

        if ($result) {
            $lista = array();
            foreach ($result as $row) {
                $entidad = new Viaje();
                $entidad->id = $row[0];
                $entidad->origen = $row[1];
                $entidad->destino = $row[2];
                $entidad->idChofer = $row[3];
                $entidad->idAutobus = $row[4];
                $entidad->salida = $row[5];
                $entidad->llegada = $row[6];
                $entidad->tipoViaje = $row[7];
                $entidad->precio = $row[8];
                $lista[$j] = $entidad;
                $j = $j + 1;
            }
        } else {
            $lista = false;
        }

        return $lista;
    }

    function getAllViajeActivo()
    {
        $conexion = new ConexionDB();

        $result = null;
        $row = null;
        $j = 0;
        $lista = false;
        $query = "SELECT *
                    FROM viaje 
                    WHERE salida >= NOW()
                    ORDER BY idviaje";
        $result = $conexion->ejecutarSelect($query);

        if ($result) {
            $lista = array();
            foreach ($result as $row) {
                $entidad = new Viaje();
                $entidad->id = $row[0];
                $entidad->origen = $row[1];
                $entidad->destino = $row[2];
                $entidad->idChofer = $row[3];
                $entidad->idAutobus = $row[4];
                $entidad->salida = $row[5];
                $entidad->llegada = $row[6];
                $entidad->tipoViaje = $row[7];
                $entidad->precio = $row[8];
                $lista[$j] = $entidad;
                $j = $j + 1;
            }
        } else {
            $lista = false;
        }

        return $lista;
    }

    function getBoletosByViaje()
    {
        $conexion = new ConexionDB();

        $result = null;
        $row = null;
        $j = 0;
        $lista = false;
        $query = "SELECT asiento
                    FROM boleto 
                    WHERE idviaje = $this->id";
        $result = $conexion->ejecutarSelect($query);

        if ($result) {
            $lista = array();
            foreach ($result as $row) {
                $valor = 0;
                $valor = $row[0];
                $lista[$j] = $valor;
                $j = $j + 1;
            }
        } else {
            $lista = false;
        }

        return $lista;
    }

    // Método para agregar a un nuevo viaje
    function insertViaje()
    {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "INSERT INTO viaje (origen, destino, idchofer, idautobus, salida, llegada, tipoviaje, precio)
                    VALUES ($this->origen, $this->destino, $this->idChofer, $this->idAutobus, '$this->salida', '$this->llegada', '$this->tipoViaje', $this->precio)";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }

    // Método para eliminar a un viaje
    function deleteViaje() {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "";
        if ($this->tieneBoletos($this->id)) {
            return 1;
        } else {
            $query = "DELETE FROM viaje WHERE idviaje = $this->id";
        }
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }

    function asientosDisponibles($id, $asientos) {
        $conexion = new ConexionDB();
        $ocupados = 0;
        $asientos = intval($asientos);

        $sQuery = " SELECT COUNT(idviaje) 
                                FROM boleto 
                                WHERE idviaje = $id;";
        $result = $conexion->ejecutarSelect($sQuery);
        if ($result) {
            $ocupados = $result[0][0];
        }
        return intval($asientos - $ocupados);
    }

    function tieneBoletos($id) {
        $conexion = new ConexionDB();
        $existe = 0;

        $sQuery = " SELECT COUNT(idviaje) 
                                FROM boleto 
                                WHERE idviaje = $id;";
        $result = $conexion->ejecutarSelect($sQuery);
        if ($result) {
            $existe = $result[0][0];
        }
        return $existe >= 1;
    }

    // Método para actualizar a un viaje
    function updateViaje() {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "UPDATE viaje SET
        origen = $this->origen,
        destino = $this->destino,
        idchofer = $this->idChofer,
        idautobus = $this->idAutobus,
        salida = '$this->salida',
        llegada = '$this->llegada',
        tipoviaje = '$this->tipoViaje',
        precio = $this->precio
        WHERE idviaje = $this->id";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }
}
