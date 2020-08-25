<?php include("includes/db.php") ?>

<!DOCTYPE html>
<html lang="en">

<!-- Cabeceras -->
<?php include("includes/header.php") ?>

<body>
    <!-- NavBar -->
    <?php include("includes/navbar.php") ?>

    <!-- Formulario -->
    <div class="container mt-5">
        <div class="col justify-content-around">
            <div class="jumbotron">
                <h3 class="mb-3">
                    <i class="fas fa-user-plus"></i>
                    Complete datos de registro
                </h3>

                <form action="" method="POST">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputName">Nombre:</label>
                            <input type="text" class="form-control" name="inputName" placeholder="Nicolas" required autofocus />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputApellido">Apellido:</label>
                            <input type="text" class="form-control" name="inputApellido" placeholder="Gomez" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail">Email:</label>
                        <input type="email" class="form-control" name="inputEmail" placeholder="nicogomez@gmail.com" required />
                    </div>
                    <div class="form-group">
                        <label for="inputUser">Usuario:</label>
                        <input type="text" class="form-control" name="inputUser" placeholder="NicoTibbon" required />
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputPass">Contraseña:</label>
                            <input type="password" class="form-control" name="inputPass" placeholder="Contraseña" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputValidarPass">Validar contraseña:</label>
                            <input type="password" class="form-control" name="inputValidarPass" placeholder="Repetir contraseña" required />
                        </div>
                    </div>
                    <div class="form-group col">
                        <button type="submit" name="btnRegistro" class="btn btn-success btn-block">
                            <i class="far fa-check-circle"></i>
                            Registrarse
                        </button>
                    </div>
                    <div class="form-group col">
                        <button type="reset" class="btn btn-primary btn-block">
                            <i class="fas fa-eraser"></i>
                            Borrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <?php include("includes/scripts.php") ?>

</body>

</html>