<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cliente extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //DataTables
    public function getList($postData=null){

        $postData = $this->input->post();


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
            ac.cid like '%".$searchValue."%'
            or ac.razon_social like'%".$searchValue."%'
            *or ac.nit like'%".$searchValue."%'
            or ac.nacimiento like'%".$searchValue."%'
            or ac.telefono like'%".$searchValue."%'
            ) ";
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('fact_cliente ac');
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('fact_cliente ac');
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('
            ac.id,
            ac.cid,
            ac.razon_social,

            DATE_FORMAT(ac.nacimiento, "%d-%m-%Y") as nacimiento,
            ac.telefono,
            ac.correo_electronico,
            ac.id_tipo_doc,
            ac.numero_doc,
            ac.complemento,
            ac.codigo_pais,
            ac.celular,
                ');
        $this->db->from('fact_cliente ac');

        if($searchValue != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();

        foreach($records as $record ){
            $button = '<div align="center">';

            if($this->permission1->method('administrar_adquisiciones_cliente','delete')->access()) {
                $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
            }
            $button .= '&nbsp;&nbsp;<a href=" javascript:loadModal( ' . $record->id . ', \'update\' ); " class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title=" Editar " ><i class="fa fa-pencil"></i></a>';

            $button .= '</div>';

            $data[] = array(
                'id'   =>$record->id,
                'cid'   =>$record->cid,
                'razon_social'   =>$record->razon_social,
               // 'nit'   =>$record->nit,
                'nacimiento'   =>$record->nacimiento,
                'telefono'   =>$record->telefono,

                'correo_electronico' =>$record->correo_electronico,
                'id_tipo_doc' =>$record->id_tipo_doc,
                'numero_doc' =>$record->numero_doc,
                'complemento' =>$record->complemento,
                'codigo_pais' =>$record->codigo_pais,
                'celular' =>$record->celular,

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
        $this->db->select('*');
        $this->db->from('fact_cliente');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //se modifcio $this->db->order_by('id','asc');  dado que en la tabla no existe ese campo
    public function clientes() {
        $this->db->select('*');
        $this->db->from('fact_cliente');
        $this->db->order_by('idcliente','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }



}
