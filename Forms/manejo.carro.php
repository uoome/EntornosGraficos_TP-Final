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
// include services
include_once(DAO_PATH . "dao.carro.compra.php");
include_once(DAO_PATH . "dao.lineaCompra.php");
include_once(DAO_PATH . "dao.zapatilla.php");

$lineaCompraService = new LineaCompraService();
$carroCompraService = new CarroService();

$carro = new CarroCompra();

// Ver que haya REQUEST
if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    // Si es addToCart -> Generar linea de compra y agregarla al carro
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])) {
        $lineaCompra = new LineaCompra();
        // Fetch ID
        $productID = $_REQUEST['id'];
        $lineaCompra->set_idZapatilla($productID);
        // Acutalizar cantidad
        empty($_REQUEST['qty']) ? $lineaCompra->set_qty(1) : $lineaCompra->set_qty($_REQUEST['qty']);
        // Actualizar subtotal
        $item = $lineaCompra->get_zapatilla($productID); //Fetch Zapatilla
        if($item != null) {
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
        $qtyToUpdate = $_REQUEST['qty'];
        // die(var_dump($dataToUpdate));
        $updateItem = $carro->actualizarCarro($rowidToUpdate, $qtyToUpdate);
        echo $updateItem ? 'ok' : 'err';
        die;
    } elseif ($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])) {
        // Eliminar el item del carro
        $deleteItem = $carro->remover($_REQUEST['id']);
        // Setear mensaje de error si es necesario
        if(!$deleteItem) {
            $_SESSION['mensaje'] = "Error al eliminar item del carro de compra";
            $_SESSION['tipo_mensaje'] = "danger";
        }
        // Redirect
        header("Location: ../verCarro.php");
    } elseif ($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0 && !empty($_SESSION['sessCustomerID'])) {
        // insert order details into database
        // Modificar comportamiento, hacer dao
        // $insertOrder = $db->query("INSERT INTO orders (customer_id, total_price, created, modified) VALUES ('" . $_SESSION['sessCustomerID'] . "', '" . $cart->total() . "', '" . date("Y-m-d H:i:s") . "', '" . date("Y-m-d H:i:s") . "')");
        // Agregar funcionalidad de mail automatico
        if ($insertOrder) {
            $orderID = $db->insert_id;
            $sql = '';
            // get cart items
            $cartItems = $cart->contents();
            foreach ($cartItems as $item) {
                $sql .= "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('" . $orderID . "', '" . $item['id'] . "', '" . $item['qty'] . "');";
            }
            // insert order items into database
            $insertOrderItems = $db->multi_query($sql);

            if ($insertOrderItems) {
                $cart->destroy();
                header("Location: ../orderSuccess.php?id=$orderID");
            } else {
                header("Location: ../checkout.php");
            }
        } else {
            header("Location: ../checkout.php");
        }
    }
} else die("Bad request");

?>