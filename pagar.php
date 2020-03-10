<?php
include 'global/config.php';
include 'global/conexion.php';
include 'carrito.php';
//include 'templates/header.php';
?>
<?php
if($_POST){
    try{
        $pdo -> beginTransaction();
        //cliente
        $Correo="mail@mail.com";//$_POST["correo"];
        $cliente=$pdo->prepare("INSERT INTO `clientes` 
        (`id_cliente`, `nombre`, `apellido`, `telefono`, `correo`, 
        `rfc`, `calle`, `numero_ext`, `numero_int`, `colonia`, `ciudad`, 
        `estado`, `cp`, `fechas`) VALUES (NULL, 'X', NULL, NULL, :Correo, 
        NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NOW());");

        //echo $pdo->inTransaction();

        $cliente->bindParam(":Correo", $Correo);  
        $cliente->execute();
        $last_id = $pdo->lastInsertId();
        $pdo->commit();
    } catch (PDOException $ex){
        echo $ex->getMessage();
        $pdo->rollBack();
    }
    
    try{
        $pdo -> beginTransaction(); echo "</br>";
        //venta
        $total=0;
        $SID=session_id();

        foreach($_SESSION['CARRITO'] as $indice=>$producto){
            $total=$total+($producto['PRECIO']*$producto['CANTIDAD']);
        }
        $query=$pdo->prepare("INSERT INTO `ventas` 
        (`id_venta`, `id_empleado`, `id_cliente`, `id_estacion`, 
        `clave_transaccion`, `total`, `pagado`, `tipo_pago`, `fechas`) 
        VALUES (NULL, '1', :lastid, '1', :clave_transaccion, :total, '1', NULL, NOW());");
        $query->bindParam(":lastid", $last_id);
        $query->bindParam(":clave_transaccion", $SID);
        $query->bindParam(":total", $total);

        $query->execute();
        //echo $pdo->inTransaction(); echo "</br>";
        $pdo->commit();

        $idVenta=$pdo->lastInsertId();

        //venta_partida
        foreach($_SESSION['CARRITO'] as $indice=>$producto){
            $query=$pdo->prepare("INSERT INTO `ventas_partida` 
            (`id_ventas_partida`, `id_venta`, `id_producto`, `cantidad`, `precio`, `fechas`) 
            VALUES (NULL, :IDVENTA, :IDPRODUCTO, :CANTIDAD, :PRECIO, NOW());");

            $query->bindParam(":IDVENTA", $idVenta);
            $query->bindParam(":IDPRODUCTO", $producto['ID']);
            $query->bindParam(":CANTIDAD", $producto['CANTIDAD']);
            $query->bindParam(":PRECIO", $producto['PRECIO']);
            

            $query->execute();

        }
    
    } catch (PDOException $ex){
        echo $ex->getMessage();
        $pdo->rollBack();
    }

    echo "<h3>".$total."</h3>";
}
?>

<?php
include 'templates/footer.php';
?>