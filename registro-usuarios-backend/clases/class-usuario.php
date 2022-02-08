<?php
    //clase usuario
    class Usuario{
        //atributos de la clase usuario
        private $nombre;
        private $apellido;
        private $fechaNacimiento;
        private $pais;
        //constructor de la clase usuario 
        public function __construct($nombre,$apellido,$fechaNacimiento,$pais){
            $this->nombre = $nombre;
            $this->apellido = $apellido;
            $this->fechaNacimiento = $fechaNacimiento;
            $this->pais =$pais;
        }
        public function getNombre()
        {
            return $this->nombre;
        }
        /**
         * 
         * 
         * @return self
         */
        public function setNombre($nombre)
        {
            $this->nombre = $nombre;

            return $this;
        }
        public function getApellido()
        {
            return $this->apellido;
        }
        /**
         * 
         * 
         * @return self
         */
        public function setApellido($apellido)
        {
            $this->apellido = $apellido;

            return $this;
        }
        public function getFechaNacimiento()
        {
            return $this->fechaNacimiento;
        }
        /**
         * 
         * 
         * @return self
         */
        public function setFechaNacimiento($fechaNacimiento)
        {
            $this->fechaNacimiento = $fechaNacimiento;

            return $this;
        }
    public function getpais()
        {
            return $this->pais;
        }
        /**
         * 
         * 
         * @return self
         */
        public function setpais($pais)
        {
            $this->pais = $pais;
            return $this;
        }
        public function __toString(){
            return $this->nombre ." ".$this->apellido."(".$this->fechaNacimiento.",".$this->pais.")";
        }

        //CRUD
        //metodo guardar
        public function guardarUsuario(){
            //cadena con la informacion que se va a leer desde   "../data/usuarios.json"
            $contenidoArchivo = file_get_contents("../data/usuarios.json");
            //cadena que contiene toda la informacion
            // true para que convertoir en un arreglo asociativo
            $usuarios = json_decode($contenidoArchivo, true);
            //aqui se agregar los elementos 
            $usuarios[] = array(
                //indices y valores
                "nombre"=> $this->nombre,
                "apellido"=> $this->apellido,
                "fechaNacimiento"=> $this->fechaNacimiento,
                "pais"=> $this->pais
            );
            //sobre escribir todo el contenido del archivo
            //abrir el archivo con la ruta con W para sustituir
            $archivo = fopen("../data/usuarios.json","w");
            //fwrite para escribir el contenido  (contenido (parametro convertido en una cadena json))
            fwrite($archivo, json_encode($usuarios));
            //cerrar el flujo del archivo
            fclose($archivo);
        }
        //metodo obtener usuarios
        //static para acceder a los datos sin crear instancias
        public static function obtenerUsuarios(){
            //cadena con la informacion que se va a leer desde   "../data/usuarios.json"
            $contenidoArchivo = file_get_contents("../data/usuarios.json");
            echo $contenidoArchivo;
        }

        //obtener un solo usuario
        //static para acceder a los datos sin crear instancias
        //entra como parametro el indice para obtener un solo usuario
        public static function obtenerUsuario($indice){
            //cadena con la informacion que se va a leer desde   "../data/usuarios.json"
            $contenidoArchivo = file_get_contents("../data/usuarios.json");
            //cadena que contiene toda la informacion
            // true para que convertoir en un arreglo asociativo
            $usuarios = json_decode($contenidoArchivo, true);
            echo json_encode($usuarios[$indice]);
        }
        //metodo para actualizar
        //entra como parametro el indice para actualizar
        public function actualizarUsuario($indice){
            //cadena con la informacion que se va a leer desde   "../data/usuarios.json"
            $contenidoArchivo = file_get_contents("../data/usuarios.json");
            //cadena que contiene toda la informacion
            // true para que convertoir en un arreglo asociativo
            $usuarios = json_decode($contenidoArchivo, true);
            //arreglo con los incices y valores que se van a sustituir
            $usuario = array(
                'nombre'=> $this->nombre,
                'apellido'=> $this->apellido,
                'fechaNacimiento'=> $this->fechaNacimiento,
                'pais'=> $this->pais,
            );
            //el indice actual se sustituye por $usuarios (que se acaba de crear)
            $usuarios[$indice] = $usuario;
            //sobre escribir todo el contenido del archivo
            //abrir el archivo con la ruta con W para sustituir
            $archivo = fopen('../data/usuarios.json','w');
            //fwrite para escribir el contenido  (contenido (parametro convertido en una cadena json))
            fwrite($archivo, json_encode($usuarios));
            //cerrar el flujo del archivo
            fclose($archivo);

        }
        //Metodo para eliminar
        //entra como parametro el indice para eliminar
        public static function eliminarUsuario($indice){
            //cadena con la informacion que se va a leer desde   "../data/usuarios.json"
            $contenidoArchivo = file_get_contents("../data/usuarios.json");
            //cadena que contiene toda la informacion
            // true para que convertoir en un arreglo asociativo
            $usuarios = json_decode($contenidoArchivo, true);
            //funsion array_splice que recibe como parametro el arreglo (usuarios), 
            //el elemento que se va a eliminar y la cantidad de elementos a eliminar
            array_splice($usuarios, $indice, 1);
            //sobre escribir todo el contenido del archivo
            //abrir el archivo con la ruta con W para sustituir
            $archivo = fopen('../data/usuarios.json','w');
            //fwrite para escribir el contenido  (contenido (parametro convertido en una cadena json))
            fwrite($archivo, json_encode($usuarios));
            //cerrar el flujo del archivo
            fclose($archivo);
        }
    }

?>