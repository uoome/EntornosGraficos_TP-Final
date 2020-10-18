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

    /** Consulta que inserta un carro para guardar registro, una vez realizada la compra
    *   @param CarroCompra $carro
    *   @return null|int $idCarro
    */
    function insertCarro(CarroCompra $carroToAdd) 
    {
        $idCarro = null;
        
        try {
            // Armar query
            $sqlPagoExist = "INSERT INTO `carro_compra`(total, id_usuario, forma_pago) VALUES (?,?,?);";
            $sqlPagoNull = "INSERT INTO `carro_compra`(total, id_usuario) VALUES (?,?);";
            // Fetch data to insert
            $total = $carroToAdd->get_total_carro();
            $userID = $carroToAdd->get_idUsuario();
            $pago = $carroToAdd->get_formaPago();
            // Armar statement dependiendo el pago
            if(isset($pago)) {
                $stmt = $this->connect()->prepare($sqlPagoExist);
                $stmt->bind_param(
                    "dii",
                    $total,
                    $userID,
                    $pago
                );
            } else {
                $stmt = $this->connect()->prepare($sqlPagoNull);
                $stmt->bind_param(
                    "di",
                    $total,
                    $userID
                );
            }
            // Ejecutar y guardar resultado
            $flag = $stmt->execute();
            if($flag) $idCarro = $stmt->insert_id;
            // die(var_dump($idCarro));
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
        return $idCarro;
    }

}

?>