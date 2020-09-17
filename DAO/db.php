<?php

class ConnectionDB
{
  // Variables
  private $servername;
  private $username;
  private $password;
  private $dbname;
  public $conn;

  // Metodos
  protected function connect() {
    $this->servername = "localhost";
    $this->username = "root";
    $this->password = "";
    $this->dbname = "tibbonzapas";

    try {
      $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

      if ($this->conn->connect_error) {
        die("Connection failed: " . $this->conn->connect_error);
      } else return $this->conn;
    } catch(mysqli_sql_exception $sqlEx) {
      echo "Error al abrir conexion a DB: " . $sqlEx->getMessage();
    } catch(Exception $ex) {
      echo "Error al abrir conexion a DB: " . $ex->getMessage();
    }
  }

  protected function closeConnection() {
    try{
      if($this->conn !== null) $this->conn->close();
    } catch(mysqli_sql_exception $sqlEx) {
      echo "Error al cerrar conexion a DB: " . $sqlEx->getMessage();
    } catch(Exception $ex) {
      echo "Error al cerrar conexion a DB: " . $ex->getMessage();
    }
  }

}
