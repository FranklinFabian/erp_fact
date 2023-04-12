<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cortereposicion extends CI_Model {

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
            acr.id like '%".$searchValue."%'
            or acl.cid like'%".$searchValue."%'
            or acl.razon_social like'%".$searchValue."%'
            or aa.id like'%".$searchValue."%'
            or DATE_FORMAT(acr.fecha, '%d-%m-%Y') like'%".$searchValue."%'
            or acr.nota like'%".$searchValue."%'
            or at.nombre like'%".$searchValue."%'
            ) ";
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('adq_corte_reposicion acr');
        $this->db->join('adq_abonado aa','aa.id = acr.id_abonado','left');
        $this->db->join('adq_tipo at','at.id = acr.id_tipo','left');
        $this->db->join('adq_cliente acl','acl.id = aa.id_cliente','left');

        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('adq_corte_reposicion acr');
        $this->db->join('adq_abonado aa','aa.id = acr.id_abonado','left');
        $this->db->join('adq_tipo at','at.id = acr.id_tipo','left');
        $this->db->join('adq_cliente acl','acl.id = aa.id_cliente','left');

        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('
            acr.id as id,
            acl.cid as cid,
            acl.razon_social as razon_social,
            aa.id as id_abonado,
            DATE_FORMAT(acr.fecha, "%d-%m-%Y") as fecha,
            acr.nota as nota,
            at.nombre as tipo
                       ');
        $this->db->from('adq_corte_reposicion acr');
        $this->db->join('adq_abonado aa','aa.id = acr.id_abonado','left');
        $this->db->join('adq_tipo at','at.id = acr.id_tipo','left');
        $this->db->join('adq_cliente acl','acl.id = aa.id_cliente','left');

        if($searchValue != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();

        foreach($records as $record ){
            $button = '<div align="center">';
            $base_url = base_url();

            if($this->permission1->method('administrar_adquisiciones_cortereposicion','delete')->access()) {
                $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
            }
            $button .= '&nbsp;&nbsp;<a href=" javascript:loadModal( ' . $record->id . ', \'update\' ); " class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title=" Editar " ><i class="fa fa-pencil"></i></a>';
            $button .=' <a href="'.$base_url.'adquisiciones/Ccortereposicion/print/'.$record->id.'" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="right" title=" Imprimir " target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>';

            $button .= '</div>';

            $data[] = array(
                'id'   =>$record->id,
                'cid'   =>$record->cid,
                'razon_social'   =>$record->razon_social,
                'id_abonado'   =>$record->id_abonado,
                'fecha'   =>$record->fecha,
                'nota'   =>$record->nota,
                'tipo'   =>$record->tipo,
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
        $this->db->select('acr.*, aa.id_cliente  as id_cliente');
        $this->db->from('adq_corte_reposicion acr');
        $this->db->join('adq_abonado aa','aa.id = acr.id_abonado','left');
        $this->db->where('acr.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }



    public function tipos() {
        $this->db->select('*');
        $this->db->from('adq_tipo');
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function impresion_cabecera($id) {
        $this->db->select('
        acr.id as numero,
        DATE_FORMAT(acr.fecha, "%d-%m-%Y") as fecha,
        aa.id as abonado,
        acat.nombre as categoria,
        aa.medidor as medidor,
        ac.razon_social as razon_social,
        aa.direccion as direccion,
        asum.nombre as suministro,
        act.nombre as centro,
        apos.nombre as poste,
        acon.nombre as consumidor,
        at.nombre as tipo,
        acr.nota as nota,





        ');
        $this->db->from('adq_corte_reposicion acr ');
        $this->db->join('adq_tipo at','at.id = acr.id_tipo','left');
        $this->db->join('adq_abonado aa','aa.id = acr.id_abonado','left');
        $this->db->join('adq_cliente ac','ac.id = aa.id_cliente','left');
        $this->db->join('adq_categoria acat','acat.id = aa.id_categoria','left');
        $this->db->join('adq_suministro asum','asum.id = aa.id_suministro','left');
        $this->db->join('adq_consumidor acon','acon.id = aa.id_consumidor','left');
        $this->db->join('adq_poste apos','apos.id = aa.id_poste','left');
        $this->db->join('adq_centro_transformacion act','act.id = apos.id_centro_transformacion','left');
        $this->db->where('acr.id', $id);
        $this->db->order_by('acr.id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


}
