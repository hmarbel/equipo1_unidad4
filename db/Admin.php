<?php

include_once("Conexion.php");
include_once("Persona.php");

class Admin extends Persona
{

    private $user = "";
    private $super = "";
    private $password = "";

    function setUser($valor)
    {
        $this->user = $valor;
    }

    function getUser()
    {
        return $this->user;
    }

    function setSuper($valor)
    {
        $this->super = $valor;
    }

    function getSuper()
    {
        return $this->super;
    }

    function setPassword($valor)
    {
        $this->password = $valor;
    }

    function getPassword()
    {
        return $this->password;
    }

    // Método para cargar la información del administrador actual
    function loadAdmin()
    {
        $conexion = new ConexionDB();
        $cargado = false;
        if ($this->id == 0)
            throw new Exception("Admin->loadAdmin(): Faltan 'idadmin'");
        else {
            $sQuery = " SELECT * 
                                FROM administrador 
                                WHERE idadmin = $this->id;";
            $result = $conexion->ejecutarSelect($sQuery);
            if ($result) {
                $this->id = $result[0][0];
                $this->user = $result[0][1];
                $this->nombre = $result[0][2];
                $this->apellido = $result[0][3];
                $this->email = $result[0][4];
                $this->telefono = $result[0][5];
                $this->fechaN = DateTime::createFromFormat('Y-m-d', $result[0][6]);
                $this->password = $result[0][7];
                $this->super = $result[0][8];
                $this->sexo = $result[0][9];
                $cargado = true;
            }
        }
        return $cargado;
    }

    // Método para recuperar a todos los administradores
    function getAllAdmin()
    {
        $conexion = new ConexionDB();

        $result = null;
        $row = null;
        $j = 0;
        $lista = false;
        $query = "SELECT *
                    FROM administrador 
                    ORDER BY idadmin";
        $result = $conexion->ejecutarSelect($query);

        if ($result) {
            $lista = array();
            foreach ($result as $row) {
                $entidad = new Admin();
                $entidad->id = $row[0];
                $entidad->user = $row[1];
                $entidad->nombre = $row[2];
                $entidad->apellido = $row[3];
                $entidad->email = $row[4];
                $entidad->telefono = $row[5];
                $entidad->fechaN = DateTime::createFromFormat('Y-m-d', $row[6]);
                $entidad->password = $row[7];
                $entidad->super = $row[8];
                $entidad->sexo = $row[9];
                $lista[$j] = $entidad;
                $j = $j + 1;
            }
        } else {
            $lista = false;
        }

        return $lista;
    }

    // Método para agregar a un nuevo administrador
    function insertAdmin()
    {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "INSERT INTO administrador (username, nombre, apellido, email, telefono, fechan, password, super, sexo)
                    VALUES ('$this->user', '$this->nombre', '$this->apellido', '$this->email', '$this->telefono', '$this->fechaN', '$this->password', '$this->super', '$this->sexo')";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }

    // Método para eliminar a un administrador
    function deleteAdmin() {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "DELETE FROM administrador WHERE idadmin = $this->id";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }

    // Método para actualizar a un administrador
    function updateAdmin() {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "UPDATE administrador SET
        username = '$this->user',
        nombre = '$this->nombre',
        apellido = '$this->apellido',
        email = '$this->email',
        telefono = '$this->telefono',
        fechan = '$this->fechaN',
        password = '$this->password',
        super = '$this->super',
        sexo = '$this->sexo'
        WHERE idadmin = $this->id";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }
}
