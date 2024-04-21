<?php
include_once "funciones.php";
include_once "conexion.php";
$html = 0;
if(isset($_POST['buscar'])){
	$filtro = mysqli_real_escape_string ($conn,$_POST['filtro']);
	$clv = mysqli_real_escape_string($conn,$_POST['clv']);
	$clv =($clv == '') ? 'vacio':$clv ;
	$sentencia;
	if ($clv != 'vacio'){
		$sentencia = "SELECT * FROM Trabajo WHERE Clave = '$clv';";
	 	$html =_cargar_trabajos($conn,$sentencia);
	}else{
		if ($filtro != '*' && $filtro != 'N') {
			$sentencia = "SELECT * FROM Trabajo WHERE Activo = '$filtro';";
			$html =_cargar_trabajos($conn,$sentencia);
		}else{
			$sentencia = "SELECT * FROM Trabajo;";
			$html =_cargar_trabajos($conn,$sentencia);
		}
	}
}else if (isset($_POST['alta'])) {
	$clave= mysqli_real_escape_string($conn,$_POST['clave']);
	$titulo= mysqli_real_escape_string($conn,$_POST['titulo']);  
	$fecha= mysqli_real_escape_string($conn,$_POST['fecha_r']); 
	$encargado= mysqli_real_escape_string($conn,$_POST['encargado']); 
	$activo= mysqli_real_escape_string($conn,$_POST['activo']); 

	// Generamos el sql que necesitamos
	$sentencia_sql = "INSERT INTO Trabajo(Clave,Titulo,Fecha_registro,Encargado,Activo) VALUES (nueva_clave('$clave'),'$titulo','$fecha','$encargado','$activo');";
	//enviamos el sql a la base
	$sentencia_insert = mysqli_query($conn,$sentencia_sql);
	if ($sentencia_insert) {
		echo "<script language='javascript'>alert('Registro de trabajo correcto');</script>";
	}else{
		echo "<script language='javascript'>alert('UPS, algo salio mal en la sentencia');</script>";
	}
	mysqli_close($conn);
	
}else if (isset($_POST['eliminar'])){
	$clave= mysqli_real_escape_string($conn,$_POST['clave']);
	// Generamos el sql que necesitamos
	$sentencia_sql = "CALL baja_trabajo('$clave')";
	//enviamos el sql a la base
	$sentencia_delete = mysqli_query($conn,$sentencia_sql);
	if ($sentencia_delete) {
		echo "<script language='javascript'>alert('Se elimino el trabajo');</script>";
	}else{
		echo "<script language='javascript'>alert('UPS, algo salio mal en la sentencia');</script>";
	}
	mysqli_close($conn);

}else if (isset($_POST['modificar'])) {
	$clave= mysqli_real_escape_string($conn,$_POST['clave']);
	$titulo= mysqli_real_escape_string($conn,$_POST['titulo']);  
	$fecha= mysqli_real_escape_string($conn,$_POST['fecha_r']); 
	$encargado= mysqli_real_escape_string($conn,$_POST['encargado']); 
	$activo= mysqli_real_escape_string($conn,$_POST['activo']); 
	$activo =($activo == 'SI') ? '1' : '0'; 
	// Generamos el sql que necesitamos
	$sentencia_sql = "UPDATE Trabajo SET Titulo='$titulo', Fecha_registro='$fecha', Encargado='$encargado', Activo='$activo' WHERE Clave = '$clave';";
	//enviamos el sql a la base
	$sentencia_update = mysqli_query($conn,$sentencia_sql);
	if ($sentencia_update) {
		echo "<script language='javascript'>alert('Se modifico el trabajo');</script>";
	}else{
		echo "<script language='javascript'>alert('UPS, algo salio mal en la sentencia');</script>";
	}
	mysqli_close($conn);
}else if(isset($_POST['sinodal'])){
	$clave = mysqli_real_escape_string($conn,$_POST['clave_trab']);
	$html = _cargar_sinodal($conn,$clave);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Coordinación Administración</title>
	<link rel="stylesheet" type="text/css" href="../css/style_3.css">
</head>
<body>
	<div id="titulo">
		<div>
			<img src="../img/lgo_unam.png" alt="logo_unam" title="UNAM" width="100px">
		</div>
		<div>
			<h1>Universidad Nacional Autónoma de México</h1>
			<p>Facultad de Estudios Superiores Cuautitlan</p>
			<p>Coordinación de Administracion</p>
		</div>
		<div>
			<img src="../img/lgo_unam.png" alt="logo_unam" title="UNAM" width="100px">
		</div>
	</div>
	<nav>
		<h3>Opciones</h3>
		<button id="btn_alta">Alta Trabajo</button>
		<button id="btn_modificar">Modificar Trabajo</button>
		<button id="btn_eliminar">Eliminar Trabajo</button>
		<button id="btn_buscar">Buscar Trabajo</button>
		<button id="btn_regresar">Regresar a Inicio</button>
	</nav>
	<section>
		<h3 id="titulo_padre">Selecciona una opción</h3>
	</section>
	<!--Template  para la pagina-->
	<template id="tmp_form_Atrab">
    <div class="contenedor">
			<form action="Trabajos.php" method="POST" autocomplete="off">
				<legend>Alta Trabajo</legend>
				<div class="elemento">
					<label for="clv">
						Clave del Trabajo: 
					</label>
					<input type="text" name="clave" required id="clv">
				</div>
				<div class="elemento">
					<label for="titu">
						Titulo: 
					</label>
					<input type="text" name="titulo" required id="titu">
				</div>
				<div class="elemento">
					<label for="fech">
						Fecha de Registro:
					</label>
					<input type="text" name="fecha_r" required id="fech" placeholder="Formato de fecha: YYYY-MM-DD" >
				</div>
				<div class="elemento">
					<label for="reg">
						Encargado de Registro:
					</label>
					<input type="text" name="encargado" required id="reg" placeholder="Nombre de la persona">
				</div>
				<div class="elemento">
					<label >
						Activo:
					</label>
					<br>
					<label>SI</label>
                    <input type="checkbox" name="activo" value="1">
					<label>NO</label>
					<input type="checkbox" name="activo" value="0">
				</div>
				<div class="elemento">
					<input type="submit" name="alta" value="Enviar" >
				</div>
			</form>
		</div>
	</template>
	<template id="tmp_form_Etrab">
    <div class="contenedor">
			<form action="Trabajos.php" method="POST" autocomplete="off" id="form_eli">
				<legend>Eliminar Trabajo </legend>
				<div class="elemento">
					<label for="clv">
						Clave del Trabajo: 
					</label>
					<input type="text" name="clave" required id="clv" readonly="true">
				</div>
				<div class="elemento">
					<label for="titu">
						Titulo: 
					</label>
					<input type="text" name="titulo" required id="titu" disabled="true">
				</div>
				<div class="elemento">
					<label for="fech">
						Fecha de Registro:
					</label>
					<input type="text" name="fecha_r" required id="fech" disabled="true">
				</div>
				<div class="elemento">
					<input type="submit" name="eliminar" value="Enviar" >
				</div>
			</form>
		</div>
	</template>
	<template id="tmp_form_Mtrab">
    <div class="contenedor">
			<form action="Trabajos.php" method="POST" autocomplete="off" id="form_mod">
				<legend>Modificar Trabajo</legend>
				<div class="elemento">
					<label for="clv">
						Clave del Trabajo: 
					</label>
					<input type="text" name="clave" required id="clv" readonly="true">
				</div>
				<div class="elemento">
					<label for="titu">
						Titulo: 
					</label>
					<input type="text" name="titulo" required id="titu">
				</div>
				<div class="elemento">
					<label for="fech">
						Fecha de Registro:
					</label>
					<input type="text" name="fecha_r" required id="fech" placeholder="Formato de fecha: YYYY-MM-DD" >
				</div>
				<div class="elemento">
					<label for="reg">
						Encargado de Registro:
					</label>
					<input type="text" name="encargado" required id="reg" placeholder="Nombre de la persona">
				</div>
				<div class="elemento">
					<label >
						Activo:
					</label>
                    <input type="text"  name="activo" require placeholder="SI ó NO">
				</div>
				<div class="elemento">
					<input type="submit" name="modificar" value="Enviar" >
				</div>
			</form>
		</div>
	</template>
	<?php
	include_once "funciones.php";
	_carga_datos_bus_d();
	if ($html) {
		print($html);
		echo "<script type='text/javascript' language='javascript'>alert('Ya puedes visualizar la información solicitada de los trabajos');</script>";
	}
	?>
	<script language="javascript" src="../js/app3.js" type="text/javascript"></script>
</body>
</html>