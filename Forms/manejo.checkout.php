<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/EntornosGraficos_TP-Final/rutas.php');
include_once(DAO_PATH."db.php");
// Data
include_once(DATA_PATH."data.usuario.php");
include_once(DATA_PATH."data.compra.php");
include_once(DATA_PATH."data.carro.compra.php");
include_once(DATA_PATH."data.lineaCompra.php");
include_once(DATA_PATH."data.tarjeta.php");
// Dao
include_once(DAO_PATH."dao.usuario.php");
include_once(DAO_PATH."dao.compra.php");
include_once(DAO_PATH."dao.carro.compra.php");
include_once(DAO_PATH."dao.lineaCompra.php");
include_once(DAO_PATH."dao.tarjeta.php");

// Si se quiere confirmar la compra
if (isset($_POST['confirmar_compra'])) {

    $flag = true;

    $carro = new CarroCompra();
    // Fetch datos Form
    $idUsuario = test_input($_POST['idUser']);

    $email = test_input($_POST['emailInput']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['emailErr'] = "Formato de mail incorrecto";
        $flag = false;
    }

    /* Validar 'retiro' o 'envio' */
    if (isset($_POST['retiroCheck'])) {
        // Si es 'envio' | unchecked
        if ($_POST['retiroCheck'] == 'off') {
            // Validar direccion de entrega
            if (!empty($_POST['address'])) {
                $direccion = stripslashes($_POST['address']); 
                $direccion = htmlspecialchars($direccion);
            } else {
                $_SESSION['addressErr'] = "La direccion de entrega es requerida si no se retira por local.";
                $flag = false;
            }
        } else $direccion = null; // si es 'retiro por local' | checked
    } else $flag = false;

    // Si hay telefono, validar solo numeros enteros
    if(!empty($_POST['telefono'])) {
        $telefono = test_input($_POST["telefono"]);
        if (!validarNroEntero($telefono)) {
            $_SESSION['telefErr'] = "El telefono debe contener unicamente digitos enteros.";
            $flag = false;
        }
    } else $telefono = null;

    $formaPago = $_POST['formaPago'];
    // Guardar datos tarjeta, si estan
    $nombreTarjeta = isset($_POST['cc-name']) ? test_input($_POST['cc-name']) : null;
    // Nro Tarjeta, solo entero
    if(isset($_POST['cc-number'])) {
        $nroTarjeta = test_input($_POST["cc-number"]);
        if (!validarNroEntero($nroTarjeta)) {
            $_SESSION['cc-numberErr'] = "El numero de tarjeta debe contener unicamente digitos enteros.";
            $flag = false;
        }
    } else $nroTarjeta = null;
    
    // CVV, solo entero
    if(isset($_POST['cc-cvv'])) {
        $cvv = test_input($_POST["cc-cvv"]);
        if (!validarNroEntero($cvv)) {
            $_SESSION['cc-cvvErr'] = "El codigo de seguridad debe contener unicamente digitos enteros.";
            $flag = false;
        }
    } else $cvv = null;
    
    $monthExp = isset($_POST['cc-month']) ? test_input($_POST['cc-month']) : null;
    $yearExp = isset($_POST['cc-year']) ? test_input($_POST['cc-year']) : null;
    $fechaExp = date("m/y", mktime(1, 1, 1, $monthExp, 1, $yearExp)); // Armar fecha

    // Si hay algun dato erroneo, volver al form
    if(!$flag) {
        header("Location: ../checkout.php");
        die("Corte redirect");
    } 

    $total = $carro->total();

    // Set datos Carro
    $carro->set_total_carro($total);
    $carro->set_idUsuario($idUsuario); 

    // Inicializar CarroCompra Service
    $carroCompraService = new CarroService();
    // Insertar Carro en DB
    $idCarro = $carroCompraService->insertCarro($carro);
    // Si inserto el carro
    if($idCarro != null) {
        // Inicializar LineaCompra Service
        $lineaCompraService = new LineaCompraService();
        // Traer lineas
        $lineas = $carro->getContenidoCarro();
        foreach($lineas as $l) {
            // Fetch idCarro
            $l->set_idCarro($idCarro);
            // Insertar
            $status = $lineaCompraService->insertLineaCompra($l);
            // Si falla alguna
            if(!$status) {
                $_SESSION['mensaje'] = "Error al registrar lineas de compra.";
                $_SESSION['tipo_mensaje'] = "danger";
                // Redirect para cortar loop
                header("Location: ../checkout.php");
            };
        }

        // Si el pago es con tarjeta, cargar tarjeta
        if($formaPago != 1) {
            // Inicializar servicio tarjeta
            $tarjetaService = new TarjetaService();
            $tarjeta = new TarjetaCredito();
            $tarjeta->set_idUsuario($idUsuario);
            $tarjeta->set_nombreTarjeta($nombreTarjeta);
            $tarjeta->set_nroTarjeta($nroTarjeta);
            $tarjeta->set_fechaVencimiento($fechaExp);
            $tarjeta->set_cvv($cvv);

            $idTarjeta = $tarjetaService->insertTarjeta($tarjeta);
        }

        // Inicializar Compra
        $compraService = new CompraService();
        $newCompra = new Compra();

        $newCompra->set_usuario($idUsuario);
        $newCompra->set_carro($idCarro);
        if(isset($idTarjeta)) $newCompra->set_tarjeta($idTarjeta);
        $newCompra->set_total($total);
        $newCompra->set_tipoPago($formaPago);
        $newCompra->set_direccionEntrega($direccion);

        // Insertar Compra
        $idCompra = $compraService->insertCompra($newCompra);

        // Si el insert fue correcto
        if($idCompra != null) {
            // Agregar funcionalidad de mail automatico
            $statusMail = enviarMail($carro, $newCompra, $idCompra);

            // Si fue todo ok
            if($statusMail) {
                // Destruir carro
                $carro ->destruirCarro();
                // Redirect a orderSuccess
                header("Location: ../orderSuccess.php?id=".$idCompra);
                die("Fix para ejecutar el redirect"); // Fix para el webhost
            } else {
                $_SESSION['mensaje'] = "Error al enviar comprobante de compra.";
                $_SESSION['tipo_mensaje'] = "warning";
                $_SESSION['confirmCompra'] = false;
            }
        } else {
            $_SESSION['mensaje'] = "Error al registrar su compra.";
            $_SESSION['tipo_mensaje'] = "danger";
            $_SESSION['confirmCompra'] = false;
        }        
    } else {
        $_SESSION['mensaje'] = "Error al registrar datos del carro de compra en DB.";
        $_SESSION['tipo_mensaje'] = "danger";
        $_SESSION['confirmCompra'] = false;
    }

    // Redirect al checkout si algo fue mal
    header("Location: ../checkout.php");
} 


