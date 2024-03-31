<?php
function _carga_datos ($con){
	$sentencia_sql ="SELECT DISTINCT Seccion FROM Docente;";
	$sentencia_select = mysqli_query($con,$sentencia_sql);
	if ($sentencia_select) {
		$num_secction = mysqli_num_rows($sentencia_select);//Contamos las renglones
		if($num_secction != 0){
			//Si hay secciones
			$html = <<<EOT
				<template id="tmp_form_bus">
					<div class="contenedor">
						<form action="docentes.php" method="POST" autocomplete="off">
							<div class="elemento">
								<label for="fil">Selecciona una sección: </label>
								<select name="filtro" id="fil">
								<option value="*">Todos</option>
			EOT;
			while($reg = mysqli_fetch_array($sentencia_select,MYSQLI_ASSOC)){
				$html .= "<option value ='{$reg['Seccion']}'> {$reg['Seccion']}</option>";
			}
			$html .= <<<EOT
							</select>
							</div>
							<div class="elemento">
								<input type="submit" name="buscar" value="Enviar" >
							</div>
						</form>
					</div>
				</template>
			EOT;
			echo $html;
		}else{
			//no hay secciones
			$_no_html = <<<EOT
				<template id="tmp_form_bus">
					<div class="contenedor">
						<form action="docentes.php" method="POST" autocomplete="off">
							<div class="elemento">
								<label for="fil">Selecciona una sección: </label>
								<select name="filtro" id="fil">
									<option value="*">Todos</option>
								</select>
							</div>
							<div class="elemento">
								<input type="submit" name="buscar" value="Enviar" >
							</div>
						</form>
					</div>
				</template>
			EOT;
			echo $_no_html;
		}
	}else{
		//Fallo de sentencia 
		echo "<script type='text/javascript' language='javascript'> alert('fallo en la sentencia ');</script>";
		$_no_html = <<<EOT
				<template id="tmp_form_bus">
					<div>
						<h2>Fallo critico en la conexión de la base de datos</h2>
					</div>
				</template>
			EOT;
			echo $_no_html;
	}
	mysqli_close($con);
}

