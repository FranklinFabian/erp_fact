<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mactivos_Responsable extends CI_Model {

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
            actr.nombre like '%".$searchValue."%' 
            or ace.nombre like'%".$searchValue."%' 
            ) ";
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('activos_catalogo_responsable acr');
        $this->db->join('activos_catalogo_tipo_responsable actr','actr.id = acr.id_tipo_responsable','left');
        $this->db->join('activos_catalogo_empresa ace','ace.id = acr.id_empresa','left');
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('activos_catalogo_responsable acr');
        $this->db->join('activos_catalogo_tipo_responsable actr','actr.id = acr.id_tipo_responsable','left');
        $this->db->join('activos_catalogo_empresa ace','ace.id = acr.id_empresa','left');
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('acr.id id,
                actr.nombre tipo_responsable,
                ace.nombre empresa,
                acr.nombre nombre,
                acr.ci ci,
                acr.cargo cargo,
                acr.descripcion descripcion,
                acr.estado estado                
                ');
        $this->db->from('activos_catalogo_responsable acr');
        $this->db->join('activos_catalogo_tipo_responsable actr','actr.id = acr.id_tipo_responsable','left');
        $this->db->join('activos_catalogo_empresa ace','ace.id = acr.id_empresa','left');

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
                'tipo_responsable'   =>$record->tipo_responsable,
                'empresa'   =>$record->empresa,
                'nombre'   =>$record->nombre,
                'ci'   =>$record->ci,
                'cargo'   =>$record->cargo,
                'descripcion'   =>$record->descripcion,
                'estado'   =>$record->estado,
                'button'   =>$button
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
        acr.*,
        actr.id id_tipo_responsable,
        ace.id id_empresa        
        ');
        $this->db->from('activos_catalogo_responsable acr');
        $this->db->join('activos_catalogo_tipo_responsable actr','actr.id = acr.id_tipo_responsable','left');
        $this->db->join('activos_catalogo_empresa ace','ace.id = acr.id_empresa','left');
        $this->db->where('acr.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function dropdown() {
        $this->db->select('*');
        $this->db->from('activos_catalogo_responsable');
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
        $this->db->from('activos_catalogo_responsable');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

}
