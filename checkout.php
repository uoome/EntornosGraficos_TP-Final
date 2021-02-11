<?php
/*
En este página, se registra el ID del cliente en la sesión y se obtienen los respectivos datos del cliente de la tabla customers. 
Una vez que el cliente decide realizar el pedido, llamamos al archivo cartAction.php con la solicitud “placeOrder”.
*/

// inicializar rutas
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
// initialize shopping cart class
include_once(DATA_PATH . "data.usuario.php");
include_once(DATA_PATH . "data.lineaCompra.php");
include_once(DATA_PATH . "data.carro.compra.php");
include_once(DAO_PATH . "dao.usuario.php");

// Fetch usuario
if (isset($_SESSION['usuarioActual'])) $usuarioActual = $_SESSION['usuarioActual'];
else $usuarioActual = null;

// Fetch carro 
$carro = new CarroCompra();
// redirect to home if cart is empty
if ($carro->total_items() <= 0) header("Location: index.php");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Styles -->
    <?php include(INCLUDES_PATH."styles.links.php") ?>

    <!-- Custom CSS -->
    <style>
        .right {
            float: right;
        }

        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
            font-size: 3.5rem;
            }
        }

        .container {
        max-width: 960px;
        }

        .lh-condensed { line-height: 1.25; }
    </style>

    <script>
        // Funcion para manejar pago en 'efectivo' o 'tarjeta'
        function enableTarjeta() {
            var efectivo = document.getElementById('efectivo');
            var nombreTarjeta = document.getElementById('cc-name');
            var nroTarjeta = document.getElementById('cc-number');
            var cvv = document.getElementById('cc-cvv');
            var mesExp = document.getElementById('cc-month');
            var anioExp = document.getElementById('cc-year');
            

            if(efectivo.checked) {
                console.log("Deshabilitar carga de tarjeta");
                nombreTarjeta.disabled = true;
                nroTarjeta.disabled = true;
                cvv.disabled = true;
                mesExp.disabled = true;
                anioExp.disabled = true;
            } else {
                console.log("Habilitar carga tarjeta");
                nombreTarjeta.disabled = false;
                nroTarjeta.disabled = false;
                cvv.disabled = false;
                mesExp.disabled = false;
                anioExp.disabled = false;
            }
        }
        // Funcion para manejar 'envio' o 'retiro por local'
        function enableRetiro(checkbox) {
            var retiro = document.getElementById('retiroCheck');
            var inputDireccion = document.getElementById('address');

            // checkbox.checkbox ? inputDireccion.disabled = true: inputDireccion.disabled = false;
            if(checkbox.checked) {
                console.log("Retiro local.");
                inputDireccion.disabled = true;
            } else {
                console.log("Envio.");
                inputDireccion.disabled = false;
            }
        }
    </script>
    
    <!-- Custom styles for this template -->
    <!-- <link href="form-validation.css" rel="stylesheet" /> -->

    <title>Checkout | Tibbonzapas</title>
</head>

