<?php
session_start(); //permite trabajar con variables sesión, mantiene información de la navegacion del usuario
//al hacer la compra despues del carrito usamos esta vaiable de sesion
$mensaje=""; //para enviar 

//click en boton agregar
if(isset($_POST['btnAccion'])){
    switch($_POST['btnAccion']){
        case 'Agregar': //value boton
            //funcion para validacion id
            if(is_numeric(openssl_decrypt($_POST['nombre_id'], COD, KEY))){
                //variable id que es igual a la desencriptacion
                $ID = openssl_decrypt($_POST['nombre_id'], COD, KEY); //ID solo para esta validacion
                $mensaje.="ID válido".$ID."<br/>";
            } else {
                $mensaje.="No es un ID".$ID."<br/>";
            }
            if(is_string(openssl_decrypt($_POST['nombre_nombre'], COD, KEY))){
                $NOMBRE=openssl_decrypt($_POST['nombre_nombre'], COD, KEY);
                $mensaje.="Sí es un nombre".$NOMBRE."<br/>";
                } else {$mensaje.="No es un nombre"."<br/>"; break;}
                if(is_numeric(openssl_decrypt($_POST['nombre_cantidad'], COD, KEY))){
                    $CANTIDAD=openssl_decrypt($_POST['nombre_cantidad'], COD, KEY);
                    $mensaje.="Sí es una cantidad".$CANTIDAD."<br/>";
                } else {$mensaje.="No es una cantidad"."<br/>"; break;}
                if(is_numeric(openssl_decrypt($_POST['nombre_precio'], COD, KEY))){
                    $PRECIO=openssl_decrypt($_POST['nombre_precio'], COD, KEY);
                    $mensaje.="Sí es un precio".$PRECIO."<br/>";
                } else {$mensaje.="No es un precio"."<br/>"; break;}


            if(!isset($_SESSION['CARRITO'])){//si no tenemos una variable de sesion carrito

                $producto=array( //variable que guarda todo lo que elusuario envia al carrito con post
                    'ID'=>$ID,
                    'NOMBRE'=>$NOMBRE,
                    'CANTIDAD'=>$CANTIDAD,
                    'PRECIO'=>$PRECIO
                );
                $_SESSION['CARRITO'][0]=$producto;//toma la variable de sesión carrito y almacena en la posición 0 la variable producto
                $mensaje= "Producto agregado al carrito";
            } else { //cuando ya tenemos 1 producto en el carrito
                $idProductos=array_column($_SESSION['CARRITO'], "ID"); //arraycolumn deposita todos los id's que hay en la variable de sesión carrito

                if(in_array($ID, $idProductos)){
                    echo "<script>alert('El producto ya ha sido seleccionado...');</script>";
                    $mensaje="";
                } else {
                    $NumeroProductos=count($_SESSION['CARRITO']); //contabiliza el carrito de compras, a partir del 0
                    $producto=array(
                    'ID'=>$ID,
                    'NOMBRE'=>$NOMBRE,
                    'CANTIDAD'=>$CANTIDAD,
                    'PRECIO'=>$PRECIO
                    );
                    $_SESSION['CARRITO'][$NumeroProductos]=$producto; //se agrega al carrito
                    $mensaje= "Producto agregado al carrito";
                }
            }
            //$mensaje=print_r($_SESSION, true);
        break;
        case "Eliminar":
            if(is_numeric(openssl_decrypt($_POST['id'], COD, KEY))){
                //variable id que es igual a la desencriptacion
                $ID = openssl_decrypt($_POST['id'], COD, KEY);
                foreach($_SESSION['CARRITO'] as $indice=>$producto){
                    if($producto['ID']==$ID){
                        unset($_SESSION['CARRITO'][$indice]);
                        echo "<script>alert('Elemento borrado...');</script>";
                    }
                }
            } else {
                $mensaje.="No es un ID".$ID."<br/>";
            }
        break;
        }
}

?>
