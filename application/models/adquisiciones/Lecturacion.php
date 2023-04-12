<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lecturacion extends CI_Model {

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
            $searchQuery = " (aa.id like '%".$searchValue."%' or ac.cid like '%".$searchValue."%' or ac.razon_social like'%".$searchValue."%')";
         }

         ## Total number of records without filtering
         $this->db->select('count(*) as allcount');
         $this->db->from('adq_abonado aa');
         $this->db->join('adq_cliente ac','ac.id = aa.id_cliente','left');
          if($searchValue != '')
         $this->db->where($searchQuery);
         $records = $this->db->get()->result();
         $totalRecords = $records[0]->allcount;

         ## Total number of record with filtering
         $this->db->select('count(*) as allcount');
        $this->db->from('adq_abonado aa');
        $this->db->join('adq_cliente ac','ac.id = aa.id_cliente','left');
         if($searchValue != '')
            $this->db->where($searchQuery);
         $records = $this->db->get()->result();
         $totalRecordwithFilter = $records[0]->allcount;

         ## Fetch records
         $this->db->select('aa.id id,
                ac.cid cid,
                ac.razon_social razon_social,
                ');
         $this->db->from('adq_abonado aa');
         $this->db->join('adq_cliente ac','ac.id = aa.id_cliente','left');
         if($searchValue != '')
         $this->db->where($searchQuery);
         $this->db->order_by($columnName, $columnSortOrder);
         $this->db->limit($rowperpage, $start);
         $records = $this->db->get()->result();
         $data = array();

         foreach($records as $record ){
          $button = '<div align="center">';
          $base_url = base_url();

             /*if($this->permission1->method('administrar_adquisiciones_lecturacion','delete')->access()){
                 $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger " data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
             }*/

             $button .=' <a href="'.$base_url.'adquisiciones/Clecturacion/update_form/'.$record->id.'" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title=" Ingresar "><i class="fa fa-eye" aria-hidden="true"></i></a>';

             $button .=' <a href="'.$base_url.'adquisiciones/Clecturacion/print/'.$record->id.'" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="right" title=" Imprimir " target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>';


             $button .= '</div>';

             $data[] = array(
                 'id'       =>$record->id,
                 'cid'   =>$record->cid,
                 'razon_social'    =>$record->razon_social,
                 'button'   =>$button,
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

    //Cabecera Ingreso
    public function retrieve_cabecera($id) {
        $this->db->select('aa.id id,
                ac.cid cid,
                ac.razon_social razon_social,
                aa.medidor medidor,
                aa.lectura lectura,
                aa.multiplicador multiplicador,
                acat.nombre categoria,
                ac.numero_doc numero_doc,
                aa.direccion direccion




                ');
        $this->db->from('adq_abonado aa');
        $this->db->join('adq_cliente ac','ac.id = aa.id_cliente','left');
        $this->db->join('adq_categoria acat','acat.id = aa.id_categoria','left');
        $this->db->where('aa.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Cabecera Impresion
    public function impresion_cabecera($id) {
        //$this->db->select('coc.codigo as codigo, coc.observacion as observacion, DATE_FORMAT(coc.fecha, "%d-%m-%Y") as fecha_formateada, p.nombre as nombre_proveedor');
        $this->db->select('
        aa.id as abonado,
        acat.nombre as categoria,
        aa.medidor as medidor,
        ac.razon_social as razon_social,
        aa.direccion as direccion,
        asum.nombre as suministro,
        act.nombre as centro,
        apos.nombre as poste,
        acon.nombre as consumidor,

        ');
        $this->db->from('adq_abonado aa');
        $this->db->join('adq_cliente ac','ac.id = aa.id_cliente','left');
        $this->db->join('adq_categoria acat','acat.id = aa.id_categoria','left');
        $this->db->join('adq_suministro asum','asum.id = aa.id_suministro','left');
        $this->db->join('adq_consumidor acon','acon.id = aa.id_consumidor','left');
        $this->db->join('adq_poste apos','apos.id = aa.id_poste','left');
        $this->db->join('adq_centro_transformacion act','act.id = apos.id_centro_transformacion','left');
        $this->db->where('aa.id', $id);
        $this->db->order_by('aa.id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Detalle Impresion
    public function impresion_detalle($id) {
        $this->db->select('
        al.*,
        DATE_FORMAT(al.fecha, "%d-%m-%Y") as fecha,
        ae.nombre as estimado,
        aes.nombre as sin_factura,
        aesta.nombre as observada
        ');
        $this->db->from('adq_lecturacion al');
        $this->db->join('adq_estado ae','ae.id = al.estimado','left');
        $this->db->join('adq_estado aes','aes.id = al.sin_factura','left');
        $this->db->join('adq_estado aesta','aesta.id = al.observada','left');
        $this->db->where('al.id_abonado', $id);
        $this->db->order_by('al.id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Modal
    public function retrieve_datamodal($id) {
        $this->db->select('al.*');
        $this->db->from('adq_lecturacion al');
        $this->db->where('al.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
   /* public function list_dropdown() {
        $this->db->select('*, DATE_FORMAT(fecha, "%d-%m-%Y") as fecha_formateada');
        $this->db->from('almacen_cabecera_orden_compra');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }*/

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




}
