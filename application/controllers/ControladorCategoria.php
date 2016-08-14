<?php

class ControladorCategoria extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Categoria');
        $this->load->model('Principal');

        $this->load->library('form_validation');
    }

    public function mostrarPrincipal() {
        $this->Principal->controlarSesion();

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('contents/menu_central_categorias', $data, true);
        $this->load->view('index', $data);
    }

    public function verCategoria($idCategoria = "") {
        $this->Principal->controlarSesion();

        if ($idCategoria == "") {
            $data['nodo'] = "Principal";
            $data['categorias'] = $this->Categoria->getNodosSuperiores($idCategoria);
        } else {
            $data['nodo'] = $this->Categoria->getCategoria($idCategoria);
            $data['categorias'] = $this->Categoria->getHijos($idCategoria);
        }

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('contents/categorias', $data, true);
        $this->load->view('index', $data);
    }

    public function formCategoria() {
        $this->Principal->controlarSesion();

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('contents/form_categoria', $data, true);
        $this->load->view('index', $data);
    }

    public function crearCategoria() {
        $this->form_validation->set_rules('nombre_categoria', 'Categoria', 'required');

        if ($this->form_validation->run() == false) {
            $this->formCategoria();
        } else {
            $categoria = array(
                'NOMBRE_CATEGORIA' => $this->Principal->
                        preparacionTexto($_POST['nombre_categoria']),
                'DESCRIPCION_CATEGORIA' => $this->Principal->
                        preparacionTexto($_POST['descripcion_categoria'])
            );
            if ($this->Categoria->crearCategoria($categoria)) {
                $enlaces = array();
                $enlaces[] = array(
                    'link' => base_url(),
                    'texto' => "Ir al inicio"
                );
                $enlaces[] = array(
                    'link' => base_url() .
                    "index.php/ControladorCategoria/mostrarNodos/",
                    'texto' => "Ver categorias"
                );

                $data['titulo'] = "Categoria Registrada";
                $data['enlaces'] = $enlaces;
                $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
                $data['contenido'] = $this->load->view('/mensajes/seccion_temporal', $data, true);
                $this->load->view('index', $data);
            } else {
                $data['titulo_error'] = "No se pudo crear Categoria: ";
                $data['mensaje_error'] = "La categoria ya exixte en la base de datos";
                $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
                $data['contenido'] = $this->load->view('/errors/errores', $data, true);
                $this->load->view('index', $data);
            }
        }
    }

    public function formSubdivisiones() {
        $this->Principal->controlarSesion();

        $sql = "SELECT ID_CATEGORIA FROM CATEGORIA LIMIT 1";
        $row = $this->db->query($sql)->row_array();
        
        $superiores = $this->Categoria->categoriasPermisibles($row['ID_CATEGORIA']);
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        if ($this->Categoria->cantidadNodosSuperiores() > 1) {
            $data['categorias'] = $this->Categoria->getCategorias();
            $data['subCategorias'] = $superiores;
            $data['contenido'] = $this->load->view('contents/form_crear_subdivision', $data, true);
        }
        else {
            $data['contenido'] = "No se puede crear subdivision";
        }
        $this->load->view('index', $data);
    }

    public function formAgregarSubdivisiones($idCategoria) {
        $this->Principal->controlarSesion();

        if ($this->Categoria->restriccionCategoria($idCategoria) == false) {
            $data['subCategorias'] = $this->Categoria->getNodosSuperiores();
            $data['categoria'] = $this->Categoria->getCategoria($idCategoria);
            $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
            $data['contenido'] = $this->load->view('contents/form_agregar_subdivision', $data, true);
            $this->load->view('index', $data);
        } else {
            $data['titulo_error'] = "Subdivisiones: ";
            $data['mensaje_error'] = "No se puede crear sudivisiones en este nodo";
            $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
            $data['contenido'] = $this->load->view('/errors/errores', $data, true);
            $this->load->view('index', $data);
        }
    }

    public function agregarSubdivision() {
        $this->Categoria->registrarSubdivision();  
    }

    public function recibirPostAjax() {
        $opcion = $_POST['opcion'];
        switch ($opcion) {
            case 'categorias':
                $categorias = $this->Categoria->categoriasPermisibles($_POST['id_categoria']);
                echo json_encode($categorias);
                break;
        }
    }
    
}
