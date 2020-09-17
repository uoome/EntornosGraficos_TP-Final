<?php 
// Archivo que contiene consultas de DB dedicadas a la tabla `usuario`
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH . "db.php");
include_once(DATA_PATH . "data.usuario.php");

class UsuarioService extends ConnectionDB {

    /* CONSULTAS */

    function login($user, $pass) {
        $usuarioLogueado = null;

        $query = "SELECT * FROM usuario WHERE username = '$user' AND password = '$pass' ;";

        try {
            $data = $this->connect()->query($query);

            if ($data->num_rows > 0) {
                while ($row = $data->fetch_assoc()) {
                    $usuarioLogueado = new Usuario();
                    $usuarioLogueado->set_id($row["id_usuario"]);
                    $usuarioLogueado->set_nombre($row["nombre"]);
                    $usuarioLogueado->set_apellido($row["apellido"]);
                    $usuarioLogueado->set_username($row["username"]);
                    $usuarioLogueado->set_tipo($row["tipo_usuario"]);
                    // Se omite password
                }
            }
        } catch (mysqli_sql_exception $sqlEx) {
            echo "Error en consulta 'getZapatillas': " . $sqlEx->getMessage();
        } catch (Exception $ex) {
            echo "Error en consulta 'getZapatillas': " . $ex->getMessage();
        }
        // Agregar usuario a la session
        return $usuarioLogueado;
    }

}
