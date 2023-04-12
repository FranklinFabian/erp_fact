<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mactivos_Depreciacion extends CI_Model {

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
        $searchQuery = "1 = 1";

        if(trim($postData['activo']) != ''){
            $searchQuery .= " and ad.id_activo = '" . $postData['activo'] ."'" ;
        }

        if($postData['fecha_inicio'] != ''){
            $date = new DateTime($postData['fecha_inicio']);
            $fecha_inicio = $date->format('Y-m-d');
            $searchQuery .= " and ad.fecha >= '" . $fecha_inicio ."'" ;
        }

        if($postData['fecha_fin'] != ''){
            $date = new DateTime($postData['fecha_fin']);
            $fecha_fin = $date->format('Y-m-d');
            $searchQuery .= " and ad.fecha <= '" . $fecha_fin ."'" ;
        }

        if($searchValue != ''){
            $searchQuery .= " (
            ar.codigo_activo like '%".$searchValue."%'
            ) ";
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('activos_depreciacion ad');
        $this->db->join('activos_registro ar','ar.id = ad.id_activo','left');
        $this->db->join('activos_catalogo_ufv acu','acu.id = ad.id_ufv','left');

        if($searchValue != '' || $searchQuery !='')
            $this->db->where($searchQuery);
            $records = $this->db->get()->result();
            $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('activos_depreciacion ad');
        $this->db->join('activos_registro ar','ar.id = ad.id_activo','left');
        $this->db->join('activos_catalogo_ufv acu','acu.id = ad.id_ufv','left');

        if($searchValue != '' || $searchQuery !='')
            $this->db->where($searchQuery);
            $records = $this->db->get()->result();
            $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('ad.id id,
                ar.codigo_activo id_activo,
                ad.fecha fecha,
                ad.valor_inicial valor_inicial,
                acu.valor id_ufv,
                ad.factor factor,
                ad.incremento_actualizacion incremento_actualizacion,
                ad.valor_actualizado valor_actualizado,
                ad.depreciacion_acumulada depreciacion_acumulada,
                ad.aitb_depreciacion_acumulada aitb_depreciacion_acumulada,
                ad.depreciacion_ejercicio depreciacion_ejercicio,
                ad.depreciacion_acumulada_actualizada depreciacion_acumulada_actualizada,
                ad.valor_neto valor_neto,
                ad.meses_vida_util meses_vida_util
                ');
        $this->db->from('activos_depreciacion ad');
        $this->db->join('activos_registro ar','ar.id = ad.id_activo','left');
        $this->db->join('activos_catalogo_ufv acu','acu.id = ad.id_ufv','left');

        if($searchValue != '' || $searchQuery !='')
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
                'id_activo'   =>$record->id_activo,
                'fecha'   =>$record->fecha,
                'valor_inicial'   =>$record->valor_inicial,
                'id_ufv'   =>$record->id_ufv,
                'factor'   =>$record->factor,
                'incremento_actualizacion'   =>$record->incremento_actualizacion,
                'valor_actualizado'   =>$record->valor_actualizado,
                'depreciacion_acumulada'   =>$record->depreciacion_acumulada,
                'aitb_depreciacion_acumulada'   =>$record->aitb_depreciacion_acumulada,
                'depreciacion_ejercicio'   =>$record->depreciacion_ejercicio,
                'depreciacion_acumulada_actualizada'   =>$record->depreciacion_acumulada_actualizada,
                'valor_neto'   =>$record->valor_neto,
                'meses_vida_util'   =>$record->meses_vida_util
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
