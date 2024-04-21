<?php
include_once "funciones.php";
$html = 0;
if(isset($_POST['buscar'])){
	$sentencia;
	$con = mysqli_connect("localhost:3306","root","","coordinacion_web");
	$filtro =mysqli_real_escape_string($con, $_POST['filtro']);
	if ($filtro != '*') {
		$sentencia = "SELECT * FROM Docente WHERE Seccion = '$filtro';";
		$html =_cargar_docentes($con,$sentencia);
	}else{
		$sentencia = "SELECT * FROM Docente;";
		$html =_cargar_docentes($con,$sentencia);
	}
}else if (isset($_POST['alta'])) {
	$con = mysqli_connect("localhost:3306","root","","coordinacion_web");
	
	$num_tdor = mysqli_real_escape_string($con,$_POST['num_tdor']);
	$nombre = mysqli_real_escape_string($con,$_POST['nombre']); 
	$fecha= mysqli_real_escape_string($con,$_POST['fecha']); 
	$rfc= mysqli_real_escape_string($con,$_POST['RFC']); 
	$titulo= mysqli_real_escape_string($con,$_POST['titulo']); 
	$especialidad= mysqli_real_escape_string($con,$_POST['especialidad']); 
	$celular= mysqli_real_escape_string($con,$_POST['celular']); 
	$correo= mysqli_real_escape_string($con,$_POST['correo']); 
	$t_cargos = mysqli_real_escape_string($con,$_POST['t_cargos']);
	$seccion = mysqli_real_escape_string($con,$_POST['seccion']); 
	// Generamos el sql que necesitamos
	$sentencia_sql = "INSERT INTO Docente (Num_trabajador,Nombre_docente,Fecha_ingreso,Rfc, Titulo,Especialidad,Celular,Correo_e,Total_cargos,Seccion) VALUES ('$num_tdor', '$nombre','$fecha','$rfc','$titulo','$especialidad','$celular','$correo','$t_cargos','$seccion');";
	//enviamos el sql a la base
	$sentencia_insert = mysqli_query($con,$sentencia_sql);
	if ($sentencia_insert) {
		echo "<script language='javascript'>alert('Se registro el docente');</script>";
	}else{
		echo "<script language='javascript'>alert('UPS, algo salio mal en la sentencia');</script>";
	}
	mysqli_close($con);

}else if (isset($_POST['eliminar'])) {
	$con = mysqli_connect("localhost:3306","root","","coordinacion_web");

	$num_tdor = mysqli_real_escape_string($con,$_POST['num_t']); 
	// Generamos el sql que necesitamos
	$sentencia_sql = "DELETE FROM Docente WHERE Num_trabajador ='$num_tdor';";
	//enviamos el sql a la base
	$sentencia_delete = mysqli_query($con,$sentencia_sql);
	if ($sentencia_delete) {
		echo "<script language='javascript'>alert('Se elimino el docente');</script>";
	}else{
		echo "<script language='javascript'>alert('UPS, algo salio mal en la sentencia');</script>";
	}
	mysqli_close($con);

}else if (isset($_POST['mod'])) {
	$con = mysqli_connect("localhost:3306","root","","coordinacion_web");

	$num_tdor = mysqli_real_escape_string($con,$_POST['num_t']);
	$nombre = mysqli_real_escape_string($con,$_POST['nombre']);  
	$celular= mysqli_real_escape_string($con,$_POST['celular']); 
	$correo= mysqli_real_escape_string($con,$_POST['correo']); 
	$t_cargos = mysqli_real_escape_string($con,$_POST['t_cargos']);
	$seccion = mysqli_real_escape_string($con,$_POST['seccion']); 
	// Generamos el sql que necesitamos
	$sentencia_sql = "UPDATE Docente SET Nombre_docente='$nombre', Celular='$celular', Correo_e='$correo', Total_cargos='$t_cargos', Seccion='$seccion' WHERE Num_trabajador = '$num_tdor';";
	//enviamos el sql a la base
	$sentencia_update = mysqli_query($con,$sentencia_sql);
	if ($sentencia_update) {
		echo "<script language='javascript'>alert('Se modifico el docente');</script>";
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
	<link rel="stylesheet" type="text/css" href="../css/style_2.css">
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
		<button id="btn_alta">Alta Docente</button>
		<button id="btn_modificar">Modificar Docente</button>
		<button id="btn_eliminar">Eliminar Docente</button>
		<button id="btn_buscar">Buscar Docente</button>
		<button id="btn_regresar">Regresar a Inicio</button>
	</nav>
	<section>
		<h3 id="titulo_padre">Selecciona una opción</h3>
	</section>
	<!--Template  para la pagina-->
	<template id="tmp_form_Adoc">
		<div class="contenedor">
			<form action="docentes.php" method="POST" autocomplete="off">
				<legend>Alta de Docentes</legend>
				<div class="elemento">
					<label for="num_t">
						Numero de trabajador: 
					</label>
					<input type="text" name="num_tdor" required id="num_t">
				</div>
				<div class="elemento">
					<label for="nom">
						Nombre: 
					</label>
					<input type="text" name="nombre" required id="nom">
				</div>
				<div class="elemento">
					<label for="fech">
						Fecha de ingreso:
					</label>
					<input type="text" name="fecha" required id="fech" placeholder="Formato YYYY-MM-DD">
				</div>
				<div class="elemento">
					<label for="rfc">
						RFC Docente: 
					</label>
					<input type="text" name="RFC" required id="rfc">
				</div>
				<div class="elemento">
					<label for="titu">
						Titulo:
					</label>
					<input type="text" name="titulo" required id="titu">
				</div>
				<div class="elemento">
					<label for="esp">
						Especialidad:
					</label>
					<input type="text" name="especialidad" required id="esp">
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
					<label for="total">
						Total de cargos:
					</label>
					<input type="text" name="t_cargos" required id="total">
				</div>
				<div class="elemento">
					<label for="sec">
						Sección:
					</label>
					<input type="text" name="seccion" required id="sec">
				</div>
				<div class="elemento">
					<input type="submit" name="alta" value="Enviar" >
				</div>
			</form>
		</div>
	</template>
	<template id="tmp_form_Edoc">
		<div class="contenedor">
			<form action="docentes.php" method="POST" autocomplete="off" id="form_eli">
				<legend>Eliminar de Docentes</legend>
				<div class="elemento">
					<label for="nom">
						Nombre: 
					</label>
					<input type="text" name="nombre" required id="nom">
				</div>
				<div class="elemento">
					<label for="titu">
						Titulo:
					</label>
					<input type="text" name="titulo" required id="titu">
				</div>
				<div class="elemento">
					<label for="esp">
						Especialidad:
					</label>
					<input type="text" name="especialidad" required id="esp">
				</div>
				<div class="elemento">
					<input type="submit" name="eliminar" value="Enviar" >
					<input type="hidden" name="num_t">
				</div>
			</form>
		</div>
	</template>
	<template id="tmp_form_Mdoc">
		<div class="contenedor">
			<form action="docentes.php" method="POST" autocomplete="off" id="form_mod">
				<legend>Modificación de Docentes</legend>
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
					<label for="total">
						Total de cargos:
					</label>
					<input type="text" name="t_cargos" required id="total">
				</div>
				<div class="elemento">
					<label for="sec">
						Sección:
					</label>
					<input type="text" name="seccion" required id="sec">
				</div>
				<div class="elemento">
					<input type="submit" name="mod" value="Enviar" >
					<input type="hidden" name="num_t">
				</div>
			</form>
		</div>
	</template>
	<?php
	include_once "conexion.php";
	include_once "funciones.php";
	_carga_datos($conn);
	if ($html) {
		print($html);
		echo "<script type='text/javascript' language='javascript'>alert('Ya puedes visualizar los docentes');</script>";
	}
	?>
	<script language="javascript" src="../js/app1.js" type="text/javascript"></script>
</body>
</html>