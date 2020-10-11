<?php
/*
El cliente es redirigido a esta página si su pedido se ha realizado de manera satisfactoria.
*/

if (!isset($_REQUEST['id'])) {
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Order Success | Tibbonzapas</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Botstrap CSS -->
    <link rel="stylesheet" href="CSS/Bootstrap/css/bootstrap.min.css" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="CSS/fontawesome-free-5.14.0-web/css/all.css" />
    <!-- Icon -->
    <link rel="shortcut icon" href="IMG/favicon.ico" type="image/x-icon">
    <style>
        .container {
            width: 100%;
            padding: 50px;
        }

        p {
            color: #34a853;
            font-size: 18px;
        }
    </style>
</head>
</head>

<body>
    <div class="container">
        <div class="jumbotron">
            <h1>Order Status</h1>
            <p>Your order has submitted successfully. Order ID is #<?php echo $_GET['id']; ?></p>
            <p>An receipt has been sent to your email address</p>
        </div>
    </div>

    <!-- Scripts -->
    <?php include(INCLUDES_PATH . "scripts.php") ?>
</body>

</html>