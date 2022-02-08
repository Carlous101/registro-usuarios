//Consumir REST API CON AJAX
//declaracion de una variable global de un arreglo normal
var usuarios = [];
var usuarioSeleccionado;
//la url se mantiene, entonces se crea una constante
//ruta del backend
const url = '../../registro-usuarios/registro-usuarios-backend/api/usuarios.php';
//Funsion obtener usuarios
function obtenerUsuarios() {
    //Esto es una petición asíncrona!
    axios({
        method: 'GET',
        //consume del backend
        url: url,
        //tipo de respuesta Json 
        responseType: 'json'
        //funsion que se ejecuta cuando responde el servidor 
    }).then(res => {
        console.log(res.data);
        //asigancion al arreglo con la variable global
        this.usuarios = res.data;
        llenarTabla();
    }).catch(error => {
        //imprime el error en la consola
        console.error(error);
    });
}
//llamado inmediato para que aparesca al inicio
obtenerUsuarios();

//funsion que se encarga de recorrer el objeto Json para generar dinamicamente la informacion
function llenarTabla() {
    //se vacia la tabla para evitar que se repitan los datos
    document.querySelector('#tabla-usuarios tbody').innerHTML ='';
    //por cada elemento se agrega un tbody
    for (let i = 0; i < usuarios.length; i++) {
        //buscar dentro de la etiqueta interna tbody
        document.querySelector('#tabla-usuarios tbody').innerHTML +=
        //se aplican los valores correspondientes con el nombre del atributo
            `<tr>
                <td>${usuarios[i].nombre}</td>
                <td>${usuarios[i].apellido}</td>
                <td>${usuarios[i].fechaNacimiento}</td>
                <td>${usuarios[i].pais}</td>
                <td>
                    <button type="button" onclick="eliminar(${i})">Eliminar</button>
                    <button type="button" onclick="seleccionar(${i})">Editar</button>
                </td>
            </tr>`;
    }
}
//funsion para eliminar un usuario
function eliminar(indice) {
    //imprimir en la consola el indice 
    console.log('Eliminar el elemento con el índice ' + indice);
    //peticion ajax con axios
    axios({
        //metodo delete
        method: 'DELETE',
        //la url se mantiene + el parametro (indice a eliminar)
        url: url + `?id=${indice}`,
        //tipo de respuesta Json 
        responseType: 'json'
    }).then(res => {
        console.log(res.data);
        //se actualiza la tabla para verificar los datos en tiempo real 
        obtenerUsuarios();
    }).catch(error => {
        //imprime el error en la consola
        console.error(error);
    });
}
//funsion para guardar un usuario
function guardar(){
    //se construye el json usuario que se va a guardar
    let usuario={
        nombre: document.getElementById('nombre').value,
        apellido: document.getElementById('apellido').value,
        fechaNacimiento: document.getElementById('fechaNacimiento').value,
        pais: document.getElementById('pais').value
    };//Imprimir por consola lo que se va a guardar
    console.log('Usuario a guardar', usuario);
    //Versión Ajax usando Axios
    axios({
        //metodo post
        method: 'POST',
        //la url se mantiene
        url: url,
        //tipo de respuesta Json 
        responseType: 'json',
        //para el post se le pasa data:usuario
        data:usuario    
    }).then(res => {
        console.log(res);
        //se limpian los campos
        limpiar();
        //se actualiza la tabla para verificar los datos en tiempo real 
        obtenerUsuarios();
    }).catch(error => {
        //imprime el error en la consola
        console.error(error);
    });
}
//funsion para limpiar los campos ya utilizados
function limpiar(){
    document.getElementById('nombre').value=null;
    document.getElementById('apellido').value=null;
    document.getElementById('fechaNacimiento').value=null;
    document.getElementById('pais').valu=null;

    document.getElementById('btn-guardar').style.display='inline';
    document.getElementById('btn-actualizar').style.display='none';
}
//funsion para actualizar
function actualizar(){
    //se construye el json usuario que se va a actualizar
    let usuario={
        nombre: document.getElementById('nombre').value,
        apellido: document.getElementById('apellido').value,
        fechaNacimiento: document.getElementById('fechaNacimiento').value,
        pais: document.getElementById('pais').value
    };
    //imprimir en consola el usuario a actualizar
    console.log('Usuario a actualizar ──> ', usuario);
    //Versión Ajax usando Axios
    axios({
        //metodo PUT
        method: 'PUT',
        //la url se mantiene + el parametro (indice a actualizar)
        url: url + `?id=${usuarioSeleccionado}`,
        //tipo de respuesta Json 
        responseType: 'json',
        //para el post se le pasa data:usuario
        data:usuario    
    }).then(res => {
        console.log(res);
        limpiar();
        //se actualiza la tabla para verificar los datos en tiempo real 
        obtenerUsuarios();
    }).catch(error => {
        //imprime el error en la consola
        console.error(error);
    });
}

//funsion para tomar un elemento, llenar los campos del elemnto tomado
//y poder editarlo
function seleccionar(indice){
    usuarioSeleccionado=indice;
    console.log('Se selecciono el elemento '+indice);
    //primero se obtiene el elemento del servidor
    axios({
        //metodo GET
        method: 'GET',
        //la url se mantiene + el parametro (indice selecionado)
        url: url + `?id=${indice}`,
        //tipo de respuesta Json 
        responseType: 'json'
    }).then(res => {
        console.log(res);
        //acceso a cada uno de los input
        //en los valores se asigna lo que el servidor nos responde (res.data)
        document.getElementById('nombre').value=res.data.nombre;
        document.getElementById('apellido').value=res.data.apellido;
        document.getElementById('fechaNacimiento').value=res.data.fechaNacimiento;
        document.getElementById('pais').value=res.data.pais;
        //Aquí se modifican los botones 
        document.getElementById('btn-guardar').style.display='none';
        document.getElementById('btn-actualizar').style.display='inline';
    }).catch(error => {
        //imprime el error en la consola
        console.error(error);
    });
}


