<?php

include_once("Conexion.php");
include_once("Persona.php");

class Cliente extends Persona {

    private $activo = 0;
    private $password = "";

    function setActivo($valor) {
        $this->activo = $valor;
    }

    function getActivo() {
        return $this->activo;
    }

    function setPassword($valor)
    {
        $this->password = $valor;
    }

    function getPassword()
    {
        return $this->password;
    }

    function loadCliente()
    {
        $conexion = new ConexionDB();
        $cargado = false;
        if ($this->id == 0)
            throw new Exception("Cliente->loadCliente(): Faltan 'idcliente'");
        else {
            $sQuery = " SELECT * 
                                FROM cliente 
                                WHERE idcliente = " . $this->id;
            $result = $conexion->ejecutarSelect($sQuery);
            if ($result) {
                $this->id = $result[0][0];
                $this->nombre = $result[0][1];
                $this->apellido = $result[0][2];
                $this->email = $result[0][3];
                $this->password = $result[0][4];
                $this->activo = $result[0][5];
                $cargado = true;
            }
        }
        return $cargado;
    }

    function insertCliente()
    {
        $conexion = new ConexionDB();
        $filasAfectadas = -1;
        $query = "INSERT INTO cliente (nombre, apellido, email, password, activo)
                    VALUES ('$this->nombre', '$this->apellido', '$this->email', '$this->password', '$this->activo')";
        $filasAfectadas = $conexion->ejecutarComando($query);
        return $filasAfectadas;
    }
}

?>