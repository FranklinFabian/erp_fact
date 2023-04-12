<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ma_Ordenes_compra extends CI_Model {

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
            $searchQuery = " (p.nombre like '%".$searchValue."%' or c.codigo like '%".$searchValue."%' or DATE_FORMAT(c.fecha, '%d-%m-%Y') like'%".$searchValue."%' or c.observacion like'%".$searchValue."%')";
         }

         ## Total number of records without filtering
         $this->db->select('count(*) as allcount');
         $this->db->from('almacen_cabecera_orden_compra c');
         $this->db->join('almacen_proveedor p','p.id = c.id_proveedor','left');
          if($searchValue != '')
         $this->db->where($searchQuery);
         $records = $this->db->get()->result();
         $totalRecords = $records[0]->allcount;

         ## Total number of record with filtering
         $this->db->select('count(*) as allcount');
         $this->db->from('almacen_cabecera_orden_compra c');
         $this->db->join('almacen_proveedor p','p.id = c.id_proveedor','left');
         if($searchValue != '')
            $this->db->where($searchQuery);
         $records = $this->db->get()->result();
         $totalRecordwithFilter = $records[0]->allcount;

         ## Fetch records
         $this->db->select('c.id id,
                c.codigo codigo,
                DATE_FORMAT(c.fecha, "%d-%m-%Y") as fecha_formateada,
                c.observacion observacion,
                p.nombre proveedor
                ');
         $this->db->from('almacen_cabecera_orden_compra c');
         $this->db->join('almacen_proveedor p','p.id = c.id_proveedor','left');
         if($searchValue != '')
         $this->db->where($searchQuery);
         $this->db->order_by($columnName, $columnSortOrder);
         $this->db->limit($rowperpage, $start);
         $records = $this->db->get()->result();
         $data = array();

         foreach($records as $record ){
          $button = '<div align="center">';
          $base_url = base_url();

             if($this->permission1->method('administrar_almacen_orden_compra','delete')->access()){
                 $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger " data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
             }

             $button .=' <a href="'.$base_url.'Cma_orden_compra/update_form/'.$record->id.'" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title=" Ingresar "><i class="fa fa-eye" aria-hidden="true"></i></a>';

             $button .=' <a href="'.$base_url.'Cma_orden_compra/print/'.$record->id.'" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="right" title=" Imprimir " target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>';


             $button .= '</div>';

             $data[] = array(
                 'id'       =>$record->id,
                 'codigo'   =>$record->codigo,
                 'fecha_formateada'    =>$record->fecha_formateada,
                 'observacion'    =>$record->observacion,
                 'proveedor'   =>$record->proveedor,
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
        $this->db->select('*');
        $this->db->from('almacen_cabecera_orden_compra');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Cabecera Impresion
    public function impresion_cabecera($id) {
        $this->db->select('coc.codigo as codigo, coc.observacion as observacion, DATE_FORMAT(coc.fecha, "%d-%m-%Y") as fecha_formateada, p.nombre as nombre_proveedor');
        $this->db->from('almacen_cabecera_orden_compra coc');
        $this->db->join('almacen_proveedor p','p.id = coc.id_proveedor','left');
        $this->db->where('coc.id', $id);
        $this->db->order_by('coc.id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Detalle Impresion
    public function impresion_detalle($id) {
        $this->db->select('oc.cantidad cantidad, oc.costo costo, a.nombre articulo, g.nombre grupo, u.nombre as unidad');
        $this->db->from('almacen_orden_compra oc');
        $this->db->join('almacen_articulo a','a.id = oc.id_articulo','left');
        $this->db->join('almacen_grupo g','g.id = a.id_grupo','left');
        $this->db->join('almacen_unidad u','u.id = a.id_unidad','left');
        $this->db->where('oc.id_cabecera', $id);
        $this->db->order_by('oc.id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Modal
    public function retrieve_datamodal($id) {
        $this->db->select('oc.*, a.id_grupo as id_grupo');
        $this->db->from('almacen_orden_compra oc');
        $this->db->join('almacen_articulo a','a.id = oc.id_articulo','left');
        $this->db->where('oc.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function list_dropdown() {
        $this->db->select('*, DATE_FORMAT(fecha, "%d-%m-%Y") as fecha_formateada');
        $this->db->from('almacen_cabecera_orden_compra');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }




}
