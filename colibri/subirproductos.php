<?php
/**
 * Created by PhpStorm.
 * User: Eunkyu
 * Date: 5/8/2017
 * Time: 9:22 AM
 */

    //conectar a base de datos
    $server = "localhost";
    $user = "root";
    $password = "";
    $bd = "tienda2";

    $conexion = mysqli_connect($server, $user, $password, $bd)
        or die ("Error en la Conexion");
        echo ("Conexion Ejecutada");

    //variables para insertar a base de datos
    $nomprod = $_POST['Nombre'];
    $categ = $_POST['Categoria'];
    $precio = $_POST['Precio'];
    $descripcion = $_POST['Descripcion'];
    $fotos = $_POST['Archivo1'];
    echo $fotos;

    //verify categoria
    $findcateg = "SELECT codcategoria FROM categoria WHERE categoria ='$categ'";
    $result2 = mysqli_query($conexion, $findcateg);

    //Ingresar categoria
    //Si existe categoria ingresado
    if(mysqli_num_rows($result2) > 0) {
        $row = $result2->fetch_assoc();
        $codcateg = $row["codcategoria"];
        echo $codcateg;
    }
    //Si no existe categoria ingresado
    else {
        $query2 = "SELECT MAX(codcategoria) AS max FROM categoria";
        $result4 = mysqli_query($conexion, $query2);
        $row2 = mysqli_fetch_array($result4);
        $codmax2 = $row2['max'];
        echo $codmax2;
        $codcateg = $codmax2 +1;

        $insert2 = "INSERT INTO categoria (codcategoria, categoria) VALUES ('$codcateg', '$categ')";
        $result5 = mysqli_query($conexion, $insert2);
    }

    //verify codigo producto
    $query = "SELECT MAX(codproducto) AS max FROM producto";
    $result3 = mysqli_query($conexion, $query);
    $row = mysqli_fetch_array($result3);
    $codmax = $row['max'];
    echo $codmax;
    $codprod = $codmax +1;

    $insert = "INSERT INTO producto (codproducto, precio, descripcion, codcategoria, nombre) VALUES ('$codprod', '$precio', '$descripcion','$codcateg', '$nomprod')";
    $result = mysqli_query($conexion, $insert)
        or die ("Error insertar al bd");

    //insert image
    $foto = $_FILES["Archivo1"]["name"];
    $ruta = $_FILES["Archivo1"]["tmp_name"];
    $destino = "Images/".$foto;
    copy($ruta, $destino);

    $insert3 = "INSERT INTO fotos (CODPRODUCTO, foto) VALUES ('$codprod', '$destino')";
    $result6 = mysqli_query($conexion, $insert3)
        or die ("Error insertar al bd");

        //Desconectar
        mysqli_close($conexion);
        echo "Datos insertados correctamente";


?>