/**
 * Metodo que envia mail automatico al cliente.
 * @param CarroCompra $cc
 * @param Compra $c
 * @param int $idCompra
 * @return bool $mailStatus
 */
function enviarMail(CarroCompra $cc, Compra $c, $idCompra) {
    //dirección del remitente 
    $clientID = $c->get_usuario();
    $usuarioService = new UsuarioService();
    $client = $usuarioService->getUser($clientID);
    // Armar mail
    // Si indico mail en el Input, usar ese mail. Sino, usar el mail predeterminado del ususario (el cargado en DB)
    if (isset($_POST['emailInput'])) {
        $to = "nicogomezwp@gmail.com," . $_POST['emailInput'];
    } else {
        $to = "nicogomezwp@gmail.com," . $client->get_email();
    }

    $subject = "Recibo de Compra | ID " . $idCompra;

    // Fetch detalle del carro
    $detalle = $cc->getContenidoCarro();

    // Armar cuerpo del mail en html
    $cuerpo = "
        <html> 
        <head> 
            <title>
                Recibo de Compra | ID <strong>". $idCompra ."</strong>
            </title> 
        </head> 
        <body> 
            <h1>Detalles de la compra: Nro.". $idCompra ."</h1> 
            <h5>Total: $ ". $c->get_total() ."</h5>
            <p>Fecha: " . date("Y-m-d h:i:sa") ."</p>
            <p>Direccion de entrega: " . $c->get_direccionEntrega() . "</p>
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
    $headers .= "From: nicogomezwp@gmail.com";

    $response = mail($to, $subject, $cuerpo, $headers);

    return $response;
}

/**
 * Funcion que quita espacios, '\' y caracteres especiales del valor del input ingresado
 * @param mixed $data
 * @return string $data
 */
function test_input($data)
{ 
    $data = trim($data); // Quitar espacios
    $data = stripslashes($data); // Quitar '\'
    $data = htmlspecialchars($data); // Formatear caracteres especiales
    return $data;
}

/**
 * Funcion que recibe un valor y determina si solo tiene numeros enteros.
 * Retorna TRUE si tiene solo enteros, FALSE caso contrario.
 * @param mixed $nro
 * @return bool $result
 */
function validarNroEntero($nro) {
    $regexEnteros = "/^\d+$/"; // regex que valida solo numeros enteros
    $pregMatchValue = preg_match($regexEnteros, $nro);

    // Si no es 1 -> No es solo enteros
    $result = ($pregMatchValue != 1) ? FALSE : TRUE ;
    // die(var_dump($nro, $result));

    return $result;
}