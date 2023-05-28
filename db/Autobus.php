<?php

include_once("Conexion.php");

class Autobus
{
    private $id = "";
    private $placas = "";
    private $tipoViaje = "";
    private $activo = "";

    function setId($valor)
    {
        $this->id = $valor;
    }

    function getId()
    {
        return $this->id;
    }

    function setPlacas($valor)
    {
        $this->placas = $valor;
    }

    function getPlacas()
    {
        return $this->placas;
    }

    function setTipoViaje($valor)
    {
        $this->tipoViaje = $valor;
    }

    function getTipoViaje()
    {
        return $this->tipoViaje;
    }

    function setActivo($valor)
    {
        $this->activo = $valor;
    }

    function getActivo()
    {
        return $this->activo;
    }


    // Método para cargar la información de la central actual
    function loadAutobus()
    {
        $conexion = new ConexionDB();
        $cargado = false;
        if ($this->id == 0)
            throw new Exception("Autobus->loadAutobus(): Faltan 'idautobus'");
        else {
            $sQuery = " SELECT * 
                                FROM autobus 
                                WHERE idautobus = $this->id;";
            $result = $conexion->ejecutarSelect($sQuery);
            if ($result) {
                $this->id = $result[0][0];
                $this->placas = $result[0][1];
                $this->tipoViaje = $result[0][2];
                $this->activo = $result[0][3];
                $cargado = true;
            }
        }
        return $cargado;
    }

    function existeAutobus($id)
    {
        $conexion = new ConexionDB();
        $existe = 0;

        $sQuery = " SELECT COUNT(idautobus) 
                                FROM autobus 
                                WHERE idautobus = $id AND activo = '1';";
        $result = $conexion->ejecutarSelect($sQuery);
        if ($result) {
            $existe = $result[0][0];
        }
        return $existe >= 1;
    }

    function getCantidadAsientos() {
        if ($this->tipoViaje == "1") {
            return 44;
        }

        if ($this->tipoViaje == "2") {
            return 27;
        }
    }

    // Método para recuperar a todas las centrales
    function getAllAutobus()
    {
        $conexion = new ConexionDB();

        $result = null;
        $row = null;
        $j = 0;
        $lista = false;
        $query = "SELECT *
                    FROM autobus 
                    ORDER BY idautobus";
        $result = $conexion->ejecutarSelect($query);

        if ($result) {
            $lista = array();
            foreach ($result as $row) {
                $entidad = new Autobus();
                $entidad->id = $row[0];
                $entidad->placas = $row[1];
                $entidad->tipoViaje = $row[2];
                $entidad->activo = $row[3];
                $lista[$j] = $entidad;
                $j = $j + 1;
            }
        } else {
            $lista = false;
        }

        return $lista;
    }

    // Método para agregar a un nuevo autobús
    function insertAutobus()
    {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "INSERT INTO autobus (placas, tipoviaje, activo)
                    VALUES ('$this->placas', '$this->tipoViaje', '$this->activo')";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }

    // Método para eliminar a un autobús
    function deleteAutobus() {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "";
        if ($this->tieneViajes($this->id)) {
            $query = "UPDATE autobus SET activo = '0' WHERE idautobus = $this->id";
        } else {
            $query = "DELETE FROM autobus WHERE idautobus = $this->id";
        }
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }

    function tieneViajes($id) {
        $conexion = new ConexionDB();
        $existe = 0;

        $sQuery = " SELECT COUNT(idautobus) 
                                FROM viaje 
                                WHERE idautobus = $id;";
        $result = $conexion->ejecutarSelect($sQuery);
        if ($result) {
            $existe = $result[0][0];
        }
        return $existe >= 1;
    }

    // Método para actualizar a un autobús
    function updateAutobus() {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "UPDATE autobus SET
        placas = '$this->placas',
        tipoviaje = '$this->tipoViaje',
        activo = '$this->activo'
        WHERE idautobus = $this->id";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }

    // Método para restaurar a una central
    function restoreAutobus() {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "UPDATE autobus SET
        activo = '1'
        WHERE idautobus = $this->id";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }
}
