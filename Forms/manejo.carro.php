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
include_once(DAO_PATH . "dao.usuario.php");

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
        $qtyToUpdate = $_REQUEST['qty'];
        // die(var_dump($dataToUpdate));
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
} elseif (isset($_POST['confirmar_compra'])) {
    // Setear forma de pago
    isset($_POST['formaPagoSelect']) ? $carro->set_formaPago($_POST['formaPagoSelect']) : $carro->set_formaPago(null);
    // Setear total y usuario
    $carro->set_total_carro($carro->total());
    $carro->set_idUsuario($_SESSION['usuarioActual']->get_id()); 

    // Inicializar servicios
    $lineaCompraService = new LineaCompraService();
    $carroCompraService = new CarroService();
    // Insertar Carro en DB
    $idGen = $carroCompraService->insertCarro($carro);
    // die(var_dump($idGen));
    // Si inserto el carro
    if($idGen != null) {
        // Traer lineas
        $lineas = $carro->getContenidoCarro();
        foreach($lineas as $l) {
            // Fetch idCarro
            $l->set_idCarro($idGen);
            // Insertar
            $status = $lineaCompraService->insertLineaCompra($l);
            // echo "Status";
            // die(var_dump($status));
            // Si falla alguna
            if(!$status) {
                $_SESSION['mensaje'] = "Error al registrar lineas de compra.";
                $_SESSION['tipo_mensaje'] = "danger";
                // Redirect para cortar loop
                header("Location: ../orderSuccess.php");
            };
        }

        // Agregar funcionalidad de mail automatico
        $statusMail = enviarMail($carro, $idGen);

        // Si fue todo ok
        if($statusMail) {
            $_SESSION['mensaje'] = "Su compra se ha registrado con exito. 
                Revise su correo para ver la factura. 
                El ID de su compra es: ".$idGen;
            $_SESSION['tipo_mensaje'] = "success";
            $_SESSION['confirmCompra'] = true;
            // Destruir carro
            $carro ->destruirCarro();
        } else {
            $_SESSION['mensaje'] = "Error al registrar su compra.";
            $_SESSION['tipo_mensaje'] = "danger";
            $_SESSION['confirmCompra'] = false;
        }
    } else {
        $_SESSION['mensaje'] = "Error al registrar su compra.";
        $_SESSION['tipo_mensaje'] = "danger";
        $_SESSION['confirmCompra'] = false;
    }

    // Redirect
    header("Location: ../orderSuccess.php");
} else die("Bad request");


/**
 * Metodo que envia mail automatico al cliente.
 * @param CarroCompra $c
 * @param int $idCompra
 * @return bool $mailStatus
 */
function enviarMail(CarroCompra $c, $idCompra) {
    // Armar mail
    $to = "nicogomezwp@gmail.com";
    $subject = "Recibo de Compra | ID " . $idCompra;

    // Fetch detalle del carro
    $detalle = $c->getContenidoCarro();

    // Armar cuerpo del mail en html
    $cuerpo = "
        <html> 
        <head> 
            <title>Recibo de Compra | ID ". $idCompra ."</title> 
        </head> 
        <body> 
            <h1>Detalles de la compra: Nro.". $idCompra ."</h1> 
            <5>Total: $". $c->get_total_carro() ."</5>
            <p>Productos: </p>
            <table>
                <thead>
                    <tr>
                        <th scope='col'>Producto</th>
                        <th scope='col'>Precio</th>
                        <th scope='col'>Cantidad</th>
                        <th scope='col'>Subtotal</th>
                    </tr>
                </thead>
                <tbody>";

        // Fetch detalles de lineas de compra
        foreach($detalle as $l) {
            // Fetch datos de cada linea
            $z = $l->get_zapatilla();
            $cuerpo .= "
            <tr>
                <td>" . $z->get_nombre() . "</td>
                <td>" . $z->get_precio() . "</td>
                <td>" . $l->get_qty() . "</td>
                <td>" . $l->get_subtotalLinea() . "</td>
            </tr>";
        }
        
        $cuerpo .= "
                </tbody>
            </table>

            <p>Este es un mensaje generado automaticamente.</p>
            <p>Por favor no responda este mensaje.</p>
        </body> 
        </html>"; 

    

    //para el envío en formato HTML 
    $headers = "MIME-Version: 1.0\r\n"; 
    $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

    //dirección del remitente 
    $clientID = $c->get_idUsuario();
    $usuarioService = new UsuarioService();
    $client = $usuarioService->getUser($clientID);
    $headers .= "From: " . $client->get_email();

    //ruta del mensaje desde origen a destino 
    // $headers .= "Return-path: holahola@desarrolloweb.com\r\n";

    $response = mail($to, $subject, $cuerpo, $headers);

    return $response;
}

?>