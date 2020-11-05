<?php
// inicializar rutas
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');

if(isset($_GET['id'])) { 
    // Fetch ID
    $idCompra = $_GET['id'];
    // Iniciar/Retomar sesion
    session_start();
    // Fetch usuario sesion
    if (isset($_SESSION['usuarioActual'])) $usuarioActual = $_SESSION['usuarioActual'];
    else {
        // Mensaje error
        $_SESSION['mensaje'] = "No esta autorizado a estar en esta seccion.";
        $_SESSION['tipo_mensaje'] = "danger";
    };
} else {
    // Mensaje error
    $_SESSION['mensaje'] = "Error de request.";
    $_SESSION['tipo_mensaje'] = "danger";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Cabeceras -->
    <?php include(INCLUDES_PATH."styles.links.php") ?>
    
    <title>Confirmacion de Compra | Tibbonzapas</title>
</head>

<body>
    <!-- Si hay ID, mostrar contenido -->
    <?php if(isset($idCompra) && isset($usuarioActual)) { ?>
    <div class="container-fluid mt-4">
        <div class="container">
            <div class="jumbotron">
                <h1 class="display-4">Confirmacion de Compra!</h1>
                <p class="lead">Su orden de compra <strong>Nro: <?= $idCompra ?></strong> se ha completado con exito.</p>
                <hr class="my-4">
                <p>Se ha enviado un email a la direccion de correo electronico indicada en la confirmacion de compra.</p>
                <a class="btn btn-primary" href="tienda.php" role="button">Tienda</a>
            </div>
        </div>
        <!-- Footer -->
        <?php include(INCLUDES_PATH."footer.html") ?>
    </div>
    <?php } else { ?>
    <!-- Mensaje alerta -->
    <?php if (isset($_SESSION['mensaje'])) { ?>
        <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?>" role="alert">
            <?= $_SESSION['mensaje'] ?>
        </div>
        <?php } ?>
    <?php } ?>

    <!-- Limpiar mensajes de sesion -->
    <?php 
        if(isset($_SESSION['mensaje'])) unset($_SESSION['mensaje']); 
        if(isset($_SESSION['tipo_mensaje'])) unset($_SESSION['tipo_mensaje']);        
    ?>
    
    <!-- Scripts -->
    <?php include(INCLUDES_PATH."scripts.php") ?>
</body>

</html>