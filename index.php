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

		$sql_total="select nombreartículo, sección,precio,paísdeorigen from productos where sección='deportes'";


		$resultado=$base->prepare($sql_total);
		$resultado->execute(array());

		$num_filas=$resultado->rowCount();//mostrar cantidad de filas dentro del array
		$total_paginas=ceil($num_filas/$tamaño_paginas);
		echo "Numero de registros de la consulta: " . $num_filas . "<br>";
		echo "Mostramos " . $tamaño_paginas . " registos por pagina" . "<br>";

		echo "Mostrando la pagina: " . $pagina . " de: " . $total_paginas . "<br>";

		$resultado->closeCursor();

		$sql_limite="select nombreartículo, sección,precio,paísdeorigen from productos where sección='deportes' limit $empezar_desde,$tamaño_paginas";

		$resultado=$base->prepare($sql_limite);
		$resultado->execute(array());

		while($registro=$resultado->fetch(PDO::FETCH_ASSOC)){

			echo("Nombre articulo: " . $registro["nombreartículo"] . " Seccion: " . $registro["sección"] . " Precio: " . $registro["precio"] . " Pais de origen: " . $registro["paísdeorigen"] . "<br>");

		}


	} catch (Exception $e) {
		echo "Linea de error: " . $e->getLine();
	}

//-----------------paginacion----------------//
	for ($i=1; $i <=$total_paginas ; $i++) { 
		echo " <a href='?pagina=" . $i . "'>" . $i . "</a>  ";
	}

?>

</body>
</html>