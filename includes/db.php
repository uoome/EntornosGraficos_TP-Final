<?php
// Anterior
// include("Data/usuario-data.php");

// Nuevo
include_once($_SERVER['DOCUMENT_ROOT'].'EntornosGraficos_TP-Final/rutas.php');
include_once(DATA_PATH."usuario-data.php");

session_start();

$servername = "localhost";
$username = "root";
$password = "";
$db = "tibbonzapas";

try {
  // Crear conexion (POO)
  $conn = new mysqli($servername, $username, $password, $db);

  // Chequear
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

} catch (Exception $ex) {
  echo "Error al conectar la DB: " . $ex->getMessage();
}

?>

