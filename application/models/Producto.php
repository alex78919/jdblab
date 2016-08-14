<?php

class Producto extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('Principal');
    }

    public function registrarProducto() {
        $id = -1;
        $nombre = $this->Principal->preparacionTexto($_POST['nombre_producto']);
        $codigo = $this->Principal->preparacionTexto($_POST['codigo_producto']);
        $descripcion = $this->Principal->preparacionTexto($_POST['descripcion_producto']);
        $precio = $_POST['precio_producto'];

        $sql = "SELECT * FROM PRODUCTO "
                . "WHERE CODIGO_PRODUCTO='$codigo' LIMIT 1";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 0) {

            $producto = array(
                'CODIGO_PRODUCTO' => $codigo,
                'NOMBRE_PRODUCTO' => $nombre,
                'DESCRIPCION_PRODUCTO' => $descripcion,
                'PRECIO_PRODUCTO' => $precio,
                'RUTA_IMAGEN' => null
            );
            $this->db->insert('PRODUCTO', $producto);
            $id = $this->db->insert_id();
            $this->subirArchivo($id);
        }

        return $id;
    }

    public function subirArchivo($idProducto) {
        if ($_FILES['upload_imagen']['size'] > 0) {
            copy($_FILES['upload_imagen']['tmp_name'], "fotos_productos/" .
                    $_FILES['upload_imagen']['name']);
            $archivo = $_FILES['upload_imagen']['name'];
            $sql = "UPDATE PRODUCTO SET RUTA_IMAGEN='$archivo'"
                    . "WHERE ID_PRODUCTO='$idProducto'";
            $this->db->query($sql);
        }
    }

    public function getNombre($id) {
        $sql = "SELECT NOMBRE_PRODUCTO FROM PRODUCTO "
                . "WHERE ID_PRODUCTO='$id' LIMIT 1";
        $query = $this->db->query($sql);
        $row_array = $query->row_array();
        return $row_array['NOMBRE_PRODUCTO'];
    }

    public function getProductos() {
        $query = $this->db->get('PRODUCTO');
        return $query->result_array();
    }

    public function getProductosPaginacion($paginacion, $segmento) {
        $this->db->order_by('NOMBRE_PRODUCTO', 'asc');
        $this->db->limit($paginacion, $segmento);
        $query = $this->db->get('PRODUCTO');
        return $query->result_array();
    }

    public function getProducto($idProducto) {
        $sql = "SELECT pr.* FROM PRODUCTO p, PRACTICA_REALIZABLE pr "
                . "WHERE p.ID_PRODUCTO = pr.ID_PRODUCTO "
                . "AND p.ID_PRODUCTO='$idProducto'";
        $query = $this->db->query($sql);
        $arrayPracticas = $query->result_array();

        $sql = "SELECT c.* FROM PRODUCTO p, COMPONENTE c "
                . "WHERE p.ID_PRODUCTO = c.ID_PRODUCTO "
                . "AND p.ID_PRODUCTO='$idProducto'";
        $query = $this->db->query($sql);
        $arrayComponentes = $query->result_array();

        $query = $this->db->query("SELECT * FROM PRODUCTO "
                . "WHERE ID_PRODUCTO='$idProducto' LIMIT 1");
        $producto = $query->row_array();

        $producto = array('id' => $producto['ID_PRODUCTO'],
            'codigo' => $producto['CODIGO_PRODUCTO'],
            'nombre' => $producto['NOMBRE_PRODUCTO'],
            'descripcion' => $producto['DESCRIPCION_PRODUCTO'],
            'precio' => $producto['PRECIO_PRODUCTO'],
            'ruta_imagen' => $producto['RUTA_IMAGEN'],
            'practicas' => $arrayPracticas,
            'componentes' => $arrayComponentes);
        return $producto;
    }

    public function getArrayProductos($arrayIdProductos) {
        $res = array();
        foreach ($arrayIdProductos as $id) {
            $res[] = $this->getProducto($id);
        }
        return $res;
    }

    public function buscarProductoPorNombre($filtroBusqueda) {
        $sql = "SELECT p.*
                FROM PRODUCTO p
                WHERE p.NOMBRE_PRODUCTO LIKE '%$filtroBusqueda%' OR p.CODIGO_PRODUCTO LIKE '%$filtroBusqueda%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function registrarPractica() {
        $practica = array(
            'ID_PRODUCTO' => $_POST['id_producto'],
            'DESCRIPCION_PRACTICA' => $_POST['practica_producto']
        );
        $this->db->insert('PRACTICA_REALIZABLE', $practica);
        return true;
    }

    public function registrarComponente() {
        $componente = array(
            'ID_PRODUCTO' => $_POST['id'],
            'ESPECIFICACION_COMPONENTE' => $this->Principal->
                    preparacionTexto($_POST['nombre_componente']),
            'NUMERO_COMPONENTES' => $_POST['cantidad_componente']
        );
        $this->db->insert('COMPONENTE', $componente);
        return true;
    }

    public function guardarEdicion() {
        $descripcion = $this->Principal->preparacionTexto($_POST['descripcion_producto']);
        $precio = $_POST['precio_producto'];
        $id = $_POST['id_producto'];
        $sql = "UPDATE PRODUCTO SET DESCRIPCION_PRODUCTO='$descripcion', "
                . "PRECIO_PRODUCTO='$precio' "
                . "WHERE ID_PRODUCTO='$id'";
        $this->db->query($sql);
        return true;
    }

    public function asignarCategoria($idProducto, $idCategoria) {
        $res = false;
        if (!$this->Categoria->subdivisiones($idCategoria)) {
            $categoriaProd = array(
                'ID_CATEGORIA' => $idCategoria,
                'ID_PRODUCTO' => $idProducto
            );

            $this->db->insert('CATEGORIA_PRODUCTO', $categoriaProd);
            $res = true;
        }
        return $res;
    }

    public function getOrdenAlfabetico($letra = "a") {
        if (strlen($letra) == 1) {
            $sql = "SELECT * FROM PRODUCTO "
                    . "WHERE NOMBRE_PRODUCTO LIKE '$letra%'";
        } else {
            $sql = "SELECT * FROM PRODUCTO "
                    . "WHERE NOMBRE_PRODUCTO LIKE 'a%'";
        }
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function totalProductos() {
        return $this->db->count_all('PRODUCTO');
    }

    public function buscarPorNombre($filtro) {
        $sql = "SELECT * FROM PRODUCTO "
                . "WHERE NOMBRE_PRODUCTO LIKE '%$filtro%'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function buscarPorCategoria($filtro, $categoria)  {
        $sql = "SELECT p.*  
                FROM PRODUCTO p, CATEGORIA c, CATEGORIA_PRODUCTO cp
                WHERE p.ID_PRODUCTO = cp.ID_PRODUCTO and c.ID_CATEGORIA = cp.ID_CATEGORIA 
                AND p.NOMBRE_PRODUCTO LIKE '%$filtro%'
                AND c.ID_CATEGORIA IN (
                SELECT j.CAT_ID_CATEGORIA 
                FROM CATEGORIA c, JERARQUIA_CATEGORIA j
                WHERE c.ID_CATEGORIA = j.ID_CATEGORIA 
                AND j.ID_CATEGORIA = '$categoria' 
                ) UNION 
                SELECT p.*  
                FROM producto p, categoria c, categoria_producto cp
                WHERE p.ID_PRODUCTO = cp.ID_PRODUCTO and c.ID_CATEGORIA = cp.ID_CATEGORIA 
                and c.ID_CATEGORIA = '$categoria' "
                . "AND p.NOMBRE_PRODUCTO LIKE '%$filtro%'";
                
        $query = $this->db->query($sql);
        return $query->result_array();    
    }

    public function agregarPracticaRealizable($id) {
        $descripcion_practica = $this->
                Principal->preparacionTexto($_POST['practica_realizable']);
        $practica = array(
            'ID_PRODUCTO' => $id,
            'DESCRIPCION_PRACTICA' => $descripcion_practica
        );
        $this->db->insert('PRACTICA_REALIZABLE', $practica);
    }
    
    public function getPractica($idPractica) { 
        $sql = "SELECT * FROM PRACTICA_REALIZABLE "
                . "WHERE ID_PRACTICA='$idPractica' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    
    public function editarPracticaRealizable($idPractica) {
        $practica = $this->Principal->
                preparacionTexto($_POST['practica_realizable']);
        
        $sql = "UPDATE PRACTICA_REALIZABLE SET "
                . "DESCRIPCION_PRACTICA='$practica' "
                . "WHERE ID_PRACTICA='$idPractica'";
        $query = $this->db->query($sql);
    }
    
    public function eliminarPractica($idPractica) {
        $sql = "DELETE FROM PRACTICA_REALIZABLE WHERE ID_PRACTICA='$idPractica'";
        $this->db->query($sql);
    }
    
    public function editarComponente($idComponente) {
        $componente = $this->Principal->
                preparacionTexto($_POST['componente']);
        $cantidad = abs($_POST['cantidad']);
        
        $sql = "UPDATE COMPONENTE SET "
                . "ESPECIFICACION_COMPONENTE='$componente',"
                . "NUMERO_COMPONENTES='$cantidad' "
                . "WHERE ID_COMPONENTE='$idComponente'";
        $query = $this->db->query($sql);
    }
    
    public function getComponente($idComponente) {
        $sql = "SELECT * FROM COMPONENTE "
                . "WHERE ID_COMPONENTE='$idComponente' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }
    
    public function eliminarComponente($idComponente) {
        $sql = "DELETE FROM COMPONENTE WHERE ID_COMPONENTE = '$idComponente'";
        $this->db->query($sql);
    }
    
    public function actualizarFoto($archivoFoto, $idProducto) {
        if($archivoFoto['size'] > 0) {
            copy($archivoFoto['tmp_name'], "fotos_productos/" .
                    $archivoFoto['name']);
            $archivo = $archivoFoto['name'];
            $sql = "UPDATE PRODUCTO SET RUTA_IMAGEN='$archivo'"
                    . "WHERE ID_PRODUCTO='$idProducto'";
            $this->db->query($sql);
        }
    }

    
}
