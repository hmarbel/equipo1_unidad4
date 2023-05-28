<?php

error_reporting(E_ALL);

class ConexionDB
{

    private $conn = null;

    // Método para abrir la conexión con la base de datos
    public function openConnection()
    {
        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=hydrus", "root", "",  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
        } catch (Exception $e) {
            throw $e;
        }
    }

    // Método para cerrar la conexión con la base de datos
    public function closeConnection()
    {
        try {
            if ($this->conn != null) {
                $this->conn = null;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }

    // Método para ejecutar INSERT, UPDATE, DELETE
    public function ejecutarComando($query)
    {
        try {
            $this->openConnection();

            $rows = -1;
            if ($query == "") {
                throw new Exception("Conexion->ejecutarComando: Consulta vacía");
            }
            if ($this->conn == null) {
                throw new Exception("Conexion->ejecutarComando: Error en la conexión");
            }
            try {
                $rows = $this->conn->exec($query);
            } catch (Exception $e) {
                throw $e;
            }

            $this->closeConnection();
            return $rows;
        } catch (Exception $e) {
            $this->closeConnection();
            throw $e;
        }
    }

    // Método para ejecutar SELECT
    public function ejecutarSelect($query)
    {
        try {
            $this->openConnection();

            $rows = null;
            $result = null;
            $row = null;
            $column = "";
            $i = 0;
            $j = 0;

            if ($query == "") {
                throw new Exception("Conexión->ejecutarSelect: Consulta vacía");
            }
            if ($this->conn == null) {
                throw new Exception("Conexión->ejecutarSelect: Error en la conexión");
            }
            try {
                $result = $this->conn->query($query); //un objeto PDOStatement o falso en caso de error
            } catch (Exception $e) {
                throw $e;
            }
            if ($result) {
                foreach ($result as $row) {
                    foreach ($row as $llave => $column) {
                        if (is_string($llave)) {
                            $rows[$i][$j] = $column;
                            $j++;
                        }
                    }
                    $j = 0;
                    $i++;
                }
            }

            $this->closeConnection();
            return $rows;
        } catch (Exception $e) {
            $this->closeConnection();
            throw $e;
        }
    }
}
