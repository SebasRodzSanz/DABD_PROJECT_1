//constantes
const d = document,
titulo = d.getElementById('titulo_padre'),
tmp_form_alta = d.getElementById('tmp_form_Aalum').content,
tmp_buscar = d.getElementById('tmp_form_bus').content,
tmp_form_mod = d.getElementById('tmp_form_Malum').content,
tmp_form_eli = d.getElementById('tmp_form_Ealum').content,
btn_alta = d.getElementById('btn_alta'),
btn_reg = d.getElementById('btn_regresar'),
btn_visualizar = d.getElementById('btn_ver'),
btn_mod = d.getElementById('btn_modificar'),
btn_eli = d.getElementById('btn_eliminar'),
fragmento = d.createDocumentFragment();
let numero_hijos,clon,info,form_eli, form_mod;

//console.log
//console.log('hola mundo');
//console.log(titulo);

//funciones
const eliminar_nodo = (nodo)=>{
	numero_hijos = nodo.childElementCount;//cuenta los hijos del nodo
	if (numero_hijos != 0) {
		//Si el numero de hijos es dif de cero elimina el hijo para evitar que se acumulen los hijos
		console.log(numero_hijos);
		titulo.removeChild(titulo.children[0]);
	}
}
//eventos
btn_alta.addEventListener('click', (e)=>{
	titulo.textContent = 'Ingresa los datos del alumno';
	eliminar_nodo(titulo);	
	clon = tmp_form_alta.cloneNode(true);
	fragmento.appendChild(clon);
	titulo.appendChild(fragmento);
});
btn_buscar.addEventListener('click',(e)=>{
	titulo.textContent = 'Selecciona una opción';
	eliminar_nodo(titulo);	
	clon = tmp_buscar.cloneNode(true);
	fragmento.appendChild(clon);
	titulo.appendChild(fragmento);
});
btn_reg.addEventListener('click', (e)=>{
	d.location.href = "../index.html";
	//Regresamos a la pagina de inicio
});
btn_visualizar.addEventListener('click', (e)=>{
	info = d.getElementById('alu_info');
	if (info) {
		titulo.textContent ='Alumnos dados de alta';
		eliminar_nodo(titulo);
		clon = info.content.cloneNode(true);
		fragmento.appendChild(clon);
		titulo.appendChild(fragmento);
	}else {
		alert('Selecciona una opción en buscar alumno y envia la petición');
	}
});
d.addEventListener('click',(e)=>{
	if (e.target.matches('#seleccion')) {
		 form_mod = tmp_form_mod.querySelector('#form_mod'); 
		 form_eli = tmp_form_eli.querySelector('#form_eli');

		//Llenar el  formulario modificar
		form_mod.celular.value = e.target.dataset.cel;
		form_mod.correo.value = e.target.dataset.cor;
		form_mod.nombre.value = e.target.dataset.nom;
		form_mod.opc_titul.value = e.target.dataset.op_titul;
		form_mod.cuenta.value = e.target.dataset.cuenta;
		

		//Llenar el  formulario eliminar
		form_eli.carrera.value = e.target.dataset.carrera;
		form_eli.nombre.value = e.target.dataset.nom;
		form_eli.opc_titul.value = e.target.dataset.op_titul;
		form_eli.cuenta.value = e.target.dataset.cuenta;

		let nombre =  e.target.dataset.nom;

		alert(`Ya puedes modificar o eliminar de ${nombre} con su respectivo boton`);
	}
});
btn_mod.addEventListener('click',(e)=>{
	titulo.textContent = 'Si no observa los datos del alumno seleccione uno';
	eliminar_nodo(titulo);
	clon = tmp_form_mod.cloneNode(true);
	fragmento.appendChild(clon);
	titulo.appendChild(fragmento);
});
btn_eli.addEventListener('click',(e)=>{
	titulo.textContent = 'Si no observa los datos del alumno seleccione uno';
	eliminar_nodo(titulo);
	clon = tmp_form_eli.cloneNode(true);
	fragmento.appendChild(clon);
	titulo.appendChild(fragmento);
});