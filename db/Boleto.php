<?php

include_once("Conexion.php");

class Boleto
{
    private $id = "";
    private $idcliente = 0;
    private $idviaje = 0;
    private $nombre = "";
    private $apellido = "";
    private $tipo = "";
    private $asiento = 0;
    private $precio = 0;

    function setId($valor)
    {
        $this->id = $valor;
    }

    function getId()
    {
        return $this->id;
    }

    function setIdCliente($valor)
    {
        $this->idcliente = $valor;
    }

    function getIdCliente()
    {
        return $this->idcliente;
    }

    function setIdViaje($valor)
    {
        $this->idviaje = $valor;
    }

    function getIdViaje()
    {
        return $this->idviaje;
    }

    function setNombre($valor)
    {
        $this->nombre = $valor;
    }

    function getNombre()
    {
        return $this->nombre;
    }

    function setApellido($valor)
    {
        $this->apellido = $valor;
    }

    function getApellido()
    {
        return $this->apellido;
    }

    function setTipo($valor)
    {
        $this->tipo = $valor;
    }

    function getTipo()
    {
        return $this->tipo;
    }

    function setAsiento($valor)
    {
        $this->asiento = $valor;
    }

    function getAsiento()
    {
        return $this->asiento;
    }

    function setPrecio($valor)
    {
        $this->precio = $valor;
    }

    function getPrecio()
    {
        return $this->precio;
    }

    // Método para cargar la información de la central actual
    function loadBoleto()
    {
        $conexion = new ConexionDB();
        $cargado = false;
        if ($this->id == 0)
            throw new Exception("Boleto->loadBoleto(): Faltan 'idboleto'");
        else {
            $sQuery = " SELECT * 
                                FROM boleto 
                                WHERE idboleto = $this->id;";
            $result = $conexion->ejecutarSelect($sQuery);
            if ($result) {
                $this->id = $result[0][0];
                $this->idcliente = $result[0][1];
                $this->idviaje = $result[0][2];
                $this->nombre = $result[0][3];
                $this->apellido = $result[0][4];
                $this->tipo = $result[0][5];
                $this->asiento = $result[0][6];
                $this->precio = $result[0][7];
                $cargado = true;
            }
        }
        return $cargado;
    }

    // Método para recuperar a todas las centrales
    function getAllBoleto()
    {
        $conexion = new ConexionDB();

        $result = null;
        $row = null;
        $j = 0;
        $lista = false;
        $query = "SELECT *
                    FROM boleto 
                    ORDER BY idboleto";
        $result = $conexion->ejecutarSelect($query);

        if ($result) {
            $lista = array();
            foreach ($result as $row) {
                $entidad = new Boleto();
                $entidad->idcliente = $row[1];
                $entidad->idviaje = $row[2];
                $entidad->nombre = $row[3];
                $entidad->apellido = $row[4];
                $entidad->tipo = $row[5];
                $entidad->asiento = $row[6];
                $entidad->precio = $row[7];
                $lista[$j] = $entidad;
                $j = $j + 1;
            }
        } else {
            $lista = false;
        }

        return $lista;
    }

    // Método para agregar a una nueva central
    function insertBoleto()
    {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "INSERT INTO boleto (idcliente, idviaje, nombre, apellido, tipo, asiento, subtotal)
                    VALUES ($this->idcliente, $this->idviaje, '$this->nombre', '$this->apellido', '$this->tipo', $this->asiento, $this->precio)";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }
}
