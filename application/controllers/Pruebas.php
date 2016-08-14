<?php

class Pruebas extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Cliente');
        $this->load->model('Producto');
        $this->load->model('Proforma');
        $this->load->model('Categoria');
        $this->load->model('Proveedor');
    }

    public function probarCliente() {
        print_r($this->Cliente->getCliente("1"));
    }

    public function probarProducto() {
        $res = $this->Producto->getProducto(2);
        print_r($res);
    }

    public function testGetCliente() {
        $cliente = $this->Cliente->getCliente(1);
        echo $cliente['nombres'];
    }

    public function probarPrototipo() {
        $p1 = $this->load->model('Prototipo');
        $this->Prototipo->getInstance("Alexander", 30);
        echo $this->Prototipo->nombre;
        $this->load->model('Prototipo', 'objeto2');
        $this->objeto2->getInstance("Remberto", 29);
        echo $this->objeto2->nombre;

        $this->Prototipo->setNombre("Enredoncio");
        $this->objeto2->setNombre("Justino");

        echo "<br>" . $this->objeto2->nombre;
        echo "<br>" . $this->Prototipo->nombre;

        $p2 = new Prototipo();
        $p2->getInstance("p2", 0);
    }

    public function testTree() {
        $this->load->model('Categoria');
        $this->Categoria->construirArbol();
    }

    public function conectar() {
        $config['hostname'] = "localhost";
        $config['username'] = "root";
        $config['password'] = "";
        $config['database'] = "jdblab_v1";
        $config['dbdriver'] = "mysqli";
        $config['dbprefix'] = "";
        $config['pconnect'] = FALSE;
        $config['db_debug'] = TRUE;
        $config['cache_on'] = FALSE;
        $config['cachedir'] = "";
        $config['char_set'] = "utf8";
        $config['dbcollat'] = "utf8_general_ci";

        $db = $this->load->database($config, true);

        /*$res_db = $db->get('productos')->result_array();
        foreach($res_db as $row) {
        
        $producto = array(
            'ID_PRODUCTO' => $row['id_prod'],
            'CODIGO_PRODUCTO' => '0012',
            'NOMBRE_PRODUCTO' => $row['nombre'],
            'DESCRIPCION_PRODUCTO' => null,
            'PRECIO_PRODUCTO' => 0,
            'RUTA_IMAGEN' => null
            );
            $this->db->insert('producto', $producto);
        */
        /*    $archivo = $row['img'];
            $archivo = substr($archivo, 7);
            $id = $row['id_prod'];
            $sql = "UPDATE PRODUCTO set RUTA_IMAGEN='$archivo' "
                    . "WHERE ID_PRODUCTO = '$id'";
            $this->db->query($sql);
        /*               
        }*/

        $clientes = $db->get('CLIENTE')->result_array();
        $emails = array();
        $this->db->trans_start();
        foreach($clientes as $cliente) {
            $cl = array(
                'ID_PERSONA' => $cliente['ID_CLIENTE'],
                'ID_INSTITUCION' => $cliente['ID_INSTITUCION'],
                'ID_PROFESION' => $cliente['ID_PROFESION'],
                'ID_CARGO' => $cliente['ID_CARGO'],
                'ID_CIUDAD' => $cliente['ID_CIUDAD']
            );
            $this->db->insert('cliente', $cl);
        }
        $this->db->trans_complete();
        /*
        $sql = "SELECT t.* 
from cliente c, telefono t
where c.ID_CLIENTE = t.ID_TELEFONO";
        $telefonos = $db->query($sql)->result();
        $this->db->trans_start();
        foreach($telefonos as $telefono) { 
            
            $telf = array(
                'ID_TELEFONO' => $telefono->ID_TELEFONO,
                'ID_TIPO_TELF' => null,
                'NUMERO_TELEFONO' => $telefono->NUMERO_TELEFONO,
                'DESCRIPCION_TELEFONO' => NULL
            );
            $this->db->insert('telefono', $telf);
            $telfPersona = array(
                'ID_TELEFONO' => $telefono->ID_TELEFONO,
                'ID_PERSONA' => $telefono->ID_CLIENTE
            ); 
            $this->db->insert('TELEFONO_PERSONA', $telfPersona);
        }
        $this->db->trans_complete();*/

    }
    
    public function testProforma() {
        print_r($this->Proforma->getProforma(1));
    }
    
    public function testClienteProformas() {
        $proformas = $this->Cliente->getProformas(4);
        print_r($proformas);
    }
    
    public function testReporte() {
        $this->Proforma->exportarProforma(3);
    }
    
    public function testNombreCompleto() {
        $nombre = $this->Cliente->getNombreCompleto(4);
        echo $nombre;
    }

    public function testSub() {
        $this->Categoria->subdiviciones(5);
    }

    public function testSuperior() {
        if($this->Categoria->esNodoSuperior(2)) {
            echo "Correcto es nodo superior!!!";
        }
        else { 
            echo "No es nodo superior";
        }
    }
    
    public function testAsignar() {
        if($this->Categoria->asignarSubdivision(1, 3)) {
            echo "Asignacion exitosa";
        }
        else { 
            echo "No se puede asignar";
        }
    }
    
    public function testBusqueda() {
        $prods = $this->Producto->buscarPorNombre("cono de caida");
        print_r($prods);
    }
    
    public function testCantidadNodos() {
        echo $this->Categoria->CantidadNodosSuperiores();
    }
    
    public function testEsSub() {
        if($this->Categoria->estaDebajoDe(11, 15)) {
            echo "es";
        }
        else {
            echo "no es";
        }
        
    }
    
    
    public function testNombres() {
        echo $this->Cliente->verificarNombres('alexandercorralesferrel') 
                ? "Verdad" : "Falso";
    }
    
    public function testAlfabetico() {
        $prod = $this->Producto->getOrdenAlfabetico('c');
        print_r($prod);
    }
    
    public function testNombreProducto() {
        $query = $this->db->get('producto');
        $productos = $query->result();
        foreach($productos as $producto) {
            echo $producto->NOMBRE_PRODUCTO . "<BR>";
        }
    }
    
    public function testPermisibles() {
        $cat = $this->Categoria->categoriasPermisibles(17);
        print_r($cat);
    }

    public function testSegmentado() {
        $clientes = $this->Cliente->busquedaSegmentada("profesion", "2", "");
        print_r($clientes);
    }
    
    public function testBusquedaCategoria() {
        $productos = $this->Producto->buscarPorCategoria('', '1');
        echo count($productos);
    }

    public function testWord(){
        $res = $this->Proforma->exportarProformaDetallada(1);
    }
    
    public function testNombreProveedor() { 
        $res = $this->Proveedor->verificarNombre("campero");
        echo $res == true ? "no existe" : "existe";
    }

    public function testExisteArchivo() {
        echo file_exists(FCPATH . "fotos_productos/SL-38.jpg") ? "existe" : "no existe";
        echo "<br>";
        echo FCPATH;
    }
    
    public function testGrupos() {
        $res = $this->Proveedor->miembrosGrupo(1);
        print_r($res);
    }
}

