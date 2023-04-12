<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calcular_tv extends CI_Controller{

  public function index(){
    if(isAdmin()){
      $periodo_act = $this->periodos_model->get_activo();
      $data['periodo_act'] = $periodo_act;
      $data['main_content'] = 'calcular_tv/index_view';
      $data['title'] = 'Calcular tv';
      $this->load->view('template/template_view', $data);
    }else
    redirect(base_url());
  }

  
  public function calcular(){
    if(isAdmin()){
      $periodo_act = $this->periodos_model->get_activo();
      $fecha_ini = substr($periodo_act['emision'],0,8).'01';
      $fecha_fin = $periodo_act['emision'];
      
      $abon1_tv = $this->calculo_tv_model->get_abonados_tv(2);
      $abon_extr_tv = $this->calculo_tv_model->get_abonados_extra_tv(2, $fecha_ini, $fecha_fin);
      $abonados_tv = array_merge($abon1_tv, $abon_extr_tv);
      // var_dump($periodo_act);
      // var_dump($fecha_ini);
      // var_dump($fecha_fin);

      foreach ($abonados_tv as $key => $value) {
        $resultado = $this->calculo_tv_model->llamada($value['idabonado'], $periodo_act['idperiodo'], $fecha_ini, $fecha_fin);

        $lectura['idabonado']=$value['idabonado'];
        $lectura['idperiodo']=$periodo_act['idperiodo'];
        $lectura['idservicio']=2;
        $lectura['idcategoria']=$value['idcategoria'];
        $lectura['indice']=0;
        $lectura['estimado']=0;
        $lectura['mulmed']=0;
        $lectura['kwh']=$resultado['dias_servicio'];
        $lectura['potencia']=0;
        $lectura['imp_fijo']=0;
        $lectura['imp_adic']=0;
        $lectura['imp_poten']=0;
        $lectura['imp_total']=round($resultado['importe'],1);
        $lectura['conexion']=0;


        $lectura['recargo']=0;
        $lectura['aseo']=0;
        $lectura['alumbrado']=0;
        $lectura['ley1886']=0;
        $lectura['dignidad']=0;
        $lectura['afcoop']=0;
        $lectura['devolucion']=0;
        $lectura['desdom']=0;
        $lectura['desap']=0;
        $lectura['desau']=0;
        $lectura['desafcoop']=0;
        $lectura['kvarh']=0;
        $lectura['imp_penal']=0;
        $lectura['lectreactiva']=0;
        $lectura['freg_ene0']=0;
        $lectura['frepetido']=0;
        $lectura['estado']=0;
        $lectura['pago']=0;
        $lectura['cobrador']=NULL;
        $lectura['lecturador']=0;
        $lectura['usuario']=$this->session->userdata('usuario');
        //var_dump($lectura);
        $verifica = $this->calculo_tv_model->verifica_adelantado($value['idabonado'], $periodo_act['idperiodo']);
        if(!is_null($verifica))
          if($verifica['estado'] != "1"){
            //echo 'Existe UPPDATE idabonado'.$verifica['idabonado'].' <br>';
            //var_dump($verifica);
          //REPOSICION
          $reposicion=$this->calculo_tv_model->get_reposicion($value['idabonado']);
          if(!is_null($reposicion)){
            $lectura['reposicion']=$reposicion['costo'];
            $data_reposicion['cobrado']=1;
            $data_reposicion['idlectura']=$verifica['idlectura'];
            $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
          }else
            $lectura['reposicion']=0;//FIN REPOSICION
            
            $this->lecturas_model->actualizar($verifica['idlectura'], $lectura);
          }else{
            continue;
            //echo 'NO SE TOCA idabonado'.$verifica['idabonado'].' <br>';
          }
        else{
          //echo 'Procesar INSERT idabonado'.$value['idabonado'].' <br>';
          $idlectura = $this->lecturas_model->current_num();
          $lectura['idlectura']=$idlectura;
          //REPOSICION
          $reposicion=$this->calculo_tv_model->get_reposicion($value['idabonado']);
          if(!is_null($reposicion)){
            $lectura['reposicion']=$reposicion['costo'];
            $data_reposicion['cobrado']=1;
            $data_reposicion['idlectura']=$idlectura;
            $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
          }else
            $lectura['reposicion']=0;//FIN REPOSICION
  
          $this->lecturas_model->insertar($lectura);
        }//fin verifica
      }// fin foreach
      echo 'Proceso finalizado exitosamente <a href="'.base_url().'">Volver al inicio</a>';
    }
    else
      redirect(base_url());
  }

}//fin class
