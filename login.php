<?php include("includes/db.php") ?>

<!DOCTYPE html>
<html lang="en">

<!-- Cabeceras -->
<?php include("includes/header.php") ?>

<body>
    <!-- NavBar -->
    <?php include("includes/navbar.php") ?>

    <!-- Content -->
    <div class="container col-md-4 mt-5">
        <div class="card border-dark">
            <div class="card-header">
                <p class="h5 text-center">
                    <i class="fas fa-sign-in-alt"></i>
                    LogIn
                </p>
            </div>
            <div class="card-body">
                <!-- Formulario -->
                <form action="#" method="POST">
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

    <!-- Scripts -->
    <?php include("includes/scripts.php") ?>

</body>

</html>