function _cargar_docentes ($con,$sentencia_sql){
	$sentencia_select = mysqli_query($con,$sentencia_sql);
	if($sentencia_select){
		$html = <<<EOT
			<template id="doc_info">
				<div id="docente_cont">
		EOT;
		while($reg = mysqli_fetch_array($sentencia_select,MYSQLI_ASSOC)){
			$html .= <<<EOT
			<div class="contenedor_d">
				<div class="nombre">
					<h3>{$reg['Nombre_docente']}</h3>
					<hr>
				</div>
				<div class="info">
					<p>Numero de trabajador: {$reg['Num_trabajador']}</p>
					<p>Rcf: {$reg['Rfc']}</p>
					<p>Titulo: {$reg['Titulo']}</p>
					<p>Especialidad: {$reg['Especialidad']}</p>
					<p>Sección: {$reg['Seccion']}</p>
					<p>Correo Electronico: {$reg['Correo_e']}</p>
					<p>Celular: {$reg['Celular']}</p>
					<p>Antiguedad: Pendiente</p>
				</div>
				<div class="total">
					<p>Total de cargos</p>
					<p>#{$reg['Total_cargos']}</p>
				</div>
				<div>
					<button id='seleccion' data-num='{$reg['Num_trabajador']}' data-sec='{$reg['Seccion']}' data-cor='{$reg['Correo_e']}' data-cel='{$reg['Celular']}' data-totalc='{$reg['Total_cargos']}' data-nom='{$reg['Nombre_docente']}' data-titul='{$reg['Titulo']}' data-esp='{$reg['Especialidad']}'>
						Seleccionar
					</button>
				</div>
			</div>
			EOT;
		}
		$html .= <<<EOT
		</div>
		</template>
		EOT;
		mysqli_close($con);
		return $html;
	}else{
		echo "<script type='text/javascript' language='javascript'> alert('fallo en la sentencia ');</script>";
	}
	mysqli_close($con);
}
function _carga_datos_bus ($con){
	$sentencia_sql ="SELECT DISTINCT Opcion_titulacion FROM Alumno;";
	$sentencia_select = mysqli_query($con,$sentencia_sql);
	if ($sentencia_select) {
		$num_opc = mysqli_num_rows($sentencia_select);//Contamos las renglones
		if($num_opc != 0){
			//Si hay secciones
			$html = <<<EOT
				<template id="tmp_form_bus">
					<div class="contenedor">
						<form action="alumno.php" method="POST" autocomplete="off">
							<div class="elemento">
								<label for="fil">Selecciona una opción de titulación: </label>
								<select name="filtro" id="fil">
								<option value="*">Todos</option>
			EOT;
			while($reg = mysqli_fetch_array($sentencia_select,MYSQLI_ASSOC)){
				$html .= "<option value ='{$reg['Opcion_titulacion']}'> {$reg['Opcion_titulacion']}</option>";
			}
			$html .= <<<EOT
							</select>
							</div>
							<div class="elemento">
								<input type="submit" name="buscar" value="Enviar" >
							</div>
						</form>
					</div>
				</template>
			EOT;
			echo $html;
		}else{
			//no hay secciones
			$_no_html = <<<EOT
				<template id="tmp_form_bus">
					<div class="contenedor">
						<form action="alumno.php" method="POST" autocomplete="off">
							<div class="elemento">
								<label for="fil">Selecciona una opción de titulación: </label>
								<select name="filtro" id="fil">
									<option value="*">Todos</option>
								</select>
							</div>
							<div class="elemento">
								<input type="submit" name="buscar" value="Enviar" >
							</div>
						</form>
					</div>
				</template>
			EOT;
			echo $_no_html;
		}
	}else{
		//Fallo de sentencia 
		echo "<script type='text/javascript' language='javascript'> alert('fallo en la sentencia ');</script>";
		$_no_html = <<<EOT
				<template id="tmp_form_bus">
					<div>
						<h2>Fallo critico en la conexión de la base de datos</h2>
					</div>
				</template>
			EOT;
			echo $_no_html;
	}
	mysqli_close($con);
}
function _cargar_alumnos ($con,$sentencia_sql){
	$sentencia_select = mysqli_query($con,$sentencia_sql);
	if($sentencia_select){
		$html = <<<EOT
			<template id="alu_info">
				<div id="alumno_cont">
		EOT;
		while($reg = mysqli_fetch_array($sentencia_select,MYSQLI_ASSOC)){
			$html .= <<<EOT
			<div class="contenedor_d">
				<div class="nombre">
					<h3>{$reg['Nombre']}</h3>
					<hr>
				</div>
				<div class="info">
					<p>Numero de Cuenta: {$reg['Cuenta']}</p>
					<p>Carrera : {$reg['Carrera']}</p>
					<p>Opción de Titulación: {$reg['Opcion_titulacion']}</p>
					<p>Correo Electronico: {$reg['Correo_e']}</p>
					<p>Celular: {$reg['Telefono']}</p>
				</div>
				<div>
					<button id='seleccion' data-cuenta='{$reg['Cuenta']}'  data-cor='{$reg['Correo_e']}' data-cel='{$reg['Telefono']}'  data-nom='{$reg['Nombre']}' data-op_titul='{$reg['Opcion_titulacion']}' data-carrera='{$reg['Carrera']}'>
						Seleccionar
					</button>
				</div>
			</div>
			EOT;
		}
		$html .= <<<EOT
		</div>
		</template>
		EOT;
		mysqli_close($con);
		return $html;
	}else{
		echo "<script type='text/javascript' language='javascript'> alert('fallo en la sentencia ');</script>";
	}
	mysqli_close($con);
}

?>