<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH."db.php");
include_once(DATA_PATH."data.usuario.php"); // Necesario para que no crashee el navbar

// Iniciar/Retomar sesion
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Cabeceras -->
    <?php include(INCLUDES_PATH."styles.links.php") ?>

    <title>Contacto | Tibbonzapas</title>
</head>

<body>
    <!-- NavBar -->
    <?php include(INCLUDES_PATH."navbar.php") ?>

    <!-- Content -->
    <div class="container-fuild">

        <div class="container mt-2 shadow p-3 mb-5 bg-white rounded">
            <div class="card bg-light">
                <div class="card-header">
                    <img src="IMG/Tibbon_locacion.png" class="card-img-top mx-auto d-block" alt="Ubicación en mapa">
                </div>
                <div class="card-body">
                    <h5 class="card-title">Contactenos</h5>
                    <!-- Mensaje alerta -->
                    <?php if (isset($_SESSION['mensaje'])) { ?>
                        <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?>" role="alert">
                            <?= $_SESSION['mensaje'] ?>
                        </div>
                    <?php } ?>
                    <form action="Forms/manejo.contacto.php" method="POST">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="nombre_contacto" placeholder="Nombre" required autofocus />
                            </div>
                            <div class="form-group col-md-6">
                                <input type="email" class="form-control" name="email_contacto" placeholder="E-mail" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="coment_contacto" placeholder="Comentario" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" name="send_contacto" class="btn btn-success btn-block">
                                <i class="fas fa-envelope-square"></i>
                                Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Limpiar mensajes -->
        <?php if (isset($_SESSION['mensaje'])) unset($_SESSION['mensaje']); ?>

        <!-- Footer -->
        <?php include(INCLUDES_PATH."footer.html") ?>
    </div>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH."scripts.php") ?>

</body>

</html>