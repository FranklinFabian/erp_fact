<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mga_Pagos extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //DataTables
    public function getList($postData=null){
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
            gs.codigo like '%".$searchValue."%' or
            gs.costo like '%".$searchValue."%' or
            gc.codigo like '%".$searchValue."%' or
            gc.ci like '%".$searchValue."%' or
            gc.razon_social like '%".$searchValue."%' or
            gc.nit like '%".$searchValue."%') ";
         }

         ## Total number of records without filtering
         $this->db->select('count(*) as allcount');
         $this->db->from('ga_suscripcion gs');
         $this->db->join('ga_cliente gc','gc.id = gs.id_cliente','left');
         $this->db->where('gc.estado_cliente', 'Aprobado');
         if($searchValue != '')
         $this->db->where($searchQuery);
         $records = $this->db->get()->result();
         $totalRecords = $records[0]->allcount;

         ## Total number of record with filtering
         $this->db->select('count(*) as allcount');
         $this->db->from('ga_suscripcion gs');
         $this->db->join('ga_cliente gc','gc.id = gs.id_cliente','left');
         $this->db->where('gc.estado_cliente', 'Aprobado');
         if($searchValue != '')
            $this->db->where($searchQuery);
         $records = $this->db->get()->result();
         $totalRecordwithFilter = $records[0]->allcount;

         ## Fetch records
         $this->db->select('
                gs.*,
                gc.codigo codigo_cliente,
                gc.ci ci_cliente,
                gc.razon_social razon_social_cliente,
                gc.nit nit_cliente
                ');
         $this->db->from('ga_suscripcion gs');
         $this->db->join('ga_cliente gc','gc.id = gs.id_cliente','left');
         $this->db->where('gc.estado_cliente', 'Aprobado');
         if($searchValue != '')
         $this->db->where($searchQuery);
         $this->db->order_by($columnName, $columnSortOrder);
         $this->db->limit($rowperpage, $start);
         $records = $this->db->get()->result();
         $data = array();

         foreach($records as $record ){
          $button = '<div align="center">';
          $base_url = base_url();

             $button .=' <a href="'.$base_url.'Cga_pago/update_form/'.$record->id.'" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Ingresar"><i class="fa fa-eye" aria-hidden="true"></i></a>';

             $button .=' <a href="'.$base_url.'Cga_pago/print/'.$record->id.'" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="right" title="Imprimir" target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>';

             $button .= '</div>';

             $data[] = array(
                 'id'                   =>$record->id,
                 'codigo'               =>$record->codigo,
                 'costo'                =>$record->costo,
                 'codigo_cliente'       =>$record->codigo_cliente,
                 'ci_cliente'           =>$record->ci_cliente,
                 'razon_social_cliente' =>$record->razon_social_cliente,
                 'nit_cliente'          =>$record->nit_cliente,
                 'button'               =>$button
             );
         }

         ## Response
         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
         );

         return $response; 
    }

    //Reporte pdf ficha
    public function reporte_ficha_cliente($id) {
        $this->db->select('gc.*,
                DATE_FORMAT(gc.fecha_nacimiento, "%d-%m-%Y") as fecha_nacimiento_formato,
                DATE_FORMAT(gc.fecha_socio, "%d-%m-%Y") as fecha_socio_formato,
                gd.nombre as departamento,
                gs.id id_suscripcion,
                gs.codigo as codigo_suscripcion,
                gs.costo as costo_suscripcion,
                DATE_FORMAT(gs.fecha, "%d-%m-%Y") as fecha_suscripcion_formato,');
        $this->db->from('ga_cliente gc');
        $this->db->join('ga_suscripcion gs','gs.id_cliente = gc.id','left');
        $this->db->join('ga_departamento gd','gd.id = gc.id_expedido','left');
        $this->db->where('gs.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function reporte_pago($id) {
        $this->db->select('gp.*, DATE_FORMAT(gp.fecha, "%d-%m-%Y") as fecha_formato');
        $this->db->from('ga_pago gp');
        $this->db->join('ga_suscripcion gs','gs.id = gp.id_suscripcion','left');
        $this->db->where('gs.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function recibo_pago($id) {
        $this->db->select('
        gc.codigo as codigo_cliente,
        gc.ci as ci_cliente,
        gc.razon_social as razon_social_cliente,
        gs.codigo as codigo_suscripcion,
        DATE_FORMAT(gp.fecha, "%d-%m-%Y") as fecha_formato,
        gp.*         
         ');
        $this->db->from('ga_pago gp');
        $this->db->join('ga_suscripcion gs','gs.id = gp.id_suscripcion','left');
        $this->db->join('ga_cliente gc','gc.id = gs.id_cliente','left');
        $this->db->where('gp.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function retrieve_datamodal($id) {
        $this->db->select('*');
        $this->db->from('ga_pago');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

}
