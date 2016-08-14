<?php
class ClasificacionProveedor extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    public function insertar($nombre, $descripcion) { 
        $this->db->trans_begin();
        $clasificacion = array(
            'NOMBRE_CLASIFICACION' => trim($nombre),
            'DESCRIPCION_CLASIFICACION' => trim($descripcion)
        );
        $this->db->insert('CLASIFICACION_PROVEEDOR', $clasificacion);
    }
    
    
}

