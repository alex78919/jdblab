<?php

class Proforma extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->library('excel');
    }

    public function guardarProforma() {
        $this->db->trans_begin();
        $query = $this->db->query
                        ("SELECT MAX(NUMERO_PROFORMA) AS maximo FROM PROFORMA")->row_array();

        $maximo = count($query) == 0 ? 0 : $query['maximo'];
        
        $diasValidez = 30;
        $fecha = date("Y-m-d");
        $fechaValidez = strtotime ( "+" . $diasValidez.  " day" , strtotime ( $fecha ) ) ;
        $fechaValidez = date ( 'Y-m-j' , $fechaValidez );
        
        $proforma = array(
            'ID_PERSONA' => $_POST['id_cliente'],
            'NUMERO_PROFORMA' => $maximo + 1,
            'FECHA_PROFORMA' => $fecha, 
            'FECHA_VALIDEZ' => $fechaValidez
        );
        $this->db->insert('PROFORMA', $proforma);
        $idProforma = $this->db->insert_id();
        $productos = json_decode($_POST['guardar_datos_proforma']);
        foreach ($productos as $producto) {
            $proforma_producto = array(
                'ID_PROFORMA' => $idProforma,
                'ID_PRODUCTO' => $producto->id,
                'CANTIDAD_PRODUCTO' => $producto->cantidad,
                'PRECIO_VENTA' => $producto->precio
            );
            $this->db->insert('PROFORMA_PRODUCTO', $proforma_producto);
        }
        if($this->db->trans_status() == false) {
            $this->db->trans_rollback();
        }
        else { 
            $this->db->trans_commit();
        }
    }

    public function getProforma($idProforma) {
        $sql = "SELECT * FROM PROFORMA WHERE ID_PROFORMA='$idProforma' LIMIT 1";
        $query = $this->db->query($sql);
        return $query->row_array();
    }

    public function getProductosProforma($idProforma) {
        $sql = "SELECT pr.*, pp.CANTIDAD_PRODUCTO, pp.PRECIO_VENTA   
                FROM PROFORMA p, PROFORMA_PRODUCTO pp, PRODUCTO pr
                WHERE p.ID_PROFORMA = pp.ID_PROFORMA AND 
                pp.ID_PRODUCTO = pr.ID_PRODUCTO AND p.ID_PROFORMA = '$idProforma'";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function sumaTotal($idProforma) {
        $sql = "SELECT SUM(p.PRECIO_PRODUCTO * pr.CANTIDAD_PRODUCTO) AS suma
                FROM PRODUCTO p, PROFORMA_PRODUCTO pr, PROFORMA pf
                WHERE pf.ID_PROFORMA = pr.ID_PROFORMA and pr.ID_PRODUCTO = p.ID_PRODUCTO";
        $query = $this->db->query($sql);
        $res = $query->row_array();
        return $res['suma'];
    }

    public function exportarProforma($idProforma, $tipoModelo) {


        $objReader = PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $this->excel;

        $destino = "";
        $banco = "";
        $nombreSujeto = "";
        $numeroCuenta = "";
        switch ($tipoModelo) {
            case '1':
                $objPHPExcel = $objReader->load("plantillaexcel/Proforma 000 JDBlab.xlsx");
                $destino = "JDBLAB";
                $banco = "Banco Union";
                $nombreSujeto = "Delia Crespo David";
                $numeroCuenta = "113611426";
                break;
            case '2':
                $objPHPExcel = $objReader->load("plantillaexcel/Proforma 000 LABOFISI.xlsx");
                $destino = "LABOFISI SRL";
                $banco = "Banco Union";
                $nombreSujeto = "LABOFISI SRL";
                $numeroCuenta = "1979463";
                break;
            case '3':
                $objPHPExcel = $objReader->load("plantillaexcel/Proforma 000 LATEC.xlsx");
                $destino = "LATEC SRL";
                $banco = "Banco Union";
                $nombreSujeto = "LATEC SRL";
                $numeroCuenta = "117522645";
                break;
            case '4':
                $objPHPExcel = $objReader->load("plantillaexcel/Proforma 000 TECNOEQUIP.xlsx");
                $destino = "TECNOequip";
                $banco = "Banco de Crédito";
                $nombreSujeto = "Jorge Dávalos Crespo";
                $numeroCuenta = "3015040742318";
                break;
            default:
                $objPHPExcel = $objReader->load("plantillaexcel/Proforma 000 JDBlab.xlsx");
                $destino = "JDBLAB";
                $banco = "Banco Union";
                $nombreSujeto = "Delia Crespo David";
                $numeroCuenta = "113611426";
                break;
        }


        $cliente = $this->Cliente->getCliente($this->session->userdata('id_cliente'));
        $proforma = $this->getProforma($idProforma);
        $productosProforma = $this->getProductosProforma($idProforma);

        $objPHPExcel->getProperties()->setCreator("JDBLAB") // Nombre del autor
                ->setLastModifiedBy("JDBLAB") //Ultimo usuario que lo modificó
                ->setTitle("Reporte cliente: " . $cliente['nombres']); // Titulo
        //->setSubject("Reporte Excel con PHP y MySQL") //Asunto
        //->setDescription("Reporte de alumnos") //Descripción
        //->setKeywords("reporte alumnos carreras") //Etiquetas
        //->setCategory("Reporte excel"); //Categorias
// Se combinan las celdas A1 hasta D1, para colocar ahí el titulo del reporte
        /* $objPHPExcel->setActiveSheetIndex(0)
          ->mergeCells('A1:D1'); */


        $diasValidez = 30;
        //Datos de proforma
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("F1", $proforma['NUMERO_PROFORMA'])
                ->setCellValue("F2", $proforma['FECHA_PROFORMA'])
                ->setCellValue("F3", "=F2+" . $diasValidez);

        //Datos del cliente
        $nombreCliente = ucfirst($cliente['nombres']) . " " .
                ucfirst($cliente['apellido_p']) . " " . ucfirst($cliente['apellido_m']);
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("C9", $nombreCliente)
                ->setCellValue("C10", ucfirst($cliente['cargo']['nombre']))
                ->setCellValue("C11", ucfirst($cliente['institucion']['nombre']))
                ->setCellValue("C12", ucfirst($cliente['direccion']))
                ->setCellValue("C14", ucfirst($cliente['ciudad']['nombre']));
        $telefonos = "";
        foreach ($cliente['telefonos'] as $telefono) {
            $telefonos .= $telefono['NUMERO_TELEFONO'] . "   ";
        }

        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("C13", $telefonos);

        /*
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue("C9" , $nombreCliente);
         */

        $fila = 18;
// Se agregan los titulos del reporte

        for ($i = 0; $i < count($productosProforma); $i++) {
            $filaActual = $fila + $i;
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A" . $filaActual, $productosProforma[$i]['CANTIDAD_PRODUCTO']) // Titulo del reporte
                    ->setCellValue("B" . $filaActual, strtoupper($productosProforma[$i]['CODIGO_PRODUCTO']))  //Titulo de las columnas
                    ->setCellValue("C" . $filaActual, ucfirst($productosProforma[$i]['NOMBRE_PRODUCTO']))
                    ->setCellValue("E" . $filaActual, $productosProforma[$i]['PRECIO_VENTA'])
                    ->setCellValue("F" . $filaActual, "=A" . $filaActual . "*E" . $filaActual);
            $objPHPExcel->setActiveSheetIndex(0)->getRowDimension("" . $filaActual)->setRowHeight(40);
        }

        $styleArray = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_MEDIUM, 'color' => array('argb' => '#000000'),),),);
        $objWorksheet = $objPHPExcel->getActiveSheetIndex();
        $objPHPExcel->setActiveSheetIndex(0)->getStyle("F" . $fila . ":" . "F" . $filaActual)->applyFromArray($styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle("E" . $fila . ":" . "E" . $filaActual)->applyFromArray($styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle("D" . $fila . ":" . "D" . $filaActual)->applyFromArray($styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle("C" . $fila . ":" . "C" . $filaActual)->applyFromArray($styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle("B" . $fila . ":" . "B" . $filaActual)->applyFromArray($styleArray);
        $objPHPExcel->setActiveSheetIndex(0)->getStyle("A" . $fila . ":" . "A" . $filaActual)->applyFromArray($styleArray);

        $filaActual = $filaActual + 2;
        $objPHPExcel->setActiveSheetIndex(0)
                ->mergeCells("A" . $filaActual . ":C" . $filaActual)
                ->mergeCells("D" . $filaActual . ":F" . $filaActual);
        $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue("A" . $filaActual,"LUGAR DE ENTREGA: ");

        $filaTemp = $filaActual + 1;


        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A" . $filaTemp, "INFORMACION DE PAGOS");
        $filaTemp ++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A" . $filaTemp, "Destino:")
                ->setCellValue("C" . $filaTemp, $destino);
        $filaTemp ++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A" . $filaTemp, "Banco:")
                ->setCellValue("C" . $filaTemp, $banco);
        $filaTemp ++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A" . $filaTemp, "A nombre de:")
                ->setCellValue("C" . $filaTemp, $nombreSujeto);
        $filaTemp ++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("A" . $filaTemp, "Nº de cuenta:")
                ->setCellValue("C" . $filaTemp, $numeroCuenta);
        $filaTemp = $filaActual + 1;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("E" . $filaTemp, "Subtotal Bs.:");
        $filaTemp ++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("E" . $filaTemp, "Embalaje y envio Bs.:");
        $filaTemp ++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("E" . $filaTemp, "Total Factura Bs.:");
        $filaTemp ++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("E" . $filaTemp, "Pago recibido Bs.:");
        $filaTemp ++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("E" . $filaTemp, "Fecha de pago");
        $filaTemp ++;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("E" . $filaTemp, "SALDO Bs.:");
        $filaTemp = $filaActual + 6;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("C" . $filaTemp, "Incluye impuestos de ley");

        $filaTemp = $filaActual + 1;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("F" . $filaTemp, "=SUM(F" . $fila . ":F" . $filaActual . ")");

        $filaTotal = $filaTemp;
        $filaEmbalaje = $filaTemp + 1;
        $filaTemp = $filaTemp + 2;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("F" . $filaTemp, "=SUM(F" . $filaTotal . ":F" . $filaEmbalaje . ")");

        $filaTotal = $filaTemp;
        $filaPago = $filaTotal + 1;

        $filaTemp = $filaTemp + 3;
        $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue("F" . $filaTemp, "=F" . $filaTotal . "-F" . $filaPago . "");

// Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="reporte-proforma.xls"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    public function getProformasCliente() {
        $sql = "SELECT p.*, c.NOMBRES_CLIENTE, c.APELLIDO_P_CLIENTE, 
            c.APELLIDO_M_CLIENTE
            FROM PROFORMA p, CLIENTE c
            WHERE c.ID_CLIENTE = p.ID_PROFORMA ";
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    public function getDetalleProductos($idProforma) {
        $productos = array();
        $sql = "SELECT p.ID_PRODUCTO 
                FROM PRODUCTO p, PROFORMA pf, PROFORMA_PRODUCTO pp 
                WHERE pf.ID_PROFORMA=pp.ID_PROFORMA AND 
                    pp.ID_PRODUCTO=p.ID_PRODUCTO AND 
                    pf.ID_PROFORMA='$idProforma'";
        $query = $this->db->query($sql);
        $rows = $query->result_array();
        foreach ($rows as $row) {
            $productos[] = $this->Producto->getProducto($row['ID_PRODUCTO']);  
        }
        return $productos;
    }

    public function exportarProformaDetallada($idProforma) {
        $this->load->library('word');
        $PHPWord = $this->word;

        //Generando datos para exportar
        $productos = $this->getDetalleProductos($idProforma);

        $section = $PHPWord->createSection();
        $styleFont = array('bold'=>true, 'size'=>14, 'name'=>'Arial');
        $styleParagraph = array('align'=>'left', 'spaceAfter'=>100);

        $styleFont2 = array('bold'=>false, 'size'=>11, 'name'=>'Arial');
        $styleParagraph2 = array('align'=>'left', 'spaceAfter'=>100);

        $styleFont3 = array('bold'=>false, 'size'=>11, 'name'=>'Arial');
        $styleParagraph3 = array('align'=>'left', 'spaceAfter'=>10);
        foreach($productos as $producto) {
            $tituloProducto = utf8_decode(strtoupper($producto['codigo'])) . " " 
            . utf8_decode(ucfirst($producto['nombre']));

            $section->addText($tituloProducto, $styleFont, $styleParagraph);
            $section->addTextBreak(1); 

            if(file_exists("fotos_productos/" . $producto["ruta_imagen"])) {
                $section->addImage("fotos_productos/" . $producto['ruta_imagen'], 
                        array('width'=>210, 'height'=>210, 'align'=>'center'));
            } 

            $descripcion = utf8_decode(ucfirst($producto['descripcion']));
            $section->addText($descripcion, $styleFont2, $styleParagraph2);  

            foreach($producto['componentes'] as $componente) {
                $comp = utf8_decode(ucfirst($componente['ESPECIFICACION_COMPONENTE']));
                $section->addText($comp, $styleFont3, $styleParagraph3);    
            }
            $section->addTextBreak(5);
        }
        


        // Save File
        $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
        $filename = 'proforma_detallada.docx';
        $objWriter->save($filename);

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$filename);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filename));
        flush();
        readfile($filename);
        unlink($filename); // deletes the temporary file
        exit;
    }

}
