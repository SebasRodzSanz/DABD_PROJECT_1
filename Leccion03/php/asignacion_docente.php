<?php
include_once "conexion.php";
include_once "funciones.php";
$html = 0;
if (isset($_POST['alta']) && isset($_POST['alumno'])) {
	$clave= mysqli_real_escape_string($conn,$_POST['clave']); 
	$alumno = mysqli_real_escape_string($conn,$_POST['alumno']);

	// Generamos el sql que necesitamos
	$sentencia_sql = "UPDATE Alumno SET Folio = '$clave' WHERE Cuenta ='$alumno' ";
	//enviamos el sql a la base
	$sentencia_insert = mysqli_query($conn,$sentencia_sql);
	if ($sentencia_insert) {
		echo "<script language='javascript'>alert('Se asigno el trabajo al alumno');</script>";
	}else{
		echo "<script language='javascript'>alert('UPS, algo salio mal en la sentencia');</script>";
	}
}else  if(isset($_POST['alta']) && isset($_POST['docente'])){
	$clave= mysqli_real_escape_string($conn,$_POST['clave']);
	$categoria= mysqli_real_escape_string($conn,$_POST['categoria']);
	$docente = mysqli_real_escape_string($conn,$_POST['docente']);

	// Generamos el sql que necesitamos
	$sentencia_sql = "INSERT INTO Detalle(Num_trabajador,Clave_trabajo,Categoria) VALUES('$docente','$clave','$categoria');";
	//enviamos el sql a la base
	$sentencia_insert = mysqli_query($conn,$sentencia_sql);
	if ($sentencia_insert) {
		echo "<script language='javascript'>alert('Se asigno un sinodal al trabajo: $clave');</script>";
	}else{
		echo "<script language='javascript'>alert('UPS, algo salio mal en la sentencia');</script>";
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Coordinación Administración</title>
	<link rel="stylesheet" type="text/css" href="../css/style_4.css">
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
		<button id="btn_regresar">Regresar a Inicio</button>
	</nav>
	<?php
	$html = <<<EOT
	<div class="informacion">
	<div id="docente">
	<form action="#" method="POST">
	<legend>Selecciona un docente</legend>
	<div class="seleccion">
	<select id="select_docente" name="sel">
	<option>Selecciona un docente</option>
	EOT;
	$script =<<<EOT
	<script type='text/javascript' language='javascript'> 
		var arreglo_alumn=[];
		var arreglo_docen=[];
		let alumno, docente;
	EOT;
	$c = 0;
	$sentencia_sql1 = "SELECT * FROM Alumno;";
	$sentencia_sql2 = "SELECT Num_trabajador, Nombre_docente,Titulo,Especialidad,Total_cargos FROM Docente;";

	$sentencia_select1 = mysqli_query($conn,$sentencia_sql1);
	$sentencia_select2 = mysqli_query($conn,$sentencia_sql2);
	if($sentencia_select1 && $sentencia_select2){
		$num1 = mysqli_num_rows($sentencia_select1);
		$num2 = mysqli_num_rows($sentencia_select2);
		if($num1 !=0  && $num2 != 0){
			//si hay alumnos y doceentes : si se pueden relacionar
			while($reg = mysqli_fetch_array($sentencia_select2,MYSQLI_ASSOC)){
				$html .= "<option data-id='$c'> {$reg['Nombre_docente']}</option>";
				$script .=<<<EOT
				docente ={
					Id_js:"{$c}",
					Num:"{$reg['Num_trabajador']}",
					Nombre:"{$reg['Nombre_docente']}",
					Especialidades:"{$reg['Especialidad']}",
					Titulo:"{$reg['Titulo']}",
					Num_cargos:"{$reg['Total_cargos']}",
				}
				arreglo_docen[{$c}]=docente;
				EOT;
				$c++;
			}
			$html .=<<<EOT
			</select>
			</div>
			</form>
			<p id="nodo_d"></p>
			</div>
			<div id="alumno">
			<form action="#" method="POST">
				<legend>Selecciona un alumno</legend>
				<div class="seleccion">
					<select id="select_alumno" name="sel">
					<option>Selecciona un alumno</option>
			EOT;
			$c=0;
			while($reg2 = mysqli_fetch_array($sentencia_select1,MYSQLI_ASSOC)){
				$html .= "<option data-id='{$c}'> {$reg2['Nombre']}</option>";
				$script .=<<<EOT
				alumno={
					Id_js:"{$c}",
					Cuenta:"{$reg2['Cuenta']}",
					Nombre:"{$reg2['Nombre']}",
					Folio:"{$reg2['Folio']}",
					Correo:"{$reg2['Correo_e']}",
					Telefono:"{$reg2['Telefono']}"
				}
				arreglo_alumn[{$c}]= alumno;
				EOT;
				$c++;
			}
			$script .= "</script>";
			$html .= <<<EOT
			</select>
			</div>
			</form>
			<p id="nodo_a"></p>
			</div>
			</div>
			EOT;
			echo $html;
			echo $script;
			mysqli_close($conn);
		}else{
			//no hay alumnos y docentes : no se pueden relacionar
			$_no_html = <<<EOT
			<template id="tmp_form_Atrab">
				<div class="contenedor">
					<h2>Tienes que dar de alta un alumno y un docente</h2>
				</div>
			</template>	
			EOT;
			echo $_no_html;
			mysqli_close($conn);
		}
	}else{
		echo "<script type='text/javascript' language='javascript'> alert('fallo en la sentencia ');</script>";
	}
	?>
    <div class="formulario">
        <div class="contenido">
        <form action="asignacion_docente.php" method="POST" autocomplete="off" id='form_alta'>
            <legend>Formulario Asignación de Trabajo y Asignación de Sinodal</legend>
            <div class="elemento">
				<label for="clv">
					Clave del Trabajo: 
				</label>
				<input type="text" name="clave" required id="clv">
			</div>
			<div class="elemento">
				<label for="docentes">Docentes:</label>
				<input type="checkbox" value="1" id='des_doc'>
                <input type="text" name="docente" required id="docentes">
            </div>
            <div class="elemento">
				<label for="alumnos">Alumno:</label>
				<input type="checkbox" value="1" id='des_alu'>
                <input type="text" name="alumno" required id="alumnos">
            </div>
            <div class="elemento">
				<label for="categ">
					Categoria del docente:
				</label>
				<input type="checkbox" value="1" id='des_cate'>
				<input type="text" name="categoria" required id="categ">
			</div>
			<div class="elemento">
				<input type="submit" name="alta" value="Enviar" >
			</div>
        </form>
        </div>
    </div>
	<template id="tarjeta_alumno">
		<div id="tarjeta">
        	<h3>Nombre alumno</h3>
        	<hr>
        	<p>Cuenta</p>
        	<p>Folio</p>
        	<p>Correo</p>
        	<p>Telefono</p>
        	<button class="seleccion_alum">Seleccionar</button>
    	 </div>
	</template>
	<template id="tarjeta_docente">
		<div id="tarjeta">
            <h3>Nombre Docente</h3>
            <hr>
            <p>Num trabajador</p>
            <p>Titulo</p>
            <p>Lista de especialidades:</p>
            <p>Num cargos</p>
            <button class="seleccion_docen">Seleccionar</button>
        </div>
	</template>
	<script language="javascript" src="../js/app4.js" type="text/javascript"></script>
</body>
</html>