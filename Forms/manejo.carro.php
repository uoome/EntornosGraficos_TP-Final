<?php
/*
Clase que maneja la funcionalidad del carro de compra:
    Armar carro.
    Agregar item al carro.
    Eliminar item del carro.
    Aceptar compra y redireccionar al formulario de pagos.
*/

// inicializar rutas
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
// include classes
include_once(DAO_PATH . "db.php");
include_once(DATA_PATH . "data.carro.compra.php");
include_once(DATA_PATH . "data.lineaCompra.php");
include_once(DATA_PATH . "data.zapatilla.php");
include_once(DATA_PATH . "data.compra.php");
// include services
include_once(DAO_PATH . "dao.carro.compra.php");
include_once(DAO_PATH . "dao.lineaCompra.php");
include_once(DAO_PATH . "dao.zapatilla.php");
include_once(DAO_PATH . "dao.usuario.php");
include_once(DAO_PATH . "dao.compra.php");

$carro = new CarroCompra();

// Ver que haya REQUEST
if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    // Si es addToCart -> Generar linea de compra y agregarla al carro
    if ($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])) {
        $lineaCompra = new LineaCompra();
        // Fetch ID
        $productID = $_REQUEST['id'];
        $lineaCompra->set_idZapatilla($productID);
        // Acutalizar cantidad
        empty($_REQUEST['qty']) ? $lineaCompra->set_qty(1) : $lineaCompra->set_qty($_REQUEST['qty']);
        // Actualizar subtotal
        $item = $lineaCompra->get_zapatilla(); //Fetch Zapatilla
        if ($item != null) {
            $lineaCompra->set_subtotalLinea($item->get_precio() * $lineaCompra->get_qty());
            // Agregar al carro
            $insertValido = $carro->insertLinea($lineaCompra);
            // Redireccionar
            $redirectLoc = $insertValido ? '../verCarro.php' : '../tienda.php';
            // die($redirectLoc);
            header("Location: " . $redirectLoc);
        } else die("No existe el item");
    } elseif ($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])) {
        // Solo cantidad de un producto ya agregado
        $rowidToUpdate = $_REQUEST['id'];
        $qtyToUpdate = intval($_REQUEST['qty']);
        $updateItem = $carro->actualizarCarro($rowidToUpdate, $qtyToUpdate);
        echo $updateItem ? 'ok' : 'err';
        die;
    } elseif ($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])) {
        // Eliminar el item del carro
        $deleteItem = $carro->remover($_REQUEST['id']);
        // Setear mensaje de error si es necesario
        if (!$deleteItem) {
            $_SESSION['mensaje'] = "Error al eliminar item del carro de compra";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        // Redirect
        header("Location: ../verCarro.php");
    }
} elseif (isset($_POST['btnAddCarro'])) { // Ver si hay POST
    // Crear nueva linea
    $newLinea = new LineaCompra();
    // Fetch values
    if (isset($_POST['colorSelect'])) $newLinea->set_color($_POST['colorSelect']);
    if (isset($_POST['talleSelect']) && $_POST['talleSelect'] != 0) $newLinea->set_talle($_POST['talleSelect']);
    if (isset($_POST['inputCantidad']) && $_POST['inputCantidad'] != 0) $newLinea->set_qty($_POST['inputCantidad']);
    else $newLinea->set_qty(1);
    // if(isset($_POST['inputCantidad'])) $newLinea->set_qty($_POST['inputCantidad']);
    $newLinea->set_idZapatilla($_POST['idProd']);

    // Actualizar subtotal
    $itemLinea = $newLinea->get_zapatilla(); //Fetch Zapatilla
    if ($itemLinea != null) {
        $newLinea->set_subtotalLinea($itemLinea->get_precio() * $newLinea->get_qty());
        // Agregar al carro
        $insertValido = $carro->insertLinea($newLinea);
        // Redireccionar
        $redirectLoc = $insertValido ? '../verCarro.php' : '../tienda.php';
        // die($redirectLoc);
        header("Location: " . $redirectLoc);
    } else die("No existe el item");
} else die("Bad request");


?>