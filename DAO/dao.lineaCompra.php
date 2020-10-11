<?php

// Archivo que contiene consultas de DB dedicadas a la tabla `carro-zapatilla`
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH . "db.php");
include_once(DATA_PATH . "data.lineaCompra.php");

class LineaCompraService extends ConnectionDB {

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

    function insertLieaCompra($lineaCompra) {

        try {
            // Armar query
            $sql = "INSERT INTO `carro_zapatilla`(id_carro, id_zapatilla, cantidad, subtotal_linea) 
            VALUES (?,?,?,?);";
            // Armar statement
            $stmt = $this->connect()->prepare($sql);
            $stmt->bind_param(
                "iiid",
                $lineaCompra->get_idCarro(),
                $lineaCompra->get_idZapatilla(),
                $lineaCompra->get_qty(),
                $lineaCompra->get_subtotalLinea()
            );
            // Ejecutar y guardar resultado
            $flag = $stmt->execute();
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