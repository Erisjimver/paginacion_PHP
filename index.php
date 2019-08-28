<!DOCTYPE html>
<html>
<head>
	<title>Paginacion</title>
</head>
<body>


<?php 

	try {

		$base=new PDO("mysql:host=localhost; dbname=pruebas", "root", "");

		$base->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$base->exec("SET CHARACTER SET utf8");

		$sql_total="select nombreartículo, sección,precio,paísdeorigen from productos where sección='deportes' limit 0,3";


		$resultado=$base->prepare($sql_total);
		$resultado->execute(array());

		while($registro=$resultado->fetch(PDO::FETCH_ASSOC)){

			echo("Nombre articulo: " . $registro["nombreartículo"] . " Seccion: " . $registro["sección"] . " Precio: " . $registro["precio"] . " Pais de origen: " . $registro["paísdeorigen"] . "<br>");

		}

		$resultado->closeCursor();
		
	} catch (Exception $e) {
		echo "Linea de error: " . $e->getLine();
	}



?>

</body>
</html>