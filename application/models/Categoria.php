<?php

class Categoria extends CI_Model {

    var $categorias = array();

    function __construct() {
        parent::__construct();
        
    }

    public function construirArbol() {
        $sql = "SELECT c.ID_CATEGORIA
                FROM CATEGORIA c
                WHERE c.ID_CATEGORIA NOT IN(
	SELECT j.CAT_ID_CATEGORIA
	FROM jerarquia_categoria j)";

        $nodosSup = $this->db->query($sql)->result_array();
        print_r($nodosSup);
    }

    public function getNodosSuperiores() {
        $sql = "SELECT c.*
                FROM CATEGORIA c
                WHERE c.ID_CATEGORIA NOT IN(
	SELECT j.CAT_ID_CATEGORIA
	FROM jerarquia_categoria j)";

        $nodosSup = $this->db->query($sql)->result_array();
        return $nodosSup;
    }
    
    
    
    public function cantidadNodosSuperiores() {
        $sql = "SELECT c.*
                FROM CATEGORIA c
                WHERE c.ID_CATEGORIA NOT IN(
	SELECT j.CAT_ID_CATEGORIA
	FROM jerarquia_categoria j)";
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    public function getHijos($idCategoria) {
        $sql = "SELECT j.CAT_ID_CATEGORIA 
                FROM CATEGORIA c, JERARQUIA_CATEGORIA j
                WHERE c.ID_CATEGORIA = j.ID_CATEGORIA 
                AND j.ID_CATEGORIA = '$idCategoria  '";
        $nodosHijos = $this->db->query($sql)->result_array();
        $res = array();
        foreach ($nodosHijos as $nodo) {
            $res[] = $this->getCategoria($nodo['CAT_ID_CATEGORIA']);
        }
        return $res;
    }

    public function getCategoria($idCategoria) {
        $sql = "SELECT * "
                . "FROM CATEGORIA "
                . "where ID_CATEGORIA='$idCategoria' LIMIT 1";
        return $this->db->query($sql)->row_array();
    }
    
    public function getCategorias() {
        $query = $this->db->get('CATEGORIA');
        return $query->result_array();
    }

    public function subdiviciones($id) {
        $res = false;
        $sql = "SELECT j.CAT_ID_CATEGORIA 
                FROM CATEGORIA c, JERARQUIA_CATEGORIA j
                WHERE c.ID_CATEGORIA = j.ID_CATEGORIA 
                AND j.ID_CATEGORIA = '$id'";
        $query = $this->db->query($sql);
        if($query->num_rows() > 0) {
            $res = true;
        }
        return $res;
    }

    public function crearCategoria($arrayCategoria) {
        $res = false;
        if(gettype($arrayCategoria) == "array" && count($arrayCategoria) == 2) {
            $nombre = $arrayCategoria['NOMBRE_CATEGORIA'];
            $sql = "SELECT * FROM CATEGORIA "
                    . "WHERE NOMBRE_CATEGORIA='$nombre'";
            $query = $this->db->query($sql);
            if($query->num_rows() == 0) {
                $this->db->insert('CATEGORIA',$arrayCategoria);
                $res = true;
            }
        }
        return $res;
    }
    
    public function getCategoriasInferiores() {
        $sql = "";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function rectriccionCatSuperior($id) {
        return !($this->cantidadNodosSuperiores() > 1);
    }
    
    public function restriccionCatInferior($idSup, $idInf) {
        
    }
    
    public function estaDebajoDe($idCatSuperior, $idCatInferior) {
        $idHijo = $idCatInferior;
        $encontrado = false;
        do {
            $sql = "SELECT ID_CATEGORIA 
                FROM JERARQUIA_CATEGORIA
                WHERE CAT_ID_CATEGORIA = '$idHijo'";
            $query = $this->db->query($sql);
            if($query->num_rows() == 1) {
                $idPadre = $query->row()->ID_CATEGORIA;
                if($idPadre == $idCatSuperior) {
                    $encontrado = true;
                    
                }
                $idHijo = $idPadre;
            }
            
        } while($query->num_rows() == 1 && $encontrado == false);
        return $encontrado;
    }
    
    public function asignarSubdivision($idCatSuperior, $idCatInferior) {
        $res = false;
        if($this->esNodoSuperior($idCatInferior) && 
            $this->cantidadNodosSuperiores() > 1 && 
                $idCatSuperior != $idCatInferior) {
            $relCategoria = array(
                'ID_CATEGORIA' => $idCatSuperior,
                'CAT_ID_CATEGORIA' => $idCatInferior
            );
            $this->db->insert('JERARQUIA_CATEGORIA', $relCategoria);
            $res = true;
        }
        return $res;
    }
    
    public function esNodoSuperior($id) { 
        $res = false;
        $sql = "SELECT c.*
                FROM CATEGORIA c
                WHERE c.ID_CATEGORIA NOT IN(
                SELECT j.CAT_ID_CATEGORIA
                FROM JERARQUIA_CATEGORIA j) AND c.ID_CATEGORIA = '$id'";
        $query = $this->db->query($sql);
        if($query->num_rows() == 1) {
            $res = true;
        } 
        return $res;
    }
    
    /**
     * Genera un array de categorias que pueden asignarse a otra categoria 
     * en este caso el $idSup es la categoria superior a la que se le pueden 
     * asignar categorias hijos de $idCat 
     * 
     * @return array de categorias 
     * @param integer $idCat id de una tupla de la tabla CATEGORIA
     */
    public function categoriasPermisibles($idCat) {
        $res = array();
        $sql = "SELECT c.*
                FROM CATEGORIA c
                WHERE c.ID_CATEGORIA NOT IN(
                SELECT j.CAT_ID_CATEGORIA
                FROM JERARQUIA_CATEGORIA j) AND c.ID_CATEGORIA != '$idCat'";
        $query = $this->db->query($sql);
        $categorias = $query->result_array();
        foreach ($categorias as $categoria) {
            $idSup = $categoria['ID_CATEGORIA'];  
            if(!$this->estaDebajoDe($idSup, $idCat)) {
                $res[] = $categoria;
            }
        }
        return $res;
    }
    
    public function registrarSubdivision() {
        $idSup = $_POST['id_superior'];
        $idInf = $_POST['id_inferior'];
        $jerarquia = array(
            'ID_CATEGORIA' => $idSup,
            'CAT_ID_CATEGORIA' =>$idInf
        );  
        $this->db->insert('JERARQUIA_CATEGORIA', $jerarquia);
    }
}
