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

    // Consulta que retorna un array de usuarios
    function getUsuarios()
    {
        $usuarios = null;
        $query = "SELECT * FROM `usuario`;";

        try {
            // Ejecutar query
            $data = $this->connect()->query($query);
            $numRows = $data->num_rows;
            // Si hay datos devueltos
            if ($numRows > 0) {
                // Fetch data
                while ($row = $data->fetch_assoc()) {
                    $usuarios[] = $row;
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
        return $usuarios;
    }

    // Consulta que inserta una nueva zapatilla
    function insertAdmin($admin)
    {
        try {
            // Armar query
            $sql = "INSERT INTO `usuario`(nombre, apellido, username, password, email, telefono, tipo_usuario) 
            VALUES (?,?,?,?,?,?,?);";
            // Armar statement
            $stmt = $this->connect()->prepare($sql);
            $stmt->bind_param(
                "sssssii",
                $admin->get_nombre(),
                $admin->get_apellido(),
                $admin->get_username(),
                $admin->get_password(),
                $admin->get_email(),
                $admin->get_telefono(),
                $admin->get_tipo()
            );
            // Ejecutar y guardar resultado
            $flag = $stmt->execute();
            // Cerrar prep
            $stmt->close();
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            echo "Error al insertar nuevo administrador: " . $sqlEx->getMessage();
        } catch (Exception $ex) {
            echo "Error al insertar nuev0 administrador: " . $ex->getMessage();
        }
        // Devolver resultado
        return $flag;
    }

}
