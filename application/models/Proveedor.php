<?php

class Proveedor extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function registrarProveedor($nombre, $descripcion, 
            $direccion, $telefono, $email) {
        $res = -1;
        $proveedor = array(
            'NOMBRE_PROVEEDOR' => trim($nombre),
            'DESCRIPCION_PROVEEDOR' => trim($descripcion),
            'DIRECCION_PROVEEDOR' => trim($direccion),
        );

        $this->db->trans_begin();
        $this->db->insert('PROVEEDOR', $proveedor);
        $idProveedor = $this->db->insert_id();

        if (strlen($telefono) > 0) {
            $telf = array(
                'ID_TIPO_TELF' => NULL,
                'NUMERO_TELEFONO' => $telefono,
                'DESCRIPCION_TELEFONO' => NULL
            );
            $this->db->insert('TELEFONO', $telf);

            $telefonoProveedor = array(
                'ID_TELEFONO' => $this->db->insert_id(),
                'ID_PROVEEDOR' => $idProveedor
            );
            $this->db->insert('TELEFONO_PROVEEDOR', $telefonoProveedor);
        }

        if (strlen($email) > 0) {
            $mail = array(
                'NOMBRE_EMAIL' => $email,
                'DESC_EMAIL' => NULL
            );
            $this->db->insert('EMAIL', $mail);

            $mailProveedor = array(
                'ID_EMAIL' => $this->db->insert_id(),
                'ID_PROVEEDOR' => $idProveedor
            );
            $this->db->insert('PROVEEDOR_EMAIL', $mailProveedor);
        }


        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $res = $idProveedor;
        }
        return $res;
    }

    public function verificarNombre($nombre) {
        $res = false;
        $sql = "SELECT * FROM PROVEEDOR "
                . "WHERE NOMBRE_PROVEEDOR='$nombre'";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 0) {
            $res = true;
        }
        return $res;
    }
    
    public function getProveedores() { 
        $query = $this->db->get('proveedor');
        return $query->result_array();
    }
    
    public function getProveedor($idProveedor) {
        $sql = "SELECT * FROM PROVEEDOR "
                . "WHERE ID_PROVEEDOR='$idProveedor' LIMIT 1";
        $query = $this->db->query($sql);
        $row = $query->row_array();
        
        $telefonos = $this->getTelefonos($idProveedor);
        $emails = $this->getEmails($idProveedor);
        $grupos = $this->getGrupos($idProveedor);
        $proveedor = array(
            'id' => $row['ID_PROVEEDOR'],
            'nombre' => $row['NOMBRE_PROVEEDOR'],
            'descripcion' => $row['DESCRIPCION_PROVEEDOR'],
            'direccion' => $row['DIRECCION_PROVEEDOR'],
            'telefonos' => $telefonos,
            'emails' => $emails,
            'grupos' => $grupos
        );
        return $proveedor;
    }
    
    public function getTelefonos($idProveedor) { 
        $sql = "SELECT t.*, tt.NOMBRE_TIPO_TELF
                FROM TELEFONO t, TELEFONO_PROVEEDOR tp, 
                PROVEEDOR p, TIPO_TELEFONO tt
                WHERE p.ID_PROVEEDOR=tp.ID_PROVEEDOR AND 
               tp.ID_TELEFONO=t.ID_TELEFONO AND 
               tt.ID_TIPO_TELF=t.ID_TIPO_TELF AND
               p.ID_PROVEEDOR='$idProveedor'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getEmails($idProveedor) { 
        $sql = "SELECT e.* FROM EMAIL e, PROVEEDOR_EMAIL pe, "
                . "PROVEEDOR p "
                . "WHERE p.ID_PROVEEDOR=pe.ID_PROVEEDOR AND "
                . "pe.ID_EMAIL=e.ID_EMAIL AND "
                . "p.ID_PROVEEDOR='$idProveedor'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getGrupos($idProveedor) { 
        $sql = "SELECT c.* "
                . "FROM CLASIFICACION_PROVEEDOR c, PROVEEDOR_GRUPO pg, "
                . "PROVEEDOR p "
                . "WHERE p.ID_PROVEEDOR=pg.ID_PROVEEDOR AND "
                . "pg.ID_CLASIFICACION=c.ID_CLASIFICACION AND "
                . "p.ID_PROVEEDOR='$idProveedor'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    public function getGruposExclude($idProveedor, $filtro) { 
        $sql = "SELECT * FROM CLASIFICACION_PROVEEDOR
                WHERE ID_CLASIFICACION NOT IN 
                (SELECT c.ID_CLASIFICACION 
                FROM CLASIFICACION_PROVEEDOR c, PROVEEDOR_GRUPO pg, 
                PROVEEDOR p 
                WHERE p.ID_PROVEEDOR=pg.ID_PROVEEDOR AND 
                pg.ID_CLASIFICACION=c.ID_CLASIFICACION AND 
                p.ID_PROVEEDOR='$idProveedor') AND "
                . "NOMBRE_CLASIFICACION LIKE '%$filtro%'";
        
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function registrarGrupo($nombre, $descripcion) {
        $grupo = array(
            'NOMBRE_CLASIFICACION' => $nombre,
            'DESCRIPCION_CLASIFICACION' => $descripcion,
        );
        $this->db->insert('CLASIFICACION_PROVEEDOR', $grupo);
        return $this->db->insert_id();
    }

    public function verificarGrupo($nombreGrupo) {
        $res = false;
        $sql = "SELECT * FROM CLASIFICACION_PROVEEDOR 
            WHERE NOMBRE_CLASIFICACION='$nombreGrupo' LIMIT 1";
        $query = $this->db->query($sql);
        if($query->num_rows() == 0) {
            $res = true;
        }
        return $res;
    }
    
    public function asignarGrupos($grupos) {
        $this->db->trans_start();
        foreach ($grupos as $grupo) { 
            $grp = array(
                'ID_CLASIFICACION' => $grupo,
                'ID_PROVEEDOR' => $this->session->userdata('id_proveedor')
            );
            $this->db->insert('PROVEEDOR_GRUPO', $grp);
        }
        $this->db->trans_complete();
    }
    
    public function getGruposAll() {
        $query = $this->db->get('CLASIFICACION_PROVEEDOR');
        return $query->result();
    }
    
    public function miembrosGrupo($idGrupo) {
        $sql = "SELECT p.* 
                FROM PROVEEDOR p, PROVEEDOR_GRUPO pg, CLASIFICACION_PROVEEDOR c
                WHERE p.ID_PROVEEDOR = pg.ID_PROVEEDOR 
                AND pg.ID_CLASIFICACION = c.ID_CLASIFICACION 
                AND c.ID_CLASIFICACION = '$idGrupo'";
        $query = $this->db->query($sql);
        return $query->result();
    }
    
    public function getGrupo($idGrupo) { 
        $sql = "SELECT * "
                . "FROM CLASIFICACION_PROVEEDOR "
                . "WHERE ID_CLASIFICACION='$idGrupo' LIMIT 1";
        $row = $this->db->query($sql)->row();
        $grupo = array(
            'id' => $row->ID_CLASIFICACION,
            'nombre' => $row->NOMBRE_CLASIFICACION,
            'descripcion' => $row->DESCRIPCION_CLASIFICACION,
            'miembros_grupo' => $this->miembrosGrupo($idGrupo)
        );
        return $grupo;
    }
    
    public function eliminarMiembro($idProveedor) {
        $idGrupo = $this->session->userdata('id_grupo');
        $sql = "DELETE FROM PROVEEDOR_GRUPO WHERE "
                . "ID_CLASIFICACION='$idGrupo' AND ID_PROVEEDOR='$idProveedor'";
        $this->db->query($sql);
    }
}
