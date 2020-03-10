<?php
include 'global/config.php';
include 'carrito.php';
include 'templates/header.php';
?>

<br>
<h3>Mi Carrito</h3>
<?php if(!empty($_SESSION['CARRITO'])) {?>
    <table class="table table-light table-bordered">
        <tbody>
            <tr>
                <th width="40%">Descripción</th>
                <th width="15%" class="text-center">Cantidad</th>
                <th width="20%" class="text-center">Precio</th>
                <th width="20%" class="text-center">Total</th>
                <th width="5%">--</th>
            </tr>

            <?php $total=0; ?>
            <?php foreach($_SESSION['CARRITO'] as $indice=>$producto) {?>
                <tr>
                    <td width="40%"><?php echo $producto['NOMBRE'] ?></td>
                    <td width="15%" class="text-center"><?php echo $producto['CANTIDAD'] ?></td>
                    <td width="20%" class="text-center">$<?php echo $producto['PRECIO'] ?></td>
                    <td width="20%" class="text-center">$<?php echo number_format($producto['PRECIO']* $producto['CANTIDAD'], 2); ?>
                    
                    <form action="" method="post">

                        <input type="hidden" 
                        name="id" 
                        id="id"
                        value="<?php echo openssl_encrypt($producto['ID'], COD, KEY)?>">

                        <td width="5%"><button 
                        class="btn btn-danger" 
                        type="submit"
                        name="btnAccion"
                        value="Eliminar"
                        >Eliminar</button></td>
                    </form>
                    </td>
                
                </tr>
                <?php $total=$total+($producto['PRECIO']*$producto['CANTIDAD']);?>
            <?php }?>  

            <tr>
                <td colspan="3" align="right"><h3>Total</h3></td>
                <td align="right"><h3>$<?php echo number_format($total,2);?></h3></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="5">
                    <form action="pagar.php" method="post">
                        <div class="alert alert-success">
                            <div class="form-group">
                                <label for="my-input">Email:</label>
                                <input id="correo" name="correo"
                                class="form-control" 
                                type="email"
                                placeholder="Escriba su correo" required
                                >
                            </div>
                            <small id="emailHelp" 
                            class="form-text text-muted">
                            Productos se enviarán a este correo</small>
                        </div>
                        <button class="btn btn-primary btn-lg btn-block" 
                            type="submit" name="btnAccion" method="post" value="venta">^⨀ᴥ⨀^ Pagar	(◕ᴥ◕ʋ)
                        </button>
                    </form>    
                </td>
            </tr>
        </tbody>
    </table>
<?php } else { ?>
    <div class="alert alert-success">
        Sin productos
    </div>
<?php } ?>

<?php
include 'templates/footer.php';
?>