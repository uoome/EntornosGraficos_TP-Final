<?php
// Nuevo
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH . "db.php");
include_once(DAO_PATH . "dao.usuario.php");

function test_input($data)
{ 
    $data = trim($data); // Quitar espacios
    $data = stripslashes($data); // Quitar '\'
    $data = htmlspecialchars($data); // Formatear caracteres especiales
    return $data;
}

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
        $_SESSION['mensaje'] = "Credenciales incorrectas.";
        $_SESSION['tipo_mensaje'] = "danger";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="generator" content="Jekyll v4.1.1" />
    <!-- Cabeceras -->
    <?php include(INCLUDES_PATH . "styles.links.php") ?>

    <title>LogIn | Tibbonzapas</title>

    <!-- <link
        rel="canonical"
        href="https://getbootstrap.com/docs/4.5/examples/sign-in/"
    /> -->

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="CSS/signin.css" rel="stylesheet" />
</head>

<body class="text-center">
    <!-- Form signIn -->
    <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <img class="mb-4" src="IMG/zapa.icon.jpg" alt="" width="72" height="72" />
        <h1 class="h3 mb-3 font-weight-normal">Inicie Sesion</h1>
        <!-- Mensaje alerta -->
        <?php if (isset($_SESSION['mensaje'])) { ?>
            <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?>" role="alert">
                <?= $_SESSION['mensaje'] ?>
            </div>
        <?php } ?>
        <div class="form-group">
            <label for="inputUsername" class="sr-only">Username</label>
            <input id="inputUsername" name="username" class="form-control" required placeholder="Usuario" type="text" autofocus />
        </div>
        <div class="form-group">
            <label for="inputPassword" class="sr-only">Contraseña</label>
            <input id="inputPassword" name="password" class="form-control" required placeholder="Contraseña" type="password" />
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">
            Sign in
        </button>
        <a class="btn btn-secondary btn-block" href="registro.cliente.php">
            Registrarse
        </a>
        <p class="mt-5 mb-3 text-muted">&copy; Gomez Nicolas - 2020</p>
    </form>

    <!-- Limpiar mensajes -->
    <?php 
    if (isset($_SESSION['mensaje'])) unset($_SESSION['mensaje']); 
    if (isset($_SESSION['tipo_mensaje'])) unset($_SESSION['tipo_mensaje']); 
    ?>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH . "scripts.php") ?>

</body>

</html>