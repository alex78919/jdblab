<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ControladorPrincipal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Principal');
        $this->load->model('Profesion');
        $this->load->model('Cargo');
        $this->load->model('Institucion');
        $this->load->model('Ciudad');
    }

    public function index() {
        $this->cargarPaginaPrincipal();
        
    }

    private function cargarPaginaPrincipal() {
        if ($this->session->userdata('id_usuario')) {
            $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
            $data['contenido'] = $this->load->view('/contents/menu_central_principal', '', true);
            $this->load->view('index', $data);
            
        } else {
            $this->load->view('login');
        }
    }
    
    public function iniciarSesion() {
        $usuario = $this->input->post('nombre_usuario');
        $clave = $this->input->post('clave_usuario');
        $datos_usuario = $this->Principal->autentificarUsuario($usuario, $clave);

        if ($datos_usuario) {
            $this->session->set_userdata('id_usuario', $datos_usuario['ID_USUARIO']);
            $this->cargarPaginaPrincipal();
        }
        else {
            $this->load->view('login');
        }
    }
    
    public function salir() {
        unset($this->session->id_usuario);
    }

    public function recibirPostAjax() {
        $post = $_POST['opcion'];

        switch ($post) {
            case 'insertarCiudad':
                $ciudad = $_POST['ciudad'];
                if ($this->Ciudad->insertarCiudad($ciudad)) {
                	$query = $this->Ciudad->getCiudades();
                	echo json_encode($query);
                }
                else {
                	echo 0;
                }
                break;
            case 'insertarCargo': 
            	$cargo = $_POST['cargo'];
                if ($this->Cargo->insertarCargo($cargo)) {
                    $query = $this->Cargo->getCargos();
                    echo json_encode($query);
                }
                else {
                    echo 0;
                }
            	break; 

           	case 'insertarProfesion' : 
            	$profesion = $_POST['profesion'];
                if ($this->Profesion->insertarProfesion($profesion)) {
                    $query = $this->Profesion->getProfesiones();
                    echo json_encode($query);
                }
                else {
                    echo 0;
                }
                break;
                
                case 'insertarInstitucion' : 
            	$institucion = $_POST['institucion'];
                if ($this->Institucion->insertarInstitucion($institucion)) {
                    $query = $this->Institucion->getInstituciones();
                    echo json_encode($query);
                }
                else {
                    echo 0;
                }
                break;

            case 'ciudad': 
                $ciudades = $this->Ciudad->getCiudades();
                echo json_encode($ciudades);  
                break;

            case 'cargo': 
                $cargos = $this->Cargo->getCargos();
                echo json_encode($cargos);  
                break;

            case 'institucion': 
                $instituciones = $this->Institucion->getInstituciones();
                echo json_encode($instituciones);  
                break;

            case 'profesion': 
                $profesiones = $this->Profesion->getProfesiones();
                echo json_encode($profesiones);  
                break;
        }
    }
    
    public function logout() {
        $this->session->unset_userdata('id_usuario');
        $this->load->view('login');
    }

}
