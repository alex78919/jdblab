<?php

class Profesion extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('Principal');
    }
    
    public function getProfesiones() {
        $query = $this->db->get('PROFESION');
        return $query->result_array();
    }

    public function insertarProfesion($profesion) {
        $res = false;
        $profesion = $this->Principal->preparacionTexto($profesion);
        $sql = "SELECT * FROM PROFESION "
                . "WHERE NOMBRE_PROFESION='$profesion'";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 0) {
            $profesion = array('NOMBRE_PROFESION' => $profesion);
            $this->db->insert('PROFESION', $profesion);
            $res = true;
        }
        return $res;
    }

}

?>
