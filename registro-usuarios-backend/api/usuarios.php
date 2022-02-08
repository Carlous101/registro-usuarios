<?php
    //Recibir peticiones del usuario
    //header: se le indica que cualquien echo que se envía está en formato JSON
    header("Content-Type: application/json");
    //importar la clase usuario
    include_once("../clases/class-usuario.php");
    switch($_SERVER['REQUEST_METHOD']){
        //si es POST entonces guarda un usuario
        case 'POST': //Guardar
            // retorna una cadena en formato JSON
            //el true me retorna un arreglo asociativo 
            $_POST = json_decode(file_get_contents('php://input'),true);
            //arreglo con los valores nombre, apellido, fechanacimiento....
            //objeto de tipo usurio con toda la informacion para los atributos internos
            $usuario = new Usuario($_POST["nombre"],$_POST["apellido"],$_POST["fechaNacimiento"],$_POST["pais"]);
            //lamar al metodo guardarusuario
            $usuario->guardarUsuario();
            //envia un mensaje con la información que se va a guardar en un arreglo asociativo
            $resultado["mensaje"]="Guardar alumno, informacion: ".json_encode($_POST);
            //enviar el arreglo asociativo en formato JSON
            echo json_encode($resultado);
        break;
        //si es GET obtiene un usuario o usuarios
        case 'GET'://OBTENER
            //si hay un parametro id retorna un usuario
            if(isset($_GET['id'])){
            //echo json_encode($resultado);
            //llamar a la funcion obtener usuario y se le envia el id al metodo mensionado
            Usuario::obtenerUsuario($_GET['id']);
            //caso contrario me retorna todos los usuarios
            }else{
                //:: operador para acceder 
            //uso del operador de resolucion de ambito     
            Usuario::obtenerUsuarios();
            }
        break; 
        //si es PUT actualizar un usuario 
        case 'PUT':
            // retorna una cadena en formato JSON
            //el true me retorna un arreglo asociativo 
            $_PUT = json_decode(file_get_contents('php://input'),true);
            //arreglo con los valores nombre, apellido, fechanacimiento....
            //objeto de tipo usurio con toda la informacion para los atributos internos
            $usuario = new Usuario($_PUT['nombre'],$_PUT['apellido'],$_PUT['fechaNacimiento'],$_PUT['pais']);
            $usuario->actualizarUsuario($_GET['id']);
            //envia un mensaje con la información que se va a guardar en un arreglo asociativo
            $resultado["mensaje"]="Actualizar un alumno con el id: ".$_GET['id'].
                                    ", Informacion a actualizar: ".json_encode($_PUT);
            //enviar el arreglo asociativo en formato JSON
            echo json_encode($resultado);
            //echo "Actualizar un usuario";
        break; 
        //si es delete aliminar un usuario 
        case 'DELETE':
            //echo "Eliminar un usuario";
            //uso del operador de resolucion de ambito 
            Usuario::eliminarUsuario($_GET["id"]);
            //envia un mensaje con la información que se va a guardar en un arreglo asociativo
            $resultado["mensaje"]="Eliminar un usuario con el id: ".$_GET['id']; 
            //enviar el arreglo asociativo en formato JSON
            echo json_encode($resultado);           
        break; 
    }
?>


