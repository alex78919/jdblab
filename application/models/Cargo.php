<?php

class Cargo extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('Principal');
    }


    public function getCargos() {
        $query = $this->db->get('CARGO');
        return $query->result_array();
    }

    public function insertarCargo($cargo) {
        $res = false;
        $cargo = $this->Principal->preparacionTexto($cargo);
        $sql = "SELECT * FROM CARGO "
                . "WHERE NOMBRE_CARGO='$cargo'";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 0) {
            $cargo = array('NOMBRE_CARGO' => $cargo);
            $this->db->insert('CARGO', $cargo);
            $res = true;
        }
        return $res;
    }

}

?>
