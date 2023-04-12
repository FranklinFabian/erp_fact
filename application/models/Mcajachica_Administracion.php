<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mcajachica_Administracion extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //DataTables
    public function getList($postData=null){
        //$id_cabecera = $_POST["id_cabecera"];

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

        if($postData['fecha_inicio'] != ''){
            $date = new DateTime($postData['fecha_inicio']);
            $fecha_inicio = $date->format('Y-m-d');
            $searchQuery .= " and ccr.fecha >= '" . $fecha_inicio ."'" ;
        }

        if($postData['fecha_fin'] != ''){
            $date = new DateTime($postData['fecha_fin']);
            $fecha_fin = $date->format('Y-m-d');
            $searchQuery .= " and ccr.fecha <= '" . $fecha_fin ."'" ;
        }

        if(trim($postData['cuenta']) != ''){
            $searchQuery .= " and ccr.id_cuenta = '" . $postData['cuenta'] ."'" ;
        }

        if(trim($postData['solicitante']) != ''){
            $searchQuery .= " and ccr.id_solicitante = '" . $postData['solicitante'] ."'" ;
        }

        if($searchValue != ''){
            $searchQuery = " ";
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('caja_chica_registro ccr');
        $this->db->join('caja_chica_catalogo_cuenta cccc','cccc.id = ccr.id_cuenta','left');
        $this->db->join('caja_chica_catalogo_solicitante cccs','cccs.id = ccr.id_solicitante','left');
        if($searchValue != '' || $searchQuery !='')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('caja_chica_registro ccr');
        $this->db->join('caja_chica_catalogo_cuenta cccc','cccc.id = ccr.id_cuenta','left');
        $this->db->join('caja_chica_catalogo_solicitante cccs','cccs.id = ccr.id_solicitante','left');
        if($searchValue != '' || $searchQuery !='')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('
                ccr.id id,
                ccr.fecha fecha,
                cccc.codigo cuenta_codigo,
                cccc.nombre cuenta_nombre,
                cccs.nombre solicitante,
                ccr.monto monto,
                ccr.descripcion descripcion               
                ');
        $this->db->from('caja_chica_registro ccr');
        $this->db->join('caja_chica_catalogo_cuenta cccc','cccc.id = ccr.id_cuenta','left');
        $this->db->join('caja_chica_catalogo_solicitante cccs','cccs.id = ccr.id_solicitante','left');

        if($searchValue != '' || $searchQuery !='')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();

        foreach($records as $record ){
            $button = '<div align="center">';

            if($this->permission1->method('administrar_caja_chica_administracion','delete')->access()) {
                $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
            }
            $button .= '&nbsp;&nbsp;<a href=" javascript:loadModal( ' . $record->id . ', \'update\' ); " class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title=" Editar " ><i class="fa fa-pencil"></i></a>';

            $button .= '</div>';

            $data[] = array(
                'id'   =>$record->id,
                'fecha'   =>$record->fecha,
                'cuenta'   =>$record->cuenta_codigo . " - " . $record->cuenta_nombre,
                'solicitante'   =>$record->solicitante,
                'monto'   =>$record->monto,
                'descripcion'   =>$record->descripcion,
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
        $this->db->select('*');
        $this->db->from('caja_chica_registro ccr');
        $this->db->where('ccr.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }



}
