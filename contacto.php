<?php include("includes/db.php") ?>

<!DOCTYPE html>
<html lang="en">

<!-- Cabeceras -->
<?php include("includes/header.php") ?>

<body>
    <!-- NavBar -->
    <?php include("includes/navbar.php") ?>

    <!-- Content -->
    <div class="container-fuild">

        <div class="container mt-2 shadow p-3 mb-5 bg-white rounded">
            <div class="card bg-light">
                <div class="card-header">
                    <img src="IMG/Tibbon_locacion.png" class="card-img-top mx-auto d-block" alt="Ubicación en mapa">
                </div>
                <div class="card-body">
                    <h5 class="card-title">Contactenos</h5>
                    <form action="" method="">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="nombre_contacto" placeholder="Nombre" required autofocus />
                            </div>
                            <div class="form-group col-md-6">
                                <input type="text" class="form-control" name="email_contacto" placeholder="E-mail" required />
                            </div>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name="coment_contacto" placeholder="Comentario" rows="5" required></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">
                                <i class="fas fa-envelope-square"></i>
                                Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <?php include("includes/footer.html") ?>
    </div>

    <!-- Scripts -->
    <?php include("includes/scripts.php") ?>

</body>

</html>