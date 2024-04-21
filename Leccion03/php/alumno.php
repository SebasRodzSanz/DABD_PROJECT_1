<?php
include_once "funciones.php";
$html = 0;
if(isset($_POST['buscar'])){
	$con = mysqli_connect("localhost:3306","root","","coordinacion_web");
	$filtro =mysqli_real_escape_string($con, $_POST['filtro']);
	$sentencia;
	if ($filtro != '*') {
		$sentencia = "SELECT * FROM Alumno WHERE Cuenta = '$filtro';";
		$html =_cargar_alumnos($con,$sentencia);
	}else{
		$sentencia = "SELECT * FROM Alumno;";
		$html =_cargar_alumnos($con,$sentencia);
	}
}else if (isset($_POST['alta'])) {
	$con = mysqli_connect("localhost:3306","root","","coordinacion_web");

	$cuenta = mysqli_real_escape_string($con,$_POST['cuenta']);
	$nombre = mysqli_real_escape_string($con,$_POST['nombre']);   
	$celular= mysqli_real_escape_string($con,$_POST['celular']); 
	$correo=  mysqli_real_escape_string($con,$_POST['correo']); 
	// Generamos el sql que necesitamos
	$sentencia_sql = "INSERT INTO Alumno(Cuenta, Nombre, Correo_e, Folio,Telefono) VALUES ('$cuenta','$nombre','$correo',NULL,'$celular');";
	//enviamos el sql a la base
	$sentencia_insert = mysqli_query($con,$sentencia_sql);
	if ($sentencia_insert) {
		echo "<script language='javascript'>alert('Registro de alumno correcto');</script>";
	}else{
		echo "<script language='javascript'>alert('UPS, algo salio mal en la sentencia');</script>";
	}
	mysqli_close($con);

}else if (isset($_POST['eliminar'])) {
	$con = mysqli_connect("localhost:3306","root","","coordinacion_web");

	$cuenta = mysqli_real_escape_string($con,$_POST['cuenta']);
	// Generamos el sql que necesitamos
	$sentencia_sql = "DELETE FROM Alumno WHERE Cuenta ='$cuenta';";
	//enviamos el sql a la base
	$sentencia_delete = mysqli_query($con,$sentencia_sql);
	if ($sentencia_delete) {
		echo "<script language='javascript'>alert('Se elimino el alumno');</script>";
	}else{
		echo "<script language='javascript'>alert('UPS, algo salio mal en la sentencia');</script>";
	}
	mysqli_close($con);

}else if (isset($_POST['mod'])) {
	$con = mysqli_connect("localhost:3306","root","","coordinacion_web");

	$cuenta = mysqli_real_escape_string($con,$_POST['cuenta']);
	$nombre = mysqli_real_escape_string($con,$_POST['nombre']);  
	$folio= mysqli_real_escape_string($con,$_POST['folio']);
	$folio = ($folio == 'Ninguno') ?'NULL' : $folio ;
	$celular= mysqli_real_escape_string($con,$_POST['celular']); 
	$correo= mysqli_real_escape_string($con,$_POST['correo']); 
	// Generamos el sql que necesitamos
	$sentencia_sql;
	if($folio != "NULL")
		$sentencia_sql = "UPDATE Alumno SET Nombre='$nombre', Folio='$folio', Telefono='$celular', Correo_e='$correo' WHERE Cuenta = '$cuenta';";
	else
		$sentencia_sql = "UPDATE Alumno SET Nombre='$nombre', Telefono='$celular', Correo_e='$correo' WHERE Cuenta = '$cuenta';";
	//enviamos el sql a la base
	$sentencia_update = mysqli_query($con,$sentencia_sql);
	if ($sentencia_update) {
		echo "<script language='javascript'>alert('Se modifico el alumno');</script>";
	}else{
		echo "<script language='javascript'>alert('UPS, algo salio mal en la sentencia');</script>";
	}
	mysqli_close($con);
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
		<button id="btn_alta">Alta Alumno</button>
		<button id="btn_modificar">Modificar Alumno</button>
		<button id="btn_eliminar">Eliminar Alumno</button>
		<button id="btn_buscar">Buscar Alumno</button>
		<button id="btn_regresar">Regresar a Inicio</button>
	</nav>
	<section>
		<h3 id="titulo_padre">Selecciona una opción</h3>
	</section>
	<!--Template  para la pagina-->
	<template id="tmp_form_Aalum">
		<div class="contenedor">
			<form action="alumno.php" method="POST" autocomplete="off">
				<legend>Alta de Alumno</legend>
				<div class="elemento">
					<label for="cuen">
						Cuenta Alumno: 
					</label>
					<input type="text" name="cuenta" required id="cuen">
				</div>
				<div class="elemento">
					<label for="nom">
						Nombre: 
					</label>
					<input type="text" name="nombre" required id="nom">
				</div>
				<div class="elemento">
					<label for="cel">
						Celular:
					</label>
					<input type="text" name="celular" required id="cel">
				</div>
				<div class="elemento">
					<label for="cor">
						Correo:
					</label>
					<input type="text" name="correo" required id="cor">
				</div>
				<div class="elemento">
					<input type="submit" name="alta" value="Enviar" >
				</div>
			</form>
		</div>
	</template>
	<template id="tmp_form_Ealum">
		<div class="contenedor">
			<form action="alumno.php" method="POST" autocomplete="off" id="form_eli">
				<legend>Eliminar de Alumno</legend>
				<div class="elemento">
					<label for="nom">
						Nombre: 
					</label>
					<input type="text" name="nombre" required id="nom"disabled="true">
				</div>
				<div class="elemento">
					<label for="cuen">
						Cuenta: 
					</label>
					<input type="text" name="num_cuenta" required id="cuen"disabled="true">
				</div>
				<div class="elemento">
					<label for="titu">
						Folio de trabajo:
					</label>
					<input type="text" name="folio" required id="titu" disabled="true">
				</div>
				
				<div class="elemento">
					<input type="submit" name="eliminar" value="Enviar" >
					<input type="hidden" name="cuenta">
				</div>
			</form>
		</div>
	</template>
	<template id="tmp_form_Malum">
		<div class="contenedor">
			<form action="alumno.php" method="POST" autocomplete="off" id="form_mod">
				<legend>Modificar de Alumnos</legend>
				<div class="elemento">
					<label for="nom">
						Nombre: 
					</label>
					<input type="text" name="nombre" required id="nom">
				</div>
				<div class="elemento">
					<label for="cel">
						Celular:
					</label>
					<input type="text" name="celular" required id="cel">
				</div>
				<div class="elemento">
					<label for="cor">
						Correo:
					</label>
					<input type="text" name="correo" required id="cor">
				</div>
				<div class="elemento">
					<label for="titu">
						Folio de trabajo:
					</label>
					<input type="text" name="folio" required id="titu">
				</div>
				<div class="elemento">
					<input type="submit" name="mod" value="Enviar" >
					<input type="hidden" name="cuenta">
				</div>
			</form>
		</div>
	</template>
	<?php
	include_once "conexion.php";
	include_once "funciones.php";
	_carga_datos_bus($conn);
	if ($html) {
		print($html);
		echo "<script type='text/javascript' language='javascript'>alert('Ya puedes visualizar los alumnos');</script>";
	}
	?>
	<script language="javascript" src="../js/app2.js" type="text/javascript"></script>
</body>
</html>