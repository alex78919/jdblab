<?php
class Prototipo extends CI_Model {
    var $nombre;
    var $edad;
    
    function __construct() {
        parent::__construct();
    }
    
    function getInstance($nombre, $edad) {
        $this->nombre = $nombre;
        $this->edad = $edad;
    }
    
    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    public function setEdad($edad) {
        $this->edad = $edad;
    }
}