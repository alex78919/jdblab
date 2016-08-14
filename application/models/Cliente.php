<?php

class Cliente extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('Proforma');
    }

    public function insertar() {
        $res = false;

        $nombre = $this->Principal->preparacionTexto($_POST['nombre_cliente']);
        $apellidop = $this->Principal->preparacionTexto($_POST['app_cliente']);
        $apellidom = $this->Principal->preparacionTexto($_POST['apm_cliente']);
        $email = $_POST['email_cliente'];
        $direccion = $this->Principal->preparacionTexto($_POST['direc_cliente']);
        $nitCliente = $this->Principal->preparacionTexto($_POST['nit_cliente']);

        if (!$this->verificarNombres($nombre . $apellidop . $apellidom)) {

            $this->db->trans_begin();
            $persona = array(
                'ID_PROVEEDOR' => NULL,
                'NOMBRES_PERSONA' => $nombre,
                'APELLIDO_P_PERSONA' => $apellidop,
                'APELLIDO_M_PERSONA' => $apellidom,
                'DIRECCION_PERSONA' => $direccion
            );
            $this->db->insert('PERSONA', $persona);
            $idPersona = $this->db->insert_id();

            $cliente = array(
                'ID_PERSONA' => $idPersona,
                'ID_INSTITUCION' => $_POST['institucion_cliente'] == "-2" ? NULL : $_POST['institucion_cliente'],
                'ID_PROFESION' => $_POST['profesion_cliente'] == "-2" ? NULL : $_POST['profesion_cliente'],
                'ID_CARGO' => $_POST['cargo_cliente'] == "-2" ? NULL : $_POST['cargo_cliente'],
                'ID_CIUDAD' => $_POST['ciudad_cliente'] == "-2" ? NULL : $_POST['ciudad_cliente'],
                'NIT_CI_CLIENTE' => $nitCliente
            );
            $this->db->insert('CLIENTE', $cliente);
            if ($_POST['telf_cliente'] != null) {
                $telefono = array('ID_TIPO_TELF' => NULL,
                    'NUMERO_TELEFONO' => $_POST['telf_cliente'],
                    'DESCRIPCION_TELEFONO' => NULL
                );
                $this->db->insert('TELEFONO', $telefono);
                $telfPersona = array(
                    'ID_TELEFONO' => $this->db->insert_id(),
                    'ID_PERSONA' => $idPersona
                );
                $this->db->insert('TELEFONO_PERSONA', $telfPersona);
            }

            if ($_POST['email_cliente'] != null) {
                $email = array(
                    'NOMBRE_EMAIL' => $_POST['email_cliente'],
                    'DESC_EMAIL' => NULL
                );
                $this->db->insert('EMAIL', $email);
                $personaEmail = array(
                    'ID_EMAIL' => $this->db->insert_id(),
                    'ID_PERSONA' => $idPersona
                );

                $this->db->insert('PERSONA_EMAIL', $personaEmail);
            }

            if ($this->db->trans_status() == false) {
                $this->db->trans_rollback();
            } else {
                $this->db->trans_commit();
                $res = true;
            }
        }

        return $res;
    }

    public function verificarNombres($nombreCompleto) {
        $res = true;
        $nombreCompleto;
        $sql = "SELECT *"
                . "FROM PERSONA "
                . "WHERE CONCAT(NOMBRES_PERSONA, APELLIDO_P_PERSONA, APELLIDO_M_PERSONA) = "
                . "'$nombreCompleto'";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 0) {
            $res = false;
        }
        return $res;
    }

    public function getNombreCompleto($id) {
        $sql = "SELECT NOMBRES_PERSONA, APELLIDO_P_PERSONA, APELLIDO_M_PERSONA "
                . "FROM PERSONA "
                . "WHERE ID_PERSONA='$id' LIMIT 1";
        $query = $this->db->query($sql)->row_array();
        $res = ucfirst($query['NOMBRES_PERSONA']) . " "
                . ucfirst($query['APELLIDO_P_PERSONA']) .
                " " . ucfirst($query['APELLIDO_M_PERSONA']);
        return $res;
    }

    public function actualizar() {
        $res = false;
        $idCliente = $this->session->userdata('id_cliente');

        $this->db->trans_begin();
        if ($_POST['ciudad'] != "-2") {
            $foranea = $_POST['ciudad'];
            $sql = "UPDATE CLIENTE SET ID_CIUDAD='$foranea' "
                    . "WHERE ID_PERSONA='$idCliente'";
            $this->db->query($sql);
        }
        if ($_POST['institucion'] != "-2") {
            $foranea = $_POST['institucion'];
            $sql = "UPDATE CLIENTE SET ID_INSTITUCION='$foranea' "
                    . "WHERE ID_PERSONA='$idCliente'";
            $this->db->query($sql);
        }
        if ($_POST['cargo'] != "-2") {
            $foranea = $_POST['cargo'];
            $sql = "UPDATE CLIENTE SET ID_CARGO='$foranea' "
                    . "WHERE ID_PERSONA='$idCliente'";
            $this->db->query($sql);
        }
        if ($_POST['profesion'] != "-2") {
            $foranea = $_POST['profesion'];
            $sql = "UPDATE CLIENTE SET ID_PROFESION='$foranea' "
                    . "WHERE ID_PERSONA='$idCliente'";
            $this->db->query($sql);
        }

        $nombres = $this->Principal->preparacionTexto($_POST['nombre_cliente']);
        $apellidop = $this->Principal->preparacionTexto($_POST['app_cliente']);
        $apellidom = $this->Principal->preparacionTexto($_POST['apm_cliente']);
        $direccion = trim($_POST['direc_cliente']);
        $sql = "UPDATE PERSONA SET NOMBRES_PERSONA='$nombres', "
                . "APELLIDO_P_PERSONA='$apellidop', "
                . "APELLIDO_M_PERSONA='$apellidom', "
                . "DIRECCION_PERSONA='$direccion' "
                . "WHERE ID_PERSONA='$idCliente'";
        $this->db->query($sql);

        $nit = $_POST['nit_cliente'];
        $sql = "UPDATE CLIENTE SET NIT_CI_CLIENTE='$nit' "
                . "WHERE ID_PERSONA='$idCliente'";
        $this->db->query($sql);

        if ($this->db->trans_status() == false) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $res = true;
        }
        return $res;
    }

    public function getTelefonosCliente($idCliente) {
        $res = array();
        $sql = "SELECT t.NUMERO_TELEFONO 
		FROM CLIENTE, TELEFONO t
		WHERE CLIENTE.ID_CLIENTE = t.ID_CLIENTE and CLIENTE.ID_CLIENTE = '$idCliente'";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $res[] = $row->NUMERO_TELEFONO;
        }
        return $res;
    }

    public function getTelefonos($idCliente) {
        $sql = "SELECT t.*, tt.NOMBRE_TIPO_TELF
                FROM PERSONA p, TELEFONO_PERSONA tp, TELEFONO t, TIPO_TELEFONO tt
                WHERE p.ID_PERSONA=tp.ID_PERSONA AND tp.ID_TELEFONO=t.ID_TELEFONO
                AND t.ID_TIPO_TELF = tt.ID_TIPO_TELF AND p.ID_PERSONA = '$idCliente'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getClientesTelefonos($filtroSql = "") {
        $res = array();
        $query;
        if ($filtroSql == "") {
            $query = $this->db->get('CLIENTE');
        } else {
            $query->$this->db->query($filtroSql);
        }
        $arrayResultado = $query->result_array();
        foreach ($arrayResultado as $resultado) {
            $resultado['telefonos'] = $this->getTelefonosCliente($resultado['ID_CLIENTE']);
            array_push($res, $resultado);
        }
        return $res;
    }

    public function buscarPorNombres($filtroSql) {
        $sql = "SELECT c.*
                FROM CLIENTE c
                WHERE c.NOMBRES_CLIENTE LIKE '%$filtroSql%';";
        $query = $this->db->query($sql);
        $clientes = $query->result_array();
        return $clientes;
    }

    public function getClientes() {
        $sql = "SELECT * FROM PERSONA p, CLIENTE c "
                . "WHERE p.ID_PERSONA = c.ID_PERSONA";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getCliente($idCliente) {
        $sql = "SELECT *  
                FROM PERSONA ps, CLIENTE cl LEFT OUTER JOIN CIUDAD c 
                ON cl.ID_CIUDAD = c.ID_CIUDAD LEFT OUTER JOIN INSTITUCION i 
                ON cl.ID_INSTITUCION = i.ID_INSTITUCION
		LEFT OUTER JOIN CARGO cg ON cl.ID_CARGO = cg.ID_CARGO 
                LEFT OUTER JOIN PROFESION p ON cl.ID_PROFESION = p.ID_PROFESION
                WHERE ps.ID_PERSONA = cl.ID_PERSONA 
                AND cl.ID_PERSONA = '$idCliente' LIMIT 1";

        $query = $this->db->query($sql);
        $resCliente = $query->row_array();
        $telefonos = $this->getTelefonos($idCliente);
        $emails = $this->getEmails($idCliente);

        $cliente = array('id' => $resCliente['ID_PERSONA'],
            'nit_cliente' => $resCliente['NIT_CI_CLIENTE'],
            'nombres' => $resCliente['NOMBRES_PERSONA'],
            'apellido_p' => $resCliente['APELLIDO_P_PERSONA'],
            'apellido_m' => $resCliente['APELLIDO_M_PERSONA'],
            'emails' => $emails,
            'direccion' => $resCliente['DIRECCION_PERSONA'],
            'telefonos' => $telefonos,
            'ciudad' => array("id" => $resCliente['ID_CIUDAD'],
                "nombre" => $resCliente['NOMBRE_CIUDAD']),
            'institucion' => array("id" => $resCliente['ID_INSTITUCION'],
                "nombre" => $resCliente['NOMBRE_INSTITUCION']),
            'cargo' => array("id" => $resCliente['ID_CARGO'],
                "nombre" => $resCliente['NOMBRE_CARGO']),
            'profesion' => array("id" => $resCliente['ID_PROFESION'],
                "nombre" => $resCliente['NOMBRE_PROFESION'])
        );
        return $cliente;
    }

    public function getEmails($idCliente) {
        $sql = "SELECT * FROM PERSONA p, CLIENTE c, PERSONA_EMAIL pe, EMAIL e "
                . "WHERE c.ID_PERSONA=p.ID_PERSONA AND "
                . "p.ID_PERSONA=pe.ID_PERSONA AND pe.ID_EMAIL=e.ID_EMAIL AND "
                . "p.ID_PERSONA='$idCliente'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function busquedaAvanzada($arrayOpciones) {
        
    }

    public function getProformas($idCliente) {
        $sql = "SELECT p.* 
                FROM CLIENTE c, PROFORMA p
                WHERE c.ID_PERSONA = p.ID_PERSONA AND 
                c.ID_PERSONA = '$idCliente'";
        $query = $this->db->query($sql);
        $resultado = $query->result_array();
        return $resultado;
    }

    public function guardarNumeroTelefono($idCliente) {
        $res = false;
        
        $numero = $_POST['telefono'];    
        $tipoTelefono = $_POST['tipo_telefono'];
        
        $detalles = trim($_POST['detalles_telefono']);
        
        $this->db->trans_begin();
        $telf = array(
            'ID_TIPO_TELF' => $tipoTelefono,
            'NUMERO_TELEFONO' => $numero, 
            'DESCRIPCION_TELEFONO' => $detalles
        );
        $this->db->insert('TELEFONO', $telf);
        $telefonoPersona = array(
            'ID_TELEFONO' => $this->db->insert_id(), 
            'ID_PERSONA' => $idCliente
        );
        
        $this->db->insert('TELEFONO_PERSONA', $telefonoPersona);
        
        if($this->db->trans_status() == false) {
            $this->db->trans_rollback();
        }
        else {
            $this->db->trans_commit();
            $res = true;
        }
        return $res;
    }

    public function verificarNumero($idCliente, $numero) {
        $res = false;
        $sql = "SELECT t.NUMERO_TELEFONO "
                . "FROM PERSONA p, TELEFONO_PERSONA tp, TELEFONO t "
                . "WHERE p.ID_PERSONA=tp.ID_PERSONA AND "
                . "tp.ID_TELEFONO=t.ID_TELEFONO "
                . "AND t.NUMERO_TELEFONO='$numero' AND p.ID_PERSONA=$idCliente";
        $query = $this->db->query($sql);
        if ($query->num_rows() == 0) {
            $res = true;
        }
        return $res;
    }

    /**
     * Elimina al cliente de la base de datos
     * 
     * @param integer $id del cliente
     */
    public function eliminar($id) {
        
    }

    public function eliminarTelefono($idTelefono) {
        $sql = "DELETE FROM TELEFONO "
                . "WHERE ID_TELEFONO='$idTelefono'";
        $this->db->query($sql);
    }

    public function busquedaSegmentada($opcion, $filtro, $filtroCliente, $paginacion = 0, $segmento = 0) {
        switch ($opcion) {
            case 'institucion':
                $sql = "SELECT c.* FROM CLIENTE c, INSTITUCION i 
                        WHERE c.ID_INSTITUCION = i.ID_INSTITUCION AND 
                        i.ID_INSTITUCION='$filtro' AND 
                        c.NOMBRES_CLIENTE like '%$filtroCliente%'";
                break;
            case 'ciudad':
                $sql = "SELECT c.* FROM CLIENTE c, CIUDAD ci 
                        WHERE c.ID_CIUDAD = ci.ID_CIUDAD AND 
                        ci.ID_CIUDAD='$filtro' AND 
                        c.NOMBRES_CLIENTE like '%$filtroCliente%' ";
                break;
            case 'cargo':
                $sql = "SELECT c.* FROM CLIENTE c, CARGO ca 
                        WHERE c.ID_CARGO = ca.ID_CARGO AND 
                        ca.ID_CARGO='$filtro' AND 
                        c.NOMBRES_CLIENTE like '%$filtroCliente%' ";
                break;
            case 'profesion':
                $sql = "SELECT c.* FROM CLIENTE c, PROFESION p 
                        WHERE c.ID_PROFESION = p.ID_PROFESION AND 
                        p.ID_PROFESION='$filtro' AND 
                        c.NOMBRES_CLIENTE like '%$filtroCliente%' ";
                break;
            default:
                return array();
                break;
        }
        $this->db->limit($paginacion, $segmento);
        $query = $this->db->query($sql);
        $res = $query->result_array();
        return $res;
    }

    public function totalBusquedaSegmentada($opcion, $filtro, $filtroCliente) {
        switch ($opcion) {
            case 'institucion':
                $sql = "SELECT * FROM CLIENTE c, INSTITUCION i 
                        WHERE c.ID_INSTITUCION = i.ID_INSTITUCION AND 
                        i.NOMBRE_INSTITUCION LIKE '%$filtro%' AND 
                        c.NOMBRES_CLIENTE like '%$filtroCliente%' ";
                break;
            case 'ciudad':
                $sql = "SELECT * FROM CLIENTE c, CIUDAD ci 
                        WHERE c.ID_CIUDAD = ci.ID_CIUDAD AND 
                        ci.NOMBRE_CIUDAD LIKE '%$filtro%' AND 
                        c.NOMBRES_CLIENTE like '%$filtroCliente%' ";
                break;
            case 'cargo':
                $sql = "SELECT * FROM CLIENTE c, CARGO ca 
                        WHERE c.ID_CARGO = ca.ID_CARGO AND 
                        ca.NOMBRE_CARGO LIKE '%$filtro%' AND 
                        c.NOMBRES_CLIENTE like '%$filtroCliente%' ";
                break;
            case 'profesion':
                $sql = "SELECT * FROM CLIENTE c, PROFESION p 
                        WHERE c.ID_PROFESION = p.ID_PROFESION AND 
                        p.NOMBRE_PROFESION LIKE '%$filtro%' AND 
                        c.NOMBRES_CLIENTE like '%$filtroCliente%' ";

            default:
                return 0;
                break;
        }
        $query = $this->db->query($sql);
        return $query->num_rows();
    }

}
