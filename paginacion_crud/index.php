<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>CRUD</title>
<link rel="stylesheet" type="text/css" href="hoja.css">


</head>

<body>
<?php

  include("conexion.php");

  //$conexion=$base->query("select * from datos_usuarios");

  //$registros=$conexion->fetchAll(PDO::FETCH_OBJ);

//--------------------------------PAGINACION -----------------------------//
      $tamaño_paginas=3;//cantidad de registros que se van a mostrar
    if(isset($_GET["pagina"])){
      if($_GET["pagina"]==1){
        header("location:index.php");
      }
      else{
        $pagina=$_GET["pagina"];
      }
    }
    else{
    $pagina=1;//posicion inicial de lso registros a mostrar     
    }

    $empezar_desde=($pagina-1)*$tamaño_paginas;

    $sql_total="select * from datos_usuarios";


    $resultado=$base->prepare($sql_total);
    $resultado->execute(array());

    $num_filas=$resultado->rowCount();//mostrar cantidad de filas dentro del array
    $total_paginas=ceil($num_filas/$tamaño_paginas);
//------------------------------TERMINA PAGINACION ---------------------//

  $registros=$base->query("select * from datos_usuarios limit $empezar_desde,$tamaño_paginas")->fetchAll(PDO::FETCH_OBJ);//array de objetos   //id,nombre,apellidos,direccion// son propiedades que contiene este array

  if(isset($_POST["cr"])){


      $nombre=$_POST["Nom"];
      $apellido=$_POST["Ape"];
      $direccion=$_POST["Dir"];      

      $sql="insert into datos_usuarios (nombre,apellido,direccion) values (:miNom,:miApe,:miDir)";
      $resultado=$base->prepare($sql);
      $resultado->execute(array(":miNom"=>$nombre, ":miApe"=>$apellido, ":miDir"=>$direccion));

      header("Location:index.php");


  }

 

 ?>

<h1>CRUD<span class="subtitulo">Create Read Update Delete</span></h1>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
  <table width="50%" border="0" align="center">
    <tr >
      <td class="primera_fila">Id</td>
      <td class="primera_fila">Nombre</td>
      <td class="primera_fila">Apellido</td>
      <td class="primera_fila">Dirección</td>
      <td class="sin">&nbsp;</td>
      <td class="sin">&nbsp;</td>
      <td class="sin">&nbsp;</td>
    </tr> 
   
	<?php	
  foreach($registros as $persona):?>
   	<tr>
      <td><?php  echo $persona->id ?></td>
      <td><?php  echo $persona->nombre ?></td>
      <td><?php  echo $persona->apellido ?></td>
      <td><?php  echo $persona->direccion ?></td>
 
      <td class="bot"><a href="borrar.php?id=<?php echo $persona->id ?>"><input type='button' name='del' id='del' value='Borrar'></a></td>
      <td class='bot'><a href="editar.php?id=<?php echo $persona->id ?> & nom=<?php echo $persona->nombre ?> & ape=<?php echo $persona->apellido ?> & dir=<?php echo $persona->direccion ?>"><input type='button' name='up' id='up' value='Actualizar'></a></td>
    </tr>  
    
<?php 
  endforeach;
?>
	<tr>
	<td></td>
      <td><input type='text' name='Nom' size='10' class='centrado'></td>
      <td><input type='text' name='Ape' size='10' class='centrado'></td>
      <td><input type='text' name=' Dir' size='10' class='centrado'></td>
      <td class='bot'><input type='submit' name='cr' id='cr' value='Insertar'></td></tr>  
      <tr><td colspan="4"><?php 


//-----------------paginacion----------------//
  for ($i=1; $i <=$total_paginas ; $i++) { 
    echo " <a href='?pagina=" . $i . "'> " . $i . " </a>  ";
  }

   ?></td></tr>  
  </table>
</form>


<p>&nbsp;</p>
</body>
</html>