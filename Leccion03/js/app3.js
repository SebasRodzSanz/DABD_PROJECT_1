//SCRIP DE LA PAGINA DE TRABAJOS 
//constantes
const d = document,
btnAlta = d.getElementById('btn_alta'),
btnModificar = d.getElementById('btn_modificar'),
btnEliminar = d.getElementById('btn_eliminar'),
btnBuscar = d.getElementById('btn_buscar'),
btnRegresar = d.getElementById('btn_regresar'),
titulo_padre = d.getElementById('titulo_padre'),
tmp_form_alta = d.getElementById('tmp_form_Atrab').content,
tmp_form_eliminar = d.getElementById('tmp_form_Etrab').content,
tmp_form_modificar = d.getElementById('tmp_form_Mtrab').content,
tmp_form_buscar = d.getElementById('tmp_form_bus').content,
fragmento = d.createDocumentFragment();
let numero_hijos,clon,info,form_eli, form_mod,nombre;

//funciones
const eliminar_nodo = (nodo)=>{
	numero_hijos = nodo.childElementCount;//cuenta los hijos del nodo
	if (numero_hijos != 0) {
		//Si el numero de hijos es dif de cero elimina el hijo para evitar que se acumulen los hijos
		console.log(numero_hijos);
		titulo.removeChild(titulo.children[0]);
	}
}
//Eventos
btnRegresar.addEventListener('click',(e)=>{
    d.location.href = "../index.html";
});;
btnAlta.addEventListener('click',(e)=>{
    titulo_padre.textContent = 'Introduce los datos del trabajo';
    eliminar_nodo(titulo_padre);

    clon = tmp_form_alta.cloneNode(true);
    fragmento.appendChild(clon);
    titulo_padre.appendChild(fragmento);
});
btnBuscar.addEventListener('click',(e)=>{
    titulo_padre.textContent = 'Ingresa los datos solicitados';
    eliminar_nodo(titulo_padre);

    clon = tmp_form_buscar.cloneNode(true);
    fragmento.appendChild(clon);
    titulo_padre.appendChild(fragmento);
});
d.addEventListener('DOMContentLoaded',(e)=>{
    info = d.getElementById('trab_info_uno') || d.getElementById('sinodal_info');
    if(info){
        titulo_padre.textContent='Información de los trabajos de titulación';
        eliminar_nodo(titulo_padre);

        clone = info.content.cloneNode(true);
        fragmento.appendChild(clone);
        titulo_padre.appendChild(fragmento);
    }else{
        console.log('no se ha enviado info sobre los trabajos ');
    }
});
btnModificar.addEventListener('click',(e)=>{
	titulo_padre.textContent = 'Si no observa los datos del trabajo seleccione uno';
	eliminar_nodo(titulo_padre);
	clon = tmp_form_modificar.cloneNode(true);
	fragmento.appendChild(clon);
	titulo_padre.appendChild(fragmento);
});
btnEliminar.addEventListener('click',(e)=>{
	titulo_padre.textContent = 'Si no observa los datos del trabajo seleccione uno';
	eliminar_nodo(titulo_padre);
	clon = tmp_form_eliminar.cloneNode(true);
	fragmento.appendChild(clon);
	titulo_padre.appendChild(fragmento);
});
d.addEventListener('click',(e)=>{
    if (e.target.matches('#seleccion')) {
        form_eli = tmp_form_eliminar.querySelector('#form_eli');
        form_mod = tmp_form_modificar.querySelector('#form_mod');

        //llenar el formulario de eliminar
        form_eli.clave.value = e.target.dataset.clv;
        form_eli.titulo.value = e.target.dataset.titulo;
        form_eli.fecha_r.value = e.target.dataset.fech;

         //llenar el formulario de modificar
         form_mod.clave.value = e.target.dataset.clv;
         form_mod.titulo.value = e.target.dataset.titulo;
         form_mod.fecha_r.value = e.target.dataset.fech;
         form_mod.encargado.value = e.target.dataset.nom;
         form_mod.activo.value = e.target.dataset.activo;

        nombre =  e.target.dataset.titulo;
		alert(`Ya puedes modificar o eliminar el trabajo ${nombre} con su respectivo boton`);
    }
});