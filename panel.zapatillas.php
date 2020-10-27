<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'EntornosGraficos_TP-Final/rutas.php');
include(DATA_PATH."data.usuario.php");
include(DAO_PATH."dao.zapatilla.php");

// Iniciar sesion
session_start();
// Fetch usuario
$usuarioActual = new Usuario();
if(isset($_SESSION['usuarioActual'])) $usuarioActual = $_SESSION['usuarioActual'];
else $usuarioActual = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Cabeceras -->
    <?php include(INCLUDES_PATH."styles.links.php") ?>

    <title>Panel de Zapatillas | Tibbonzapas</title>
</head>

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
                                <th scope="col">Precio</th>
                                <th scope="col">Descripcion</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Imagen</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Traer zapatillas
                            $zapaService = new ZapatillaDataService();
                            $data = $zapaService->getZapatillas();
                            // Si hay datos
                            if ($data != null) {
                                foreach($data as $zapa) {
                            ?>
                                <tr>
                                    <td class="text-center">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a 
                                                href="modificar.zapa.php?id=<?= $zapa["id_zapatilla"] ?>" 
                                                class="btn btn-info" 
                                                title="Modificar Zapatilla"
                                            >
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a 
                                                href="Forms/admin.delete.zapatilla.php?id=<?= $zapa["id_zapatilla"] ?>" 
                                                class="btn btn-danger" 
                                                title="Eliminar Zapatilla"
                                            >
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                    <td><?= $zapa["id_zapatilla"] ?></td>
                                    <td><?= $zapa["nombre"] ?></td>                            
                                    <td>
                                        <?php
                                        if(empty($zapa["precio"])) echo "0.0";
                                        else echo $zapa["precio"];
                                        ?>
                                    </td>                                    
                                    <td>
                                        <?php
                                        if(empty($zapa["descripcion"])) echo "Sin Descrip";
                                        else echo $zapa["descripcion"];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if(empty($zapa["tipo"])) echo "Unisex";
                                        else echo $zapa["tipo"];
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if(empty($zapa["img_path"])) echo "NO";
                                        else echo "SI";
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
                    <?php 
                    unset($_SESSION['mensaje']); 
                    unset($_SESSION['tipo_mensaje']); 
                    ?>
                </div>
            </div>
            <!-- Card-Footer -->
            <div class="card-footer">
                <a 
                    href="registro.zapatilla.php"
                    class="btn btn-primary"
                    title="Crear Zapatilla"
                >
                    <i class="fas fa-plus"></i>            
                </a>
            </div>
        </div>
    </div>

    <?php } else { ?>
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