<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lista_corte extends CI_Controller{

  public function lista_electricidad(){
    if(isLogin()){
      $data['idservicio'] = 1;
      $data['lista_cortes'] = $this->cortes_model->get_listas_cortes(1);
      $data['main_content'] = 'lista_corte/lista_electricidad_view';
      $data['title'] = 'Lista de lista_cortes';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function lista_cable(){
    if(isLogin()){

      $data['idservicio'] = 2;
      $data['lista_cortes'] = $this->cortes_model->get_listas_cortes(2);
      $data['main_content'] = 'lista_corte/lista_cable_view';
      $data['title'] = 'Lista de lista_cortes';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function nuevo($idservicio){
    if(isLogin()){
      $data['idservicio'] = $idservicio;
      $data['circuitos'] = $this->centros_model->get_all();
      $data['main_content'] = 'lista_corte/nuevo_view';
      $data['title'] = 'Nueva lista_corte';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function crear(){
    if(isLogin())
    {
      $data['codigo'] = mb_strtoupper(trim($this->input->post('codigo')));
      $data['lista_corte'] = mb_strtoupper(trim($this->input->post('lista_corte')));
      $data['usuario'] = $this->session->userdata('id_empleado');
      $this->lista_cortes_model->insertar($data);
      echo 'ok';
    }
    else
      redirect(base_url());
  }

  public function generar($idservicio){
    if(isLogin()){
      $idcentro = $this->input->post('idcentro');
      $abonados = $this->abonados_model->get_idabonado_by_serv_centro($idservicio, $idcentro);
      
      //para numero
      $ultima_fila = $this->cortes_model->get_ultima_fila($idservicio);
      $numero=null;
      if(is_null($ultima_fila))
        $numero = 1;
      else
        $numero = $ultima_fila['numero'] + 1;
      //fin para numero
      
      $lista=0;
      $insertar = false;

      $i=0;
      $ultima_lista = $this->cortes_model->get_ultima_lista($idservicio);
      if(is_null($ultima_lista)){
        $lista=1;
        $insertar = true;
      }else{
        $lista=(int)$ultima_lista['lista'];
          //verificar rango fechas
          if(fecha_en_rango(date('Y-m-01'),date('Y-m-t'),substr($ultima_fila['fecha'],0,10))){// fecha ini y fin del now, fecha ultimo reg
            if(($abonados[0]['idcentro'] != $ultima_lista['idcentro']))
              $insertar = true;
            else
              $insertar = false;
          }else{
            $insertar = true;
          }
        }

      // si se va insertar antes un update a abonados set enlista = 0
      $lista_corte=array();
      foreach ($abonados as $key => $value) {
        $meses = $this->lecturas_model->contar_meses_deuda($value['idabonado']);        
        if($meses['meses'] >= $this->input->post('meses')){/// los meses contados del abonado es >= al input post meses

          $lista_corte[$i]['numero']=$numero++;
          $lista_corte[$i]['idservicio']=$idservicio;
          $lista_corte[$i]['idabonado']=$value['idabonado'];
          $lista_corte[$i]['fecha']=date('Y-m-d H:i:s');
          $lista_corte[$i]['lista']=$lista;
          $lista_corte[$i]['meses']=$meses['meses'];
          $lista_corte[$i]['pagado']=0;
          $lista_corte[$i]['estado']='S';
          $lista_corte[$i]['entregado']=1;
          $lista_corte[$i]['fentrega']=date('Y-m-d H:i:s');
          $lista_corte[$i]['pentrega']=$this->session->userdata('usuario');
          $lista_corte[$i]['devuelto']=1;
          $lista_corte[$i]['fdevuelto']=date('Y-m-d H:i:s');
          $lista_corte[$i]['usuario']=$this->session->userdata('id_empleado');
          $lista_corte[$i]['solicitante']='por deuda de '.$meses['meses'].' meses';
          $i++;
        }//fin if cumple meses
      }

      if($insertar){
        $data_abo['encorte']=0;
        $this->abonados_model->actualizar_abonado_lista($idcentro,$data_abo);
        $lista++;
        foreach ($lista_corte as $key => $data_corte) {
          $data_corte['lista']=$lista;
          $this->cortes_model->insertar($data_corte);

          $data_abonado['encorte']=1;//////actualiza abonado encorte=1
          $this->abonados_model->actualizar($data_corte['idabonado'], $data_abonado);
        }
        if(!empty($lista_corte)) echo 'Lista creada con exito';
        else echo 'No se encontro abonados para cortar en este circuito con la cantidad de meses solicitadas.';
      }
      else
        echo 'Ya existe una lista para este circuito';      
    }
    else
      redirect(base_url());
  }

  public function generar_pdf($idservicio, $lista){
    if(isLogin()){
      $cortes = $this->cortes_model->get_cortes_by_servicio_lista($idservicio, $lista);
      //$data['cortes'] = $cortes;
      $data['idservicio']=$idservicio;
      $data['lista']=$lista;
      $poste=$this->postes_model->get_poste($cortes[0]['idposte']);
      $centro=$this->centros_model->get_centro($poste['idcentro']);
      $data['circuito']=$centro['centro'];

      $array_cortes = array_chunk($cortes, 10);
      $data['array_cortes']=$array_cortes;

      //var_dump($array_cortes);
      //$this->load->view('lista_corte/generar_pdf2_view', $data);

      $this->load->library('Pdf');
      $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
      $pdf->SetCreator(PDF_CREATOR);
      $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
      $pdf->SetMargins(PDF_MARGIN_LEFT, 15, PDF_MARGIN_RIGHT);
      $pdf->setPrintHeader(false);
      $pdf->setPrintFooter(false);
      $pdf->SetMargins(7, 5, 7, true);
      $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
      $pdf->SetFont('dejavusans', '', 4);
      $pdf->AddPage('P', 'A4');

      $html = $this->load->view('lista_corte/generar_pdf2_view', $data, true);
      $pdf->writeHTML($html, true, false, true, false, '');
      $pdf->Output('lista_salida.pdf', 'I');

    }
    else
      redirect(base_url());
  }

    
}//fin class
