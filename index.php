<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
include 'templates/header.php';
?>


        <br>

        <?php if($mensaje!=""){?>

            <div class="alert-success">
                <?php echo ($mensaje);?>    
                
                <a href="mostrarCarrito.php" class="badge badge-success">Ver carrito</a>
            </div>

        <?php } ?>

        <div class="row">

        <?php
            $sentencia = $pdo->prepare('SELECT * FROM productos');
            $sentencia->execute();
            $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
            //print_r($listaProductos);
        ?>

        
        <?php foreach($listaProductos as $producto){?>
            <!--Productos-->
            <div class="col-3">
                <div class="card">

                    <img title="<?php echo $producto['nombre'] ?>" 
                    alt="<?php echo $producto['nombre'] ?>" 
                    class="card-img-top" 
                    src="<?php echo $producto['imagen'] ?>"
                    data-toggle="popover"
                    data-trigger="hover"
                    data-content="<?php echo $producto['descripcion'] ?>"
                    height = "250px";
                    >
                    

                    <div class="card-body">
                    <span><?php echo $producto['nombre'] ?></span>
                        <h5 class="card-title">$ <?php echo $producto['precio'] ?></h5>
                        <p class="card-text">Descripción</p>
                        
                        <form action="" method="post">

                            <input type="hidden" name="nombre_id" id="id_id" value="<?php echo openssl_encrypt($producto['id_producto'], COD, KEY);?>">
                            <input type="hidden" name="nombre_nombre" id="id_nombre" value="<?php echo openssl_encrypt($producto['nombre'], COD, KEY);?>">
                            <input type="hidden" name="nombre_cantidad" id="id_cantidad" value="<?php echo openssl_encrypt(1, COD, KEY);?>">  
                            <input type="hidden" name="nombre_precio" id="id_precio" value="<?php echo openssl_encrypt($producto['precio'], COD, KEY);?>">

                            <!--
                                ID - name = id, id= id
                                Nombre - name = nombre, id = nombre
                                Precio - name = precio, id = precio  
                                1      - name = cantidad, id = cantidad 
                            -->

                            <button class="btn btn-primary" 
                            name="btnAccion" value="Agregar" 
                            type="submit">Agregar al carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } ?>

        </div>
    </div>
    <script>
        $(function(){
            $('[data-toggle="popover"]').popover()
        });
    </script>

<?php
include 'templates/footer.php';
?>