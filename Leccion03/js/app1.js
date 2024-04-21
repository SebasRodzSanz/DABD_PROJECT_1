//constantes
const d = document,
titulo = d.getElementById('titulo_padre'),
tmp_form_alta = d.getElementById('tmp_form_Adoc').content,
tmp_buscar = d.getElementById('tmp_form_bus').content,
tmp_form_mod = d.getElementById('tmp_form_Mdoc').content,
tmp_form_eli = d.getElementById('tmp_form_Edoc').content,
btn_alta = d.getElementById('btn_alta'),
btn_reg = d.getElementById('btn_regresar'),
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
	titulo.textContent = 'Ingresa los datos del docente';
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

d.addEventListener('DOMContentLoaded',(e)=>{
	info = d.getElementById('doc_info');
	if (info) {
		titulo.textContent ='Docentes dados de alta';
		eliminar_nodo(titulo);
		clon = info.content.cloneNode(true);
		fragmento.appendChild(clon);
		titulo.appendChild(fragmento);
	}
})
d.addEventListener('click',(e)=>{
	if (e.target.matches('#seleccion')) {
		 form_mod = tmp_form_mod.querySelector('#form_mod'); 
		 form_eli = tmp_form_eli.querySelector('#form_eli');

		//Llenar el  formulario modificar
		form_mod.celular.value = e.target.dataset.cel;
		form_mod.correo.value = e.target.dataset.cor;
		form_mod.t_cargos.value =e.target.dataset.totalc ;
		form_mod.seccion.value = e.target.dataset.sec;
		form_mod.nombre.value = e.target.dataset.nom;
		form_mod.num_t.value = e.target.dataset.num;

		//Llenar el  formulario eliminar
		form_eli.especialidad.value = e.target.dataset.esp;
		form_eli.titulo.value = e.target.dataset.titul;
		form_eli.nombre.value = e.target.dataset.nom;
		form_eli.num_t.value = e.target.dataset.num;

		let nombre =  e.target.dataset.nom;

		alert(`Ya puedes modificar o eliminar de ${nombre} con su respectivo boton`);
	}
});
btn_mod.addEventListener('click',(e)=>{
	titulo.textContent = 'Si no observa los datos del docente seleccione uno';
	eliminar_nodo(titulo);
	clon = tmp_form_mod.cloneNode(true);
	fragmento.appendChild(clon);
	titulo.appendChild(fragmento);
});
btn_eli.addEventListener('click',(e)=>{
	titulo.textContent = 'Si no observa los datos del docente seleccione uno';
	eliminar_nodo(titulo);
	clon = tmp_form_eli.cloneNode(true);
	fragmento.appendChild(clon);
	titulo.appendChild(fragmento);
});