<!-- Antiguo -->
<div class="row">
                            <!-- Col Left -->
                            <div class="col-md-8">
                                <div class="row">
                                    <!-- Arriba -->
                                    <div class="col">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Producto</th>
                                                    <th scope="col">Precio</th>
                                                    <th scope="col">Cantidad</th>
                                                    <th scope="col">Subtotal</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if ($carro->total_items() > 0) {
                                                    // echo "Cart";
                                                    // var_dump($cart);
                                                    //get cart items from session
                                                    // echo "Cart Items";
                                                    $cartItems = $carro->getContenidoCarro();
                                                    // var_dump($cartItems);
                                                    foreach ($cartItems as $item) {
                                                        $zapa = $item->get_zapatilla();
                                                ?>
                                                        <tr>
                                                            <td><?php echo $zapa->get_nombre(); ?></td>
                                                            <td>$
                                                                <?php echo number_format($zapa->get_precio(), 2, ',', '.'); ?>
                                                            </td>
                                                            <td><?php echo $item->get_qty(); ?></td>
                                                            <td>$
                                                                <?php echo number_format($item->get_subtotalLinea(), 2, ',', '.'); ?>
                                                            </td>
                                                        </tr>
                                                <?php } } else { ?>
                                                <tr>
                                                    <td colspan="4">
                                                        <p>No hay items en tu carro....</p>
                                                    </td>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Force next columns to break to new line -->
                                    <div class="w-100"></div>
                                    <!-- Abajo -->
                                    <div class="col">
                                        <?php if ($carro->total_items() > 0) { ?>
                                            <div class="alert alert-secondary text-center ml-auto" role="alert">
                                                <strong>Total <?php echo '$' . $carro->total(); ?></strong>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <!-- Col right -->
                            <div class="col-md-4">
                                <h4>Detalles de envio</h4>
                                <?php if ($usuarioActual != null) { ?>
                                    <p>
                                        <strong>Nombre: </strong><?php echo $usuarioActual->get_nombre(); ?>
                                    </p>
                                    <p>
                                        <strong>Apellido: </strong><?php echo $usuarioActual->get_apellido(); ?>
                                    </p>
                                    <p>
                                        <strong>Telefono: </strong><?php echo $usuarioActual->get_telefono(); ?>
                                    </p>
                                    <p>
                                        <strong>Email: </strong><?php echo $usuarioActual->get_email(); ?>
                                    </p>
                                <?php } else { ?>
                                    <p> Error al cargar datos del usuario </p>
                                <?php } ?>
                            </div>
                        </div>