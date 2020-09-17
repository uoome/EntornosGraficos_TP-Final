<?php
// Archivo que contiene consultas de DB dedicadas a la tabla `zapatillas`
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH . "db.php");
include_once(DATA_PATH . "data.zapatilla.php");

class ZapatillaDataService extends ConnectionDB
{

    /* CONSULTAS */

    // Consulta que retorna un array de zapatillas
    function getZapatillas()
    {
        $zapatillas = null;
        $query = "SELECT * FROM `zapatilla`;";

        try {
            // Ejecutar query
            $data = $this->connect()->query($query);
            $numRows = $data->num_rows;
            // Si hay datos devueltos
            if ($numRows > 0) {
                // Fetch data
                while ($row = $data->fetch_assoc()) {
                    $zapatillas[] = $row;
                }
            }
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            echo "Error en consulta 'getZapatillas': " . $sqlEx->getMessage();
        } catch (Exception $ex) {
            echo "Error en consulta 'getZapatillas': " . $ex->getMessage();
        }
        // Devolver data
        return $zapatillas;
    }

    // Consulta que inserta una nueva zapatilla
    function insertZapa($newZapa)
    {
        try {
            // Armar query
            $sql = "INSERT INTO `zapatilla`(nombre, color, precio, descripcion, img_path, talle) VALUES (?,?,?,?,?,?);";
            // Armar statement
            $stmt = $this->connect()->prepare($sql);
            $stmt->bind_param(
                "ssdssi",
                $newZapa->get_nombre(),
                $newZapa->get_color(),
                $newZapa->get_precio(),
                $newZapa->get_descripcion(),
                $newZapa->get_img_path(),
                $newZapa->get_talle()
            );
            // Ejecutar y guardar resultado
            $flag = $stmt->execute();
            // Cerrar prep
            $stmt->close();
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            echo "Error al insertar nueva zapatilla: " . $sqlEx->getMessage();
        } catch (Exception $ex) {
            echo "Error al insertar nueva zapatilla: " . $ex->getMessage();
        }
        // Devolver resultado
        return $flag;
    }

}
