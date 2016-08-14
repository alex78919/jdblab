<?php
class ControladorProforma extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Producto');
        $this->load->model('Cliente');
        $this->load->model('Proforma');
        $this->load->model('Categoria');
    }

    public function cargarVistaNuevaProforma($idCliente) {
        $data['cliente'] = $this->Cliente->getCliente($idCliente);
        $data['items'] = $this->Producto->getProductos();
        $data['categorias'] = $this->Categoria->getCategorias();
        
        $data['plantilla_productos'] = $this->
                load->view('/contents/busqueda_productos', $data, true);
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/crear_proforma', $data, true);
        $this->load->view('index', $data);
    }
    
    public function vistaSeleccionarProductos() {
        $data['items'] = $this->Producto->getProductos();
        //$this->load->view()
    }
    
    public function registrarProforma() {
        $this->Proforma->guardarProforma();
        
        $enlaces = array();
        $enlaces[] = array(
            'link' => base_url(),
            'texto' => "Ir al inicio"
        );
        $enlaces[] = array(
            'link' => base_url() . "index.php/ControladorCliente/detallesCliente",
            'texto' => "Ver cliente"
        );
        $enlaces[] = array(
            'link' => base_url() . "index.php/ControladorCliente/mostrarProformas",
            'texto' => "Proformas cliente"
        );
        
        $data['titulo'] = "Acciones a seguir:";
        $data['enlaces'] = $enlaces;
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/mensajes/seccion_temporal', $data, true);
        $this->load->view('index', $data);
    }
    
    public function detallesProforma($idProforma) {
        $data['nombre_cliente'] = $this->Cliente->getNombreCompleto(
                $this->session->userdata('id_cliente'));
        $data['proforma'] = $this->Proforma->getProforma($idProforma);
        $data['productos'] = $this->Proforma->getProductosProforma($idProforma);
        $data['total'] = $this->Proforma->sumaTotal($idProforma);

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/detalles_proforma', $data, true);
        $this->load->view('index', $data);
    }
    
    public function exportarProforma($idProforma, $tipoModelo) {
        $this->Proforma->exportarProforma($idProforma, $tipoModelo);
    }
    
    public function listaProformas() {
        $data['proformas'] = $this->Proforma->getProformasCliente();
        
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/lista_proformas', $data, true);
        $this->load->view('index', $data);
    }

    public function exportarProformaDetallada($idProforma) {
        $this->Proforma->exportarProformaDetallada($idProforma);
    }
}
