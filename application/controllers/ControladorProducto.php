<?php

class ControladorProducto extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Principal');
        $this->load->model('Producto');
        $this->load->model('Categoria');

        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    public function registrarProducto() {
        $this->Principal->controlarSesion();

        $this->form_validation->set_rules('codigo_producto', 'Codigo', 'required');
        $this->form_validation->set_rules('nombre_producto', 'Producto', 'required');
        //$this->form_validation->set_rules('precio_producto', 'Precio', 'required|numeric');
        //$this->form_validation->set_rules('descripcion_producto', 'Descripcion', 'required');
        //$this->form_validation->set_rules('upload_imagen', 'Imagen', 'required');

        if ($this->form_validation->run() == false) {
            $this->cargarFormularioProducto();
        } else {
            $id = $this->Producto->registrarProducto();
            if ($id != -1) {
                $enlaces = array();
                $enlaces[] = array(
                    'link' => base_url(),
                    'texto' => "Ir al inicio"
                );
                $enlaces[] = array(
                    'link' => base_url() .
                    "index.php/ControladorProducto/vistaProducto/" . $id,
                    'texto' => "Ver Producto"
                );
                $enlaces[] = array(
                    'link' => base_url() .
                    "index.php/ControladorProducto/CargarFormularioProducto/",
                    'texto' => "Registrar otro producto"
                );

                $data['titulo'] = "Producto registrado:";
                $data['enlaces'] = $enlaces;
                $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
                $data['contenido'] = $this->load->view('/mensajes/seccion_temporal', $data, true);
                $this->load->view('index', $data);
            } else {
                $enlaces = array();
                $enlaces[] = array(
                    'link' => base_url() .
                    "index.php/ControladorProducto/CargarFormularioProducto/",
                    'texto' => "Volver a intentar"
                );

                $data['titulo_error'] = "Producto no registrado:";
                $data['mensaje_error'] = "Ya existe un producto con el mismo codigo";
                $data['enlace'] = base_url() .
                        "index.php/ControladorProducto/registrarProducto/";
                $data['textoEnlace'] = "Intentar registrar otra vez";
                $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
                $data['contenido'] = $this->load->view('/errors/errores', $data, true);
                $this->load->view('index', $data);
            }
        }
    }

    public function cargarFormularioProducto() {
        $this->Principal->controlarSesion();

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/nuevo_producto', '', true);
        $this->load->view('index', $data);
    }

    public function mostrarVistaProductos() {
        $this->Principal->controlarSesion();

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/menu_central_productos', '', true);
        $this->load->view('index', $data);
    }

    public function mostrarProductos() {
        $this->Principal->controlarSesion();

        $paginacion = 15;

        $config['base_url'] = base_url() .
                "index.php/ControladorProducto/mostrarProductos";
        $config['total_rows'] = $this->Producto->totalProductos();
        $config['per_page'] = $paginacion;
        $config['num_links'] = 10;
        $config['first_link'] = 'Primera';
        $config['last_link'] = 'Última';
        $config['next_link'] = 'Siguiente »';
        $config['prev_link'] = '« Anterior';


        $this->pagination->initialize($config);

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['productos'] = $this->Producto->
                getProductosPaginacion($paginacion, $this->uri->segment(3));
        $data['contenido'] = $this->load->view('/contents/lista_productos', $data, true);
        $this->load->view('index', $data);
    }

    public function mostrarAlfabeticamente($letra) {
        $this->Principal->controlarSesion();

        if (strlen($letra) == 1) {
            $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
            $data['productos'] = $this->Producto->getOrdenAlfabetico($letra);
            $data['contenido'] = $this->load->view('/contents/lista_productos', $data, true);
            $this->load->view('index', $data);
        }
    }

    public function mostrarBusqueda() {
        $this->Principal->controlarSesion();

        $filtro = $_POST['busqueda_productos'];

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['productos'] = $this->Producto->buscarPorNombre($filtro);
        $data['contenido'] = $this->load->view('/contents/lista_productos', $data, true);
        $this->load->view('index', $data);
    }

    public function cargarVistaEdicion($id) {
        $this->Principal->controlarSesion();

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['producto'] = $this->Producto->getProducto($id);
        $data['contenido'] = $this->load->view('/contents/editar_producto', $data, true);
        $this->load->view('index', $data);
    }

    public function recibirPostAjax() {
        isset($_POST['opcion']) ? $opcion = $_POST['opcion'] : $opcion = "";
        switch ($opcion) {
            case 'getProductos':
                $productos = json_decode($_POST['productos']);
                echo json_encode($this->Producto->getArrayProductos($productos));
                break;
            case 'buscar':
                $filtroBusqueda = $_POST['filtroBusqueda'];
                $categoria = $_POST['categoria'];
                if($categoria == "-1") {
                    $productos = $this->Producto->
                            buscarPorNombre($filtroBusqueda);
                } else {
                    $productos = $this->Producto->
                        buscarPorCategoria($filtroBusqueda, $categoria);
                }
                echo json_encode($productos);
                break;
            default:
                echo "por defecto";
                break;
        }
    }

    public function vistaProducto($idProducto = "") {
        $this->Principal->controlarSesion();

        if (!$idProducto == "") {
            $this->session->set_userdata('id_producto', $idProducto);
        }

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['producto'] = $this->Producto->
                getProducto($this->session->userdata('id_producto'));
        $data['contenido'] = $this->load->view('/contents/informacion_producto', $data, true);
        $this->load->view('index', $data);
    }

    public function guardarEdicion() {
        $this->form_validation->set_rules('precio_producto', 'Precio', 'required|numeric');
        $this->form_validation->set_rules('descripcion_producto', 'Descripcion', 'required');

        if ($this->form_validation->run() == false) {
            $this->cargarVistaEdicion($_POST['id_producto']);
        } else {
            $this->Producto->guardarEdicion();
            $this->vistaProducto($_POST['id_producto']);
        }
    }

    public function operacionesProducto($id, $opcion) {


        switch ($opcion) {
            case 'editar':
                $this->cargarVistaEdicion($id);
                break;
            case 'agregar_componente':
                $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
                $data['producto'] = $this->Producto->getProducto($id);
                $data['contenido'] = $this->load->view('/contents/add_componente', $data, true);
                $this->load->view('index', $data);
                break;
            default:
                break;
        }
    }

    public function formEdicionComponente($idComponente) {
        $data['producto'] = $this->Producto->getNombre(
                $this->session->userdata('id_producto'));
        $data['componente'] = $this->Producto->getComponente($idComponente);
        $data['menu_lateral'] = $this->load->view(
                '/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view(
                '/contents/form_edicion_componente', $data, true);
        $this->load->view('index', $data);
    }

    public function guardarEdicionComponente($idComponente) {
        $this->form_validation->set_rules(
                'componente', 'Especificacion', 'required|trim');
        $this->form_validation->set_rules(
                'cantidad', 'Cantidad', 'required|is_natural_no_zero');
        if ($this->form_validation->run() == false) {
            $this->formEdicionComponente($idComponente);
            echo "false";
        } else {
            $this->Producto->editarComponente($idComponente);
            $this->vistaProducto();
        }
    }

    public function formEdicionPractica($idPractica) {
        $data['nombre_producto'] = $this->Producto->getNombre(
                $this->session->userdata('id_producto'));
        $data['practica'] = $this->Producto->getPractica($idPractica);

        $data['menu_lateral'] = $this->load->view(
                '/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view(
                '/contents/form_edicion_practica', $data, true);
        $this->load->view('index', $data);
    }

    public function guardarEdicionPractica($idPractica) {
        $this->form_validation->set_rules('practica_realizable', 'Practica realizable', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->formEdicionPractica($idPractica);
        } else {
            $this->Producto->EditarPracticaRealizable($idPractica);
            $this->vistaProducto();
        }
    }

    public function eliminarPractica($idPractica) {
        $this->Producto->eliminarPractica($idPractica);
        $this->vistaProducto();
    }

    public function agregarComponente() {
        $this->Principal->controlarSesion();

        $id = $_POST['id'];
        $this->form_validation->set_rules('nombre_componente', 'Componente', 'required');
        $this->form_validation->set_rules('cantidad_componente', 'Cantidad', 'required|numeric');

        if ($this->form_validation->run() == false) {
            $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
            $data['producto'] = $this->Producto->getProducto($id);
            $data['contenido'] = $this->load->view('/contents/add_componente', $data, true);
            $this->load->view('index', $data);
        } else {
            $this->Producto->registrarComponente();
            $this->vistaProducto($id);
        }
    }

    public function formPracticaRealizable() {
        $this->Principal->controlarSesion();
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['producto'] = $this->Producto->getProducto(
                $this->session->userdata('id_producto'));
        $data['contenido'] = $this->load->view('/contents/form_practica_realizable', $data, true);
        $this->load->view('index', $data);
    }

    public function formAsignacion() {
        $this->Principal->controlarSesion();

        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['nombre_producto'] = $this->Producto->getNombre(
                $this->session->userdata('id_producto'));
        $data['categorias'] = $this->Categoria->getCategoriasInferiores();
        $data['contenido'] = $this->load->view('/contents/form_asignacion_categoria', $data, true);
        $this->load->view('index', $data);
    }

    public function registrarPracticaRealizable() {
        $this->Principal->controlarSesion();

        $this->form_validation->set_rules('practica_realizable', 'Practica realizable', 'required');

        if ($this->form_validation->run() == false) {
            $this->formAsignacion();
        } else {
            $this->Producto->agregarPracticaRealizable(
                    $this->session->userdata('id_producto'));
            $this->vistaProducto();
        }
    }

    public function eliminarComponente($idComponente) {
        $this->Producto->EliminarComponente($idComponente);
        $this->vistaProducto();
    }

    public function formActualizarFoto() {

        $data['id_producto'] = $this->session->userdata('id_producto');
        $data['menu_lateral'] = $this->load->view('/contents/menu_lateral', '', true);
        $data['contenido'] = $this->load->view('/contents/form_actualizar_foto', $data, true);
        $this->load->view('index', $data);
    }

    public function guardarFoto() {

        $archivoFoto = $_FILES['foto_producto'];
        $this->Producto->actualizarFoto($archivoFoto, $this->session->userdata('id_producto'));
        $this->vistaProducto();
    }

}

?>