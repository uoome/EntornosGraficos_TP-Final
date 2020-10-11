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
        // $query = "SELECT * FROM `zapatilla` ORDER BY id_zapatilla DESC LIMIT 10;";

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
            die("Error (SQL) en consulta 'getZapatillas': " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error en consulta 'getZapatillas': " . $ex->getMessage());
        }
        // Devolver data
        return $zapatillas;
    }

    /**
     * Consulta que retorna 4 zapatillas de muestra
     * @return null/Zapatilla[] 
     */
    function getMuestra()
    {
        $zapatillas = null;
        $query = "SELECT * FROM `zapatilla` ORDER BY id_zapatilla LIMIT 4;";

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
            die("Error (SQL) en consulta 'getZapatillas': " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error en consulta 'getZapatillas': " . $ex->getMessage());
        }
        // Devolver data
        return $zapatillas;
    }

    /**
     * Consulta que retorna datos de una zapatilla
     * @param int $id
     * @return null/Zapatilla
     */
    function getZapatilla($id) 
    {
        $zapatilla = null;
        $query = "SELECT * FROM `zapatilla` WHERE id_zapatilla = '$id';";

        try {
            // Ejecutar query
            $data = $this->connect()->query($query);
            // Si hay datos devueltos -> Fetch data
            if ($data->num_rows > 0) 
                // Crear zapa
                $zapatilla = new Zapatilla();
                // Guadar datos
                while($row = $data->fetch_assoc()){
                    $zapatilla->set_id($row['id_zapatilla']);
                    $zapatilla->set_nombre($row['nombre']);
                    $zapatilla->set_color($row['color']);
                    $zapatilla->set_precio($row['precio']);
                    $zapatilla->set_descripcion($row['descripcion']);
                    $zapatilla->set_talle($row['talle']);
                    $zapatilla->set_img_path($row['img_path']);
                }
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) en consulta 'getZapatilla': " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error en consulta 'getZapatilla': " . $ex->getMessage());
        }
        // Devolver data
        return $zapatilla;
    }

    // Consulta que inserta una nueva zapatilla
    function insertZapa($newZapa)
    {
        try {
            // Armar query
            $sql = "INSERT INTO `zapatilla`(nombre, color, precio, descripcion, img_path, talle) 
            VALUES (?,?,?,?,?,?);";
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
            die("Error (SQL) al insertar nueva zapatilla: " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error al insertar nueva zapatilla: " . $sqlEx->getMessage());
        }
        // Devolver resultado
        return $flag;
    }

    // Consulta elimina una zapatilla
    function deleteZapatilla($id)
    {
        try {
            // Armar query
            $queryDelete = "DELETE FROM `zapatilla` WHERE id_zapatilla = ?;";
            // Armar statement
            $stmt = $this->connect()->prepare($queryDelete);
            $stmt->bind_param("i", $id);
            // Ejecutar delete
            $flag = $stmt->execute();
            // Cerrar prep
            $stmt->close();
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) al eliminar una zapatilla: " . $sqlEx->getMessage()); 
        } catch (Exception $ex) {
            die("Error (SQL) al eliminar una zapatilla: " . $sqlEx->getMessage()); 
        }
        // Devolver resultado
        return $flag;
    }

    function validarExistenciaDeZapatilla($id)
    {
        $idValido = false;

        try {
            // Armar query
            $query = "SELECT id_zapatilla FROM `zapatilla` WHERE id_zapatilla = '$id';";
            // Armar statement
            $data = $this->connect()->query($query);
            // Validar devolucion
            if($data->num_rows > 0) 
                $idValido = true;
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) validar existentcia de zapatilla en DB: " . $sqlEx->getMessage()); 
        } catch (Exception $ex) {
            die("Error validar existentcia de zapatilla en DB: " . $sqlEx->getMessage()); 
        }
        // Devolver resultado
        return $idValido;
    }
}

?>