<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orden extends CI_Model {

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
            aos.id like '%".$searchValue."%'
            or acl.cid like'%".$searchValue."%'
            or acl.razon_social like'%".$searchValue."%'
            or aa.id like'%".$searchValue."%'
            or as.nombre like'%".$searchValue."%'
            or ades.nombre like'%".$searchValue."%'
            or aes.nombre like'%".$searchValue."%'
            or aos.nota like'%".$searchValue."%'
            or DATE_FORMAT(aos.fecha_registro, '%d-%m-%Y') like'%".$searchValue."%'
            or DATE_FORMAT(aos.fecha_inicio, '%d-%m-%Y') like'%".$searchValue."%'
            or DATE_FORMAT(aos.fecha_fin, '%d-%m-%Y') like'%".$searchValue."%'
            or u.first_name like'%".$searchValue."%'
            or u.last_name like'%".$searchValue."%'
            ) ";
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('adq_orden_servicio aos');
        $this->db->join('adq_servicio as','as.id = aos.id_servicio','left');
        $this->db->join('adq_estado aes','aes.id = aos.id_estado_cobro','left');
        $this->db->join('adq_abonado aa','aa.id = aos.id_abonado','left');
        $this->db->join('adq_cliente acl','acl.id = aa.id_cliente','left');
        $this->db->join('adq_estado_servicio ades','ades.id = aos.id_estado_servicio','left');
        $this->db->join('users u','u.id = aos.id_empleado','left');


        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('adq_orden_servicio aos');
        $this->db->join('adq_servicio as','as.id = aos.id_servicio','left');
        $this->db->join('adq_estado aes','aes.id = aos.id_estado_cobro','left');
        $this->db->join('adq_abonado aa','aa.id = aos.id_abonado','left');
        $this->db->join('adq_cliente acl','acl.id = aa.id_cliente','left');
        $this->db->join('adq_estado_servicio ades','ades.id = aos.id_estado_servicio','left');
        $this->db->join('users u','u.id = aos.id_empleado','left');
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('
            aos.id,
            acl.cid as cid,
            acl.razon_social as razon_social,
            aa.id as id_abonado,
            as.nombre as nombre_servicio,
            ades.nombre as estado_servicio,
            aes.nombre as estado_cobro,
            aos.nota as nota,
            DATE_FORMAT(aos.fecha_registro, "%d-%m-%Y") as fecha_registro,
            DATE_FORMAT(aos.fecha_inicio, "%d-%m-%Y") as fecha_inicio,
            DATE_FORMAT(aos.fecha_fin, "%d-%m-%Y") as fecha_fin,
            u.first_name as nombre_empleado,
            u.last_name as apellido_empleado
                       ');
        $this->db->from('adq_orden_servicio aos');
        $this->db->join('adq_servicio as','as.id = aos.id_servicio','left');
        $this->db->join('adq_estado aes','aes.id = aos.id_estado_cobro','left');
        $this->db->join('adq_abonado aa','aa.id = aos.id_abonado','left');
        $this->db->join('adq_cliente acl','acl.id = aa.id_cliente','left');
        $this->db->join('adq_estado_servicio ades','ades.id = aos.id_estado_servicio','left');
        $this->db->join('users u','u.id = aos.id_empleado','left');

        if($searchValue != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();

        foreach($records as $record ){
            $button = '<div align="center">';
            $base_url = base_url();

            if($this->permission1->method('administrar_adquisiciones_orden','delete')->access()) {
                $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
            }
            $button .= '&nbsp;&nbsp;<a href=" javascript:loadModal( ' . $record->id . ', \'update\' ); " class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title=" Editar " ><i class="fa fa-pencil"></i></a>';
            $button .=' <a href="'.$base_url.'adquisiciones/Corden/printtcpdf/'.$record->id.'" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="right" title=" Imprimir " target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>';

            $button .= '</div>';

            $data[] = array(
                'id'   =>$record->id,
                'cid'   =>$record->cid,
                'razon_social'   =>$record->razon_social,
                'id_abonado'   =>$record->id_abonado,
                'nombre_servicio'   =>$record->nombre_servicio,
                'estado_servicio'   =>$record->estado_servicio,
                'estado_cobro'   =>$record->estado_cobro,
                'nota'   =>$record->nota,
                'fecha_registro'   =>$record->fecha_registro,
                'fecha_inicio'   =>$record->fecha_inicio,
                'fecha_fin'   =>$record->fecha_fin,
                'nombre_empleado'   =>$record->nombre_empleado,
                'apellido_empleado'   =>$record->apellido_empleado,
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
        $this->db->select('aos.*, aa.id_cliente  as id_cliente');
        $this->db->from('adq_orden_servicio aos');
        $this->db->join('adq_abonado aa','aa.id = aos.id_abonado','left');
        $this->db->where('aos.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }



    public function estados() {
        $this->db->select('*');
        $this->db->from('adq_estado');
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function estados_servicio() {
        $this->db->select('*');
        $this->db->from('adq_estado_servicio');
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function abonados() {
        $this->db->select('*');
        $this->db->from('adq_abonado');
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }


    public function empleados() {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }


    public function impresion_cabecera($id) {
        //$this->db->select('coc.codigo as codigo, coc.observacion as observacion, DATE_FORMAT(coc.fecha, "%d-%m-%Y") as fecha_formateada, p.nombre as nombre_proveedor');
        $this->db->select('
        aos.id as numero,
        DATE_FORMAT(aos.fecha_registro, "%d-%m-%Y") as fecha_registro,
        aa.id as abonado,
        acat.nombre as categoria,
        aa.medidor as medidor,
        ac.razon_social as razon_social,
        aa.direccion as direccion,
        asum.nombre as suministro,
        act.nombre as centro,
        apos.nombre as poste,
        acon.nombre as consumidor,

        as.nombre as nombre_servicio,
        as.costo as costo_servicio,
        aos.nota as nota,
        DATE_FORMAT(aos.fecha_inicio, "%d-%m-%Y") as fecha_inicio,
        DATE_FORMAT(aos.fecha_fin, "%d-%m-%Y") as fecha_fin,





        ');
        $this->db->from('adq_orden_servicio aos ');
        $this->db->join('adq_servicio as','as.id = aos.id_servicio','left');
        $this->db->join('adq_abonado aa','aa.id = aos.id_abonado','left');
        $this->db->join('adq_cliente ac','ac.id = aa.id_cliente','left');
        $this->db->join('adq_categoria acat','acat.id = aa.id_categoria','left');
        $this->db->join('adq_suministro asum','asum.id = aa.id_suministro','left');
        $this->db->join('adq_consumidor acon','acon.id = aa.id_consumidor','left');
        $this->db->join('adq_poste apos','apos.id = aa.id_poste','left');
        $this->db->join('adq_centro_transformacion act','act.id = apos.id_centro_transformacion','left');
        $this->db->where('aos.id', $id);
        $this->db->order_by('aos.id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }



}
