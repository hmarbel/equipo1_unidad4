<?php

include_once("Conexion.php");
include_once("Persona.php");

class Chofer extends Persona
{
    private $activo = "";

    function setActivo($valor)
    {
        $this->activo = $valor;
    }

    function getActivo()
    {
        return $this->activo;
    }


    // Método para cargar la información del chofer actual
    function loadChofer()
    {
        $conexion = new ConexionDB();
        $cargado = false;
        if ($this->id == 0)
            throw new Exception("Chofer->loadChofer(): Faltan 'idchofer'");
        else {
            $sQuery = " SELECT * 
                                FROM chofer 
                                WHERE idchofer = $this->id;";
            $result = $conexion->ejecutarSelect($sQuery);
            if ($result) {
                $this->id = $result[0][0];
                $this->nombre = $result[0][1];
                $this->apellido = $result[0][2];
                $this->email = $result[0][3];
                $this->telefono = $result[0][4];
                $this->fechaN = DateTime::createFromFormat('Y-m-d', $result[0][5]);
                $this->sexo = $result[0][6];
                $this->activo = $result[0][7];
                $cargado = true;
            }
        }
        return $cargado;
    }

    function existeChofer($id)
    {
        $conexion = new ConexionDB();
        $existe = 0;

        $sQuery = " SELECT COUNT(idchofer) 
                                FROM chofer 
                                WHERE idchofer = $id AND activo = '1';";
        $result = $conexion->ejecutarSelect($sQuery);
        if ($result) {
            $existe = $result[0][0];
        }
        return $existe >= 1;
    }

    // Método para recuperar a todos los choferes
    function getAllChofer()
    {
        $conexion = new ConexionDB();

        $result = null;
        $row = null;
        $j = 0;
        $lista = false;
        $query = "SELECT *
                    FROM chofer 
                    ORDER BY idchofer";
        $result = $conexion->ejecutarSelect($query);

        if ($result) {
            $lista = array();
            foreach ($result as $row) {
                $entidad = new Chofer();
                $entidad->id = $row[0];
                $entidad->nombre = $row[1];
                $entidad->apellido = $row[2];
                $entidad->email = $row[3];
                $entidad->telefono = $row[4];
                $entidad->fechaN = DateTime::createFromFormat('Y-m-d', $row[5]);
                $entidad->sexo = $row[6];
                $entidad->activo = $row[7];
                $lista[$j] = $entidad;
                $j = $j + 1;
            }
        } else {
            $lista = false;
        }

        return $lista;
    }

    // Método para agregar a un nuevo chofer
    function insertChofer()
    {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "INSERT INTO chofer (nombre, apellido, email, telefono, fechan, sexo, activo)
                    VALUES ('$this->nombre', '$this->apellido', '$this->email', '$this->telefono', '$this->fechaN', '$this->sexo', '$this->activo')";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }

    // Método para eliminar a un chofer
    function deleteChofer() {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "";
        if ($this->tieneViajes($this->id)) {
            $query = "UPDATE chofer SET activo = '0' WHERE idchofer = $this->id";
        } else {
            $query = "DELETE FROM chofer WHERE idchofer = $this->id";
        }
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }

    function tieneViajes($id) {
        $conexion = new ConexionDB();
        $existe = 0;

        $sQuery = " SELECT COUNT(idchofer) 
                                FROM viaje 
                                WHERE idchofer = $id;";
        $result = $conexion->ejecutarSelect($sQuery);
        if ($result) {
            $existe = $result[0][0];
        }
        return $existe >= 1;
    }

    // Método para actualizar a un chofer
    function updateChofer() {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "UPDATE chofer SET
        nombre = '$this->nombre',
        apellido = '$this->apellido',
        email = '$this->email',
        telefono = '$this->telefono',
        fechan = '$this->fechaN',
        sexo = '$this->sexo',
        activo = '$this->activo'
        WHERE idchofer = $this->id";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }

    function restoreChofer() {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "UPDATE chofer SET
        activo = '1'
        WHERE idchofer = $this->id";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }
}
