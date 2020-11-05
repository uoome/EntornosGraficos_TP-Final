<?php
/*
El cliente es redirigido a esta página para confirmar su compra.
*/

// inicializar rutas
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
// initialize shopping cart class
include_once(DATA_PATH . "data.usuario.php");
include_once(DATA_PATH . "data.carro.compra.php");
include_once(DATA_PATH . "data.lineaCompra.php");

// if (!isset($_REQUEST['id'])) {
//     header("Location: index.php");
// }
// Iniciar/Retomar sesion
// session_start();

// Fetch usuario
if (isset($_SESSION['usuarioActual'])) $usuarioActual = $_SESSION['usuarioActual'];
else $usuarioActual = null;
// Fetch carro
$carro = new CarroCompra();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Botstrap CSS -->
    <link rel="stylesheet" href="CSS/Bootstrap/css/bootstrap.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="CSS/fontawesome-free-5.14.0-web/css/all.css" />
    <!-- Icon -->
    <link rel="shortcut icon" href="IMG/favicon.ico" type="image/x-icon">
    <!-- Custom CSS -->
    <style>
        .container {
            width: 100%;
            padding: 50px;
        }
    </style>

    <title>Confirmacion de Compra | Tibbonzapas</title>

</head>

<body>
    <!-- Contenido solo visible para usuarios logueados -->
    <?php if ($usuarioActual != null) { ?>
        <div class="container">
            <div class="jumbotron">
                <h1>Confirmar Compra</h1>
                <p>Seleccione la forma de pago para completar la compra.</p>
                <p>Una vez finalizado el proceso, recibira un mail con la confirmacion y los datos de su compra.</p>
                
                <!-- Back to store si la compra fue exito -->
                <?php if (isset($_SESSION['confirmCompra']) && $_SESSION['confirmCompra'] == true) { ?>
                    <a href="tienda.php" class="form-control btn btn-info btn-block">
                        Volver a la tienda
                    </a>
                <?php } else { ?>
                    <!-- Formulario -->
                    <form action="Forms/manejo.carro.php" class="form-inline" method="POST">
                        <!-- Total -->
                        <label class="my-1 mr-2" for="totalCarro">
                            Total: <strong> $
                                            <?php echo number_format($carro->total(), 2, ',', '.'); ?>
                                    </strong>
                        </label>
                        <!-- Forma Pago -->
                        <label class="sr-only" for="formaPagoSelect">Forma Pago</label>
                        <select class="form-control my-1 mr-2" id="formaPagoSelect" name="formaPagoSelect" require>
                            <option selected>Elija...</option>
                            <option value="1">Efectivo</option>
                            <option value="2">Debito</option>
                            <option value="3">Credito</option>
                        </select>

                        <button type="submit" name="confirmar_compra" class="form-control btn btn-primary my-1 mr-2">
                            Confirmar
                        </button>
                    </form>
                <?php } ?>
                <!-- Mensaje alerta -->
                <?php if (isset($_SESSION['mensaje'])) { ?>
                    <div class="mt-2 alert alert-<?= $_SESSION['tipo_mensaje'] ?>" role="alert">
                        <?= $_SESSION['mensaje'] ?>
                    </div>
                    <a href="tienda.php" class="form-control btn btn-info btn-block">
                        Volver a la tienda
                    </a>
                <?php } ?>
            </div>
        </div>
        <!-- Limpiar mensajes de sesion -->
        <?php
        unset($_SESSION['mensaje']);
        unset($_SESSION['tipo_mensaje']);
        unset($_SESSION['confirmCompra']);
        ?>

        <!-- Mensaje de autorizacion -->
    <?php } else { ?>
        <div class="container mt-3">
            <div class="alert alert-danger text-center" role="alert">
                No esta autorizado a estar en esta seccion!
            </div>
        </div>
    <?php } ?>



    <!-- Scripts -->
    <?php include(INCLUDES_PATH . "scripts.php") ?>
</body>

</html>