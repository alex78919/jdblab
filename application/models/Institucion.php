<?php
class Institucion extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('Principal');
              
    }
    
    public function getInstituciones() {
        $query = $this->db->get('INSTITUCION');
        return $query->result_array();
    }
    
    public function insertarInstitucion($institucion) {
        $res = false;
        $institucion = $this->Principal->preparacionTexto($institucion);
        $sql = "SELECT * FROM INSTITUCION "
                . "WHERE NOMBRE_INSTITUCION='$institucion'";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 0) {
            $institucion = array('NOMBRE_INSTITUCION' => $institucion);
            $this->db->insert('INSTITUCION', $institucion);
            $res = true;
        }
        return $res;    
    }
}