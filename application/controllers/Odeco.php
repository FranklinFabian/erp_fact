<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Odeco extends CI_Controller {

    public $menu;

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('session');
        $this->load->model('OdecoModel');
        $this->auth->check_admin_auth();
    }
    //cargar por defecto el formulario de reclamos de usuarios
    public function index() {
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        //get oficinas odeco
        $get_oficinaodeco = $CI->OdecoModel->get_oficinaodeco();
        $i = 0;
        if (!empty($get_oficinaodeco)) {
            foreach ($get_oficinaodeco as $k => $v) {
                $i++;
                $get_oficinaodeco[$k]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        //get tipo de reclamos
        $tipo_reclamo = $CI->OdecoModel->tipo_reclamo();
        $i = 0;
        if (!empty($tipo_reclamo)) {
            foreach ($tipo_reclamo as $k => $v) {
                $i++;
                $tipo_reclamo[$k]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        //get usuarios/clientes/consumidores
        $get_IdAbonado = $CI->OdecoModel->get_IdAbonado();
        $i = 0;
        if (!empty($get_IdAbonado)) {
            foreach ($get_IdAbonado as $k => $v) {
                $i++;
                $get_IdAbonado[$k]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        //localidades
        $get_localidades = $CI->OdecoModel->get_localidades();
        //agrupar
        $data = array(
            'tipo_reclamo' => $tipo_reclamo,
            'get_IdAbonado' => $get_IdAbonado,
            'get_oficinaodeco' => $get_oficinaodeco,
            'get_localidades' => $get_localidades
        );
        //render view 
        $content = $CI->parser->parse('odeco/reclamos_cliente/formulario_reclamos', $data, true);
        $this->template->full_admin_html_view($content);
    }
    //mostrar la lista de reclamos generados
    public function listar_reclamos()
    {
        $semestre_actual1 = $this->OdecoModel->semestre_actual();
        $semestre_actual = $semestre_actual1[0]['Sigla'];
        $semestre ='';
        if(!empty($this->input->post('semestre'))){$semestre=$this->input->post('semestre');}else{$semestre = $semestre_actual;}
        $semestre = $this->OdecoModel->semestre($semestre);
        $listar_semestres = $this->OdecoModel->listar_semestres(); 

        //agrupar
        $data = array(
            'title'         => 'Reclamos Recepcionados Registrados',
            'semestre' =>$semestre,
            'listar_semestres' => $listar_semestres
        );
        $content = $this->parser->parse('odeco/reclamos_cliente/reclamos_listar', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function listar_reclamos_ajax()
    {
        // POST data
        $postData = $this->input->post();

        $semestre = $postData['searchSemestre'];
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];

        $data = $this->OdecoModel->listar_reclamos($postData,$fecha_inicial,$fecha_final); 

        // Get data
        echo json_encode($data);
    }
    /*public function listar_reclamos_atendidos()
    {   
        $semestre_actual1 = $this->OdecoModel->semestre_actual();
        $semestre_actual = $semestre_actual1[0]['Sigla'];
        $semestre ='';
        if(!empty($this->input->post('semestre'))){$semestre=$this->input->post('semestre');}else{$semestre = $semestre_actual;}
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $odeco_list = $this->OdecoModel->listar_reclamos_atendidos($fecha_inicial,$fecha_final); 
        $listar_semestres = $this->OdecoModel->listar_semestres(); 
        //agrupar
        $data = array(
            'title'         => 'RECLAMOS ATENDIDOS',
            'odeco_list' => $odeco_list,
            'semestre' =>$semestre,
            'listar_semestres' => $listar_semestres
        );
        $content = $this->parser->parse('odeco/reclamos_cliente/reclamos_atendidos', $data, true);
        $this->template->full_admin_html_view($content);
    }*/
    public function listar_reclamos_atendidos()
    {
        $semestre_actual1 = $this->OdecoModel->semestre_actual();
        $semestre_actual = $semestre_actual1[0]['Sigla'];
        $semestre ='';
        if(!empty($this->input->post('semestre'))){$semestre=$this->input->post('semestre');}else{$semestre = $semestre_actual;}
        $semestre = $this->OdecoModel->semestre($semestre);
        $listar_semestres = $this->OdecoModel->listar_semestres(); 

        //agrupar
        $data = array(
            'title'         => 'RECLAMOS ATENDIDOS',
            'semestre' =>$semestre,
            'listar_semestres' => $listar_semestres
        );
        $content = $this->parser->parse('odeco/reclamos_cliente/reclamos_atendidos', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function listar_reclamos_atendidos_ajax()
    {
        // POST data
        $postData = $this->input->post();

        $semestre = $postData['searchSemestre'];
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];

        $data = $this->OdecoModel->listar_reclamos_atendidos($postData,$fecha_inicial,$fecha_final); 

        // Get data
        echo json_encode($data);
    }
    //buscar abonado en la base de datos
    public function buscar_abonado(){
        $Id_Abonado = $this->input->post('Id_Abonado');
        $result = $this->OdecoModel->clientetitular_list($Id_Abonado);
        echo json_encode($result);
    }
    //Insert reclamo
    public function registrar_reclamo() {

        $data = array(
            'NRO_CUENTA'   => $this->input->post('nro_cuenta'),
            'NIVEL_CALIDAD' => $this->input->post('nivel_calidad'),
            'COD_LOCALIDAD' => $this->input->post('cod_localidad'),
            'CATEGORIA'   => $this->input->post('categoria'),
            'COD_RECLAMO' => $this->input->post('cod_reclamo'),
            'FECHA_HORA_REC' => $this->input->post('fecha_recepcion'),
            'MOTIVO'   => $this->input->post('motivo'),
            'ESTADO'   => 'RECEPCIONADO',
            'ESTADO_DEL_REGISTRO'   => 'ACTIVO'
        );
        $Id_reclamo = $this->OdecoModel->registrar_reclamo($data);
        $fila = json_decode($_POST['equipos'], true);
        $equipo = (!empty($fila)) ? $equipo = 1: $equipo=0;
        $data = array(
            //reistro adicional
            'Id_reclamo'   => $Id_reclamo,
            'Oficina_odeco'   => $this->input->post('oficina_odeco'),
            'Medio_recepcion' => $this->input->post('medio_recepcion'),
            'Cliente'   => $this->input->post('nro_cuenta'),
            'Nombre_reclamante' => $this->input->post('nombre_reclamante'),
            'Ci_reclamante' => $this->input->post('nro_ci_reclamante'),
            'Direccion_reclamante' => $this->input->post('direccion_reclamante'),
            'Nro_cuenta_reclamante' => $this->input->post('nro_cuenta_reclamante'),
            'Telefono_1_reclamante'   => $this->input->post('telefono_1'),
            'Telefono_2_reclamante'   => $this->input->post('telefono_2'),
            'Localidad_reclamante'   => $this->input->post('localidad'),
            'Zona_reclamante'   => $this->input->post('cod_zona_reclamante'),
            'Nro_medidor_reclamante' => $this->input->post('medidor_reclamante'),
            'Domicilio_real_reclamante' => $this->input->post('domicilio_real'),
            'Domicilio_especial' => $this->input->post('domicilio_especial'),
            'Domicilio_procesal' => $this->input->post('domicilio_procesal'),
            'Fecha_evento_causa'   => $this->input->post('fecha_evento'),
            'Hora_evento_causa'   => $this->input->post('hora_evento'),
            'Equipo'   => $equipo
        );
        $result = $this->OdecoModel->registrar_reclamo_adicional($data);
        if(!empty($fila)){
            foreach ($fila as $valor) 
            {
              $parametros = array(
                          'Id_reclamo' => $Id_reclamo,
                          'Descripcion' => $valor['descripcion_dano'],
                          'Marca' => $valor['marca'],
                          'Modelo' => $valor['modelo'],
                          'Serie' => $valor['serie'],
                          'Anio' => $valor['anio'],
                          'Observaciones' => $valor['observaciones']
                      );
                      $equipos = $this->OdecoModel->registrar_equipos($parametros);
                      if ($equipos) 
                      {
                          $respuesta = 1;
                      }
            }
        }
        if ($Id_reclamo && $result) {
            echo json_encode($Id_reclamo);
        } else {
            echo json_encode('Error');
        }
    }
    //ver detalle de reclamo
    public function ver_detalle_reclamo($numero_reclamo){

        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        $odeco_detail = $CI->OdecoModel->get_detalle_reclamo($numero_reclamo);
        $data = array(
            'title'         => 'Ver Detalle de Reclamo',
            'data' => $odeco_detail
        );
        $content = $CI->parser->parse('odeco/reclamos_cliente/ver_detalle_reclamo', $data, true);
        $this->template->full_admin_html_view($content);
    }
    //emitir pronunciamiento form
    public function emitir_pronunciamiento($numero_reclamo){
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        $odeco_detail = $CI->OdecoModel->get_detalle_reclamo($numero_reclamo);
        $data = array(
            'title'         => 'Ver Detalle de Reclamo',
            'data'   => $odeco_detail,
        );
        $content = $CI->parser->parse('odeco/reclamos_cliente/emitir_pronunciamiento', $data, true);
        $this->template->full_admin_html_view($content);
    }
    //emoitir pronunciamiento DB
    public function registrar_pronunciamiento() {
        $idreclamo = $this->input->post('idreclamo');
        $data = array(
            'FECHA_HORA_RES'   => $this->input->post('fecha_respuesta'),
            'FECHA_HORA_SOL' => $this->input->post('fecha_solucion'),
            'IND_JUSTIFICADO' => $this->input->post('indicador_justificado'),
            'IND_CONFORMIDAD'   => $this->input->post('indicador_conformidad'),
            'TIEMPO_TRAMITE' => $this->input->post('tiempo_tramite'),
            'ESTADO'   => $this->input->post('estado'),
            'OBSERVACION'   => $this->input->post('observacion')
        );
        $result = $this->OdecoModel->registrar_pronunciamiento($data, $idreclamo);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode('Error');
        }
    }
    //anular reclamo
    public function anular_reclamo(){
        $idreclamo = $this->input->post('id');
        $data = array(
            'ESTADO_DEL_REGISTRO'   => 'INACTIVO'
        );
        $result = $this->OdecoModel->anular_reclamo($idreclamo, $data);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode('Error');
        }
    }
    //generar reportes de reclamos
    public function listar_reclamos_reportes()
    {
        $CI = & get_instance();
        $data = array(
            'title'         => 'Generar Reporte de Reclamos'
        );
        $content = $CI->parser->parse('odeco/reclamos_cliente/listar_reclamos_reportes', $data, true);
        $this->template->full_admin_html_view($content);
    }
    //
    //generar reportes de reclamos
    public function listar_reclamos_reportes_list()
    {
        $start       = $this->input->post('from_date');
        $end         = $this->input->post('to_date');
        $nro_cuenta         = $this->input->post('nro_cuenta');
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        $reclamos   = $CI->OdecoModel->listar_reclamos_reportes($start, $end, $nro_cuenta);
        $data = array(
            'title'          => 'Reporte de la Lista de Reclamos',
            'reclamos'        => $reclamos,
            'start'          => $start,
            'end'            => $end
        );
        $content = $CI->parser->parse('odeco/reclamos_cliente/listar_reclamos_reportes', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function listar_reclamos_reportes_por_cuenta()
    {
        $nro_cuenta         = $this->input->post('nro_cuenta');
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        $reclamos   = $CI->OdecoModel->listar_reclamos_reportes_por_cuenta($nro_cuenta);
        $data = array(
            'title'          => 'Reporte de la Lista de Reclamos',
            'reclamos'        => $reclamos
        );
        $content = $CI->parser->parse('odeco/reclamos_cliente/listar_reclamos_reportes', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function editar_pronunciamiento($nro_reclamo)
    {
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        $odeco_detail = $CI->OdecoModel->get_detalle_reclamo($nro_reclamo);
        $data = array(
            'title'         => 'Ver Detalle de Reclamo',
            'data'   => $odeco_detail,
        );
        $content = $CI->parser->parse('odeco/reclamos_cliente/editar_pronunciamiento', $data, true);
        $this->template->full_admin_html_view($content);
    }
    //actualizar pronunciamiento DB
    public function actualizar_pronunciamiento() {
        $idreclamo = $this->input->post('idreclamo');
        $data = array(
            'FECHA_HORA_RES'   => $this->input->post('fecha_respuesta'),
            'FECHA_HORA_SOL' => $this->input->post('fecha_solucion'),
            'IND_JUSTIFICADO' => $this->input->post('indicador_justificado'),
            'IND_CONFORMIDAD'   => $this->input->post('indicador_conformidad'),
            'TIEMPO_TRAMITE' => $this->input->post('tiempo_tramite'),
            'ESTADO'   => $this->input->post('estado'),
            'OBSERVACION'   => $this->input->post('observacion')
        );
        $result = $this->OdecoModel->registrar_pronunciamiento($data, $idreclamo);

        if ($result) {
            echo json_encode($result);
        } else {
            echo json_encode('Error');
        }
    }
    /**************reportes PDF DE Reclamos ***********************/
    public function formulario_pdf($nro_reclamo)
    {
        $detalles_reclamo = $this->OdecoModel->detalles_reclamo($nro_reclamo);
        $detalles_equipos = $this->OdecoModel->detalles_equipos($nro_reclamo);
        //print_r($detalles_reclamo);exit;
        $data = array(
            'titulo' => 'Detalles de Reclamo',
            'asunto'         => 'FORMULARIO DE RECLAMACI&Oacute;N DIRECTA',
            'nombre_empresa' => 'COOPELECT R.L.',
            'detalles_reclamo' => $detalles_reclamo,
            'detalles_equipos' => $detalles_equipos
        );

        $this->load->library('pdf'); 
        $content = $this->parser->parse('odeco/reclamos_cliente/reclamo_pdf', $data, true);
        $this->dompdf->load_html($content);
        $this->dompdf->setPaper('letter', 'portrait'); # tamño y orientación
        $this->dompdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("Reclamo_Nro_".$nro_reclamo.".pdf", array("Attachment"=>0));
    }
    //respuesta pdf
    public function respuesta_pdf($nro_reclamo)
    {
        $detalles_reclamo = $this->OdecoModel->detalles_reclamo($nro_reclamo);
        //print_r($detalles_reclamo);exit;
        $data = array(
            'titulo' => 'Detalles de Respuesta',
            'asunto'         => 'FORMULARIO DE RECLAMACI&Oacute;N DIRECTA',
            'detalles_reclamo' => $detalles_reclamo
        );

        $this->load->library('pdf'); 
        $content = $this->parser->parse('odeco/reclamos_cliente/respuesta_pdf', $data, true);
        $time = date('Ymdhi');
        $this->dompdf->load_html($content);
        $this->dompdf->setPaper('letter', 'portrait'); # tamño y orientación
        $this->dompdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("Respuesta_a_reclamo_Nro_".$nro_reclamo.".pdf", array("Attachment"=>0));
    }
    /***************** ALIMENTADORES *********************/
    public function alimentadores_listar()
    {
        $semestre_actual1 = $this->OdecoModel->semestre_actual();
        $semestre_actual = $semestre_actual1[0]['Sigla'];
        $semestre ='';
        if(!empty($this->input->post('semestre'))){$semestre=$this->input->post('semestre');}else{$semestre = $semestre_actual;}
        $semestre = $this->OdecoModel->semestre($semestre);
        $listar_semestres = $this->OdecoModel->listar_semestres(); 

        //agrupar
        $data = array(
            'title'         => 'Alimentadores Registrados',
            'semestre' =>$semestre,
            'listar_semestres' => $listar_semestres
        );
        $content = $this->parser->parse('odeco/alimentadores/listar_alimentadores', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function listar_alimentadores_ajax()
    {
        // POST data
        $postData = $this->input->post();

        $semestre = $postData['searchSemestre'];
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];

        $data = $this->OdecoModel->listar_alimentadores($postData,$fecha_inicial,$fecha_final); 

        // Get data
        //$data = $this->OdecoModel->listar_alimentadores($postData);
        echo json_encode($data);
    }
    public function agregar_alimentador()
    {
        $CI = & get_instance();
        $data = array(
            'title'         => 'Formulario de Registro de Nuevo Alimentador'
        );
        $content = $CI->parser->parse('odeco/alimentadores/formulario_alimentador', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function registrar_alimentador()
    {
        $data = array(
            //reistro
            'COD_ALIMENTADOR'   => $this->input->post('cod_alimentador'),
            'COD_PROTECCION' => $this->input->post('cod_proteccion'),
            'SUBESTACION'   => $this->input->post('subestacion'),
            'KVA_ALIMENTADOR' => $this->input->post('kva_alimentador'),
            'KV_ALIMENTADOR'   => $this->input->post('kv_alimentador'),
            'CONSUM_MT_1'   => $this->input->post('consum_mt_nc1'),
            'CONSUM_MT_2' => $this->input->post('consum_mt_nc2'),
            'CONSUM_BT_1' => $this->input->post('consum_bt_nc1'),
            'CONSUM_BT_2' => $this->input->post('consum_bt_nc2'),
            'COD_LOCALIDADES'   => $this->input->post('direccion')
        );
        //var_dump($data);
        $result = $this->OdecoModel->registrar_alimentador($data);
        echo json_encode($result);
    }

    public function anular_alimentador()
    {
        $cod_alimentador = $this->input->post('cod_alimentador');
        $result = $this->OdecoModel->anular_alimentador($cod_alimentador);
        echo json_encode($result);
    }
    public function ver_editar_alimentador($cod_alimentador)
    {
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        $detalles = $CI->OdecoModel->get_detalle_alimentador($cod_alimentador);
        $data = array(
            'title'         => 'Ver Detalle de Alimentador',
            'data' => $detalles
        );
        $content = $CI->parser->parse('odeco/alimentadores/ver_detalle_alimentador', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function modificar_alimentador()
    {
        $data = array(
            //reistro
            'COD_PROTECCION' => $this->input->post('cod_proteccion'),
            'SUBESTACION'   => $this->input->post('subestacion'),
            'KVA_ALIMENTADOR' => $this->input->post('kva_alimentador'),
            'KV_ALIMENTADOR'   => $this->input->post('kv_alimentador'),
            'CONSUM_MT_1'   => $this->input->post('consum_mt_nc1'),
            'CONSUM_MT_2' => $this->input->post('consum_mt_nc2'),
            'CONSUM_BT_1' => $this->input->post('consum_bt_nc1'),
            'CONSUM_BT_2' => $this->input->post('consum_bt_nc2'),
            'COD_LOCALIDADES'   => $this->input->post('direccion')
        );
        //var_dump($data);
        $cod_alimentador  = $this->input->post('cod_alimentador');
        $result = $this->OdecoModel->modificar_alimentador($data, $cod_alimentador);
        echo json_encode($result);
    }
    /***************** ELEMENTOS DE MANIOBRA *********************/
    public function listar_maniobras()
    {
        $semestre_actual1 = $this->OdecoModel->semestre_actual();
        $semestre_actual = $semestre_actual1[0]['Sigla'];
        $semestre ='';
        if(!empty($this->input->post('semestre'))){$semestre=$this->input->post('semestre');}else{$semestre = $semestre_actual;}
        $semestre = $this->OdecoModel->semestre($semestre);
        $listar_semestres = $this->OdecoModel->listar_semestres(); 
        //agrupar
        $data = array(
            'title'         => 'Elementos de Maniobra Registrados',
            'semestre' =>$semestre,
            'listar_semestres' => $listar_semestres
        );
        $content = $this->parser->parse('odeco/maniobras/listar_maniobras', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function listar_maniobras_ajax()
    {
        // POST data
        $postData = $this->input->post();
        $semestre = $postData['searchSemestre'];
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $data = $this->OdecoModel->listar_maniobras($postData,$fecha_inicial,$fecha_final); 
        echo json_encode($data);
    }
    public function agregar_maniobra()
    {
        $CI = & get_instance();
        $get_codalimentador = $CI->OdecoModel->get_codalimentador();
        $get_localidades = $CI->OdecoModel->get_localidades();
        //$get_codzona = $CI->OdecoModel->get_codzona();
        $data = array(
            'title'         => 'Formulario de Registro de Nuevo Elemento de Maniobra',
            'get_codalimentador' => $get_codalimentador,
            'get_localidades' => $get_localidades,
            //'get_codzona' => $get_codzona
        );
        $content = $CI->parser->parse('odeco/maniobras/formulario_maniobra', $data, true);
        $this->template->full_admin_html_view($content);
    }
    //get AJAX cod zona
    public function get_codzona()
    {
        $id_localidad = $this->input->post('id_localidad');
        $result = $this->OdecoModel->get_codzona($id_localidad);
        echo json_encode($result);
    }
    public function registrar_maniobra()
    {
        $data = array(
            //reistro
            'COD_PROTECCION' => $this->input->post('cod_proteccion'),
            'COD_ALIMENTADOR'   => $this->input->post('cod_alimentador'),
            'TIPO_PROTECCION' => $this->input->post('tipo_proteccion'),
            'ESTADO'   => $this->input->post('estado'),
            'KVA_PROTECCION' => $this->input->post('kva_proteccion'),
            'KV_PROTECCION'   => $this->input->post('kv_proteccion'),
            'COD_ZONA'   => $this->input->post('cod_zona'),
            'PROTECCION_SUP'   => $this->input->post('proteccion_superior'),
            'CONSUM_MT_1'   => $this->input->post('consum_mt_nc1'),
            'CONSUM_MT_2' => $this->input->post('consum_mt_nc2'),
            'CONSUM_BT_1' => $this->input->post('consum_bt_nc1'),
            'CONSUM_BT_2' => $this->input->post('consum_bt_nc2'),
            'DIRECCION'   => $this->input->post('direccion')
        );
        //var_dump($data);
        $result = $this->OdecoModel->registrar_maniobra($data);
        echo json_encode($result);
    }

    public function anular_maniobra()
    {
        $cod_proteccion = $this->input->post('cod_proteccion');
        $result = $this->OdecoModel->anular_maniobra($cod_proteccion);
        echo json_encode($result);
    }
    public function ver_editar_maniobra($cod_proteccion)
    {
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        $detalles = $CI->OdecoModel->get_detalle_maniobra($cod_proteccion);
        $get_codalimentador = $CI->OdecoModel->get_codalimentador();
        $get_localidades = $CI->OdecoModel->get_localidades();
        $get_codzona = $CI->OdecoModel->get_codzonas();
        $data = array(
            'title'         => 'Ver Detalle de Elemento de Proteccion',
            'data' => $detalles,
            'get_codalimentador' => $get_codalimentador,
            'get_localidades' => $get_localidades,
            'get_codzona' => $get_codzona
        );
        $content = $CI->parser->parse('odeco/maniobras/ver_detalle_maniobra', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function modificar_maniobra()
    {
        $data = array(
            //registro
            'COD_ALIMENTADOR'   => $this->input->post('cod_alimentador'),
            'TIPO_PROTECCION' => $this->input->post('tipo_proteccion'),
            'ESTADO'   => $this->input->post('estado'),
            'KVA_PROTECCION' => $this->input->post('kva_proteccion'),
            'KV_PROTECCION'   => $this->input->post('kv_proteccion'),
            'COD_ZONA'   => $this->input->post('cod_zona'),
            'PROTECCION_SUP'   => $this->input->post('proteccion_superior'),
            'CONSUM_MT_1'   => $this->input->post('consum_mt_nc1'),
            'CONSUM_MT_2' => $this->input->post('consum_mt_nc2'),
            'CONSUM_BT_1' => $this->input->post('consum_bt_nc1'),
            'CONSUM_BT_2' => $this->input->post('consum_bt_nc2'),
            'DIRECCION'   => $this->input->post('direccion')
        );
        //var_dump($data);
        $cod_proteccion  = $this->input->post('cod_proteccion');
        $result = $this->OdecoModel->modificar_maniobra($data, $cod_proteccion);
        echo json_encode($result);
    }
    /***************** CENTROS DE TRANSFORMACION *********************/
    public function listar_centros()
    {
        $semestre_actual1 = $this->OdecoModel->semestre_actual();
        $semestre_actual = $semestre_actual1[0]['Sigla'];
        $semestre ='';
        if(!empty($this->input->post('semestre'))){$semestre=$this->input->post('semestre');}else{$semestre = $semestre_actual;}
        $semestre = $this->OdecoModel->semestre($semestre);
        $listar_semestres = $this->OdecoModel->listar_semestres(); 
        //agrupar
        $data = array(
            'title'         => 'Centros de Transformacion Registrados',
            'semestre' =>$semestre,
            'listar_semestres' => $listar_semestres
        );
        $content = $this->parser->parse('odeco/centro_transformacion/listar_centros', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function listar_centros_ajax()
    {
        // POST data
        $postData = $this->input->post();
        $semestre = $postData['searchSemestre'];
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $data = $this->OdecoModel->listar_centros($postData,$fecha_inicial,$fecha_final); 
        echo json_encode($data);
    }
    public function agregar_centro()
    {
        $CI = & get_instance();
        $get_codalimentador = $CI->OdecoModel->get_codalimentador();
        $get_localidades = $CI->OdecoModel->get_localidades();
        $get_proteccion = $CI->OdecoModel->get_proteccion();
        $data = array(
            'title'         => 'Formulario de Registro de Nuevo Centro de Transformacion',
            'get_codalimentador' => $get_codalimentador,
            'get_localidades' => $get_localidades,
            'get_proteccion' => $get_proteccion
        );
        $content = $CI->parser->parse('odeco/centro_transformacion/formulario_centro', $data, true);
        $this->template->full_admin_html_view($content);
    }
    //registrar centro
    public function registrar_centro()
    {
        $data = array(
            //reistro
            'COD_CENTRO' => $this->input->post('cod_centro'),
            'TIPO_TRAFO' => $this->input->post('tipo_trafo'),
            'KVA_CENTRO' => $this->input->post('kva_centro'),
            'TIPO_USO' => $this->input->post('tipo_uso'),
            'NIVEL_CALIDAD' => $this->input->post('nivel_calidad'),
            'COD_PROTECCION' => $this->input->post('cod_proteccion'),
            'COD_ALIMENTADOR'   => $this->input->post('cod_alimentador'),
            'COD_PROPIEDAD' => $this->input->post('cod_propiedad'),
            'REL_TRAFO'   => $this->input->post('rel_transfo'),
            'POSICION_TAP' => $this->input->post('posicion_tap'),
            'CONSUM_MT'   => $this->input->post('consumidores_mt'),
            'CONSUM_BT'   => $this->input->post('consumidores_bt'),
            'DIRECCION'   => $this->input->post('direccion')
        );
        //var_dump($data);
        $result = $this->OdecoModel->registrar_centro($data);
        echo json_encode($result);
    }

    public function anular_centro()
    {
        $cod_centro = $this->input->post('cod_centro');
        $result = $this->OdecoModel->anular_centro($cod_centro);
        echo json_encode($result);
    }
    public function ver_editar_centro($cod_centro)
    {
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        $get_codalimentador = $CI->OdecoModel->get_codalimentador();
        $get_localidades = $CI->OdecoModel->get_localidades();
        $get_proteccion = $CI->OdecoModel->get_proteccion();
        $detalles = $CI->OdecoModel->get_detalle_centro($cod_centro);
        $data = array(
            'title'         => 'Ver Detalle de Centro de Transformacion',
            'data' => $detalles,
            'get_codalimentador' => $get_codalimentador,
            'get_localidades' => $get_localidades,
            'get_proteccion' => $get_proteccion
        );
        $content = $CI->parser->parse('odeco/centro_transformacion/ver_detalle_centro', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function modificar_centro()
    {
        $data = array(
            //registro
            'TIPO_TRAFO' => $this->input->post('tipo_trafo'),
            'KVA_CENTRO' => $this->input->post('kva_centro'),
            'TIPO_USO' => $this->input->post('tipo_uso'),
            'NIVEL_CALIDAD' => $this->input->post('nivel_calidad'),
            'COD_PROTECCION' => $this->input->post('cod_proteccion'),
            'COD_ALIMENTADOR'   => $this->input->post('cod_alimentador'),
            'COD_PROPIEDAD' => $this->input->post('cod_propiedad'),
            'REL_TRAFO'   => $this->input->post('rel_transfo'),
            'POSICION_TAP' => $this->input->post('posicion_tap'),
            'CONSUM_MT'   => $this->input->post('consumidores_mt'),
            'CONSUM_BT'   => $this->input->post('consumidores_bt'),
            'DIRECCION'   => $this->input->post('direccion')
        );
        //var_dump($data);
        $cod_centro  = $this->input->post('cod_centro');
        $result = $this->OdecoModel->modificar_centro($data, $cod_centro);
        echo json_encode($result);
    }
    /***************** CORTES PROGRAMADOS *********************/
    public function listar_cortes()
    {
        $semestre_actual1 = $this->OdecoModel->semestre_actual();
        $semestre_actual = $semestre_actual1[0]['Sigla'];
        $semestre ='';
        if(!empty($this->input->post('semestre'))){$semestre=$this->input->post('semestre');}else{$semestre = $semestre_actual;}
        $semestre = $this->OdecoModel->semestre($semestre);
        $listar_semestres = $this->OdecoModel->listar_semestres(); 
        //agrupar
        $data = array(
            'title'         => 'Cortes Programados Registrados',
            'semestre' =>$semestre,
            'listar_semestres' => $listar_semestres
        );
        $content = $this->parser->parse('odeco/cortes_programados/listar_cortes', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function listar_cortes_ajax()
    {
        // POST data
        $postData = $this->input->post();
        $semestre = $postData['searchSemestre'];
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $data = $this->OdecoModel->listar_cortes($postData,$fecha_inicial,$fecha_final); 
        echo json_encode($data);
    }
    public function agregar_corte()
    {
        $CI = & get_instance();
        $get_codalimentador = $CI->OdecoModel->get_codalimentador();
        $get_proteccion = $CI->OdecoModel->get_proteccion();
        $get_origen = $CI->OdecoModel->get_origen();
        $get_causa = $CI->OdecoModel->get_causa();
        $get_localidades = $CI->OdecoModel->get_localidades();
        $get_id_corte = $CI->OdecoModel->get_id_corte();
        $data = array(
            'title'         => 'Formulario de Registro de Nuevo Centro de Transformacion',
            'get_codalimentador' => $get_codalimentador,
            'get_proteccion' => $get_proteccion,
            'get_origen' => $get_origen,
            'get_causa' => $get_causa,
            'get_localidades' => $get_localidades,
            'get_id_corte' => $get_id_corte
        );
        $content = $CI->parser->parse('odeco/cortes_programados/formulario_corte', $data, true);
        $this->template->full_admin_html_view($content);
    }
    //get AJAX tipo origen
    public function get_tipo_origen()
    {
        $id_origen = $this->input->post('id_origen');
        $result = $this->OdecoModel->get_tipo_origen($id_origen);
        echo json_encode($result);
    }
    //get AJAX tipo causa
    public function get_tipo_causa()
    {
        $id_causa = $this->input->post('id_causa');
        $result = $this->OdecoModel->get_tipo_causa($id_causa);
        echo json_encode($result);
    }
    //registrar centro
    public function registrar_corte()
    {
        $data = array(
            //reistro
            'COD_ALIMENTADOR' => $this->input->post('cod_alimentador'),
            'COD_PROTECCION' => $this->input->post('cod_proteccion'),
            'FECHA_HORA_INI' => $this->input->post('fecha_inicial'),
            'FECHA_HORA_FIN' => $this->input->post('fecha_final'),
            'COD_ORIGEN' => $this->input->post('origen_interrupcion'),
            'ORIGEN_TIPO'   => $this->input->post('cod_tipo_origen'),
            'COD_CAUSA' => $this->input->post('causa_interrupcion'),
            'CAUSA_TIPO'   => $this->input->post('cod_tipo_causa'),
            'TIEMPO_INTERRUPCION' => $this->input->post('tiempo_interrupcion'),
            'KVA_INTERRUMP'   => $this->input->post('potencia_interrumpida'),
            'CONSUM_AFECTADOS'   => $this->input->post('consumidores_afectados'),
            'COD_ZONAS'   => $this->input->post('cod_zonas'),
            'TRABAJO'   => $this->input->post('trabajo'),
            'ESTADO'   => 'ACTIVO'
        );
        $result = $this->OdecoModel->registrar_corte($data);
        echo json_encode($result);
    }
    
    public function anular_corte()
    {
        $nro_programado = $this->input->post('nro_programado');
        $data = array(
            'ESTADO'   => 'INACTIVO'
        );
        $result = $this->OdecoModel->anular_corte($nro_programado, $data);
        echo json_encode($result);
    }
    
    public function ver_editar_corte($nro_programado)
    {
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        $get_codalimentador = $CI->OdecoModel->get_codalimentador();
        $get_proteccion = $CI->OdecoModel->get_proteccion();
        $get_origen = $CI->OdecoModel->get_origen();
        $get_causa = $CI->OdecoModel->get_causa();
        $get_tipo_origen_all = $CI->OdecoModel->get_tipo_origen_all();
        $get_tipo_causa_all = $CI->OdecoModel->get_tipo_causa_all();
        $get_localidades = $CI->OdecoModel->get_localidades();
        $detalles = $CI->OdecoModel->get_detalle_corte($nro_programado);
        $data = array(
            'title'         => 'Ver Detalle de Centro de Transformacion',
            'get_codalimentador' => $get_codalimentador,
            'get_proteccion' => $get_proteccion,
            'get_origen' => $get_origen,
            'get_causa' => $get_causa,
            'get_localidades' => $get_localidades,
            'data' => $detalles,
            'get_tipo_origen_all' => $get_tipo_origen_all,
            'get_tipo_causa_all' => $get_tipo_causa_all
        );
        $content = $CI->parser->parse('odeco/cortes_programados/ver_detalle_corte', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function modificar_corte()
    {
        $data = array(
            //registro
            'COD_ALIMENTADOR' => $this->input->post('cod_alimentador'),
            'COD_PROTECCION' => $this->input->post('cod_proteccion'),
            'FECHA_HORA_INI' => $this->input->post('fecha_inicial'),
            'FECHA_HORA_FIN' => $this->input->post('fecha_final'),
            'COD_ORIGEN' => $this->input->post('origen_interrupcion'),
            'ORIGEN_TIPO'   => $this->input->post('cod_tipo_origen'),
            'COD_CAUSA' => $this->input->post('causa_interrupcion'),
            'CAUSA_TIPO'   => $this->input->post('cod_tipo_causa'),
            'TIEMPO_INTERRUPCION' => $this->input->post('tiempo_interrupcion'),
            'KVA_INTERRUMP'   => $this->input->post('potencia_interrumpida'),
            'CONSUM_AFECTADOS'   => $this->input->post('consumidores_afectados'),
            'COD_ZONAS'   => $this->input->post('cod_zonas'),
            'TRABAJO'   => $this->input->post('trabajo'),
            'ESTADO'   => 'ACTIVO'
        );
        $cod_nro_programado  = $this->input->post('nro_programado_id');
        $result = $this->OdecoModel->modificar_corte($data, $cod_nro_programado);
        echo json_encode($result);
    }
    /********************** GESTION Y REGISTRO DE LIBROS DE GUARDIA *********/
    public function listar_libros()
    {
        $semestre_actual1 = $this->OdecoModel->semestre_actual();
        $semestre_actual = $semestre_actual1[0]['Sigla'];
        $semestre ='';
        if(!empty($this->input->post('semestre'))){$semestre=$this->input->post('semestre');}else{$semestre = $semestre_actual;}
        $semestre = $this->OdecoModel->semestre($semestre);
        $listar_semestres = $this->OdecoModel->listar_semestres(); 
        //agrupar
        $data = array(
            'title'         => 'Libros de Guardia Registrados',
            'semestre' =>$semestre,
            'listar_semestres' => $listar_semestres
        );
        $content = $this->parser->parse('odeco/libro_guardia/listar_libros', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function listar_libros_ajax()
    {
        // POST data
        $postData = $this->input->post();
        $semestre = $postData['searchSemestre'];
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $data = $this->OdecoModel->listar_libros($postData,$fecha_inicial,$fecha_final); 
        echo json_encode($data);
    }
    public function agregar_libro($semestre)
    {
        $CI = & get_instance();
        $get_codalimentador = $CI->OdecoModel->get_codalimentador();
        $get_proteccion = $CI->OdecoModel->get_proteccion();
        $get_origen = $CI->OdecoModel->get_origen();
        $get_causa = $CI->OdecoModel->get_causa();
        $get_localidades = $CI->OdecoModel->get_localidades();
        $get_id_libro = $CI->OdecoModel->get_id_libro();
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $cortes = $this->OdecoModel->get_cortes($fecha_inicial,$fecha_final); 
        $data = array(
            'title'         => 'Formulario de Registro de Nuevo Libro de Guardia',
            'get_codalimentador' => $get_codalimentador,
            'get_proteccion' => $get_proteccion,
            'get_origen' => $get_origen,
            'get_causa' => $get_causa,
            'get_localidades' => $get_localidades,
            'get_id_libro' => $get_id_libro,
            'cortes' => $cortes
        );
        $content = $CI->parser->parse('odeco/libro_guardia/formulario_libro', $data, true);
        $this->template->full_admin_html_view($content);
    }    
    //registrar centro
    public function registrar_libro()
    {
        $data = array(
            //registro
            'NRO_PROGRAMADO' => $this->input->post('nro_programado'),
            'TIPO_FALLA' => $this->input->post('tipo_falla'),
            'COD_ALIMENTADOR' => $this->input->post('cod_alimentador'),
            'COD_PROTECCION' => $this->input->post('cod_proteccion'),
            'FECHA_HORA_INI' => $this->input->post('fecha_inicial'),
            'FECHA_HORA_FIN' => $this->input->post('fecha_final'),
            'COD_ORIGEN' => $this->input->post('origen_interrupcion'),
            'ORIGEN_TIPO'   => $this->input->post('cod_tipo_origen'),
            'COD_CAUSA' => $this->input->post('causa_interrupcion'),
            'CAUSA_TIPO'   => $this->input->post('cod_tipo_causa'),
            'TIEMPO_INTERRUPCION' => $this->input->post('tiempo_interrupcion'),
            'CONSUM_AFECTADOS'   => $this->input->post('consumidores_afectados'),
            'OBSERVACION'   => $this->input->post('observacion'),
            'ESTADO'   => 'ACTIVO'
        );
        //var_dump($data);
        $result = $this->OdecoModel->registrar_libro($data);
        echo json_encode($result);
    }
    
    public function anular_libro()
    {
        $nro_libro = $this->input->post('nro_libro');
        $data = array(
            'ESTADO'   => 'INACTIVO'
        );
        $result = $this->OdecoModel->anular_libro($nro_libro, $data);
        echo json_encode($result);
    }
    
    public function ver_editar_libro($nro_diario,$semestre)
    {
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        $get_codalimentador = $CI->OdecoModel->get_codalimentador();
        $get_proteccion = $CI->OdecoModel->get_proteccion();
        $get_origen = $CI->OdecoModel->get_origen();
        $get_causa = $CI->OdecoModel->get_causa();
        $get_tipo_origen_all = $CI->OdecoModel->get_tipo_origen_all();
        $get_tipo_causa_all = $CI->OdecoModel->get_tipo_causa_all();
        $detalles = $CI->OdecoModel->get_detalle_libro($nro_diario);
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $cortes = $this->OdecoModel->get_cortes($fecha_inicial,$fecha_final); 
        $data = array(
            'title'         => 'Ver Detalle de Centro de Transformacion',
            'get_codalimentador' => $get_codalimentador,
            'get_proteccion' => $get_proteccion,
            'get_origen' => $get_origen,
            'get_causa' => $get_causa,
            'data' => $detalles,
            'get_tipo_origen_all' => $get_tipo_origen_all,
            'get_tipo_causa_all' => $get_tipo_causa_all,
            'cortes' => $cortes
        );
        $content = $CI->parser->parse('odeco/libro_guardia/ver_detalle_libro', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function modificar_libro()
    {
        $data = array(
            //registro
            'NRO_PROGRAMADO' => $this->input->post('nro_programado'),
            'TIPO_FALLA' => $this->input->post('tipo_falla'),
            'COD_ALIMENTADOR' => $this->input->post('cod_alimentador'),
            'COD_PROTECCION' => $this->input->post('cod_proteccion'),
            'FECHA_HORA_INI' => $this->input->post('fecha_inicial'),
            'FECHA_HORA_FIN' => $this->input->post('fecha_final'),
            'COD_ORIGEN' => $this->input->post('origen_interrupcion'),
            'ORIGEN_TIPO'   => $this->input->post('cod_tipo_origen'),
            'COD_CAUSA' => $this->input->post('causa_interrupcion'),
            'CAUSA_TIPO'   => $this->input->post('cod_tipo_causa'),
            'TIEMPO_INTERRUPCION' => $this->input->post('tiempo_interrupcion'),
            'CONSUM_AFECTADOS'   => $this->input->post('consumidores_afectados'),
            'OBSERVACION'   => $this->input->post('observacion')
        );
        //var_dump($data);
        $nro_diario  = $this->input->post('nro_diario');
        $result = $this->OdecoModel->modificar_libro($data, $nro_diario);
        echo json_encode($result);
    } 
    /********************** GESTION INTERRUPCIONES *********/
    public function listar_interrupciones()
    {
        $semestre_actual1 = $this->OdecoModel->semestre_actual();
        $semestre_actual = $semestre_actual1[0]['Sigla'];
        $semestre ='';
        if(!empty($this->input->post('semestre'))){$semestre=$this->input->post('semestre');}else{$semestre = $semestre_actual;}
        $semestre = $this->OdecoModel->semestre($semestre);
        $listar_semestres = $this->OdecoModel->listar_semestres(); 
        //agrupar
        $data = array(
            'title'         => 'Interrupciones Registrados',
            'semestre' =>$semestre,
            'listar_semestres' => $listar_semestres
        );
        $content = $this->parser->parse('odeco/interrupciones/listar_interrupciones', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function listar_interrupciones_ajax()
    {
        // POST data
        $postData = $this->input->post();
        $semestre = $postData['searchSemestre'];
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $data = $this->OdecoModel->listar_interrupciones($postData,$fecha_inicial,$fecha_final); 
        echo json_encode($data);
    }
    public function agregar_interrupcion($semestre)
    {
        $CI = & get_instance();
        $get_codalimentador = $CI->OdecoModel->get_codalimentador();
        $get_proteccion = $CI->OdecoModel->get_proteccion();
        $get_origen = $CI->OdecoModel->get_origen();
        $get_causa = $CI->OdecoModel->get_causa();
        $get_localidades = $CI->OdecoModel->get_localidades();
        $get_id_interrupciones = $CI->OdecoModel->get_id_interrupciones();
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $cortes = $this->OdecoModel->get_cortes($fecha_inicial,$fecha_final); 
        $libros = $this->OdecoModel->get_libros($fecha_inicial,$fecha_final); 
        $data = array(
            'title'         => 'Formulario de Registro de Nueva Interrupcion',
            'get_codalimentador' => $get_codalimentador,
            'get_proteccion' => $get_proteccion,
            'get_origen' => $get_origen,
            'get_causa' => $get_causa,
            'get_localidades' => $get_localidades,
            'get_id_interrupciones' => $get_id_interrupciones,
            'libros'    => $libros,
            'cortes'    => $cortes
        );
        $content = $CI->parser->parse('odeco/interrupciones/formulario_interrupciones', $data, true);
        $this->template->full_admin_html_view($content);
    }    
    //registrar centro
    public function registrar_interrupcion()
    {
        $data = array(
            //registro
            //'NRO_INTERRUPCION' => $this->input->post('nro_programado'),
            'NRO_DIARIO' => $this->input->post('nro_diario'),
            'NRO_PROGRAMADO' => $this->input->post('corte_programado'),
            'TIPO_FALLA' => $this->input->post('tipo_falla'),
            'COD_ALIMENTADOR' => $this->input->post('cod_alimentador'),
            'COD_PROTECCION' => $this->input->post('cod_proteccion'),
            'FECHA_HORA_INI' => $this->input->post('fecha_inicial'),
            'FECHA_HORA_FIN' => $this->input->post('fecha_final'),
            'COD_ORIGEN' => $this->input->post('origen_interrupcion'),
            'ORIGEN_TIPO'   => $this->input->post('cod_tipo_origen'),
            'COD_CAUSA' => $this->input->post('causa_interrupcion'),
            'CAUSA_TIPO'   => $this->input->post('cod_tipo_causa'),
            'TIEMPO_INTERRUPCION' => $this->input->post('tiempo_interrupcion'),
            'CONSUM_BT_1'   => $this->input->post('consumidores_bt_1'),
            'CONSUM_BT_2'   => $this->input->post('consumidores_bt_2'),
            'CONSUM_MT_1'   => $this->input->post('consumidores_mt_1'),
            'CONSUM_MT_2'   => $this->input->post('consumidores_mt_2'),
            'KVA_BT_1'   => $this->input->post('potencia_bt_1'),
            'KVA_BT_2'   => $this->input->post('potencia_bt_2'),
            'KVA_MT_1'   => $this->input->post('potencia_mt_1'),
            'KVA_MT_2'   => $this->input->post('potencia_mt_2'),
            'MOTIVO'   => $this->input->post('motivo'),
            'OBSERVACION'   => $this->input->post('observacion'),
            'ESTADO'   => 'ACTIVO'
        );
        //var_dump($data);
        $result = $this->OdecoModel->registrar_interrupcion($data);
        echo json_encode($result);
    }
    
    public function anular_interrupcion()
    {
        $nro_interrupcion = $this->input->post('nro_interrupcion');
        $data = array(
            'ESTADO'   => 'INACTIVO'
        );
        $result = $this->OdecoModel->anular_interrupcion($nro_interrupcion,$data);
        echo json_encode($result);
    }
    
    public function ver_editar_interrupcion($nro_interrupcion, $semestre)
    {
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        $get_codalimentador = $CI->OdecoModel->get_codalimentador();
        $get_proteccion = $CI->OdecoModel->get_proteccion();
        $get_origen = $CI->OdecoModel->get_origen();
        $get_causa = $CI->OdecoModel->get_causa();
        $get_tipo_origen_all = $CI->OdecoModel->get_tipo_origen_all();
        $get_tipo_causa_all = $CI->OdecoModel->get_tipo_causa_all();
        $detalles = $CI->OdecoModel->get_detalle_interrupcion($nro_interrupcion);
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $cortes = $this->OdecoModel->get_cortes($fecha_inicial,$fecha_final); 
        $libros = $this->OdecoModel->get_libros($fecha_inicial,$fecha_final); 
        $data = array(
            'title'         => 'Ver Detalle de Interrupcion',
            'get_codalimentador' => $get_codalimentador,
            'get_proteccion' => $get_proteccion,
            'get_origen' => $get_origen,
            'get_causa' => $get_causa,
            'data' => $detalles,
            'get_tipo_origen_all' => $get_tipo_origen_all,
            'get_tipo_causa_all' => $get_tipo_causa_all,
            'libros'    => $libros,
            'cortes'    => $cortes
        );
        $content = $CI->parser->parse('odeco/interrupciones/ver_detalle_interrupcion', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function modificar_interrupcion()
    {
        $data = array(
            //registro
            'NRO_DIARIO' => $this->input->post('nro_diario'),
            'NRO_PROGRAMADO' => $this->input->post('corte_programado'),
            'TIPO_FALLA' => $this->input->post('tipo_falla'),
            'COD_ALIMENTADOR' => $this->input->post('cod_alimentador'),
            'COD_PROTECCION' => $this->input->post('cod_proteccion'),
            'FECHA_HORA_INI' => $this->input->post('fecha_inicial'),
            'FECHA_HORA_FIN' => $this->input->post('fecha_final'),
            'COD_ORIGEN' => $this->input->post('origen_interrupcion'),
            'ORIGEN_TIPO'   => $this->input->post('cod_tipo_origen'),
            'COD_CAUSA' => $this->input->post('causa_interrupcion'),
            'CAUSA_TIPO'   => $this->input->post('cod_tipo_causa'),
            'TIEMPO_INTERRUPCION' => $this->input->post('tiempo_interrupcion'),
            'CONSUM_BT_1'   => $this->input->post('consumidores_bt_1'),
            'CONSUM_BT_2'   => $this->input->post('consumidores_bt_2'),
            'CONSUM_MT_1'   => $this->input->post('consumidores_mt_1'),
            'CONSUM_MT_2'   => $this->input->post('consumidores_mt_2'),
            'KVA_BT_1'   => $this->input->post('potencia_bt_1'),
            'KVA_BT_2'   => $this->input->post('potencia_bt_2'),
            'KVA_MT_1'   => $this->input->post('potencia_mt_1'),
            'KVA_MT_2'   => $this->input->post('potencia_mt_2'),
            'MOTIVO'   => $this->input->post('motivo'),
            'OBSERVACION'   => $this->input->post('observacion')
        );
        //var_dump($data);
        $nro_interrupcion  = $this->input->post('nro_programado');
        $result = $this->OdecoModel->modificar_interrupcion($data, $nro_interrupcion);
        echo json_encode($result);
    } 
    /********************** GESTION DE RESTITUCION DE SUMINISTROS *********/
    public function listar_restituciones()
    {
        $semestre_actual1 = $this->OdecoModel->semestre_actual();
        $semestre_actual = $semestre_actual1[0]['Sigla'];
        $semestre ='';
        if(!empty($this->input->post('semestre'))){$semestre=$this->input->post('semestre');}else{$semestre = $semestre_actual;}
        $semestre = $this->OdecoModel->semestre($semestre);
        $listar_semestres = $this->OdecoModel->listar_semestres(); 
        //agrupar
        $data = array(
            'title'         => 'Restitucion de Suministros Registrados',
            'semestre' =>$semestre,
            'listar_semestres' => $listar_semestres
        );
        $content = $this->parser->parse('odeco/restitucion_suministro/listar_restituciones', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function listar_restituciones_ajax()
    {
        // POST data
        $postData = $this->input->post();
        $semestre = $postData['searchSemestre'];
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $data = $this->OdecoModel->listar_restituciones($postData,$fecha_inicial,$fecha_final); 
        echo json_encode($data);
    }
    public function agregar_restitucion($semestre)
    {
        $CI = & get_instance();
        $get_proteccion = $CI->OdecoModel->get_proteccion();
        $get_id_restituciones = $CI->OdecoModel->get_id_restituciones();
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $get_interrupciones = $this->OdecoModel->get_interrupciones($fecha_inicial,$fecha_final);
        $data = array(
            'title'         => 'Formulario de Registro de Nueva Restitucion',
            'get_proteccion' => $get_proteccion,
            'get_id_restituciones' => $get_id_restituciones,
            'get_interrupciones' => $get_interrupciones
        );
        $content = $CI->parser->parse('odeco/restitucion_suministro/formulario_restitucion', $data, true);
        $this->template->full_admin_html_view($content);
    }    
    //registrar
    public function registrar_restitucion()
    {
        $fecha_reposicion = $this->input->post('fecha_reposicion');
        $fecha_reposicion_1 = new DateTime($fecha_reposicion);
        $fecha_interrupcion = $this->OdecoModel->get_fecha_interrupcion($this->input->post('nro_interrupcion'));
        $fecha_interrupcion_1 = $fecha_interrupcion[0]['FECHA_HORA_INI'];
        $fecha_interrupcion_2 = new DateTime($fecha_interrupcion_1);
        $diff = $fecha_interrupcion_2->diff($fecha_reposicion_1);
        $dias = $diff->format('%d');
        $horas = $diff->format('%h');
        $minutos = $diff->format('%i');
        $diffhoras = floatval(($dias*24+$horas).'.'.round(($minutos*100)/60));
        //print_r($diffhoras); exit();
        if ($diffhoras != false) {
            $data = array(
                //registro
                //'NRO_INTERRUPCION' => $this->input->post('nro_programado'),
                'NRO_INTERRUPCION' => $this->input->post('nro_interrupcion'),
                'COD_PROTECCION' => $this->input->post('cod_proteccion'),
                'FECHA_HORA_REPOS' => $this->input->post('fecha_reposicion'),
                'CONSUM_REP_BT_1'   => $this->input->post('consumidores_bt_1'),
                'CONSUM_REP_BT_2'   => $this->input->post('consumidores_bt_2'),
                'CONSUM_REP_MT_1'   => $this->input->post('consumidores_mt_1'),
                'CONSUM_REP_MT_2'   => $this->input->post('consumidores_mt_2'),
                'KVA_RESPUESTA_BT_1'   => $this->input->post('potencia_bt_1'),
                'KVA_RESPUESTA_BT_2'   => $this->input->post('potencia_bt_2'),
                'KVA_RESPUESTA_MT_1'   => $this->input->post('potencia_mt_1'),
                'KVA_RESPUESTA_MT_2'   => $this->input->post('potencia_mt_2'),
                'TIEMPO'   => $diffhoras,
                'MOTIVO'   => $this->input->post('motivo'),
                'OBSERVACION'   => $this->input->post('observacion'),
                'ESTADO'   => 'ACTIVO'
            );
            $result = $this->OdecoModel->registrar_restitucion($data);
            echo json_encode($result);
        }
    }
    
    public function anular_restitucion()
    {
        $nro_restitucion = $this->input->post('nro_restitucion');
        $data = array(
            'ESTADO'   => 'INACTIVO'
        );
        $result = $this->OdecoModel->anular_restitucion($nro_restitucion, $data);
        echo json_encode($result);
    }
    
    public function ver_editar_restitucion($nro_restitucion, $semestre)
    {
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        $get_proteccion = $CI->OdecoModel->get_proteccion();
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $get_interrupciones = $this->OdecoModel->get_interrupciones($fecha_inicial,$fecha_final);
        $detalles = $CI->OdecoModel->get_detalle_restitucion($nro_restitucion);
        $data = array(
            'title'         => 'Ver Detalle de Restitucion de Suministro',
            'get_interrupciones' => $get_interrupciones,
            'get_proteccion' => $get_proteccion,
            'data' => $detalles
        );
        $content = $CI->parser->parse('odeco/restitucion_suministro/ver_detalle_restitucion', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function modificar_restitucion()
    {
        $fecha_reposicion = $this->input->post('fecha_reposicion');
        $fecha_reposicion_1 = new DateTime($fecha_reposicion);
        $fecha_interrupcion = $this->OdecoModel->get_fecha_interrupcion($this->input->post('nro_interrupcion'));
        $fecha_interrupcion_1 = $fecha_interrupcion[0]['FECHA_HORA_INI'];
        $fecha_interrupcion_2 = new DateTime($fecha_interrupcion_1);
        $diff = $fecha_interrupcion_2->diff($fecha_reposicion_1);
        $dias = $diff->format('%d');
        $horas = $diff->format('%h');
        $minutos = $diff->format('%i');
        $diffhoras = floatval(($dias*24+$horas).'.'.round(($minutos*100)/60));
        if ($diffhoras != false) {
            $data = array(
                //registro
                //'NRO_INTERRUPCION' => $this->input->post('nro_programado'),
                'NRO_INTERRUPCION' => $this->input->post('nro_interrupcion'),
                'COD_PROTECCION' => $this->input->post('cod_proteccion'),
                'FECHA_HORA_REPOS' => $this->input->post('fecha_reposicion'),
                'CONSUM_REP_BT_1'   => $this->input->post('consumidores_bt_1'),
                'CONSUM_REP_BT_2'   => $this->input->post('consumidores_bt_2'),
                'CONSUM_REP_MT_1'   => $this->input->post('consumidores_mt_1'),
                'CONSUM_REP_MT_2'   => $this->input->post('consumidores_mt_2'),
                'KVA_RESPUESTA_BT_1'   => $this->input->post('potencia_bt_1'),
                'KVA_RESPUESTA_BT_2'   => $this->input->post('potencia_bt_2'),
                'KVA_RESPUESTA_MT_1'   => $this->input->post('potencia_mt_1'),
                'KVA_RESPUESTA_MT_2'   => $this->input->post('potencia_mt_2'),
                'TIEMPO'   => $diffhoras,
                'MOTIVO'   => $this->input->post('motivo'),
                'OBSERVACION'   => $this->input->post('observacion')
            );
            //var_dump($data);
            $nro_restitucion  = $this->input->post('nro_restitucion');
            $result = $this->OdecoModel->modificar_restitucion($data, $nro_restitucion);
            echo json_encode($result);
        }
        
    } 
    /********************** GESTION DE RESTITUCION DE SUMINISTROS EN MT *********/
    public function listar_restituciones_mt()
    {
        $semestre_actual1 = $this->OdecoModel->semestre_actual();
        $semestre_actual = $semestre_actual1[0]['Sigla'];
        $semestre ='';
        if(!empty($this->input->post('semestre'))){$semestre=$this->input->post('semestre');}else{$semestre = $semestre_actual;}
        $semestre = $this->OdecoModel->semestre($semestre);
        $listar_semestres = $this->OdecoModel->listar_semestres(); 
        //agrupar
        $data = array(
            'title'         => 'Restitucion de Suministros MT Registrados',
            'semestre' =>$semestre,
            'listar_semestres' => $listar_semestres
        );
        $content = $this->parser->parse('odeco/restitucion_suministro_mt/listar_restituciones_mt', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function listar_restituciones_mt_ajax()
    {
        // POST data
        $postData = $this->input->post();
        $semestre = $postData['searchSemestre'];
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $data = $this->OdecoModel->listar_restituciones_mt($postData,$fecha_inicial,$fecha_final); 
        echo json_encode($data);
    }
    public function agregar_restitucion_mt($semestre)
    {
        $CI = & get_instance();
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $get_interrupciones = $this->OdecoModel->get_interrupciones($fecha_inicial,$fecha_final);
        $get_restituciones = $CI->OdecoModel->get_restituciones($fecha_inicial,$fecha_final);
        $get_abonado = $CI->OdecoModel->get_abonado();
        //print_r($get_id_restituciones);
        $data = array(
            'title'         => 'Formulario de Registro de Nueva Restitucion',
            'get_abonado' => $get_abonado,
            'get_restituciones' => $get_restituciones,
            'get_interrupciones' => $get_interrupciones
        );
        $content = $CI->parser->parse('odeco/restitucion_suministro_mt/formulario_restitucion', $data, true);
        $this->template->full_admin_html_view($content);
    }    
    //registrar
    public function registrar_restitucion_mt()
    {
        $fecha_reposicion = $this->input->post('fecha_reposicion');
        $fecha_reposicion_1 = new DateTime($fecha_reposicion);
        $fecha_interrupcion = $this->OdecoModel->get_fecha_interrupcion($this->input->post('nro_interrupcion'));
        $fecha_interrupcion_1 = $fecha_interrupcion[0]['FECHA_HORA_INI'];
        $fecha_interrupcion_2 = new DateTime($fecha_interrupcion_1);
        $diff = $fecha_interrupcion_2->diff($fecha_reposicion_1);
        $dias = $diff->format('%d');
        $horas = $diff->format('%h');
        $minutos = $diff->format('%i');

        $diffhoras = floatval(($dias*24+$horas).'.'.round(($minutos*100)/60));
        //print_r($diffhoras);
        if ($diffhoras != false) {
            $data = array(
                //registro
                'NRO_INTERRUPCION' => $this->input->post('nro_interrupcion'),
                'NRO_REPOSICION' => $this->input->post('nro_restitucion'),
                'NRO_CUENTA' => $this->input->post('nro_cuenta'),
                'FECHA_HORA_REPOS' => $this->input->post('fecha_reposicion'),
                'TIEMPO'   => $diffhoras,
                'OBSERVACION'   => $this->input->post('observacion'),
                'ESTADO'   => 'ACTIVO'
            );
            //var_dump($data);
            $result = $this->OdecoModel->registrar_restitucion_mt($data);
            echo json_encode($result);
        }
    }
    
    public function anular_restitucion_mt()
    {
        $nro_reposicion = $this->input->post('nro_reposicion');
        $data = array(
                'ESTADO'   => 'INACTIVO'
            );
        $result = $this->OdecoModel->anular_restitucion_mt($nro_reposicion, $data);
        echo json_encode($result);
    }
    
    public function ver_editar_restitucion_mt($nro_reposicion, $semestre)
    {
        $CI = & get_instance();
        $get_detalle_restitucion_mt = $CI->OdecoModel->get_detalle_restitucion_mt($nro_reposicion);
        $semestre = $this->OdecoModel->semestre($semestre);
        $fecha_inicial = $semestre[0]['Mes_Inicio'];$fecha_final = $semestre[0]['Mes_Final'];
        $get_interrupciones = $this->OdecoModel->get_interrupciones($fecha_inicial,$fecha_final);
        $get_restituciones = $CI->OdecoModel->get_restituciones($fecha_inicial,$fecha_final);
        $get_abonado = $CI->OdecoModel->get_abonado();
        //print_r($get_id_restituciones);
        $data = array(
            'title'         => 'Formulario de Registro de Nueva Restitucion',
            'data' => $get_detalle_restitucion_mt,
            'get_abonado' => $get_abonado,
            'get_restituciones' => $get_restituciones,
            'get_interrupciones' => $get_interrupciones
        );
        $content = $CI->parser->parse('odeco/restitucion_suministro_mt/ver_detalle_restitucion_mt', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function modificar_restitucion_mt()
    {
        $fecha_reposicion = $this->input->post('fecha_reposicion');
        $fecha_reposicion_1 = new DateTime($fecha_reposicion);
        $fecha_interrupcion = $this->OdecoModel->get_fecha_interrupcion($this->input->post('nro_interrupcion'));
        $fecha_interrupcion_1 = $fecha_interrupcion[0]['FECHA_HORA_INI'];
        $fecha_interrupcion_2 = new DateTime($fecha_interrupcion_1);
        $diff = $fecha_interrupcion_2->diff($fecha_reposicion_1);
        $dias = $diff->format('%d');
        $horas = $diff->format('%h');
        $minutos = $diff->format('%i');
        $diffhoras = floatval(($dias*24+$horas).'.'.round(($minutos*100)/60));
        //print_r($diffhoras);
        if ($diffhoras != false) {
            $data = array(
                //registro
                'NRO_INTERRUPCION' => $this->input->post('nro_interrupcion'),
                'NRO_CUENTA' => $this->input->post('nro_cuenta'),
                'FECHA_HORA_REPOS' => $this->input->post('fecha_reposicion'),
                'TIEMPO'   => $diffhoras,
                'OBSERVACION'   => $this->input->post('observacion'),
                'ESTADO'   => 'ACTIVO'
            );

            $nro_restitucion = $this->input->post('nro_restitucion');
            $result = $this->OdecoModel->modificar_restitucion_mt($nro_restitucion,$data);
            echo json_encode($result);
        }
        
    }
    /********************** CRONOGRAMA DE INSTALACION DE EQUIPOS PT *********/
    public function listar_cronogramas()
    {
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        $listar_cronogramas = $CI->OdecoModel->listar_cronogramas(); 
        //agrupar
        $data = array(
            'title'         => 'Cronograma de Instalaci&oacute;n de Equipos del PT Registrados',
            'listar_cronogramas' => $listar_cronogramas
        );
        $content = $CI->parser->parse('odeco/cronogramas_instalacion/listar_cronogramas', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function agregar_cronograma()
    {
        //setlocale(LC_TIME, 'es_ES');//fecha en espaniol
        $semestre_actual1 = $this->OdecoModel->semestre_actual();
        $semestre_actual = $semestre_actual1[0]['Sigla']; $mes_actual_inicial = date('m',strtotime($semestre_actual1[0]['Mes_Inicio']));
        $anio_actual = date('Y',strtotime($semestre_actual1[0]['Mes_Inicio']));/*
        $fecha = DateTime::createFromFormat('!m', $mes_actual_inicial);
        $mes = strftime('%B', $fecha->getTimestamp());
        print_r($mes_actual_inicial);
        $semestre_11   = ['05'=>'MAYO'];
        $valor = array_key_exists('06', $semestre_11);
        print_r($valor);*/
        $semestre_1   = ['05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre'];
        $semestre_2   = ['11'=>'Noviembre','12'=>'Diciembre','01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril'];
        $meses='';
        if(array_key_exists($mes_actual_inicial, $semestre_1))
        {
            $meses = $semestre_1;
        }else{
            $meses = $semestre_2;
        }
        $CI = & get_instance();
        $get_IdAbonado = $CI->OdecoModel->get_IdAbonado();
        $i = 0;
        if (!empty($get_IdAbonado)) {
            foreach ($get_IdAbonado as $k => $v) {
                $i++;
                $get_IdAbonado[$k]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        //print_r($get_id_restituciones);
        $prefijo_empresa = 'TU';//tupizA
        $data = array(
            'title'         => 'Formulario de Registro de Nueva Cronograma',
            'meses'      =>  $meses,
            'semestre_actual'   => $semestre_actual,
            'anio_actual'   => $anio_actual,
            'prefijo_empresa'   => $prefijo_empresa,
            'get_IdAbonado' => $get_IdAbonado
        );
        $content = $CI->parser->parse('odeco/cronogramas_instalacion/formulario_cronograma', $data, true);
        $this->template->full_admin_html_view($content);
    }   
    //registrar
    public function registrar_cronograma()
    {
            $data = array(
                //registro
                'CODIGO_AE' => $this->input->post('codigo_ae'),
                'NRO_ID' => $this->input->post('nro_id'),
                'FECHA_HORA_INST' => $this->input->post('fecha_instalacion'),
                'FECHA_HORA_RET' => $this->input->post('fecha_retiro'),
                'CAMPANIA'   => $this->input->post('campana'),
                'MES'   => $this->input->post('mes'),
                'TIPO_PUNTO'   => $this->input->post('tipo_punto'),
                'TIPO_MEDICION'   => $this->input->post('tipo_medicion'),
                'OBSERVACION'   => $this->input->post('observacion'),
                'ESTADO'   => 'ACTIVO'
            );
            $result = $this->OdecoModel->registrar_cronograma($data);
            echo json_encode($result);
    }
    public function anular_cronograma()
    {
        $cod_ae = $this->input->post('cod_ae');
        $data = array(
                'ESTADO'   => 'INACTIVO'
            );
        $result = $this->OdecoModel->anular_cronograma($cod_ae, $data);
        echo json_encode($result);
    }
    
    public function ver_editar_cronograma($cod_ae)
    {
        $semestre_actual1 = $this->OdecoModel->semestre_actual();
        $semestre_actual = $semestre_actual1[0]['Sigla']; $mes_actual_inicial = date('m',strtotime($semestre_actual1[0]['Mes_Inicio']));
        $anio_actual = date('Y',strtotime($semestre_actual1[0]['Mes_Inicio']));
        $semestre_1  = ['05'=>'Mayo','06'=>'Junio','07'=>'Julio','08'=>'Agosto','09'=>'Septiembre','10'=>'Octubre'];
        $semestre_2  = ['11'=>'Noviembre','12'=>'Diciembre','01'=>'Enero','02'=>'Febrero','03'=>'Marzo','04'=>'Abril'];
        $meses='';
        if(array_key_exists($mes_actual_inicial, $semestre_1))
        {
            $meses = $semestre_1;
        }else{
            $meses = $semestre_2;
        }
        $get_IdAbonado = $this->OdecoModel->get_IdAbonado();
        $get_detalle_cronograma = $this->OdecoModel->get_detalle_cronograma($cod_ae);
        //print_r($get_id_restituciones);
        $prefijo_empresa = 'TU';//tupizA
        $data = array(
            'title'         => 'Formulario de Modificacion de Cronograma',
            'data' => $get_detalle_cronograma,
            'meses'      =>  $meses,
            'semestre_actual'   => $semestre_actual,
            'anio_actual'   => $anio_actual,
            'prefijo_empresa'   => $prefijo_empresa,
            'get_IdAbonado' => $get_IdAbonado
        );
        $content = $this->parser->parse('odeco/cronogramas_instalacion/ver_editar_cronograma', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function modificar_cronograma()
    {
            $data = array(
                'NRO_ID' => $this->input->post('nro_id'),
                'FECHA_HORA_INST' => $this->input->post('fecha_instalacion'),
                'FECHA_HORA_RET' => $this->input->post('fecha_retiro'),
                'OBSERVACION'   => $this->input->post('observacion')
            );
            $codigo_ae = $this->input->post('codigo_ae');
            $result = $this->OdecoModel->modificar_cronograma($codigo_ae,$data);
            echo json_encode($result);
    } 
    /********************** CRONOGRAMA DE INSTALACION DE EQUIPOS PT *********/
    public function indicadores_individuales()
    {
        $semestre_actual1 = $this->OdecoModel->semestre_actual();
        $semestre_actual = $semestre_actual1[0]['Sigla'];
        $semestre ='';
        if(!empty($this->input->post('semestre'))){$semestre=$this->input->post('semestre');}else{$semestre = $semestre_actual;}
        $semestre = $this->OdecoModel->semestre($semestre);
        $mes_inicial = $semestre[0]['Mes_Inicio'];$mes_final = $semestre[0]['Mes_Final'];
        $indicadores_individuales = $this->OdecoModel->indicadores_individuales($mes_inicial,$mes_final); 
        $listar_semestres = $this->OdecoModel->listar_semestres(); 
        //agrupar
        $data = array(
            'indicadores_individuales' => $indicadores_individuales,
            'listar_semestres'  => $listar_semestres,
            'semestre'  => $semestre
        );
        $content = $this->parser->parse('odeco/indicadores_individuales/indicadores_individuales', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function individuales_calidad_pdf($semestre,$nivel_calidad)
    {
        //$fecha_inicial = ''
        //$fecha = $this->OdecoModel->detalles_equipos($nro_reclamo);
        //print_r($detalles_reclamo);exit;
        $data = array(
            'titulo'      => 'CALIDAD DE DISTRIBUCI&Oacute;N - SERVICIO T&Eacute;CNICO',
            'descripcion' => 'INDICE INDIVIDUAL DE CONTINUIDAD DE SUMINISTRO CALIDAD '.$nivel_calidad,
            'nombre_empresa' => 'Cooperativa de Servicios Públicos de Electricidad Tupiza R.L.',
            'sigla' => 'COOPELECT',
            'semestre'  => $semestre
        );

        $this->load->library('pdf'); 
        $content = $this->parser->parse('odeco/indicadores_individuales/indicadores_individuales_pdf', $data, true);
        $this->dompdf->load_html($content);
        $this->dompdf->setPaper('letter', 'landscape'); # tamño y orientación
        $this->dompdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("form_st2.pdf", array("Attachment"=>0));
    }
    public function indicadores_globales()
    {
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        //$indicadores_individuales = $CI->OdecoModel->indicadores_individuales(); 
        //agrupar
        $data = array(
            'title'         => 'Cronograma de Instalaci&oacute;n de Equipos del PT Registrados',
            'nombre_empresa' => 'COOPELECT R.L.',
            //'indicadores_individuales' => $indicadores_individuales
        );
        $content = $CI->parser->parse('odeco/indicadores_globales/indicadores_globales', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function reporte_indglobal_pdf()
    {
        //$fecha_inicial = ''
        //$fecha = $this->OdecoModel->detalles_equipos($nro_reclamo);
        //print_r($detalles_reclamo);exit;
        $nombre_empresa = $this->input->post('nombre_empresa');
        $frecuencia = '';
        $tiempo = '';
        $nivel_calidad = $this->input->post('nivel_calidad');
        if($nivel_calidad == 1){
            $frecuencia = 7;
            $tiempo = 6;
        }else { 
            $frecuencia = 14;
            $tiempo = 12;
        }
        $data = array(
            'titulo'         => 'CALIDAD DE DISTRIBUCI&Oacute;N - SERVICIO T&Eacute;CNICO',
            'descripcion' => 'ÍNDICES GLOBALES DE CONTINUIDAD DE SUMINISTRO (NIVEL DE CALIDAD: '.$nivel_calidad.')',
            'nombre_empresa' => $nombre_empresa,
            'frecuencia' => $frecuencia,
            'tiempo' => $tiempo
        );

        $this->load->library('pdf'); 
        $content = $this->parser->parse('odeco/indicadores_globales/indicadores_globales_pdf', $data, true);
        $this->dompdf->load_html($content);
        $this->dompdf->setPaper('letter', 'landscape'); # tamño y orientación
        $this->dompdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("form_st1.pdf", array("Attachment"=>0));
    }
    public function indicadores()
    {
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        //$indicadores_individuales = $CI->OdecoModel->indicadores_individuales(); 
        //agrupar
        $data = array(
            'title'         => 'Cronograma de Instalaci&oacute;n de Equipos del PT Registrados',
            'nombre_empresa' => 'COOPELECT R.L.',
            //'indicadores_individuales' => $indicadores_individuales
        );
        $content = $CI->parser->parse('odeco/indicadores_comerciales/indicadores_comerciales', $data, true);
        $this->template->full_admin_html_view($content);
    }
    //INDICE DE SERVICIO COMERCIAL
    public  function indice_reclamos($semestre,$nivel_calidad,$precio_basico)
    {
        //$fecha_inicial = ''
        //$fecha = $this->OdecoModel->detalles_equipos($nro_reclamo);
        //print_r($detalles_reclamo);exit;
        $data = array(
            'titulo' => 'CALIDAD DE SERVICIO COMERCIAL',
            'descripcion'   => 'RECLAMOS DE LOS CONSUMIDORES - NIVEL DE CALIDAD: '.$nivel_calidad,
            'nombre_empresa' => 'COOPELECT R.L.',
            'periodo' => $semestre,
            //'detalles_equipos' => $detalles_equipos
        );

        $this->load->library('pdf'); 
        $content = $this->parser->parse('odeco/indicadores_comerciales/indice_reclamos_pdf', $data, true);
        $this->dompdf->load_html($content);
        $this->dompdf->setPaper('letter', 'landscape'); # tamño y orientación
        $this->dompdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("form_st2.pdf", array("Attachment"=>0));
    }
    public  function indice_facturacion($semestre,$nivel_calidad)
    {
        //$fecha_inicial = ''
        //$fecha = $this->OdecoModel->detalles_equipos($nro_reclamo);
        //print_r($detalles_reclamo);exit;
        $data = array(
            'titulo' => 'CALIDAD DE SERVICIO COMERCIAL',
            'descripcion'   => 'FACTURACION - NIVEL DE CALIDAD: '.$nivel_calidad,
            'nombre_empresa' => 'COOPELECT R.L.',
            'periodo' => $semestre,
            //'detalles_equipos' => $detalles_equipos
        );

        $this->load->library('pdf'); 
        $content = $this->parser->parse('odeco/indicadores_comerciales/indice_facturacion_pdf', $data, true);
        $this->dompdf->load_html($content);
        $this->dompdf->setPaper('letter', 'landscape'); # tamño y orientación
        $this->dompdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("form_st2.pdf", array("Attachment"=>0));
    }
    public  function indice_atencion_consumidor($semestre,$nivel_calidad,$tarifa_promedio)
    {
        //$fecha_inicial = ''
        //$fecha = $this->OdecoModel->detalles_equipos($nro_reclamo);
        //print_r($detalles_reclamo);exit;
        $this->load->model('cofiModel');
        $nombre_empresa   = $this->cofiModel->getEmpresaGestionArray($this->session->userdata('empresa_gestion_id'));
        //print_r($this->session->userdata('empresa_gestion_id'));exit();
        //print_r($nombre_empresa);exit;
        $data = array(
            'titulo' => 'CALIDAD DE SERVICIO COMERCIAL',
            'descripcion'   => 'ATENCIÓN AL CONSUMIDOR - NIVEL DE CALIDAD: '.$nivel_calidad,
            //'nombre_empresa' => 'COOPELECT R.L.',
            'periodo' => $semestre,
            'nombre_empresa'   => $this->cofiModel->getEmpresaGestionArray($this->session->userdata('empresa_gestion_id')),
            //'detalles_equipos' => $detalles_equipos
        );

        $this->load->library('pdf'); 
        $content = $this->parser->parse('odeco/indicadores_comerciales/indice_atencion_consumidores_pdf', $data, true);
        $this->dompdf->load_html($content);
        $this->dompdf->setPaper('letter', 'landscape'); # tamño y orientación
        $this->dompdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("form_st2.pdf", array("Attachment"=>0));
    }
    public function retraso_rep_suministro()
    {
        $CI = & get_instance();
        $this->load->model('cofiModel');
        $listar_semestres = $CI->OdecoModel->listar_semestres(); 
        $semestre_actual = $CI->OdecoModel->semestre_actual();
        //agrupar
        $data = array(
            'listar_semestres'    =>  $listar_semestres,
            'semestre_actual'   => $semestre_actual
        );
        $content = $CI->parser->parse('odeco/indicador_retraso_rep_suministro/retraso_rep_suministro', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function retraso_rep_suministro_pdf($semestre, $nivel_calidad)
    {
        $this->load->model('cofiModel');
        $nombre_empresa   = $this->cofiModel->getEmpresaGestionArray($this->session->userdata('empresa_gestion_id'));
         //print_r($nombre_empresa);exit;
        $data = array(
            'titulo' => 'RETRASO EN LA REPOSICION DE SUMINISTRO',
            'periodo' => $semestre,
            'nivel_calidad' => $nivel_calidad,
            'nombre_empresa'   => $this->cofiModel->getEmpresaGestionArray($this->session->userdata('empresa_gestion_id')),
            //'detalles_equipos' => $detalles_equipos
        );

        $this->load->library('pdf'); 
        $content = $this->parser->parse('odeco/indicador_retraso_rep_suministro/retraso_rep_suministro_pdf', $data, true);
        $this->dompdf->load_html($content);
        $this->dompdf->setPaper('letter', 'portrait'); # tamño y orientación
        $this->dompdf->render();
        // Output the generated PDF (1 = download and 0 = preview)
        $this->dompdf->stream("form_retrasos.pdf", array("Attachment"=>0));
    }
    /******************************************************************************************/
    //odeco Update Form
    public function odeco_update_form($odeco_id) {
        $content = $this->lodeco->odeco_edit_data($odeco_id);
        $this->template->full_admin_html_view($content);
    }

    // odeco Update
    public function odeco_update() {
        $this->load->model('OdecoModel');
        $odeco_id = $this->input->post('odeco_id');
        $data = array(
            'odeco_name' => $this->input->post('odeco_name'),
            'status'        => $this->input->post('status'),
        );

        $this->OdecoModel->update_odeco($data, $odeco_id);
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Codeco'));
    }

    // odeco delete
    public function odeco_delete($odeco_id) {
        $this->load->model('OdecoModel');
        $this->OdecoModel->delete_odeco($odeco_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
         redirect(base_url('Codeco'));
    }
    //csv upload
        function uploadCsv_odeco()
    {
          $filename = $_FILES['upload_csv_file']['name'];  
        $ext = end(explode('.', $filename));
        $ext = substr(strrchr($filename, '.'), 1);
        if($ext == 'csv'){
        $count=0;
        $fp = fopen($_FILES['upload_csv_file']['tmp_name'],'r') or die("can't open file");

        if (($handle = fopen($_FILES['upload_csv_file']['tmp_name'], 'r')) !== FALSE)
        {
  
         while($csv_line = fgetcsv($fp,1024)){
                //keep this if condition if you want to remove the first row
                for($i = 0, $j = count($csv_line); $i < $j; $i++)
                {                  
                   $insert_csv = array();
                   $insert_csv['odeco_name'] = (!empty($csv_line[0])?$csv_line[0]:null);
                }
             
                $odecodata = array(
                    'odeco_id'      => $this->auth->generator(15),
                    'odeco_name'    => $insert_csv['odeco_name'],
                    'status'           => 1
                );


                if ($count > 0) {
                    $this->db->insert('product_odeco',$odecodata);
                    }  
                $count++; 
            }
            
        }              
        $this->session->set_userdata(array('message'=>display('successfully_added')));
        redirect(base_url('Codeco'));
         }else{
        $this->session->set_userdata(array('error_message'=>'Please Import Only Csv File'));
        redirect(base_url('Codeco'));
    }
    
    }
    // odeco pdf download
        public function odeco_downloadpdf(){
        $CI = & get_instance();
        $CI->load->model('OdecoModel');
        $CI->load->model('Web_settings');
        $CI->load->model('Invoices');
        $CI->load->library('pdfgenerator'); 
        $odeco_list = $CI->OdecoModel->listar_reclamos();
        if (!empty($odeco_list)) {
            $i = 0;
            if (!empty($odeco_list)) {
                foreach ($odeco_list as $k => $v) {
                    $i++;
                    $odeco_list[$k]['sl'] = $i + $CI->uri->segment(3);
                }
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Invoices->retrieve_company();
        $data = array(
            'title'         => display('manage_odeco'),
            'odeco_list' => $odeco_list,
            'currency'      => $currency_details[0]['currency'],
            'logo'          => $currency_details[0]['logo'],
            'position'      => $currency_details[0]['currency_position'],
             'company_info'  => $company_info
        );
            $this->load->helper('download');
            $content = $this->parser->parse('odeco/reclamos_cliente/reclamo_pdf', $data, true);
            $time = date('Ymdhi');
            $dompdf = new DOMPDF();
            $dompdf->load_html($content);
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents('assets/data/pdf/'.'odeco'.$time.'.pdf', $output);
            $file_path = 'assets/data/pdf/'.'odeco'.$time.'.pdf';
           $file_name = 'odeco'.$time.'.pdf';
            force_download(FCPATH.'assets/data/pdf/'.$file_name, null);
    }
    /**
     * Metodo getDiasHabiles
     *
     * Permite devolver un arreglo con los dias habiles
     * entre el rango de fechas dado excluyendo los
     * dias feriados dados (Si existen)
     *
     * @param string $fechainicio Fecha de inicio en formato Y-m-d
     * @param string $fechafin Fecha de fin en formato Y-m-d
     * @param array $diasferiados Arreglo de dias feriados en formato Y-m-d
     * @return array $diashabiles Arreglo definitivo de dias habiles
     */
    public function getDiasHabiles($fechainicio, $fechafin) {
            $feriadosM=$this->sigeintModel->get_feriados()->result();
            $l=0;
            foreach ($feriadosM as $f) {
                $diasferiados[$l]=$f->fecha;                
                $l=$l+1;
            }  

            // Convirtiendo en timestamp las fechas
            $fechainicio = strtotime($fechainicio);
            $fechafin = strtotime($fechafin);
           
            // Incremento en 1 dia
            $diainc = 24*60*60;
           
            // Arreglo de dias habiles, inicianlizacion
            $diashabiles = array();
           
            // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
            for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                    // Si el dia indicado, no es sabado o domingo es habil
                    if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                            // Si no es un dia feriado entonces es habil
                            if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                                    array_push($diashabiles, date('Y-m-d', $midia));
                            }
                    }
            }
           
            return $diashabiles;
    }
    /***************** para calculo de feriados ***************************/
    public function listar_feriados()
    { 
        $this->load->model('cofiModel');
        $gestion = $this->cofiModel->getEmpresaGestionArray($this->session->userdata('empresa_gestion_id'));
        $empresa_id = $gestion['empresa_id'];
        $gestiones = $this->OdecoModel->listarGestiones($empresa_id);
        $data = array(
            'gestion' =>    $gestion['gestion'],
            'gestiones'   => $gestiones
        );
        $content = $this->parser->parse('odeco/feriados/listar_feriados', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function listar_feriados_ajax()
    {
        // POST data
        $postData = $this->input->post();

        // Get data
        $data = $this->OdecoModel->listar_feriados($postData);

        echo json_encode($data);
    }
    public function agregar_feriado()
    {
        $data = array(
            'title' => 'Dias Feriados'
        );
        $content = $this->parser->parse('odeco/feriados/formulario_feriado', $data, true);
        $this->template->full_admin_html_view($content);
    }   
    //registrar
    public function registrar_feriado()
    {
            $data = array(
                //registro
                'DESCRIPCION' => $this->input->post('descripcion'),
                'FECHA' => $this->input->post('fecha'),
                'ESTADO'   => 'ACTIVO'
            );
            $result = $this->OdecoModel->registrar_feriado($data);
            echo json_encode($result);
    }
    public function anular_feriado()
    {
        $id_feriado = $this->input->post('id_feriado');
        $data = array(
                'ESTADO'   => 'INACTIVO'
            );
        $result = $this->OdecoModel->anular_feriado($id_feriado, $data);
        echo json_encode($result);
    }
    
    public function ver_editar_feriado($id_feriado)
    {
        $get_detalle_feriado = $this->OdecoModel->get_detalle_feriado($id_feriado);
        $data = array(
            'title'         => 'Formulario de Modificacion de Dia Feriado',
            'data' => $get_detalle_feriado
        );
        $content = $this->parser->parse('odeco/feriados/ver_editar_feriado', $data, true);
        $this->template->full_admin_html_view($content);
    }
    public function modificar_feriado()
    {
            $data = array(
                'DESCRIPCION' => $this->input->post('descripcion'),
                'FECHA' => $this->input->post('fecha')
            );
            $id_feriado = $this->input->post('id_feriado');
            $result = $this->OdecoModel->modificar_feriado($id_feriado,$data);
            echo json_encode($result);
    } 
    //calcular tiempo segun dias habiles sin feriados ni sabados ni domingos
    //public function calcular_dias()
    public function calcular_horas_weekend_holidays($fecha_inicial, $fecha_final)
    {
        //$fecha_inicial = '2020-08-07 13:21:00';
        //$fecha_final = '2020-08-14 14:00:00';
        $feriados = $this->OdecoModel->listar_feriados();
        $array_dias = array();
        foreach ($feriados as $f) {
            array_push($array_dias, $f['FECHA']);
        }  

        $fecha_inicial1 = new DateTime($fecha_inicial);
        $fecha_final1 = new DateTime($fecha_final);
        $fecha_final1->modify('+1 day');
        $intervalo = $fecha_final1->diff($fecha_inicial1);
        //total dias
        $days = $intervalo->days;

        $periodos = new DatePeriod($fecha_inicial1, new DateInterval('P1D'), $fecha_final1);
        foreach ($periodos as $key => $periodo) {
            $curr = $periodo->format('D');
            //sacar si es sabado o domingo
            if ($curr == 'Sat' || $curr == 'Sun') {
                $days--;
            }
            //opcional 
            elseif (in_array($periodo->format('Y-m-d'), $array_dias)) {
                $days--;
            }
        }
        //echo $days.'-';
        $dias = $intervalo->format('%d');
        $horas = $intervalo->format('%h');
        $minutos = $intervalo->format('%i');
        $diffhoras = $horas +($days*24);
        $diffminutos = $minutos*(100/60); //al 100% de una hora segun la Autoridad de Electricidad
        //$diffminutos = $horas*60 + $minutos+($days*24*60);
        //echo $diffhoras.'-';
        //echo $diffminutos.'-';
        $horas = floatval($diffhoras.'.'.$diffminutos);
        //echo $horas;
        return $horas;
    }
}   
