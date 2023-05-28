<?php

include_once("Conexion.php");

class Central
{
    private $id = "";
    private $estado = "";
    private $ciudad = "";
    private $calle = "";
    private $colonia = "";
    private $noedificio = "";
    private $cp = "";
    private $nombre = "";
    private $activo = "";

    function setId($valor)
    {
        $this->id = $valor;
    }

    function getId()
    {
        return $this->id;
    }

    function setEstado($valor)
    {
        $this->estado = $valor;
    }

    function getEstado()
    {
        return $this->estado;
    }

    function setCiudad($valor)
    {
        $this->ciudad = $valor;
    }

    function getCiudad()
    {
        return $this->ciudad;
    }

    function setCalle($valor)
    {
        $this->calle = $valor;
    }

    function getCalle()
    {
        return $this->calle;
    }

    function setColonia($valor)
    {
        $this->colonia = $valor;
    }

    function getColonia()
    {
        return $this->colonia;
    }

    function setNoEdificio($valor)
    {
        $this->noedificio = $valor;
    }

    function getNoEdificio()
    {
        return $this->noedificio;
    }

    function setCP($valor)
    {
        $this->cp = $valor;
    }

    function getCP()
    {
        return $this->cp;
    }

    function setNombre($valor)
    {
        $this->nombre = $valor;
    }

