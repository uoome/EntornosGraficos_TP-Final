<?php
// Archivo que contiene consultas de DB dedicadas a la tabla `usuario`
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH . "db.php");
include_once(DATA_PATH . "data.usuario.php");

class UsuarioService extends ConnectionDB
{

    /* CONSULTAS */

    // Consulta para manejo de login -> Agregar pass encriptadas
    /**
     * @param string $user
     * @param string $pass
     * @return null/Usuario
     */
    function login($user, $pass)
    {

        $usuarioLogueado = null;

        $query = "SELECT * FROM `usuario` WHERE username = '$user' AND password = '$pass' ;";

        try {
            $data = $this->connect()->query($query);

            if ($data->num_rows > 0) {
                while ($row = $data->fetch_assoc()) {
                    $usuarioLogueado = new Usuario();
                    $usuarioLogueado->set_id($row["id_usuario"]);
                    $usuarioLogueado->set_nombre($row["nombre"]);
                    $usuarioLogueado->set_apellido($row["apellido"]);
                    $usuarioLogueado->set_username($row["username"]);
                    $usuarioLogueado->set_email($row["email"]);
                    $usuarioLogueado->set_telefono($row["telefono"]);
                    $usuarioLogueado->set_tipo($row["tipo_usuario"]);
                    // Se omite password
                }
            }
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) al validar loguin: " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error al validar loguin: " . $sqlEx->getMessage());
        }
        // Agregar usuario a la session
        return $usuarioLogueado;
    }

    function getUser($id) {
        $usuario = null;

        try {
            // Armar query
            $query = "SELECT * FROM `usuario` WHERE id_usuario = '$id';";
            // Ejecutar query
            $data = $this->connect()->query($query);
            // Validar devolucion
            if ($data->num_rows > 0)
                $usuario = $data;
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) al traer datos del Usuario desde la DB: " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error al traer datos del Usuario desde la DB: " . $sqlEx->getMessage());
        }
        // Devolver resultado
        return $usuario;
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
            die("Error (SQL) en consulta 'getUsuarios': " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error en consulta 'getUsuarios': " . $ex->getMessage());
        }
        // Devolver data
        return $usuarios;
    }

    // Consulta que inserta usuario cliente
    function insertClient($client)
    {
        try {
            // Armar query
            $sql = "INSERT INTO `usuario`(nombre, apellido, username, password, email, tipo_usuario) 
            VALUES (?,?,?,?,?,?);";
            // Armar statement
            $stmt = $this->connect()->prepare($sql);
            $stmt->bind_param(
                "sssssi",
                $client->get_nombre(),
                $client->get_apellido(),
                $client->get_username(),
                $client->get_password(),
                $client->get_email(),
                $client->get_tipo()
            );
            // Ejecutar y guardar resultado
            $flag = $stmt->execute();
            // Cerrar prep
            $stmt->close();
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) al insertar nuevo cliente: " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error al insertar nuevo cliente: " . $ex->getMessage());
        }
        // Devolver resultado
        return $flag;
    }
    // Consulta que inserta usuario administrador
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
            die("Error (SQL) al insertar nuevo administrador: " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error al insertar nuevo administrador: " . $ex->getMessage());
        }
        // Devolver resultado
        return $flag;
    }

    // Consulta elimina una zapatilla
    function deleteUsuario($id)
    {
        try {
            // Armar query
            $queryDelete = "DELETE FROM `usuario` WHERE id_usuario = ?;";
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
            die("Error (SQL) al eliminar usuario: " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error al eliminar usuario: " . $sqlEx->getMessage());
        }
        // Devolver resultado
        return $flag;
    }

    function existeUsuario($id)
    {
        $idValido = false;

        try {
            // Armar query
            $query = "SELECT id_usuario FROM `usuario` WHERE id_usuario = '$id';";
            // Armar statement
            $data = $this->connect()->query($query);
            // Validar devolucion
            if ($data->num_rows > 0)
                $idValido = true;
            // Cerrar conexion
            $this->closeConnection();
        } catch (mysqli_sql_exception $sqlEx) {
            die("Error (SQL) al validar existencia de usuario en DB: " . $sqlEx->getMessage());
        } catch (Exception $ex) {
            die("Error al validar existencia de usuario en DB: " . $sqlEx->getMessage());
        }
        // Devolver resultado
        return $idValido;
    }
}

?>