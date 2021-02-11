<?php
// Archivo que contiene consultas de DB dedicadas a la tabla `usuario`
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH . "db.php");
include_once(DATA_PATH . "data.compra.php");

class CompraService extends ConnectionDB
{

    /** Consulta que devuelve todas las compras realizadas.
     * @return null|array(Compra) $compras
     */
    function getAllCompras() 
    {
        $compras = null;
        $query = "SELECT * FROM `compra`;";

        try {
            // Ejecutar query
            $data = $this->connect()->query($query);
            $numRows = $data->num_rows;
            // Si hay datos devueltos
            if ($numRows > 0) {
                // Fetch data
                while ($row = $data->fetch_assoc()) {
                    $compras[] = $row;
                }
            }
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) en consulta 'getAllCompras': " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error en consulta 'getAllCompras': " . $ex->getMessage());
        }
        // Devolver data
        return $compras;
    }

    /** Consulta que devuelve las compras realizadas por un usuario
     * @param string $idUser
     * @return null|array(Compra) $compras
     */
    function getComprasUsuario($idUser) 
    {
        $compras = null;
        $query = "SELECT * FROM `compra` WHERE `usuario` = '$idUser';";

        try {
            // Ejecutar query
            $data = $this->connect()->query($query);
            $numRows = $data->num_rows;
            // Si hay datos devueltos
            if ($numRows > 0) {
                // Fetch data
                while ($row = $data->fetch_assoc()) {
                    $compras[] = $row;
                }
            }
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) en consulta 'getComprasUsuario': " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error en consulta 'getComprasUsuario': " . $ex->getMessage());
        }
        // Devolver data
        return $compras;
    }

    /** Consulta que devuelve los datos de una compra.
     * @param string $idCompra
     * @return null|Compra $compra
     */
    function getCompra($idCompra) {
        $compra = null;
        $query = "SELECT * FROM `compra` WHERE `id_compra`= '$idCompra';";

        try {
            // Ejecutar query
            $data = $this->connect()->query($query);
            // Si hay datos devueltos -> Fetch data
            if ($data->num_rows > 0) 
                // Crear zapa
                $compra = new Compra();
                // Guadar datos
                while($row = $data->fetch_assoc()) {
                    $compra->set_id($idCompra);
                    $compra->set_usuario($row['usuario']);
                    $compra->set_carro($row['carro']);
                    $compra->set_total($row['total']);
                    $compra->set_fechaCompra($row['fecha_compra']);
                    $compra->set_tipoPago($row['tipo_pago']);
                }
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) en consulta 'getCompra': " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error en consulta 'getCompra': " . $ex->getMessage());
        }
        // Devolver data
        return $compra;
    }

    /** Consulta que inserta en DB una Compra.
    *   @param Compra $compraToAdd
    *   @return null|int $idCompra
    */
    function insertCompra(Compra $compraToAdd) 
    {
        $idCompra = null;
        
        try {
            // Armar query
            $sqlPagoExist = "INSERT INTO `compra` (`usuario`, `carro`, `total`, `tipo_pago`, `tarjeta`, `direccion_entrega`) 
                VALUES (?,?,?,?,?,?)";
            // Fetch data to insert
            $total = $compraToAdd->get_total();
            $carroID = $compraToAdd->get_carro();
            $userID = $compraToAdd->get_usuario();
            $pago = $compraToAdd->get_tipoPago();
            $tarjetaID = $compraToAdd->get_tarjeta();
            $direccion = $compraToAdd->get_direccionEntrega();
            // die(var_dump($total, $carroID, $userID, $pago));
            // Armar statement dependiendo el pago
            $stmt = $this->connect()->prepare($sqlPagoExist);
            $stmt->bind_param(
                "iidiis",
                $userID,
                $carroID,
                $total,
                $pago,
                $tarjetaID,
                $direccion
            );            
            // Ejecutar y guardar resultado
            $flag = $stmt->execute();
            if($flag) $idCompra = $stmt->insert_id;
            // Cerrar prep
            $stmt->close();
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) al insertar Compra: " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error al insertar Compra: " . $ex->getMessage());
        }
        // Devolver resultado
        return $idCompra;
    }

}

?>