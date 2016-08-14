<?php

class ControladorCliente extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Principal');
        $this->load->model('Profesion');
        $this->load->model('Cargo');
        $this->load->model('Institucion');
        $this->load->model('Cliente');
        $this->load->model('Ciudad');
        $this->load->model('Telefono');

        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    public function menuClientes() {
        $this->Principal->controlarSesion();

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/menu_central_clientes', '', true);
        $this->load->view('index', $data);
    }

    public function validarFormulario() {
        $this->form_validation->set_rules('nit_cliente', 'NIT', 'numeric');
        $this->form_validation->set_rules('nombre_cliente', 'Ingrese el o los nombres', 'required', 'error');
        $this->form_validation->set_rules('app_cliente', 'apellido paterno', 'required');
        $this->form_validation->set_rules('email_cliente', 'Email', 'valid_email|min_length[12]');
        $this->form_validation->set_rules('telf_cliente', 'Telefono', 'numeric|min_length[7]');


        if ($this->form_validation->run() == FALSE) {
            $this->cargarFormulario();
        } else if ($this->Cliente->insertar()) {
            $data['id_cliente'] = $this->db->insert_id();
            $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
            $data['contenido'] = $this->load->view(
                    '/mensajes/post_registro_cliente', $data, true);
            $this->load->view('index', $data);
        } else {
            $data['titulo_error'] = "Cliente no registrado: ";
            $data['mensaje_error'] = "No se pudo registrar es posible que ya exista "
                    . "el cliente con el mismo nombre y apellidos ";
            $data['enlace'] = base_url() . 
                    "index.php/ControladorCliente/cargarFormulario";
            $data['textoEnlace'] = "Intentar registrar otra vez";
            
            $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
            $data['contenido'] = $this->load->view('/errors/errores', $data, true);
            $this->load->view('index', $data);
        }
    }

    public function verificarNombreCompleto() {
        
    }
    
    public function cargarFormulario() {
        $this->Principal->controlarSesion();

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['ciudades'] = $this->Principal->getCiudades();
        $data['profesiones'] = $this->Profesion->getProfesiones();
        $data['cargos'] = $this->Principal->getCargos();
        $data['instituciones'] = $this->Institucion->getInstituciones();
        $data['contenido'] = $this->load->view('/contents/nuevo_cliente', $data, true);
        $this->load->view('index', $data);
    }

    public function getClientes() {
        $query = $this->db->get('CLIENTE');
        return $query->result_array();
    }

    public function mostrar() {
        $this->Principal->controlarSesion();

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['clientes'] = $this->Cliente->getClientes();
        $data['contenido'] = $this->load->view('/contents/lista_clientes', $data, true);
        $this->load->view('index', $data);
    }

    public function getBusquedaClientes() {
        $parametroBusqueda = $_POST['parametroBusqueda'];
        echo json_encode($this->Cliente->buscarPorNombres($parametroBusqueda));
    }

    public function detallesCliente() {
        $this->Principal->controlarSesion();

        if (isset($_POST['id_cliente_detalle'])) {
            $this->session->set_userdata('id_cliente', $_POST['id_cliente_detalle']);
        }
        $idCliente = $this->session->userdata('id_cliente');

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['cliente'] = $this->Cliente->getCliente($idCliente);
        $data['contenido'] = $this->load->view(
                '/contents/informacion_cliente', $data, true);
        $this->load->view('index', $data);
    }

    public function vistaEdicion() {
        $this->Principal->controlarSesion();

        $idCliente = $this->session->userdata('id_cliente');
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['cliente'] = $this->Cliente->getCliente($idCliente);
        $data['ciudades'] = $this->Ciudad->getCiudades();
        $data['instituciones'] = $this->Institucion->getInstituciones();
        $data['cargos'] = $this->Cargo->getCargos();
        $data['profesiones'] = $this->Profesion->getProfesiones();
        $data['contenido'] = $this->load->view('/contents/edicion-cliente', $data, true);
        $this->load->view('index', $data);
    }

    public function guardarEdicion() {
        $this->form_validation->set_rules('nit_cliente', 'NIT', 'numeric');
        $this->form_validation->set_rules('nombre_cliente', 'Ingrese el o los nombres', 'required', 'error');
        $this->form_validation->set_rules('app_cliente', 'apellido paterno', 'required');
        $this->form_validation->set_rules('email_cliente', 'Email', 'valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->vistaEdicion();
        } else {
            $this->Cliente->actualizar();
            $this->detallesCliente();
        }
    }

    public function mostrarProformas() {
        $this->Principal->controlarSesion();

        $idCliente = $this->session->userdata('id_cliente');
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['cliente'] = $this->Cliente->getCliente($idCliente);
        $data['proformas'] = $this->Cliente->getProformas($idCliente);
        $data['contenido'] = $this->load->view('/contents/proformas_cliente', $data, true);
        $this->load->view('index', $data);
    }

    public function cargarFormTelefono() {
        $this->Principal->controlarSesion();

        $idCliente = $this->session->userdata('id_cliente');
        $data['cliente'] = $this->Cliente->getNombreCompleto($idCliente);
        $data['tipos'] = $this->Telefono->getTipos();
        
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/form_telefono', $data, true);
        $this->load->view('index', $data);
    }

    public function guardarNumeroTelefono() {
        $this->form_validation->set_rules('telefono', 'Telefono', 'required|is_natural_no_zero|min_length[7]');
        $this->form_validation->set_rules('telefono', 'Telefono', 'callback_verificarNumero');
        if ($this->form_validation->run() == false) {
            $this->cargarFormTelefono();
        } else {
            $this->Cliente->guardarNumeroTelefono
                    ($this->session->userdata('id_cliente'));
            $this->detallesCliente();
        }
    }
    
    public function verificarNumero($numero) { 
        if($this->Cliente->verificarNumero($this->session->
                userdata('id_cliente'),$numero) == false) {
            $this->form_validation->set_message('verificarNumero',
            'El numero ya esta registrado para este cliente');
            return false;
        }
        else { 
            return true;
        }
    }

    public function cargarEliminarTelefono() {
        $this->Principal->controlarSesion();

        $data['cliente'] = $this->Cliente->getCliente(
                $this->session->userdata('id_cliente'));
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/eliminar_telefonos', $data, true);
        $this->load->view('index', $data);
    }

    public function eliminarTelefono($idTelefono) {
        $this->Cliente->eliminarTelefono($idTelefono);
        $this->detallesCliente();
    }

    public function formBusquedaSegmentadaClientes() {
        $data['ciudades'] = $this->Ciudad->getCiudades();

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/form_busqueda_avanzada_clientes', $data, true);
        $this->load->view('index', $data);    
    }

    public function mostrarBusquedaSegmentada() {
        $this->Principal->controlarSesion();

        $opcion = $this->input->post('opcion');
        $filtro = trim($this->input->post('filtro'));
        $filtroCliente = trim($this->input->post('filtro_cliente')); 
        
        $paginacion = 10;

        $config['base_url'] = base_url() .
                    "index.php/ControladorCliente/mostrarBusquedaSegmentada";
        $config['total_rows'] = $this->Cliente->totalBusquedaSegmentada(
                    $opcion, $filtro, $filtroCliente);
        $config['per_page'] = $paginacion;
        $config['num_links'] = 5;
        $config['first_link'] = 'Primera';
        $config['last_link'] = 'Última';
        $config['next_link'] = 'Siguiente »';
        $config['prev_link'] = '« Anterior';


        $this->pagination->initialize($config);
        
        $data['ciudades'] = $this->Ciudad->getCiudades();
        $data['busqueda'] = true;
        $data['clientes'] = $this->Cliente->
                busquedaSegmentada($this->input->post('opcion'), $this->input->post('filtro'), 
            $this->input->post('filtro_cliente'), $paginacion, $this->uri->segment(3));
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/form_busqueda_avanzada_clientes', $data, true);
        $this->load->view('index', $data);
        
    }

}
