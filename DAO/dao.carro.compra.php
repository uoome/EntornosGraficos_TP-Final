<?php
// Archivo que contiene consultas de DB dedicadas a la tabla `carro-compra`
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH . "db.php");
include_once(DATA_PATH . "data.carro.compra.php");

class CarroService extends ConnectionDB {
    /* CONSULTAS */

    // Consulta que trae los datos del carro del usuario
    function getCarroUser($id_user) 
    {
        $carro = null;

        try {
            // Armar query
            $query = "SELECT * FROM `carro_compra` WHERE id_usuario = '$id_user';";
            // Ejecutar query
            $data = $this->connect()->query($query);
            // Validar devolucion
            if($data->num_rows > 0) $carro = $data;
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) al traer datos del Carro desde la DB: " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error al traer datos del Usuario desde la DB: " . $sqlEx->getMessage());
        }
        // Devolver resultado
        return $carro;
    }

    // Consulta que inserta un carro para guardar registro, una vez realizada la compra
    function insertCarro($carro) 
    {
        try {
            // Armar query
            $sql = "INSERT INTO `carro_compra`(subtotal, id_usuario) 
            VALUES (?,?);";
            // Armar statement
            $stmt = $this->connect()->prepare($sql);
            $stmt->bind_param(
                "di",
                $carro->get_subtotal(),
                $carro->get_idUsuario()
            );
            // Ejecutar y guardar resultado
            $flag = $stmt->execute();
            // Cerrar prep
            $stmt->close();
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) al insertar carro Compra: " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error al insertar carro Compra: " . $ex->getMessage());
        }
        // Devolver resultado
        return $flag;
    }

}

?>