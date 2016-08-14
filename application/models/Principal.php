<?php

class Principal extends CI_Model {

    public function autentificarUsuario($usuario, $clave) {
        $query = $this->db->get_where('USUARIO', array(
            'alias_usuario' => $usuario, 'clave_usuario' => $clave));
        return $query->row_array();
    }

    public function getClientes() {
        $query = $this->db->get('CLIENTE');
        return $query->result_array();
    }

    public function getCiudades() {
        $query = $this->db->get('CIUDAD');
        return $query->result_array();
    }

    public function getCargos() {
        $query = $this->db->get('CARGO');
        return $query->result_array();
    }

    public function insertarCiudad($ciudad) {
        $ciudad = array('NOMBRE_CIUDAD' => $ciudad);
        return $this->db->insert('CIUDAD', $ciudad);
    }

    public function preparacionTexto($texto) {
        $res;
        $res = trim($texto);
        $res = strtolower($res);
        $res = strip_tags($res);
        return $res;
    }
    
    public function controlarSesion() {
        if(!$this->session->userdata('id_usuario')) { 
            redirect(base_url() . 'index.php/ControladorPrincipal/iniciarSesion'
                    , 'refresh');
        }
    }
}

?>