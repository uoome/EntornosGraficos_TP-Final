<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include(DAO_PATH."db.php");
include(DAO_PATH."dao.usuario.php");

// Iniciar/Retomar sesion
session_start();
// Fetch usuario
$usuarioActual = new Usuario();
if(isset($_SESSION['usuarioActual'])) $usuarioActual = $_SESSION['usuarioActual'];
else $usuarioActual = null;

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
    // Si hay usuario loggeado y  es Admin
    if (
        $usuarioActual != null && 
        $usuarioActual->get_tipo() == UserTypeEnum::Administrator
    ) {
    ?>

    <div class="container mt-3">
        <div class="card bg-light">
            <!-- Card Header -->
            <div class="card-header">
                <i class="fas fa-table"></i>
                Gestion de Usuarios
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
                                <th scope="col">Apellido</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Email</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Tipo</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Traer usuarios
                        $usuarioService = new UsuarioService();
                        $data = $usuarioService->getUsuarios();
                        // Si hay datos
                        if ($data != null) {
                            foreach($data as $user) {
                        ?>
                            <tr>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="Forms/admin-modificar-usuario.php?id=<?= $user["id_usuario"] ?>" class="btn btn-info" title="Modificar Usuario">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="Forms/admin.delete.usuario.php?id=<?= $user["id_usuario"] ?>" class="btn btn-danger" title="Eliminar Usuario">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                                <td><?= $user["id_usuario"] ?></td>
                                <td><?= $user["nombre"] ?></td>
                                <td><?= $user["apellido"] ?></td>
                                <td><?= $user["username"] ?></td>
                                <td><?= $user["email"] ?></td>
                                <td><?= $user["telefono"] ?></td>
                                <td>
                                    <?php
                                    switch ($user["tipo_usuario"]) {
                                        case UserTypeEnum::Administrator:
                                            echo "Administrador";
                                            break;
                                        case UserTypeEnum::Client;
                                            echo "Cliente";
                                            break;
                                        default:
                                            echo "-";
                                            break;
                                    }
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
                </div>
            </div>        
            <!-- Card-Footer -->
            <div class="card-footer">
                <a 
                    href="registro.administrador.php" 
                    class="btn btn-primary" 
                    title="Crear Usuario"
                >
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Mensaje de autorizacion -->
    <?php } else { ?>
    <div class="container mt-3">
        <div class="alert alert-danger text-center" role="alert">
            No esta autorizado a estar en esta seccion!
        </div>
    </div>
    <?php } ?>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH."scripts.php") ?>

</body>

</html>