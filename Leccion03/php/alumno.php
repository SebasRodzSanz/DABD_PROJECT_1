<?php
include_once "funciones.php";
$html = 0;
if(isset($_POST['buscar'])){
	$filtro = $_POST['filtro'];
	$sentencia;
	$con = mysqli_connect("127.0.0.1:3308","root","","coordinacion_web");
	if ($filtro != '*') {
		$sentencia = "SELECT * FROM Alumno WHERE Opcion_titulacion = '$filtro';";
		$html =_cargar_alumnos($con,$sentencia);
	}else{
		$sentencia = "SELECT * FROM Alumno;";
		$html =_cargar_alumnos($con,$sentencia);
	}
}else if (isset($_POST['alta'])) {
	$con = mysqli_connect("127.0.0.1:3308","root","","coordinacion_web");

	$cuenta = $_POST['cuenta'];
	$nombre =$_POST['nombre'];  
	$opc_titulo=$_POST['filtro']; 
	$celular=$_POST['celular']; 
	$correo=$_POST['correo']; 
	$carrera=$_POST['carrera'];
	// Generamos el sql que necesitamos
	$sentencia_sql = "INSERT INTO Alumno(Cuenta, Nombre, Carrera, Opcion_titulacion, Correo_e, Telefono) VALUES ('$cuenta','$nombre','$carrera','$opc_titulo','$correo','$celular');";
	//enviamos el sql a la base
	$sentencia_insert = mysqli_query($con,$sentencia_sql);
	if ($sentencia_insert) {
		echo "<script language='javascript'>alert('Registro de alumno correcto');</script>";
	}else{
		echo "<script language='javascript'>alert('UPS, algo salio mal en la sentencia');</script>";
	}
	mysqli_close($con);

}else if (isset($_POST['eliminar'])) {
	$con = mysqli_connect("127.0.0.1:3308","root","","coordinacion_web");

	$cuenta = $_POST['cuenta'];
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
	$con = mysqli_connect("127.0.0.1:3308","root","","coordinacion_web");

	$cuenta = $_POST['cuenta'];
	$nombre =$_POST['nombre'];  
	$opc_titulo=$_POST['opc_titul']; 
	$celular=$_POST['celular']; 
	$correo=$_POST['correo']; 
	// Generamos el sql que necesitamos
	$sentencia_sql = "UPDATE Alumno SET Nombre='$nombre', Opcion_titulacion='$opc_titulo', Telefono='$celular', Correo_e='$correo' WHERE Cuenta = '$cuenta';";
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
		<button id="btn_ver">Visualizar Alumno</button>
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
					<label for="car">
						Carrera:
					</label>
					<input type="text" name="carrera" required id="car">
				</div>
				<div class="elemento">
					<label for="op">
						Opción de Titulación : 
					</label>
					<select name="filtro" id="fil">
						<option value="Tesis">Tesis</option>
						<option value="Servicio Social">Servicio Social</option>
						<option value="Diplomado">Diplomado</option>
						<option value="Maestria">Maestria</option>
						<option value="Seminario">Seminario</option>
						<option value="Trabajo Profecional">Trabajo Profecional</option>
					</select>
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
					<input type="text" name="nombre" required id="nom">
				</div>
				<div class="elemento">
					<label for="titu">
						Opción de Titulación:
					</label>
					<input type="text" name="opc_titul" required id="titu">
				</div>
				<div class="elemento">
					<label for="car">
						Carrera:
					</label>
					<input type="text" name="carrera" required id="car">
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
						Opción de Titulación:
					</label>
					<input type="text" name="opc_titul" required id="titu">
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