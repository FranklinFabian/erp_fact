<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cmactivos_administracion extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Mactivos_Administracion');
        $this->load->library('auth');
    }

    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lmactivos_administracion');
        $content = $CI->lmactivos_administracion->edit_data();
        $this->template->full_admin_html_view($content);
    }

    public function modal_edit(){
        $this->load->model('Mactivos_Administracion');
        $this->load->model('Mactivos_Servicio');
        $this->load->model('Mactivos_Grupo');
        $this->load->model('Mactivos_Cuenta');
        $this->load->model('Mactivos_Ubicacion');
        $this->load->model('Mactivos_Lugar');
        $this->load->model('Mactivos_Responsable');
        $this->load->model('Mactivos_Unidad');

        $id = $_GET['id'];
        $type = $_GET['type'];

        if($type == 'update'){
            $data['item'] = $this->Mactivos_Administracion->retrieve_datamodal($id)[0];
            $data['grupos'] = $this->Mactivos_Grupo->list_filtrada($data['item']['id_servicio']);
            $data['cuentas'] = $this->Mactivos_Cuenta->list_filtrada($data['item']['id_grupo']);
            $data['ubicaciones'] = $this->Mactivos_Ubicacion->list_filtrada($data['item']['id_lugar']);
            $data['almacen'] = $this->Mactivos_Administracion->list_almacen_fecha($data['item']['fecha_registro_almacen']);

            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
        }

        $data['servicios'] = $this->Mactivos_Servicio->list_dropdown();
        $data['lugares'] = $this->Mactivos_Lugar->list_dropdown();
        $data['responsables'] = $this->Mactivos_Responsable->list_dropdown();
        $data['unidades'] = $this->Mactivos_Unidad->list_dropdown();
        $this->load->view('modulo_activos/administracion/modal', $data);
    }

    public function update() {
        $this->load->model('Mactivos_Empresa');
        $this->load->model('Mactivos_Cuenta');
        $type = $this->input->post('type');
        $data = $this->input->post('item');

        $date = new DateTime($data['fecha_alta']);
        $data['fecha_alta'] = $date->format('Y-m-d');

        if ($type == 'new'){
            //Consultamos las abreviaturas
            //Empresa
            $empresa = $this->Mactivos_Empresa->get_abreviatura($data['id_responsable']);
            //Cuenta
            $cuenta = $this->Mactivos_Cuenta->get_abreviatura($data['id_cuenta']);
            //Correlativo
            $correlativo = $this->Mactivos_Cuenta->get_correlativo($data['id_cuenta']);

            $data['codigo_activo'] = $empresa . "-" . $cuenta . "-" . str_pad($correlativo, 4, '0', STR_PAD_LEFT);
        }

        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('activos_registro', $data);
        }else{
            $this->db->insert('activos_registro', $data);
            //Update correlative
            $res['correlativo'] = $correlativo + 1;

            $actualizar_correlativo = array(
                'correlativo' => $res['correlativo']
            );

            $this->db->update('activos_catalogo_cuenta', $actualizar_correlativo, 'id =' . $data['id_cuenta']);
        }
        echo 1;
    }

    public function delete() {
        $id = $this->input->post('id');
        //Verificar Relaciones registro
        $this->db->select('id');
        $this->db->from('activos_depreciacion');
        $this->db->where('id_activo', $id);
        $this->db->get();
        $affected_row = $this->db->affected_rows();
        if ($affected_row == 0){
            // Borrar Registro
            $this->db->where('id', $id);
            $this->db->delete('activos_registro');
            $res = 1;
        }else{
            $res = 0;
        }
        echo $res;
    }

    //DataTables
    public function dataList(){
        // GET data
        $this->load->model('Mactivos_Administracion');
        $postData = $this->input->post();
        $data = $this->Mactivos_Administracion->getList($postData);
        echo json_encode($data);
    }



    public function lista_articulo_almacen(){
        $fecha = $this->input->get('fecha');
        $date = new DateTime($fecha);
        $fecha = $date->format('Y-m-d');

        //echo $fecha;exit;
        $this->db->select('am.id id, ar.nombre nombre');
        $this->db->from('almacen_movimiento am');
        $this->db->join('almacen_cabecera ac','ac.id = am.id_cabecera','left');
        $this->db->join('almacen_articulo ar','ar.id = am.id_articulo','left');
        $this->db->where('fecha', $fecha);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            echo json_encode($query->result_array());
        }
        return FALSE;
    }




}
