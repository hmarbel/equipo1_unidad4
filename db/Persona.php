<?php

class Persona {

    protected $id = "";
    protected $nombre = "";
    protected $apellido = "";
    protected $fechaN = "";
    protected $sexo = "";
    protected $email = "";
    protected $telefono = "";

    function setId($valor) {
        $this->id = $valor;
    }

    function getId() {
        return $this->id;
    }

    function setNombre($valor) {
        $this->nombre = $valor;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setApellido($valor) {
        $this->apellido = $valor;
    }

    function getApellido() {
        return $this->apellido;
    }

    function setFechaN($valor) {
        $this->fechaN = $valor;
    }

    function getFechaN() {
        return $this->fechaN;
    }

    function setSexo($valor) {
        $this->sexo = $valor;
    }

    function getSexo() {
        return $this->sexo;
    }

    function setEmail($valor) {
        $this->email = $valor;
    }

    function getEmail() {
        return $this->email;
    }

    function setTelefono($valor) {
        $this->telefono = $valor;
    }

    function getTelefono() {
        return $this->telefono;
    }
    

}

?>