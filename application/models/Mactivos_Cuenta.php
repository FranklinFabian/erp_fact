<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mactivos_Cuenta extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //DataTables
    public function getList($postData=null){

        $postData = $this->input->post();

        $response = array();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value

        ## Search
        $searchQuery = "";
        if($searchValue != ''){
            $searchQuery = " (
            acs.nombre like '%".$searchValue."%' 
            or acg.nombre like'%".$searchValue."%' 
            ) ";
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('activos_catalogo_cuenta acc');
        $this->db->join('activos_catalogo_grupo acg','acg.id = acc.id_grupo','left');
        $this->db->join('activos_catalogo_servicio acs','acs.id = acg.id_servicio','left');
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('activos_catalogo_cuenta acc');
        $this->db->join('activos_catalogo_grupo acg','acg.id = acc.id_grupo','left');
        $this->db->join('activos_catalogo_servicio acs','acs.id = acg.id_servicio','left');
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('acc.id id,
                acg.nombre grupo,
                acs.nombre servicio,
                acc.codigo codigo,
                acc.nombre nombre,
                acc.abreviatura abreviatura,
                acc.correlativo correlativo,
                acc.coeficiente_depreciacion coeficiente_depreciacion,
                acc.vida_util vida_util,
                acc.descripcion descripcion,
                acc.estado estado
                ');
        $this->db->from('activos_catalogo_cuenta acc');
        $this->db->join('activos_catalogo_grupo acg','acg.id = acc.id_grupo','left');
        $this->db->join('activos_catalogo_servicio acs','acs.id = acg.id_servicio','left');

        if($searchValue != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();

        foreach($records as $record ){
            $button = '<div align="center">';

            if($this->permission1->method('administrar_activos_cuenta','delete')->access()) {
                $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
            }
            $button .= '&nbsp;&nbsp;<a href=" javascript:loadModal( ' . $record->id . ', \'update\' ); " class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title=" Editar " ><i class="fa fa-pencil"></i></a>';

            $button .= '</div>';

            $data[] = array(
                'id'   =>$record->id,
                'grupo'   =>$record->grupo,
                'servicio'   =>$record->servicio,
                'codigo'   =>$record->codigo,
                'nombre'   =>$record->nombre,
                'abreviatura'   =>$record->abreviatura,
                'correlativo'   =>$record->correlativo,
                'coeficiente_depreciacion'   =>$record->coeficiente_depreciacion,
                'vida_util'   =>$record->vida_util,
                'descripcion'   =>$record->descripcion,
                'estado'   =>$record->estado,
                'button'   =>$button,
            );
        }

        /*echo "<pre>";
        print_r($data);
        exit;*/

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
        );

        return $response;
    }


    public function retrieve_datamodal($id) {
        $this->db->select('
        acc.*,
        acs.id id_servicio
        ');
        $this->db->from('activos_catalogo_cuenta acc');
        $this->db->join('activos_catalogo_grupo acg','acg.id = acc.id_grupo','left');
        $this->db->join('activos_catalogo_servicio acs','acs.id = acg.id_servicio','left');
        $this->db->where('acc.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function dropdown() {
        $this->db->select('*');
        $this->db->from('activos_catalogo_cuenta');
        $query=$this->db->get();
        $data=$query->result();
        $list[''] = 'Seleccionar una opcion';
        if(!empty($data)){
            foreach ($data as  $value) {
                $list[$value->id] = $value->nombre;
            }
        }
        return $list;
    }

    public function list_dropdown() {
        $this->db->select('*');
        $this->db->from('activos_catalogo_cuenta');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function list_filtrada($var) {
        $this->db->select('*');
        $this->db->from('activos_catalogo_cuenta');
        $this->db->where('id_grupo', $var);
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function get_abreviatura($id) {
        $this->db->select('abreviatura');
        $this->db->from('activos_catalogo_cuenta');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->abreviatura;
        }
        return FALSE;
    }

    public function get_correlativo($id) {
        $this->db->select('correlativo');
        $this->db->from('activos_catalogo_cuenta');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->correlativo;
        }
        return FALSE;
    }

    public function list_cuentas() {
        $this->db->select('*');
        $this->db->from('activos_catalogo_cuenta');
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }


}
