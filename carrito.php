<?php
/*
En esta página utilizamos bootstrap para diseñar el listado de productos. Si así lo deseas, puedes omitir bootstrap y utilizar el diseño de tu sitio web. Todos los productos se obtendrán de la tabla products y se mostrarán con el botón “Add to Cart”. Dicho botón redirecciona al usuario a la página cartAction.php con la solicitud AddToCart y el respectivo ID del producto.
*/

// inicializar rutas
include_once($_SERVER['DOCUMENT_ROOT'] . '/EntornosGraficos_TP-Final/rutas.php');
// include database configuration file
include_once(DAO_PATH . "db.php");
// Inicializar servicios zapatilla y usuario
include(DAO_PATH . "dao.usuario.php");
include(DAO_PATH . "dao.zapatilla.php");

// Iniciar/Retomar sesion
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>PHP Shopping Cart Tutorial</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .container {
            padding: 50px;
        }

        .cart-link {
            width: 100%;
            text-align: right;
            display: block;
            font-size: 22px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Products</h1>
        <a href="viewCart.php" class="cart-link" title="View Cart">
            <i class="glyphicon glyphicon-shopping-cart"></i>
        </a>
        <div id="products" class="row list-group">
            <?php
            $zapatillaService = new ZapatillaDataService();
            $zapas = $zapatillaService->getZapatillas();

            // Si hay datos
            if ($zapas != null) {
                foreach ($zapas as $zapa) {
            ?>
                    <div class="item col-lg-4">
                        <div class="thumbnail">
                            <div class="caption">
                                <h4 class="list-group-item-heading">
                                    <?php echo $zapa['nombre']; ?>
                                </h4>
                                <p class="list-group-item-text">
                                    <?php echo $zapa["descripcion"]; ?>
                                </p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="lead">
                                            $ <?php if (empty($zapa['precio'])) echo "0.0";
                                                else echo $zapa['precio']; ?>
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <a 
                                            class="btn btn-success" 
                                            href="Forms/cartAction.php?action=addToCart&id=<?php echo $zapa["id_zapatilla"]; ?>"
                                        >
                                            Add to cart
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <p>Product(s) not found.....</p>
            <?php } ?>
        </div>
    </div>
</body>

</html>