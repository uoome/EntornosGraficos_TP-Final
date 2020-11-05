<?php

// Archivo que contiene consultas de DB dedicadas a la tabla `carro-zapatilla`
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH . "db.php");
include_once(DATA_PATH . "data.lineaCompra.php");

class LineaCompraService extends ConnectionDB {

    
    /**
     * Devuelve una linea de compra (si existe) acorde al ID de linea
     * @param int $id_lineaC
     * @return array|null $lineaCompra
     */
    function getLineaCompra($id_lineaC) {
        $lineaCompra = null;

        try {
            // Armar query
            $query = "SELECT * FROM `carro_zapatilla` WHERE id_carro_zapatilla = '$id_lineaC';";
            // Ejecutar query
            $data = $this->connect()->query($query);
            // Validar devolucion
            if($data->num_rows > 0) $lineaCompra = $data;
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) al traer datos de una Linea de Compra desde la DB: " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error al traer datos de una Linea de Compra desde la DB: " . $sqlEx->getMessage());
        }
        // Devolver resultado
        return $lineaCompra;
    }

    /**
     * Metodo que devuelve las lineas de compra de un carro particular
     * @param int $idCarro
     * @return null|array(LineaCompra) $lineasCarro
     */
    function getLineasCarro($idCarro) {
        $lineasCarro = null;

        try {
            // Armar query
            $query = "SELECT * FROM `carro_zapatilla` WHERE `id_carro` = '$idCarro';";
            // Ejecutar query
            $data = $this->connect()->query($query);
            // Validar devolucion
            if($data->num_rows > 0) {
                $lineasCarro = [];
                while($row = $data->fetch_assoc()) {
                    $lineaActual = new LineaCompra();
                    $lineaActual->set_idLineaCompra($row['id_carro_zapatilla']);
                    $lineaActual->set_idCarro($row['id_carro']);
                    $lineaActual->set_idZapatilla($row['id_zapatilla']);
                    $lineaActual->set_qty($row['cantidad']);
                    $lineaActual->set_subtotalLinea($row['subtotal_linea']);
                    $lineaActual->set_color($row['color']);
                    $lineaActual->set_talle($row['talle']);

                    // Agregar al array
                    array_push($lineasCarro, $lineaActual);
                }
            };
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) al traer datos de una Linea de Compra desde la DB: " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error al traer datos de una Linea de Compra desde la DB: " . $sqlEx->getMessage());
        }
        // Devolver resultado
        return $lineasCarro;
    }


    /**
     * Inserta una Linea de Compra en DB
     * @param LineaCompra $lineaCompra
     * @return bool $flag
     */
    function insertLineaCompra(LineaCompra $lineaCompra) {

        // die(var_dump($lineaCompra));
        try {
            // Armar query
            $sql = "INSERT INTO `carro_zapatilla` (`id_carro`, `id_zapatilla`, `cantidad`, `subtotal_linea`, `color`, `talle`) VALUES (?,?,?,?,?,?);";
            // Fetch values
            $carro = $lineaCompra->get_idCarro();
            $zapa = $lineaCompra->get_idZapatilla();
            $cant = $lineaCompra->get_qty();
            $subtot = $lineaCompra->get_subtotalLinea();
            $color = $lineaCompra->get_color();
            $talle = $lineaCompra->get_talle();
            // Armar statement
            $stmt = $this->connect()->prepare($sql);
            $stmt->bind_param(
                "iiidsi",
                $carro,
                $zapa,
                $cant,
                $subtot,
                $color,
                $talle
            );
            // Ejecutar y guardar resultado
            $flag = $stmt->execute();
            // echo "Linea zapa " . $lineaCompra->get_idZapatilla(); 
            // die(var_dump($flag));
            // Cerrar prep
            $stmt->close();
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) al insertar Linea Compra: " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error al insertar Linea Compra: " . $ex->getMessage());
        }
        // Devolver resultado
        return $flag;
    }

}

?>