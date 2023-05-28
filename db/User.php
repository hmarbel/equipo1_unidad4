<?php

include_once("Conexion.php");
include_once("Admin.php");
include_once("Cliente.php");

class User
{

    private $id = "";
    private $password = "";

    private $admin;

    private $cliente;

    public function getId()
    {
        return $this->id;
    }
    public function setId($valor)
    {
        $this->id = $valor;
    }

    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword($valor)
    {
        $this->password = $valor;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    public function setAdmin($valor)
    {
        return $this->admin = $valor;
    }

    public function getCliente()
    {
        return $this->cliente;
    }

    public function setCliente($valor)
    {
        return $this->cliente = $valor;
    }

    // Verifica si el usuario y la contraseña coinciden con algún registro en la base de datos
    public function existeCuentaAdmin()
    {
        $existe = false;
        $result = array();
        if (($this->id == "" || $this->password == ""))
            throw new Exception("Usuario->buscar: faltan datos");
        else {
            $query = "SELECT idadmin
                           FROM administrador
                           WHERE username = '$this->id'
                           AND password = '$this->password'";
            $conexion = new ConexionDB();
            $result = $conexion->ejecutarSelect($query);
            if ($result != null) {
                $this->admin = new Admin();
                $this->admin->setId($result[0][0]);
                $this->admin->loadAdmin();
                $existe = true;
            }
        }
        return $existe;
    }

    public function existeCuentaCliente()
    {
        $existe = false;
        $result = array();
        if (($this->id == "" || $this->password == ""))
            throw new Exception("Usuario->buscar: faltan datos");
        else {
            $query = "SELECT idcliente
                           FROM cliente
                           WHERE email = '$this->id'
                           AND password = '$this->password'";
            $conexion = new ConexionDB();
            $result = $conexion->ejecutarSelect($query);
            if ($result != null) {
                $this->cliente = new Cliente();
                $this->cliente->setId($result[0][0]);
                $this->cliente->loadCliente();
                $existe = true;
            }
        }
        return $existe;
    }
}
