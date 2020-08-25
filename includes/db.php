<?php
$servername = "localhost";
$username = "root";
$password = "";
$db = "tibbonzapas";

// Crear conexion (POO)
$conn = new mysqli($servername, $username, $password, $db);

// Chequear
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>