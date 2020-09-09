<?php 
// Anterior
// include("includes/db.php");
// Nuevo
include_once($_SERVER['DOCUMENT_ROOT'].'EntornosGraficos_TP-Final/rutas.php');
include(INCLUDES_PATH."db.php");
?>

<!DOCTYPE html>
<html lang="en">

<!-- Cabeceras -->
<?php include(INCLUDES_PATH."header.php"); ?>

<body>
    <!-- NavBar -->
    <?php include(INCLUDES_PATH."navbar.php"); ?>

    <!-- Content | Solo visible para usuario administrador -->
    <?php
    // Si hay usuario loggeado
    if (isset($_SESSION['usuarioActual'])) {
        $usuarioActual = $_SESSION['usuarioActual'];
        // Si el usuario es administrador
        if ($usuarioActual->get_tipo() == UserTypeEnum::Administrator) {

    ?>
    <div class="container mt-3">
        <div class="card bg-light">
            <!-- Card Header -->
            <div class="card-header">
                <i class="fas fa-table"></i>
                Gestion de Zapatillas
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <!-- Mensaje alerta -->
                <?php if (isset($_SESSION['mensaje'])) { ?>
                    <div class="alert alert-<?= $_SESSION['tipo_mensaje'] ?> alert-dismissible fade show" role="alert">
                        <?= $_SESSION['mensaje'] ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php } ?>
                <!-- Tabla -->
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Acciones</th>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Color</th>
                                <th scope="col">Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM zapatilla;";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                <tr>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a 
                                                href="Forms/admin-modificar-zapatilla.php?id=<?= $row["id_zapatilla"] ?>" 
                                                class="btn btn-info" 
                                                title="Modificar Zapatilla"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a 
                                                href="Forms/admin-delete-zapatilla.php?id=<?= $row["id_zapatilla"] ?>" 
                                                class="btn btn-danger" 
                                                title="Eliminar Zapatilla"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td><?= $row["id_zapatilla"] ?></td>
                                    <td><?= $row["nombre"] ?></td>
                                    <td>
                                        <?php
                                        if(empty($row['color'])) echo "-";
                                        else echo $row["color"];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if(empty($row["precio"])) echo "0.0";
                                        else echo $row["precio"];
                                        ?>
                                    </td>
                                </tr>
                            <?php } } else { ?>
                            
                            <div class="alert alert-warning text-center" role="alert">
                                No se encontraron datos.
                            </div>
                            <?php } ?>

                        </tbody>
                    </table>
                    <!-- Limpiar mensajes de sesion -->
                    <?php unset($_SESSION['mensaje']); ?>
                </div>
            </div>
            <!-- Card-Footer -->
            <div class="card-footer">
                <a 
                    href="registro-zapatilla.php"
                    class="btn btn-primary"
                    title="Crear Zapatilla"
                >
                    <i class="fas fa-plus"></i>            
                </a>
            </div>
        </div>
    </div>

    <?php } } else { ?>
    <div class="container mt-3">
        <div class="alert alert-danger text-center" role="alert">
            No esta autorizado a estar en esta seccion!
        </div>
    </div>
    <?php } ?>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH."scripts.php"); ?>

</body>

</html>