<?php
// Nuevo
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH . "db.php");
include_once(DAO_PATH . "dao.usuario.php");
include_once(INCLUDES_PATH . "validacion.forms.admin.php");

// Iniciar sesion
session_start();

// Validar el post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Traer y limpiar datos
    $username = test_input($_POST["username"]);
    $password = test_input($_POST["password"]);
    // Enviar datos
    $usuarioService = new UsuarioService();
    $usuarioLogueado = $usuarioService->login($username, $password);
    // Setear usuario
    if ($usuarioLogueado != null) {
        $_SESSION['usuarioActual'] = $usuarioLogueado;
        // Redirect index.php
        header("Location: index.php");
    } else {
        // Mensaje error
        $_SESSION['mensaje'] = "Credenciales incorrectas";
        $_SESSION['tipo_mensaje'] = "danger";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Cabeceras -->
    <?php include(INCLUDES_PATH."styles.links.php") ?>

    <title>LogIn | Tibbonzapas</title>
</head>

<body>
    <!-- NavBar -->
    <?php include(INCLUDES_PATH . "navbar.php") ?>

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
                    <a class="btn btn-secondary btn-block" href="registro.cliente.php">
                        Registrarse
                    </a>
                </form>
            </div>
        </div>
    </div>

    <!-- Limpiar mensajes -->
    <?php if (isset($_SESSION['mensaje'])) unset($_SESSION['mensaje']); ?>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH . "scripts.php") ?>

</body>

</html>