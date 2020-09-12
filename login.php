<?php
// Anterior
// include("includes/db.php");
// include_once("includes/validacion-forms-admin.php");

// Nuevo
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include_once(DB_PATH."db.php");
include_once(INCLUDES_PATH."validacion-forms-admin.php");

// Validar el post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Traer y limpiar datos
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);

    // Armar query
    $query = "SELECT * FROM usuario WHERE username = '$username' AND password = '$password' ;";

    $data = $conn->query($query);
    if ($data->num_rows > 0) {
        while ($row = $data->fetch_assoc()) {
            $usuario = new Usuario();
            $usuario->set_id($row["id_usuario"]);
            $usuario->set_nombre($row["nombre"]);
            $usuario->set_apellido($row["apellido"]);
            $usuario->set_username($row["username"]);
            $usuario->set_tipo($row["tipo_usuario"]);
            // Se omite password

            // Agregar usuario a la session
            $_SESSION["usuarioActual"] = $usuario;

            //Redireccionar al inicio
            header("Location: inicio.php");
        }
    } else {
        // Mensaje error
        $_SESSION['mensaje'] = "Credenciales incorrectas";
        $_SESSION['tipo_mensaje'] = "danger";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<!-- Cabeceras -->
<?php include("includes/header.php") ?>

<body>
    <!-- NavBar -->
    <?php include("includes/navbar.php") ?>

    <!-- Content -->
    <div class="container col-md-4 mt-5">
        <!-- Mensaje alerta -->
        <?php if (isset($_SESSION['mensaje'])) { ?>
            <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?>" role="alert">
                <?= $_SESSION['mensaje'] ?>
            </div>
        <?php } ?>
        <div class="card border-dark">
            <div class="card-header">
                <p class="h5 text-center">
                    <i class="fas fa-sign-in-alt"></i>
                    LogIn
                </p>
            </div>
            <div class="card-body">
                <!-- Formulario | Se maneja aca mismo -->
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                    <div class="form-group">
                        <label for="inputUsername" class="sr-only">Username</label>
                        <input id="inputUsername" name="username" class="form-control" required placeholder="Usuario" type="text" autofocus />
                    </div>
                    <div class="form-group">
                        <label for="inputPassword" class="sr-only">Contraseña</label>
                        <input id="inputPassword" name="password" class="form-control" required placeholder="Contraseña" type="password" />
                    </div>
                    <button class="btn btn-info btn-block" type="submit">
                        Log in
                    </button>
                    <a class="btn btn-secondary btn-block" href="registro-cliente.php">
                        Registrarse
                    </a>
                </form>
            </div>
        </div>
    </div>

    <!-- Limpiar mensajes -->
    <?php unset($_SESSION['mensaje']); ?>

    <!-- Scripts -->
    <?php include("includes/scripts.php") ?>

</body>

</html>