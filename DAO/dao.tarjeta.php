<?php
// Archivo que contiene consultas de DB dedicadas a la tabla `zapatillas`
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH . "db.php");
include_once(DATA_PATH . "data.tarjeta.php");

class TarjetaService extends ConnectionDB
{
    /**
     * Metodo que guarda los datos de una tarjeta de credito
     * @param TarjetaCredito $tarjetaToAdd
     * @return null|int $idTarjeta
     */
    function insertTarjeta(TarjetaCredito $tarjetaToAdd) {
        $idTarjeta = null;

        try {
            // Armar query
            $sql = "INSERT INTO `tarjeta_credito` (`nombre_tarjeta`, `nro_tarjeta`, `fecha_vencimiento`, `cvv`, `id_usuario`) 
                VALUES (?,?,?,?,?);";
            // Armar statement
            $stmt = $this->connect()->prepare($sql);
            $stmt->bind_param(
                "sisii",
                $tarjetaToAdd->get_nombreTarjeta(),
                $tarjetaToAdd->get_nroTarjeta(),
                $tarjetaToAdd->get_fechaVencimiento(),
                $tarjetaToAdd->get_cvv(),
                $tarjetaToAdd->get_idUsuario()
            );
            // Ejecutar y guardar resultado
            $rta = $stmt->execute();
            if($rta) $idTarjeta = $stmt->insert_id;
            // Cerrar prep
            $stmt->close();
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) al insertar datos de tarjeta en DB: " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error al insertar datos de tarjeta en DB: " . $sqlEx->getMessage());
        }
        // Devolver resultado
        return $idTarjeta; 
    }

}

?>