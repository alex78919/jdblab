<?php
class Telefono extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function getTipos() { 
        $query = $this->db->get('TIPO_TELEFONO');
        return $query->result_array();
    }

}