    function getNombre()
    {
        return $this->nombre;
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
    function loadCentral()
    {
        $conexion = new ConexionDB();
        $cargado = false;
        if ($this->id == 0)
            throw new Exception("Central->loadCentral(): Faltan 'idcentral'");
        else {
            $sQuery = " SELECT * 
                                FROM central 
                                WHERE idcentral = $this->id;";
            $result = $conexion->ejecutarSelect($sQuery);
            if ($result) {
                $this->id = $result[0][0];
                $this->estado = $result[0][1];
                $this->ciudad = $result[0][2];
                $this->calle = $result[0][3];
                $this->colonia = $result[0][4];
                $this->noedificio = $result[0][5];
                $this->cp = $result[0][6];
                $this->nombre = $result[0][7];
                $this->activo = $result[0][8];
                $cargado = true;
            }
        }
        return $cargado;
    }

    function existeCentral($id)
    {
        $conexion = new ConexionDB();
        $existe = 0;

        $sQuery = " SELECT COUNT(idcentral) 
                                FROM central 
                                WHERE idcentral = $id AND activo = '1';";
        $result = $conexion->ejecutarSelect($sQuery);
        if ($result) {
            $existe = $result[0][0];
        }
        return $existe >= 1;
    }

    function getCentralById($entidad_id)
    {
        $conexion = new ConexionDB();
        $cargado = false;
        if ($this->id == 0)
            throw new Exception("Central->loadCentral(): Faltan 'idcentral'");
        else {
            $sQuery = " SELECT * 
                                FROM central 
                                WHERE idcentral = $entidad_id;";
            $result = $conexion->ejecutarSelect($sQuery);
            if ($result) {
                $this->id = $result[0][0];
                $this->estado = $result[0][1];
                $this->ciudad = $result[0][2];
                $this->calle = $result[0][3];
                $this->colonia = $result[0][4];
                $this->noedificio = $result[0][5];
                $this->cp = $result[0][6];
                $this->nombre = $result[0][7];
                $this->activo = $result[0][8];
                $cargado = true;
            }
        }
        return $cargado;
    }

    // Método para recuperar a todas las centrales
    function getAllCentral()
    {
        $conexion = new ConexionDB();

        $result = null;
        $row = null;
        $j = 0;
        $lista = false;
        $query = "SELECT *
                    FROM central 
                    ORDER BY idcentral";
        $result = $conexion->ejecutarSelect($query);

        if ($result) {
            $lista = array();
            foreach ($result as $row) {
                $entidad = new Central();
                $entidad->id = $row[0];
                $entidad->estado = $row[1];
                $entidad->ciudad = $row[2];
                $entidad->calle = $row[3];
                $entidad->colonia = $row[4];
                $entidad->noedificio = $row[5];
                $entidad->cp = $row[6];
                $entidad->nombre = $row[7];
                $entidad->activo = $row[8];
                $lista[$j] = $entidad;
                $j = $j + 1;
            }
        } else {
            $lista = false;
        }

        return $lista;
    }

    function getEstados() {
        $conexion = new ConexionDB();

        $result = null;
        $row = null;
        $j = 0;
        $lista = false;
        $query = "SELECT DISTINCT(estado)
                    FROM central 
                    ORDER BY estado";
        $result = $conexion->ejecutarSelect($query);

        if ($result) {
            $lista = array();
            foreach ($result as $row) {
                $estado = "";
                $estado = $row[0];
                $lista[$j] = $estado;
                $j = $j + 1;
            }
        } else {
            $lista = false;
        }

        return $lista;
    }

    function getCiudadesByEstado($aux) {
        $conexion = new ConexionDB();

        $result = null;
        $row = null;
        $j = 0;
        $lista = false;
        $query = "SELECT ciudad
                    FROM central
                    WHERE estado = '$aux' 
                    ORDER BY ciudad";
        $result = $conexion->ejecutarSelect($query);

        if ($result) {
            $lista = array();
            foreach ($result as $row) {
                $ciudad = "";
                $ciudad = $row[0];
                $lista[$j] = $ciudad;
                $j = $j + 1;
            }
        } else {
            $lista = false;
        }

        return $lista;
    }

    // Método para agregar a una nueva central
    function insertCentral()
    {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "INSERT INTO central (estado, ciudad, calle, colonia, noedificio, cp, nombre, activo)
                    VALUES ('$this->estado', '$this->ciudad', '$this->calle', '$this->colonia', '$this->noedificio', '$this->cp', '$this->nombre', '$this->activo')";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }

    // Método para eliminar a una central
    function deleteCentral()
    {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "";
        if ($this->tieneViajes($this->id)) {
            $query = "UPDATE central SET activo = '0' WHERE idcentral = $this->id";
        } else {
            $query = "DELETE FROM central WHERE idcentral = $this->id";
        }
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }

    function tieneViajes($id) {
        $conexion = new ConexionDB();
        $existe = 0;

        $sQuery = " SELECT COUNT(*) from viaje WHERE origen = $id OR destino = $id;";
        $result = $conexion->ejecutarSelect($sQuery);
        if ($result) {
            $existe = $result[0][0];
        }
        return $existe >= 1;
    }

    function tieneOrigen($id) {
        $conexion = new ConexionDB();
        $existe = 0;

        $sQuery = " SELECT COUNT(origen) 
                                FROM viaje 
                                WHERE origen = $id;";
        $result = $conexion->ejecutarSelect($sQuery);
        if ($result) {
            $existe = $result[0][0];
        }
        return $existe >= 1;
    }

    function tieneDestino($id) {
        $conexion = new ConexionDB();
        $existe = 0;

        $sQuery = " SELECT COUNT(destino) 
                                FROM viaje 
                                WHERE destino = $id;";
        $result = $conexion->ejecutarSelect($sQuery);
        if ($result) {
            $existe = $result[0][0];
        }
        return $existe >= 1;
    }

    // Método para actualizar a una central
    function updateCentral()
    {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "UPDATE central SET
        estado = '$this->estado',
        ciudad = '$this->ciudad',
        calle = '$this->calle',
        colonia = '$this->colonia',
        noedificio = '$this->noedificio',
        cp = '$this->cp',
        nombre = '$this->nombre',
        activo = '$this->activo'
        WHERE idcentral = $this->id";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }

    // Método para restaurar a una central
    function restoreCentral()
    {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "UPDATE central SET
        activo = '1'
        WHERE idcentral = $this->id";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }
}
