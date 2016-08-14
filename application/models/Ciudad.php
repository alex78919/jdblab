<?php
class Ciudad extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('Principal');
    }

    public function insertarCiudad($ciudad) {
        $res = false;
        $ciudad = $this->Principal->preparacionTexto($ciudad);
        $sql = "SELECT * FROM CIUDAD "
                . "WHERE NOMBRE_CIUDAD='$ciudad'";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 0) {
            $ciudad = array('NOMBRE_CIUDAD' => $ciudad);
            $this->db->insert('CIUDAD', $ciudad);
            $res = true;
        }
        return $res;
    }
    
    public function getCiudades() {
        $query = $this->db->get('CIUDAD');
        return $query->result_array();
    }
}