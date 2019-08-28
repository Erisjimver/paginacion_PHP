<!DOCTYPE html>
<html>
<head>
	<title>Borrar</title>
</head>
<body>


	<?php 

	include("conexion.php");

	$id=$_GET["id"];

	$base->query("delete from datos_usuarios where id='$id'");

	header("Location:index.php");

	 ?>

</body>
</html>