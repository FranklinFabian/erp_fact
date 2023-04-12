<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Envio_facturas_22 extends CI_Controller{

  public function generar_pdf_enviar(){
    if(isAdmin()){
      $periodo_act = $this->periodos_model->get_activo();
      if(is_null($periodo_act))
        echo 'Error al obtener el periodo o factor';
      else{
        $facturas_array = $this->generar_facturas_22_model->get_facturas_enviadas($periodo_act['idperiodo'], 2);
      
        foreach ($facturas_array as $key => $lecturas) {
          //var_dump($lecturas);
          
          if(!is_null($lecturas['correo'])){
            //pdf
            $lectura = $this->lecturas_model->get_lectura($lecturas['idlectura']);
            if(!is_null($lectura) ){
              
              $configuracion = $this->configuracion_model->get_all();
              if(is_null($configuracion)){
                $configuracion['logo_linea1'] = 'MI EMPRESA';
                $configuracion['logo_linea2'] = 'MI SLOGAN';
                $configuracion['direccion'] = 'AV. SIEMPRE VIVA NRO. 16, SANTA CRUZ - BOLIVIA';
                $configuracion['telefono'] = '';
                $configuracion['whatsapp'] = '';
                $configuracion['pie_impresion'] = 'GRACIAS POR SU PREFERENCIA.';
              }
              $factura = $this->factura_22_model->get_factura_lectura($lecturas['idlectura']);
              if(is_null($factura))
              echo 'Factura no disponible: id '.$factura['idfactura_22'];
              else{
                  $abonado = $this->abonados_model->get_abonado($lectura['idabonado']);
                  $direccion_abonado = $this->calles_model->get_all_all($abonado['idcalle']);
                  $periodo = $this->periodos_model->get_periodo($lectura['idperiodo']);
                  $cliente = $this->cliente_model->get_cliente($abonado['idcliente']);
                  $data['lectura'] = $lectura;
                  $data['factura'] = $factura;
                  $data['direccion_abonado'] = $direccion_abonado;
                  $data['periodo'] = $periodo;
                  $data['configuracion'] = $configuracion;
                  $data['abonado'] = $abonado;
                  $data['cliente'] = $cliente;
                  $data['title'] = 'Factura';
              }//fin if is_null lectura
            }
            $this->load->library('Pdf');
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
            $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
            $pdf->setPrintHeader(false);
            $pdf->setPrintFooter(false);
            $pdf->SetMargins(10, 5, 10, true);
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
            $pdf->SetFont('dejavusans', '', 4);
            $pdf->AddPage('P', 'A4');
            
            $html = $this->load->view('gestion_factura/impresion_factura_22_pdf_view', $data, true);
            $pdf->writeHTML($html, true, false, true, false, '');
            $pdf->Output(getcwd().'/facturas_22/'.$lecturas['idlectura'].'_'.$factura['cuf'].'.pdf', 'F');
            //EMAIL
            $this->load->library('email');
            $this->email->clear(TRUE);
            $config['protocol'] = 'smtp';
            $config["smtp_host"] = $this->config->item('smtp_host');
            $config["smtp_user"] = $this->config->item('smtp_user');
            $config["smtp_pass"] = $this->config->item('smtp_pass');
            $config["smtp_port"] = $this->config->item('smtp_port');
            $config["mailtype"] = 'html';
            $config['charset'] = 'utf-8';
            $config['wordwrap'] = true;
            $config['validate'] = true;
            $config['newline'] = "\r\n";
            $this->email->clear(TRUE);
            $this->email->initialize($config);
            $this->email->from($this->config->item('smtp_user'), $this->config->item('razonSocial'));
            $this->email->to($lecturas['correo']);
            $this->email->subject($this->config->item('razonSocial').' Factura consumo  '.$periodo_act['emision']);
            $this->email->message('
            <p>
              Puede imprimir o descargar <a target="_blank" href="'.$this->config->item('url_qr').'nit='.$this->config->item('nit').'&cuf='.$factura['cuf'].'&numero='.$factura['nro_fact'].' ">aquí</a>
            </p> 
            ');
            $this->email->attach(getcwd().'/facturas_22/'.$factura['idlectura'].'_'.$factura['cuf'].'.pdf');
            $this->email->attach(getcwd().'/facturas_22/'.$factura['idlectura'].'_firmado.xml');
            $this->email->send();
            echo 'Factura envia a '.$lecturas['correo'].' correctamente<br>';
          }//fin if
        }//fin foreach while


      }// fin else periodo activo

    }// is admin
    else
      redirect(base_url());
  }


}//fin class