<body>
    <!-- NavBar -->
    <?php include(INCLUDES_PATH . "navbar.php") ?>

    <!-- Contenido solo visible para usuarios logueados -->
    <?php if ($usuarioActual != null) { ?>
        <div class="container-fluid">
            <!-- Preview -->
            <div class="container mt-2">
                <!-- Card -->
                <div class="card">
                    <div class="card-header">
                        <p class="h1">Finalizar Compra</p>
                    </div>
                    
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
                            <!-- Nuevo -->
                            <div class="row">
                                <!-- Resumen Carro -->
                                <div class="col-md-4 order-md-2 mb-4">
                                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                                        <span class="text-muted">Tu Carro</span>
                                        <span class="badge badge-primary badge-pill">
                                            <?= $carro->total_items() ?>
                                        </span>
                                    </h4>
                                    <ul class="list-group mb-3">
                                        <?php
                                        if ($carro->total_items() > 0) {
                                            $cartItems = $carro->getContenidoCarro();
                                            // var_dump($cartItems);
                                            foreach ($cartItems as $item) {
                                                $zapa = $item->get_zapatilla();
                                        ?>
                                        <li class="list-group-item list-group-item-light d-flex justify-content-between lh-condensed">
                                            <div>
                                                <h6 class="my-0">
                                                    <?php echo $zapa->get_nombre(); ?>
                                                </h6>
                                                <span>
                                                    x<?php echo $item->get_qty(); ?>
                                                </span>
                                                <small class="text-muted"><?php echo $zapa->get_descripcion(); ?></small>
                                            </div>
                                            <span class="text-muted">
                                                $<?php echo number_format($item->get_subtotalLinea(), 2, ',', '.'); ?>
                                            </span>
                                        </li>
                                        <?php } } else { ?>
                                            <li>No hay items en tu carro</li>
                                        <?php } ?>
                                        <li class="list-group-item list-group-item-dark d-flex justify-content-between ">
                                            <span>Total (ARS)</span>
                                            <strong>$<?php echo number_format($carro->total(), 2, ',', '.'); ?></strong>
                                        </li>
                                    </ul>
                                </div>
                                <!-- Form entrega -->
                                <div class="col-md-8 order-md-1">
                                    <h4 class="mb-3">Datos de Usuario</h4>
                                    <form action="Forms/manejo.checkout.php" method="POST" class="needs-validation" novalidate>
                                        <!-- Nombre y Apellido -->
                                        <div class="row">
                                            <input type="hidden" name="idUser" value="<?php if ($usuarioActual != null) echo $usuarioActual->get_id(); ?>">
                                            <div class="col-md-6 mb-3">
                                                <label for="firstName">Nombre</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    id="firstName" 
                                                    placeholder="<?php if ($usuarioActual != null) echo $usuarioActual->get_nombre(); ?>" 
                                                    readonly
                                                />
                                                <div class="invalid-feedback">
                                                    El nombre es requerido.
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="lastName">Apellido</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    id="lastName" 
                                                    placeholder="<?php if ($usuarioActual != null) echo $usuarioActual->get_apellido(); ?>" 
                                                    readonly                                                    
                                                />
                                                <div class="invalid-feedback">El apellido es requerido.</div>
                                            </div>
                                        </div>
                                        <!-- Usuario -->
                                        <div class="mb-3">
                                            <label for="username">Usuario</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">@</span>
                                                </div>
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    id="username" 
                                                    name="username" 
                                                    placeholder="<?php if ($usuarioActual != null) echo $usuarioActual->get_username(); ?>" 
                                                    readonly
                                                />
                                                <div class="invalid-feedback" style="width: 100%">
                                                    El nombre de usuario es requerido.
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Email -->
                                        <div class="mb-3">
                                            <label for="email">Email</label>
                                            <input 
                                                type="email" 
                                                class="form-control" 
                                                id="email" 
                                                name="emailInput" 
                                                placeholder="tu@ejemplo.com" 
                                                value="<?php if ($usuarioActual != null) echo $usuarioActual->get_email(); ?>"
                                                required
                                            />
                                            <div class="invalid-feedback">
                                                <?php if (isset($_SESSION['emailErr'])) echo $_SESSION["emailErr"]; else { ?>
                                                    Por favor ingrese una direccion de email valida.
                                                <?php } ?>  
                                            </div>
                                        </div>
                                        <!-- Retiro por local -->
                                        <div class="form-check">
                                            <input type="hidden" name="retiroCheck" value="off" />
                                            <input 
                                                type="checkbox" 
                                                class="form-check-input" 
                                                id="retiroCheck" 
                                                name="retiroCheck" 
                                                value="on"
                                                onclick="enableRetiro(this)"
                                            />
                                            <label class="form-check-label" for="passCheck">
                                                Retiro por local.
                                            </label>
                                            <small id="passChangeHelp" class="form-text text-muted">
                                                Si no tilda, indicar direccion de entrega.
                                            </small>
                                        </div>
                                        <!-- Direccion (opcional)-->
                                        <div class="mb-3">
                                            <label for="address">Direccion</label>
                                            <input 
                                                type="text" 
                                                class="form-control <?php if (isset($_SESSION['addressErr'])) { ?>is-invalid<?php } ?>" 
                                                id="address" 
                                                name="address"  
                                                aria-describedby="direccionHelp"
                                            />
                                            <small id="direccionHelp" class="form-text text-muted">Ej: Zeballos 1341.</small>
                                            <?php if (isset($_SESSION['addressErr'])) { ?>
                                                <div class="invalid-feedback">
                                                    <?= $_SESSION["addressErr"] ?>
                                                </div>
                                            <?php } ?>  
                                        </div>
                                        <!-- Telefono (opcional) -->
                                        <div class="mb-3">
                                            <label for="telefono">Telefono <span class="text-muted">(opcional)</span></label>
                                            <input 
                                                type="text" 
                                                class="form-control <?php if (isset($_SESSION['telefErr'])) { ?>is-invalid<?php } ?>" 
                                                id="telefono" 
                                                name="telefono" 
                                                value="<?php if ($usuarioActual != null) echo $usuarioActual->get_telefono(); ?>"
                                            />
                                            <small id="telefonoHelp" class="form-text text-muted">Solo numeros enteros. Ej: 3413595959.</small>
                                            <?php if (isset($_SESSION['telefErr'])) { ?>
                                                <div class="invalid-feedback">
                                                    <?= $_SESSION["telefErr"] ?>
                                                </div>
                                            <?php } ?>  
                                        </div>
                                        <hr class="mb-3" />
                                        <h4 class="mb-3">Forma de pago</h4>
                                        <!-- Radio Forma Pago -->
                                        <div class="d-block my-3">
                                            <div class="custom-control custom-radio">
                                                <input 
                                                    id="efectivo" 
                                                    name="formaPago" 
                                                    type="radio" 
                                                    value="1"
                                                    class="custom-control-input" 
                                                    checked 
                                                    required 
                                                    onclick="enableTarjeta()"
                                                />
                                                <label class="custom-control-label" for="efectivo">Efectivo</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input 
                                                    id="debito" 
                                                    name="formaPago" 
                                                    type="radio" 
                                                    value="2"
                                                    class="custom-control-input" 
                                                    required 
                                                    onclick="enableTarjeta()"
                                                />
                                                <label class="custom-control-label" for="debito">Debito</label>
                                            </div>
                                            <div class="custom-control custom-radio">
                                                <input 
                                                    id="credito" 
                                                    name="formaPago" 
                                                    type="radio" 
                                                    value="3"
                                                    class="custom-control-input" 
                                                    required 
                                                    onclick="enableTarjeta()"
                                                />
                                                <label class="custom-control-label" for="credito">Credito</label>
                                            </div>
                                        </div>
                                        <!-- Detalles Tarjeta (de ser requerido) -->
                                        <div class="row">
                                            <!-- Nombre en Tarjeta -->
                                            <div class="col-md-6 mb-3">
                                                <label for="cc-name">Nombre en tarjeta</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    id="cc-name" 
                                                    name="cc-name"  
                                                    required 
                                                    disabled
                                                />
                                                <small class="text-muted">Nombre completo como aparece en la tarjeta.</small>
                                                <div class="invalid-feedback">El nombre en tarjeta es requerido.</div>
                                            </div>
                                            <!-- Nro Tarjeta -->
                                            <div class="col-md-6 mb-3">
                                                <label for="cc-number">Nro de tarjeta</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control <?php if (isset($_SESSION['cc-numberErr'])) { ?>is-invalid<?php } ?>" 
                                                    id="cc-number" 
                                                    name="cc-number" 
                                                    minlength="16"
                                                    maxlength="16"
                                                    required 
                                                    disabled
                                                />
                                                <small id="nroTarjetaHelp" class="form-text text-muted">Numero entero de 12 digitos.</small>
                                                <div class="invalid-feedback">
                                                    <?php if (isset($_SESSION['cc-numberErr'])) echo $_SESSION["cc-numberErr"]; else { ?>
                                                        El numero de tarjeta es requerido.
                                                    <?php } ?> 
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-row">                                            
                                            <div class="col-md-3 mb-3">   
                                                <label for="cc-month">Fecha Vencimiento</label>
                                                <!-- Mes -->
                                                <select
                                                    class="custom-select"
                                                    id="cc-month"
                                                    name="cc-month"
                                                    required
                                                    disabled
                                                >
                                                    <option value="">MM</option>
                                                    <option value="01">01</option>
                                                    <option value="02">02</option>
                                                    <option value="03">03</option>
                                                    <option value="04">04</option>
                                                    <option value="05">05</option>
                                                    <option value="06">06</option>
                                                    <option value="07">07</option>
                                                    <option value="08">08</option>
                                                    <option value="09">09</option>
                                                    <option value="10">10</option>
                                                    <option value="11">11</option>
                                                    <option value="12">12</option>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Por favor ingrese el mes de vencimiento.
                                                </div>                                                                                          
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <!-- Año -->
                                                <label for="">
                                                    <small class="text-muted">MM/YY</small>
                                                </label>
                                                <select
                                                    class="custom-select"
                                                    id="cc-year"
                                                    name="cc-year"
                                                    required
                                                    disabled
                                                >
                                                    <option value="">YY</option>
                                                    <?php for($i=20; $i <= 30; $i++) { ?>
                                                        <option value="<?= $i ?>"><?= $i ?></option>
                                                    <?php } ?>
                                                </select>
                                                <div class="invalid-feedback">
                                                    Por favor ingrese el año de vencimiento.
                                                </div>   
                                            </div>
                                            <!-- CVV -->
                                            <div class="col-md-6 mb-3">
                                                <label for="cc-cvv">CVV</label>
                                                <input 
                                                    type="text" 
                                                    class="form-control col-md-3 <?php if (isset($_SESSION['cc-cvvErr'])) { ?>is-invalid<?php } ?>" 
                                                    id="cc-cvv" 
                                                    name="cc-cvv" 
                                                    minlength="3" 
                                                    maxlength="3" 
                                                    required 
                                                    disabled
                                                />
                                                <small id="cvvHelp" class="form-text text-muted">Numero entero de 3 digitos.</small>
                                                <div class="invalid-feedback">
                                                    <?php if (isset($_SESSION['cc-cvvErr'])) echo $_SESSION["cc-cvvErr"]; else { ?>
                                                        El codigo de seguridad es requerido.
                                                    <?php } ?> 
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="mb-4" />
                                        <!-- Botones -->
                                        <div class="row justify-content-around">
                                            <div class="col">
                                                <a href="tienda.php" class="btn btn-info btn-block">
                                                    <i class="fas fa-angle-left"></i>
                                                    Continuar comprando
                                                </a>
                                            </div>
                                            <div class="col">
                                                <button type="submit" class="btn btn-success btn-block" name="confirmar_compra">
                                                    Confirmar Orden
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>                    
                </div>
            </div>        
        </div>
        <!-- Footer -->
        <?php include(INCLUDES_PATH . "footer.html") ?>
        <!-- Mensaje de autorizacion -->
    <?php } else { ?>
        <div class="container mt-3">
            <div class="alert alert-danger text-center" role="alert">
                No esta autorizado a estar en esta seccion!
            </div>
        </div>
    <?php } ?>

    <!-- Limpiar mensajes de sesion -->
    <?php 
        if(isset($_SESSION['emailErr'])) unset($_SESSION['emailErr']); 
        if(isset($_SESSION['addressErr'])) unset($_SESSION['addressErr']); 
        if(isset($_SESSION['telefErr'])) unset($_SESSION['telefErr']); 
        if(isset($_SESSION['cc-numberErr'])) unset($_SESSION['cc-numberErr']); 
        if(isset($_SESSION['cc-cvvErr'])) unset($_SESSION['cc-cvvErr']); 
        if(isset($_SESSION['mensaje'])) unset($_SESSION['mensaje']); 
        if(isset($_SESSION['tipo_mensaje'])) unset($_SESSION['tipo_mensaje']); 
    ?>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH . "scripts.php") ?>

    <!-- Checkout Validation -->
    <script src="Includes/checkout-validation.js"></script>
</body>

</html>