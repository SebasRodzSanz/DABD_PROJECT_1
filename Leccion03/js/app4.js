// constantes
const d = document,
tmp_tarj_alum = d.getElementById('tarjeta_alumno').content,
tmp_tarj_doc = d.getElementById('tarjeta_docente').content,
docente_nodo = d.getElementById('nodo_d'),
alumno_nodo = d.getElementById('nodo_a'),
select_d = d.getElementById('select_docente'),
select_a = d.getElementById('select_alumno'),
checkbox_doc =  d.getElementById('des_doc'),
checkbox_alu =  d.getElementById('des_alu'),
checkbox_cat =  d.getElementById('des_cate'),
btn_regresar = d.getElementById('btn_regresar'),
form = d.getElementById('form_alta'),
fragmento = d.createDocumentFragment();
let indexOption, opcion, id, alumno_d, docente_d, clon, 
esp, lista_padre, texto, nodo_hijo;

console.log(checkbox_doc);

// funciones
const eliminar_nodo = (nodo)=>{
	numero_hijos = nodo.childElementCount;//cuenta los hijos del nodo
	if (numero_hijos != 0) {
		//Si el numero de hijos es dif de cero elimina el hijo para evitar que se acumulen los hijos
		// console.log(numero_hijos);
		nodo.removeChild(nodo.children[0]);
	}
}
const buscar_alumno = (id)=>{
    for (const alumno in arreglo_alumn) {
        if(arreglo_alumn[alumno].Id_js == id){
            return arreglo_alumn[alumno];
        }
    }
}
const buscar_docente = (id)=>{
    for (const docente in arreglo_docen) {
        if(arreglo_docen[docente].Id_js == id){
            return arreglo_docen[docente];
        }
    }
}
const lista_especialidades =(cadena)=>{
    let arregloEspecialidad = cadena.split(',');
    lista_padre = d.createElement('ol'); //Creamos una lista ordenada
    if(arregloEspecialidad.length != 1){
        for (let c = 0; c < arregloEspecialidad.length; c++) {
             nodo_hijo = d.createElement('li');//Creamos una opcion de la lista
            texto = d.createTextNode(arregloEspecialidad[c]);//creamos un texto para el li
            nodo_hijo.append(texto);//agregamos el texto al li
            lista_padre.appendChild(nodo_hijo);
        }
        clon = lista_padre.cloneNode(true);
        fragmento.appendChild(clon);
        return fragmento;//regresamos el fragmento listo para agregar
    }
    nodo_hijo = d.createElement('li');
    texto = d.createTextNode(arregloEspecialidad[0]);
    nodo_hijo.append(texto);
    lista_padre.appendChild(nodo_hijo);
    clon = lista_padre.cloneNode(true);
    fragmento.appendChild(clon);
    return fragmento;
}
// eventos
select_a.addEventListener('change',(e)=>{
    indexOption = e.target.selectedIndex;//guardamos el indice del option
    if(indexOption !=  0){
         eliminar_nodo(alumno_nodo);
         opcion = e.target.options[indexOption];//seleccionamos el option que seleccionamos
         id = opcion.dataset.id;//guardamos su id
         alumno_d = buscar_alumno(id);

         tmp_tarj_alum.querySelector('h3').textContent = alumno_d.Nombre;
         tmp_tarj_alum.querySelectorAll('p')[0].textContent =`Cuenta: ${alumno_d.Cuenta}`;
         tmp_tarj_alum.querySelectorAll('p')[1].textContent = `Folio: ${alumno_d.Folio}`;
         tmp_tarj_alum.querySelectorAll('p')[2].textContent = `Correo: ${alumno_d.Correo}`;
         tmp_tarj_alum.querySelectorAll('p')[3].textContent = `Telefono: ${alumno_d.Telefono}`;
         tmp_tarj_alum.querySelector('button').dataset.cuenta=alumno_d.Cuenta;
         
         clon = tmp_tarj_alum.cloneNode(true);
         fragmento.appendChild(clon);
         alumno_nodo.appendChild(fragmento);
         
    }
});
select_d.addEventListener('change',(e)=>{
    indexOption = e.target.selectedIndex;//guardamos el indice del option
    if(indexOption !=  0){
         eliminar_nodo(docente_nodo);
         opcion = e.target.options[indexOption];//seleccionamos el option que seleccionamos
         id = opcion.dataset.id;//guardamos su id
         docente_d = buscar_docente(id);

         tmp_tarj_doc.querySelector('h3').textContent = docente_d.Nombre;
         tmp_tarj_doc.querySelectorAll('p')[0].textContent =`Numero de trabajador: ${docente_d.Num}`;
         tmp_tarj_doc.querySelectorAll('p')[1].textContent = `Titulo: ${docente_d.Titulo}`;
         esp = tmp_tarj_doc.querySelectorAll('p')[2];
         eliminar_nodo(esp);
         esp.appendChild(lista_especialidades(docente_d.Especialidades));
         tmp_tarj_doc.querySelectorAll('p')[3].textContent = `Numero de cargos: ${docente_d.Num_cargos}`;
         tmp_tarj_doc.querySelector('button').dataset.num_t=docente_d.Num;
         
         clon = tmp_tarj_doc.cloneNode(true);
         fragmento.appendChild(clon);
         docente_nodo.appendChild(fragmento);
    }
});
btn_regresar.addEventListener('click',(e)=>{
    d.location.href = '../index.html';
});
checkbox_doc.addEventListener('change',(e)=>{
    if(e.target.checked){
        //console.log('EL CHECKBOX ESTA SELECCIONADO');
        form.docente.setAttribute('disabled','true');//Agrega un atributo
    }else{
        //console.log('EL CHECKBOX NO ESTA SELECCIONADO');
        form.docente.removeAttribute('disabled');//Elimina el atributo
    }
});
checkbox_alu.addEventListener('change',(e)=>{
    if(e.target.checked){
        //console.log('EL CHECKBOX ESTA SELECCIONADO');
        form.alumno.setAttribute('disabled','true');//Agrega un atributo
    }else{
        //console.log('EL CHECKBOX NO ESTA SELECCIONADO');
        form.alumno.removeAttribute('disabled');//Elimina el atributo
    }
});
checkbox_cat.addEventListener('change',(e)=>{
    if(e.target.checked){
        //console.log('EL CHECKBOX ESTA SELECCIONADO');
        form.categoria.setAttribute('disabled','true');//Agrega un atributo
    }else{
        //console.log('EL CHECKBOX NO ESTA SELECCIONADO');
        form.categoria.removeAttribute('disabled');//Elimina el atributo
    }
});

d.addEventListener('click',(e)=>{
    if(e.target.matches(".seleccion_alum")){
        form.alumno.value = e.target.dataset.cuenta;
    }else if(e.target.matches(".seleccion_docen")){
        form.docente.value = e.target.dataset.num_t;
    }
});