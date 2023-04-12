<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Calcular_lecturas extends CI_Controller{

  public $repetidos_afcoop=array();
  public $i=1;

  public function __construct() {
    parent::__construct();
    $this->load->model('fact/calculo_lecturas_model');
    $this->load->model('fact/periodos_model');
    $this->load->model('fact/factores_model');
    $this->load->model('fact/lecturas_model');
    if (!$this->auth->is_logged()) {
      $this->output->set_header("Location: " . base_url() . 'Admin_dashboard/login', TRUE, 302);
    }
    $this->auth->check_admin_auth();

  }
  public function index(){
      $periodo_act = $this->periodos_model->get_activo();
      $data['periodo_act'] = $periodo_act;
      $data['main_content'] = 'fact/calcular_lecturas/index_view';
      $data['title'] = 'Calcular lecturas';
      $content = $this->parser->parse('fact/calcular_lecturas/index_view', $data, true);
      /*$this->load->view('fact/template/template_view', $data);*/
      $this->template->full_admin_html_view($content);
   
  }

  public function calcular(){
    
      $periodo_act = $this->periodos_model->get_activo();
      $factores = $this->factores_model->get_factor_periodo($periodo_act['idperiodo']);
      if(is_null($periodo_act) || is_null($factores))
        echo 'Error al obtener el periodo o factor';
      else{
        $lecturas = $this->calculo_lecturas_model->get_lecturas($periodo_act['idperiodo'], 1);
        // var_dump($lecturas);
        // var_dump($periodo_act);
        foreach ($lecturas as $key => $value) {
          
          switch ($value['idcategoria']) {
            case '1': $importe_residencial = $this->residencial($value, $factores);
                      $this->lecturas_model->actualizar($importe_residencial['idlectura'], $importe_residencial);
                    break;
            case '2': $importe_general = $this->general($value, $factores);
                      $this->lecturas_model->actualizar($importe_general['idlectura'], $importe_general);
                      break;
            case '3': $importe_ind_menor = $this->industrial_menor($value, $factores);
                      $this->lecturas_model->actualizar($importe_ind_menor['idlectura'], $importe_ind_menor);
                      break;
            case '4': $importe_ind_mayor = $this->industrial_mayor($value, $factores);
                      $this->lecturas_model->actualizar($importe_ind_mayor['idlectura'], $importe_ind_mayor);
                      break;
            case '5': $importe_alumbrado_publico = $this->alumbrado_publico($value, $factores);
                      $this->lecturas_model->actualizar($importe_alumbrado_publico['idlectura'], $importe_alumbrado_publico);
                      break;

          }//fin switch
        }//fin foreach
        echo 'El calculo finalizo con exito. <a href="'.base_url().'"> volver al inicio</a> ';
      }

    
  }// fin funcion calcular

  public function residencial($lectura, $factores){
    $kwh = $lectura['kwh'];
    $importe=array();

    if(($kwh >= 0) && ($kwh <= 20)){/////////////////////////////////////////0_20///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['re_020'],1);
      $importe['imp_adic']=0;
      //DIGNIDAD Aberiguamos si el cliente tiene solo 1 unico abonado
      $abonado_dignidad = $this->calculo_lecturas_model->contar_abonados_residenciales($lectura['idcliente']);
      if(((int)$abonado_dignidad['nro_abonados'])==1)
        $importe['dignidad']=round(($importe['imp_fijo']*0.25), 1);
      else{
        $importe['dignidad']=0;
        $importe['frepetido']=1;
      }//FIN DIGNIDAD
      //LEY1886 
      $ley1886=$this->calculo_lecturas_model->get_vigente();
      $abonado_ley1886=$this->calculo_lecturas_model->beneficiario_ley1886($lectura['idabonado'], $ley1886['idley1886']);
      if(!is_null($abonado_ley1886))
        $importe['ley1886']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.2, 1);
      else
        $importe['ley1886']=0;
      // FIN LEY
      $importe['imp_total']=$importe['imp_fijo'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))
        $importe['aseo']=round($importe['imp_fijo']*0.87*($factores['aseo']), 1);
      else 
        $importe['aseo']=0;//ASEO

      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['alumbrado']=round($importe['imp_fijo']*0.87*($factores['alumbrado']), 1);
      else 
        $importe['alumbrado']=0;//ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo'])){
          $importe['devolucion']=$importe['imp_fijo'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      if($importe['dignidad']==0)
        $importe['freg_ene0']=1;
      else 
        $importe['freg_ene0']=0;

      return $importe;

    }elseif(($kwh >= 21) && ($kwh <= 100)){/////////////////////////////////////////21_100///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['re_020'],1);
      $importe['imp_adic']=round((($lectura['kwh']-20)*$factores['re_100']),1);
      //DIGNIDAD Aberiguamos si el cliente tiene solo 1 unico abonado
      $abonado_dignidad = $this->calculo_lecturas_model->contar_abonados_residenciales($lectura['idcliente']);
      if((((int)$abonado_dignidad['nro_abonados'])==1) && ($kwh <70))
        $importe['dignidad']=round((($importe['imp_fijo']+$importe['imp_adic'])*0.25), 1);
      else{
          $importe['dignidad']=0;
          $importe['frepetido']=1;
      }//FIN DIGNIDAD
        //LEY1886 
      $ley1886=$this->calculo_lecturas_model->get_vigente();
      $abonado_ley1886=$this->calculo_lecturas_model->beneficiario_ley1886($lectura['idabonado'], $ley1886['idley1886']);
      if(!is_null($abonado_ley1886))
        $importe['ley1886']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.2, 1);
      else
        $importe['ley1886']=0;
      // FIN LEY
      $importe['imp_total']=$importe['imp_fijo']+$importe['imp_adic'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))      
        $importe['aseo']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['aseo']), 1);
      else
        $importe['aseo']=0;//FIN ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['alumbrado']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['alumbrado']), 1);
      else 
        $importe['alumbrado']=0;// FIN ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo']+$importe['imp_adic'])){
          $importe['devolucion']=$importe['imp_fijo']+$importe['imp_adic'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      if($importe['dignidad']==0)
        $importe['freg_ene0']=1;
      else 
        $importe['freg_ene0']=0;

      return $importe;

    }else{/////////////////////////////////////////100 ADE///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['re_020'],1);
      $importe['imp_adic']=round((80*$factores['re_100']),1) + round((($lectura['kwh']-100)*$factores['re_ade']),1);
      $importe['dignidad']=0;// kwh > 100 no reciben beneficio
      $importe['frepetido']=1;      
      //LEY1886 
      $ley1886=$this->calculo_lecturas_model->get_vigente();
      $abonado_ley1886=$this->calculo_lecturas_model->beneficiario_ley1886($lectura['idabonado'], $ley1886['idley1886']);
      if(!is_null($abonado_ley1886))
        $importe['ley1886']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.2, 1);
      else
        $importe['ley1886']=0;
      // FIN LEY
      $importe['imp_total']=$importe['imp_fijo']+$importe['imp_adic'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))      
        $importe['aseo']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['aseo']), 1);
      else
        $importe['aseo']=0;//FIN ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['aseo']=round((($importe['imp_fijo']+$importe['imp_adic']))*0.87*($factores['aseo']), 1);
      else
        $importe['aseo']=0;//FIN ALUMBRADO
      $importe['alumbrado']=round((($importe['imp_fijo']+$importe['imp_adic']))*0.87*($factores['alumbrado']), 1);
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo']+$importe['imp_adic'])){
          $importe['devolucion']=$importe['imp_fijo']+$importe['imp_adic'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      if($importe['dignidad']==0)
        $importe['freg_ene0']=1;
      else 
        $importe['freg_ene0']=0;
      return $importe;
    }//fin else 100_ade
  }//Fin funcion RESIDENCIAL

  public function general($lectura, $factores){
    $kwh = $lectura['kwh'];
    $importe=array();

    if(($kwh >= 0) && ($kwh <= 20)){//GENERAL/////////////////////////////0_20///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['ge_020'],1);
      $importe['imp_adic']=0;
      //DIGNIDAD
      $importe['dignidad']=0;
      $importe['frepetido']=0;
      //LEY1886 
      $importe['ley1886']=0;
      $importe['imp_total']=$importe['imp_fijo'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))
        $importe['aseo']=round($importe['imp_fijo']*0.87*($factores['aseo']), 1);
      else 
        $importe['aseo']=0;//ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['alumbrado']=round($importe['imp_fijo']*0.87*($factores['alumbrado']), 1);
      else 
        $importe['alumbrado']=0;//ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo'])){
          $importe['devolucion']=$importe['imp_fijo'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      $importe['freg_ene0']=0;

      return $importe;

    }elseif(($kwh >= 21) && ($kwh <= 100)){//GENERAL////////////////////////////////21_100///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['ge_020'],1);
      $importe['imp_adic']=round((($lectura['kwh']-20)*$factores['ge_100']),1);
      //DIGNIDAD Aberiguamos si el cliente tiene solo 1 unico abonado
      $importe['dignidad']=0;
      $importe['frepetido']=0;
      //LEY1886 
      $importe['ley1886']=0;
      
      $importe['imp_total']=$importe['imp_fijo']+$importe['imp_adic'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))      
        $importe['aseo']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['aseo']), 1);
      else
        $importe['aseo']=0;//FIN ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['alumbrado']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['alumbrado']), 1);
      else 
        $importe['alumbrado']=0;// FIN ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo']+$importe['imp_adic'])){
          $importe['devolucion']=$importe['imp_fijo']+$importe['imp_adic'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      $importe['freg_ene0']=0;

      return $importe;

    }else{////GENERAL////////////////////////////100 ADE///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['ge_020'],1);
      $importe['imp_adic']=round((80*$factores['ge_100']),1) + round((($lectura['kwh']-100)*$factores['ge_ade']),1);
      $importe['dignidad']=0;// kwh > 100 no reciben beneficio
      $importe['frepetido']=0;      
      //LEY1886 
      $importe['ley1886']=0;
      // FIN LEY
      $importe['imp_total']=$importe['imp_fijo']+$importe['imp_adic'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))      
        $importe['aseo']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['aseo']), 1);
      else
        $importe['aseo']=0;//FIN ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['aseo']=round((($importe['imp_fijo']+$importe['imp_adic']))*0.87*($factores['aseo']), 1);
      else
        $importe['aseo']=0;//FIN ALUMBRADO
      $importe['alumbrado']=round((($importe['imp_fijo']+$importe['imp_adic']))*0.87*($factores['alumbrado']), 1);
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo']+$importe['imp_adic'])){
          $importe['devolucion']=$importe['imp_fijo']+$importe['imp_adic'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      $importe['freg_ene0']=0;
      return $importe;
    }//fin else 100_ade
  }//Fin funcion GENERAL

  public function industrial_menor($lectura, $factores){
    $kwh = $lectura['kwh'];
    $importe=array();

    if(($kwh >= 0) && ($kwh <= 50)){//IND MENOR /////////////////////////////0_50///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['i1_050'],1);
      $importe['imp_adic']=0;
      //DIGNIDAD
      $importe['dignidad']=0;
      $importe['frepetido']=0;
      //LEY1886 
      $importe['ley1886']=0;
      $importe['imp_total']=$importe['imp_fijo'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))
        $importe['aseo']=round($importe['imp_fijo']*0.87*($factores['aseo']), 1);
      else 
        $importe['aseo']=0;//ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['alumbrado']=round($importe['imp_fijo']*0.87*($factores['alumbrado']), 1);
      else 
        $importe['alumbrado']=0;//ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo'])){
          $importe['devolucion']=$importe['imp_fijo'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      $importe['freg_ene0']=0;

      return $importe;

    }elseif(($kwh >= 51)){//IND MENOR////////////////////////////////>51///////////////////////////////////////////////////////////////////////
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=round($factores['i1_050'],1);
      $importe['imp_adic']=round((($lectura['kwh']-50)*$factores['i1_ade']),1);
      //DIGNIDAD Aberiguamos si el cliente tiene solo 1 unico abonado
      $importe['dignidad']=0;
      $importe['frepetido']=0;
      //LEY1886 
      $importe['ley1886']=0;
      
      $importe['imp_total']=$importe['imp_fijo']+$importe['imp_adic'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))      
        $importe['aseo']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['aseo']), 1);
      else
        $importe['aseo']=0;//FIN ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['alumbrado']=round(($importe['imp_fijo']+$importe['imp_adic'])*0.87*($factores['alumbrado']), 1);
      else 
        $importe['alumbrado']=0;// FIN ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_fijo']+$importe['imp_adic'])){
          $importe['devolucion']=$importe['imp_fijo']+$importe['imp_adic'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      $importe['freg_ene0']=0;

      return $importe;
    }//fin if
    
  }//Fin funcion IND MENOR

  public function industrial_mayor($lectura, $factores){
    $kwh = $lectura['kwh'];
    $importe=array();
      
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=0;
      $importe['imp_adic']=$kwh*$factores['i2_ade'];
      $importe['imp_poten']=round($lectura['potencia']*$factores['i2_dem'],1);
      //DIGNIDAD
      $importe['dignidad']=0;
      $importe['frepetido']=0;
      //LEY1886 
      $importe['ley1886']=0;
      $importe['imp_total']=$importe['imp_adic']+$importe['imp_poten'];
      //ASEO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='2'))
        $importe['aseo']=round($importe['imp_total']*0.87*($factores['aseo']), 1);
      else 
        $importe['aseo']=0;//ASEO
      //ALUMBRADO
      if(($lectura['idliberacion']=='0') || ($lectura['idliberacion']=='1'))
        $importe['alumbrado']=round($importe['imp_total']*0.87*($factores['alumbrado']), 1);
      else 
        $importe['alumbrado']=0;//ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_total'])){
          $importe['devolucion']=$importe['imp_total'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      //AFCOOP
      $afcoop=$this->calculo_lecturas_model->get_socio($lectura['idabonado']);
      $clave = array_search($lectura['idcliente'], $this->repetidos_afcoop);
      if(!is_null($afcoop) && ($clave===false)){
        $importe['afcoop']=0.5;
        $this->repetidos_afcoop[]=$lectura['idcliente'];
      }
      else
        $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      $importe['freg_ene0']=0;

      return $importe;    
  }//Fin funcion IND MAYOR

  public function alumbrado_publico($lectura, $factores){
    $kwh = $lectura['kwh'];
    $importe=array();
      
      $importe['idlectura']=$lectura['idlectura'];
      $importe['kwh']=$lectura['kwh'];
      $importe['estado']='0';
      $importe['imp_fijo']=0;
      $importe['imp_adic']=round($kwh*$factores['ta_ade'], 1);
      $importe['imp_poten']=0;
      //DIGNIDAD
      $importe['dignidad']=0;
      $importe['frepetido']=0;
      //LEY1886 
      $importe['ley1886']=0;
      $importe['imp_total']=$importe['imp_adic'];
      $importe['aseo']=0;//ASEO
      $importe['alumbrado']=0;//ALUMBRADO
      //DEVOLUCION
      $devolucion=$this->calculo_lecturas_model->get_devolucion_abonado($lectura['idabonado']);
      if(!is_null($devolucion)){//existe devolucion por realizar
        if($devolucion['saldo']>=($importe['imp_total'])){
          $importe['devolucion']=$importe['imp_total'];//saldo cubre
          $nuevo_saldo=$devolucion['saldo']-$importe['devolucion'];//actulizando saldo
          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos
        }else{
          $importe['devolucion']=$devolucion['saldo'];//devolvemos todo el saldo restante
          $nuevo_saldo=0;
          //llendando la tabla devueltos
          $data_devueltos['idafectado']=$devolucion['idafectado'];
          $data_devueltos['idlectura']=$lectura['idlectura'];
          $data_devueltos['imp_devuelto']=$importe['devolucion'];
          $this->devueltos_model->insertar($data_devueltos);//FIN llendando la tabla devueltos

          $data_afectados['saldo']=$nuevo_saldo;
          $this->afectados_model->actualizar($devolucion['idafectado'], $data_afectados);//actualizamos afectado con nuevo saldo
          $data_resolucion['estado']='0';
          $this->resoluciones_model->actualizar($devolucion['idresolucion'], $data_resolucion);//actualizamos resolucion a estado=0
        }//fin if devolucion
      }else
        $importe['devolucion']=0;//FIN DEVOLUCION
      $importe['afcoop']=0;//FIN AFCOOP
      //CONEXION
      $conexion=$this->calculo_lecturas_model->get_conexion($lectura['idabonado']);
      if(!is_null($conexion)){
        $importe['conexion']=$conexion['costo'];
        $data_ordenes['cobrado']=1;
        $data_ordenes['idlectura']=$lectura['idlectura'];
        $this->ordenes_model->actualizar($conexion['idorden'], $data_ordenes);
      }
      else
        $importe['conexion']=0;//FIN CONEXION
      //REPOSICION
      $reposicion=$this->calculo_lecturas_model->get_reposicion($lectura['idabonado']);
      if(!is_null($reposicion)){
        $importe['reposicion']=$reposicion['costo'];
        $data_reposicion['cobrado']=1;
        $data_reposicion['idlectura']=$lectura['idlectura'];
        $this->reposiciones_model->actualizar($reposicion['idreposicion'], $data_reposicion);
      }
      else
        $importe['reposicion']=0;//FIN REPOSICION
      //RECARGOS
      $recargo=$this->calculo_lecturas_model->get_recargo($lectura['idabonado']);
      if(!is_null($recargo)){
        $suma_recargos =0;
        foreach ($recargo as $key => $recar) {
          $suma_recargos+=$recar['importe'];
          $data_recargo['cobrado']=1;
          $data_recargo['lecturacobrado']=$lectura['idlectura'];
          $this->recargos_model->actualizar($recar['idrecargo'], $data_recargo);
        }
        $importe['recargo']=$suma_recargos;
      }
      else
        $importe['recargo']=0;//FIN RECARGOS
      //FREG_ENE0
      $importe['freg_ene0']=0;

      return $importe;    
  }//Fin funcion IND MAYOR

}//fin class
