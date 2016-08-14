<?php

class ControladorProveedor extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('Proveedor');

        $this->load->library('form_validation');
    }

    public function formRegistroProveedor() {
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/form_proveedor', $data, true);
        $this->load->view('index', $data);
    }

    public function formGrupo() {
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/form_clasificacion', $data, true);
        $this->load->view('index', $data);
    }

    public function registrarProveedor() {       
        //$this->form_validation->set_rules('nombre_proveedor', 'Nombre repetido', '');
        $this->form_validation->set_rules('nombre_proveedor', 'Proveedor', 'trim|required|min_length[3]|callback_verificarProveedor');
        
        $this->form_validation->set_rules('telefono_proveedor', 'Telefono', 'numeric');
        $this->form_validation->set_rules('email_proveedor', 'Email', 'valid_email');

        if ($this->form_validation->run() == false) {
            $this->formRegistroProveedor();
        } 
        else {
            $res = $this->Proveedor->registrarProveedor(
                $_POST['nombre_proveedor'], $_POST['descripcion_proveedor'], 
                $_POST['direccion_proveedor'], $_POST['telefono_proveedor'], 
                $_POST['email_proveedor']);
            if ($res != -1) {
                $this->session->set_userdata('id_proveedor', $res);
                
                $data['titulo'] = "Proveedor registrado";
                $enlaces = array();
                $enlaces[] = array(
                    'link' => base_url() . "index.php/ControladorProveedor/"
                    . "formRegistroProveedor",
                    'texto' => "Registrar otro proveedor"
                );
                $enlaces[] = array(
                    'link' => base_url() . "index.php/ControladorProveedor/"
                    . "detallesProveedor",
                    'texto' => "Informacion del proveedor"
                );
                $data['enlaces'] = $enlaces;
                
                $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
                $data['contenido'] = $this->load->view('/mensajes/seccion_temporal', $data, true);
                $this->load->view('index', $data);
            }
        }
    }

    public function registrarGrupo() {       
        //$this->form_validation->set_rules('nombre_proveedor', 'Nombre repetido', '');
        $this->form_validation->set_rules('nombre_grupo', 'Grupo', 
            'trim|required|min_length[3]|callback_verificarGrupo');
        
        $this->form_validation->set_rules('descripcion_grupo', 'Grupo', 'trim');
        

        if ($this->form_validation->run() == false) {
            $this->formGrupo();
        } 
        else {
            $res = $this->Proveedor->registrarGrupo(
                $_POST['nombre_grupo'], $_POST['descripcion_grupo']);
            if($res != -1) {

                $data['titulo'] = "Grupo registrado";
                $enlaces = array();
                $enlaces[] = array(
                    'link' => base_url() . "index.php/ControladorProveedor/"
                    . "formGrupo",
                    'texto' => "Registrar otro grupo"
                );
                
                $data['enlaces'] = $enlaces;
                
                $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
                $data['contenido'] = $this->load->view('/mensajes/seccion_temporal', $data, true);
                $this->load->view('index', $data);    
            }
        }
        
    }

    public function verificarGrupo($nombreGrupo) {
        if($this->Proveedor->verificarGrupo($nombreGrupo) == false) {
            $this->form_validation->set_message('verificarGrupo', 'Grupo ya registrado');
            return false;    
        }
        else {
            return true;
        }
    }

    public function verificarProveedor($proveedor) {
        if ($this->Proveedor->verificarNombre($proveedor) == false) {
            $this->form_validation->set_message('verificarProveedor', 'Nombre ya registrado');
            return false;
        } else {
            return true;
        }
    }

    public function menuProveedor() {
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/menu_central_proveedores', $data, true);
        $this->load->view('index', $data);
    }
    
    public function detallesProveedor($idProveedor = "") {
        if($idProveedor != "") { 
            $this->session->set_userdata('id_proveedor', $idProveedor);
        }
        
        $data['proveedor'] = $this->Proveedor->getProveedor(
                $this->session->userdata('id_proveedor'));
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/informacion_proveedor', $data, true);
        $this->load->view('index', $data);
    }
    
    public function verProveedores() { 
        $data['proveedores'] = $this->Proveedor->getProveedores();
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/lista_proveedores', $data, true);
        $this->load->view('index', $data);
    }

    public function recibirPostAjax() {
        $opcion = $this->input->post('opcion');
        switch ($opcion) {
            case 'getProveedores': 
                $idProveedor = $this->session->userdata('id_proveedor');
                $proveedores = $this->Proveedor->getGruposExclude($idProveedor, 
                    $this->input->post('textoBusqueda'));
                echo json_encode($proveedores);
                break;
        }
    }
    
    public function asignarGrupo() { 
        $this->Proveedor->asignarGrupos(
        json_decode($this->input->post('grupos')));
        redirect(base_url() . 
                'index.php/ControladorProveedor/detallesProveedor', 'refresh');
    }
    
    public function mostrarGrupos() { 
        $data['grupos'] = $this->Proveedor->getGruposAll();
        
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/lista_grupos', $data, true);
        $this->load->view('index', $data);
    }
    
    public function detallesGrupo($idGrupo = "") { 
        if($idGrupo != "") {
            $this->session->set_userdata('id_grupo', $idGrupo);
        }
        $data['grupo'] = $this->Proveedor->getGrupo(
                $this->session->userdata('id_grupo'));
        
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/informacion_grupo', $data, true);
        $this->load->view('index', $data);
    }
    
    public function eliminarMiembro($idProveedor) { 
        $this->Proveedor->eliminarMiembro($idProveedor);
        redirect(base_url() . 'index.php/ControladorProveedor/detallesGrupo'
                    , 'refresh');
    }
}
