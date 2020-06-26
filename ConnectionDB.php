<?php

    class ConnectionDB {
        public $hostname;
        public $user;
        public $password;
        public $database;

        public function __construct($hostname = 'localhost', $user, $password, $database){

            $this->hostname = $hostname;
            $this->user = $user;
            $this->password = $password;
            $this->database = $database;
    
        }

        /* Getters */
        public function getHostname(){
            return $this->hostname;
        }
        public function getUser(){
            return $this->user; 
        }
        public function getPassword(){
            return $this->password;
        }
        public function getDatabase(){
            return $this->database;
        }

        /* Setters */
        public function setHostname($hn) {
            $this->hostname =$hn;
        }
        public function setUser($usr) {
            $this->user =$usr;
        }
        public function setPassword($pass) {
            $this->password =$pass;
        }
        public function setDatabase($db) {
            $this->database =$db;
        }
        /* Conexion a la base de datos */
        public function connect(){ 
            return mysqli_connect($this->hostname, $this->user, $this->password, $this->database);
        }
    }

    // /* Instancia de conecctionDB */
    // $miConexion = new ConnectionDB('localhost','soap-user', 'soap-user', 'tarea-soap');
    // $conn =  $miConexion->connect();
    // /* Si ocurre un error en la conexion, se muestra el error, en caso contrario, se indica que la conexion fue exitosa */
    // if($conn->connect_error) {
    //     die($conn->connect_error);
    // } else {
    //     echo "conexion exitosa";
    // }
    // /* Query de prueba */
    // $sql = "SELECT * FROM carrera";

    // /* Forma de mostrar datos de una query */
    // foreach ($conn->query($sql) as $row) {
    //     print $row['codigo'] . "\t";
        
    

?>  