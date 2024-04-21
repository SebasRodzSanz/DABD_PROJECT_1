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
function __listaEspecialidades($lista){
	$html;
	$arreglo = explode(',',$lista);
	$num_esp = count($arreglo);
	if($num_esp > 1){
		$html = "<ol>";
		for($c=0; $c<$num_esp;$c++){
			$html .= "<li>".$arreglo[$c]."</li>";
		}
		$html .="</ol>";
	}else{
		$html = <<<EOT
		<ol>
			<li>$arreglo[0]</li>
		</ol>
		EOT;
	}
	return $html;
}
function _antiguedad($fecha_ingreso){
	// funcion date para obtener la fecha actual date('Y-m-d') es el  formato de mysql

	$arreglo = explode('-',$fecha_ingreso);//separa la una cadena de texto según el simbolo
	$valor1 = intval($arreglo[0]);// convertimos la cadena a un numero entero

	$valor2 = intval(date('Y'));//obtenemos la fecha actual y la convertimos a un numero entero

	return ($valor2 - $valor1);
}

function _cargar_docentes ($con,$sentencia_sql){
	$sentencia_select = mysqli_query($con,$sentencia_sql);
	if($sentencia_select){
		$num_secction = mysqli_num_rows($sentencia_select);//Contamos las renglones
		if($num_secction != 0){
				$html = <<<EOT
				<template id="doc_info">
					<div id="docente_cont">
			EOT;
			while($reg = mysqli_fetch_array($sentencia_select,MYSQLI_ASSOC)){
				$fecha = _antiguedad($reg['Fecha_ingreso']);
				$especialidad = __listaEspecialidades($reg['Especialidad']);
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
						<p>Especialidad: {$especialidad}</p>
						<p>Sección: {$reg['Seccion']}</p>
						<p>Correo Electronico: {$reg['Correo_e']}</p>
						<p>Celular: {$reg['Celular']}</p>
						<p>Antiguedad: {$fecha}</p>
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
			$html = <<<EOT
			<template id="doc_info">
					<div id="docente_cont">
						<h3>No hay docentes en la base de datos </h3>
					</div>
			</template>
			EOT;
			mysqli_close($con);
			return $html;
		}
	}else{
		echo "<script type='text/javascript' language='javascript'> alert('fallo en la sentencia ');</script>";
	}
	mysqli_close($con);
}
function _carga_datos_bus (){
	//Imprime el formulario para la busqueda del un alumno por Numero de cuenta
	$html = <<<EOT
	<template id="tmp_form_bus">
		<div class="contenedor">
			<form action="alumno.php" method="POST" autocomplete="off">
				<div class="elemento">
					<label for="fil">Introduce el numero de cuenta: </label>
					<input type='text' name="filtro" id="fil" placeholder='Si quieres visualizar todos los alumnos escribe el simbolo *'>
				</div>
				<div class="elemento">
					<input type="submit" name="buscar" value="Enviar" >
				</div>
			</form>
		</div>
	</template>
	EOT;
	echo $html;
}

function _cargar_alumnos ($con,$sentencia_sql){
	$sentencia_select = mysqli_query($con,$sentencia_sql);
	if($sentencia_select){
		$num_secction = mysqli_num_rows($sentencia_select);//Contamos las renglones
		if($num_secction != 0){
			$html = <<<EOT
				<template id="alu_info">
					<div id="alumno_cont">
			EOT;
			while($reg = mysqli_fetch_array($sentencia_select,MYSQLI_ASSOC)){
				 $folio = (gettype($reg['Folio']) == 'NULL') ? 'Ninguno' : $reg['Folio'];
				$html .= <<<EOT
				<div class="contenedor_d">
					<div class="nombre">
						<h3>{$reg['Nombre']}</h3>
						<hr>
					</div>
					<div class="info">
						<p>Numero de Cuenta: {$reg['Cuenta']}</p>
						<p>Folio de trabajo: {$folio}</p>
						<p>Correo Electronico: {$reg['Correo_e']}</p>
						<p>Celular: {$reg['Telefono']}</p>
					</div>
					<div>
						<button id='seleccion' data-cuenta='{$reg['Cuenta']}'  data-cor='{$reg['Correo_e']}' data-cel='{$reg['Telefono']}'  data-nom='{$reg['Nombre']}' data-folio='{$folio}'>
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
			$html = <<<EOT
			<template id="alu_info">
					<div id="alumno_cont">
						<h3>No hay Alumnos en la base de datos </h3>
					</div>
			</template>
			EOT;
			mysqli_close($con);
			return $html;
		}
	}else{
		echo "<script type='text/javascript' language='javascript'> alert('fallo en la sentencia ');</script>";
	}
	mysqli_close($con);
}
function _cargar_trabajos ($con,$sentencia_sql){
	$sentencia_select = mysqli_query($con,$sentencia_sql);
	if($sentencia_select){
		$num_secction = mysqli_num_rows($sentencia_select);//Contamos las renglones
		if($num_secction != 0){
			//Si hay trabajos en la base de datos 
			$html = <<<EOT
			<template id="trab_info_uno">
				<div id="contenedor_trab">
				<table>
					<caption>Trabajos de Titulación</caption>
					<thead>
						<th>Clave</th>
						<th>Titulo</th>
						<th>Fecha de registro</th>
						<th>Encargado</th>
						<th>Activo</th>
						<th>Seleccionar</th>
						<th>Sinodales y Alumno</th>
					</thead>
					<tbody>
			EOT;
			while($reg = mysqli_fetch_array($sentencia_select,MYSQLI_ASSOC)){
				$act = ($reg['Activo'] == '1') ? 'SI': 'NO' ;
				$html .= <<<EOT
				<tr>
					<td>{$reg['Clave']}</td>
					<td>{$reg['Titulo']}</td>
					<td>{$reg['Fecha_registro']}</td>
					<td>{$reg['Encargado']}</td>
					<td>{$act}</td>
					<td>
					<button data-clv='{$reg['Clave']}' data-titulo='{$reg['Titulo']}' data-fech='{$reg['Fecha_registro']}' data-nom='{$reg['Encargado']}' data-activo='{$act}' id="seleccion">
					Seleccionar
					</button>
					</td>
					<td>
					<form action='Trabajos.php' method="POST">
					<input type='submit' class='btn-tabla' value='Solicitar' name="sinodal">
					<input type='hidden' name ='clave_trab' value='{$reg['Clave']}'>
					</form>
					</td>
				</tr>
				EOT;
			}
			$html .= <<<EOT
			</tbody>
			</table>
			</div>
			</template>
			EOT;
			mysqli_close($con);
			return $html;
		}else{
			$html = <<<EOT
			<template id="trab_info_uno">
					<div id="trabajo_cont">
						<h3>No hay trabajos en la base de datos</h3>
					</div>
			</template>
			EOT;
			mysqli_close($con);
			return $html;
		}
	}else{
		echo "<script type='text/javascript' language='javascript'> alert('fallo en la sentencia ');</script>";
	}
	mysqli_close($con);
}
function _cargar_sinodal($conn,$clave){
	$sentencia_sql = " SELECT Alumno.Nombre, Docente.Nombre_docente, Trabajo.Titulo,Trabajo.Clave, Detalle.Categoria FROM 
	Trabajo INNER JOIN Detalle ON Trabajo.Clave = Detalle.Clave_trabajo
	INNER JOIN Docente ON Docente.Num_trabajador = Detalle.Num_trabajador
	INNER JOIN alumno ON Alumno.Folio = Trabajo.Clave
	WHERE Trabajo.Clave = '$clave' ORDER BY Alumno.Nombre;
	";
	$sentencia_select = mysqli_query($conn,$sentencia_sql);
	if($sentencia_select){
		$num_ren = mysqli_num_rows($sentencia_select);//Contamos las renglones
		if($num_ren != 0){
			//Si hay trabajos en la base de datos 
			$html = <<<EOT
			<template id="sinodal_info">
				<div id="contenedor_trab">
				<table>
					<caption>Sinodales Asignados</caption>
					<thead>
						<th>Clave</th>
						<th>Titulo</th>
						<th>Alumno</th>
						<th>Docente</th>
						<th>Categoria</th>
					</thead>
					<tbody>
			EOT;
			$nom=''; $titul='';$clav='';
			while($reg = mysqli_fetch_array($sentencia_select,MYSQLI_ASSOC)){
				if($clav != $reg['Clave']){
					$clav = $reg['Clave'];
					$html .="<tr> <td rowspan='{$num_ren}'>{$clav}</td>";
				} else{$html .= "<tr> ";}
				if($titul != $reg['Titulo']){
					$titul = $reg['Titulo'];
					$html .= "<td rowspan='{$num_ren}'>{$titul}</td>";
				} //else{$html .= "<td></td>";}
				if($nom != $reg['Nombre']){
					$nom = $reg['Nombre'];
					$html .= "<td>{$nom}</td>";
				}else{$html .= "<td></td>";}
				$html .= <<<EOT
					<td>{$reg['Nombre_docente']}</td>
					<td>{$reg['Categoria']}</td>
				</tr>
				EOT;
			}
			$html .= <<<EOT
			</tbody>
			</table>
			</div>
			</template>
			EOT;
			mysqli_close($conn);
			return $html;
		}else{
			$html = <<<EOT
			<template id="sinodal_info">
					<div id="trabajo_cont">
						<h3>El trabajo seleccionado no tiene sinodales asignados ni alumno asignado</h3>
					</div>
			</template>
			EOT;
			mysqli_close($conn);
			return $html;
		}
	}else{
		echo "<script type='text/javascript' language='javascript'> alert('fallo en la sentencia ');</script>";
	}
	mysqli_close($conn);
}
function _carga_datos_bus_d (){
	//Imprime el formulario para la busqueda del un alumno por Numero de cuenta
	$html = <<<EOT
	<template id="tmp_form_bus">
		<div class="contenedor">
			<form action="Trabajos.php" method="POST" autocomplete="off">
				<div class="elemento">
					<label for="fil">Introduce la clave del trabajo: </label>
					<select name="filtro">
						<option value="N">Selecciona una opción</option>
						<option value="*">Todos</option>
						<option value="1">Activo</option>
						<option value="0">No Activo</option>
					</select>
				</div>
				<div class="elemento">
				<label>Clave del trabajo: <label>
				<input type="text" name="clv" placeholder="Ejem. TE1">
				</div>
				<div class="elemento">
					<input type="submit" name="buscar" value="Enviar" >
				</div>
			</form>
		</div>
	</template>
	EOT;
	echo $html;
}
//<input type='text' name="filtro" id="fil" placeholder='Si quieres visualizar todos los trabajos escribe el simbolo *'>
function __conversion_activo ($valor){
	if($valor == "SI"){
		return "1";#SI
	}else{
		return "0";#NO
	}
}
function _docentes_alumnos ($con){
	
}


?>