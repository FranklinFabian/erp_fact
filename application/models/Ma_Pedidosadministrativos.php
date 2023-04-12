<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ma_Pedidosadministrativos extends CI_Model {

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
            $searchQuery = " (c.codigo like '%".$searchValue."%' or DATE_FORMAT(c.fecha, '%d-%m-%Y') like'%".$searchValue."%' or c.uso like '%".$searchValue."%')";
         }

         ## Total number of records without filtering
         $this->db->select('count(*) as allcount');
         $this->db->from('almacen_cabecera_pedido c');
         $this->db->where('tipo','Administrativo');
          if($searchValue != '')
         $this->db->where($searchQuery);
         $records = $this->db->get()->result();
         $totalRecords = $records[0]->allcount;

         ## Total number of record with filtering
         $this->db->select('count(*) as allcount');
         $this->db->from('almacen_cabecera_pedido c');
         $this->db->where('tipo','Administrativo');
         if($searchValue != '')
            $this->db->where($searchQuery);
         $records = $this->db->get()->result();
         $totalRecordwithFilter = $records[0]->allcount;

         ## Fetch records
         $this->db->select('c.id id,
                c.codigo codigo,
                c.uso uso,
                DATE_FORMAT(c.fecha, "%d-%m-%Y") as fecha_formateada
                ');
         $this->db->from('almacen_cabecera_pedido c');
         $this->db->where('tipo','Administrativo');
         if($searchValue != '')
         $this->db->where($searchQuery);
         $this->db->order_by($columnName, $columnSortOrder);
         $this->db->limit($rowperpage, $start);
         $records = $this->db->get()->result();
         $data = array();

         foreach($records as $record ){
          $button = '<div align="center">';
          $base_url = base_url();

             if($this->permission1->method('administrar_almacen_pedido_administrativo','delete')->access()){
                 $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger " data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
             }

             $button .=' <a href="'.$base_url.'Cma_pedidoadministrativo/update_form/'.$record->id.'" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title=" Ingresar "><i class="fa fa-eye" aria-hidden="true"></i></a>';

             $button .=' <a href="'.$base_url.'Cma_pedidoadministrativo/print/'.$record->id.'" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="right" title=" Imprimir " target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>';


             $button .= '</div>';

             $data[] = array(
                 'id'       =>$record->id,
                 'codigo'   =>$record->codigo,
                 'fecha_formateada'    =>$record->fecha_formateada,
                 'uso'    =>$record->uso,
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
        $this->db->from('almacen_cabecera_pedido');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Cabecera Impresion
    public function impresion_cabecera($id) {
        $this->db->select('cp.codigo as codigo, DATE_FORMAT(cp.fecha, "%d-%m-%Y") as fecha_formateada , cp.uso uso');
        $this->db->from('almacen_cabecera_pedido cp');
        $this->db->where('cp.id', $id);
        $this->db->order_by('cp.id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Detalle Impresion
    public function impresion_detalle($id) {
        $this->db->select('p.cantidad cantidad, a.nombre articulo, g.nombre grupo, u.nombre as unidad, pr.nombre proyecto');
        $this->db->from('almacen_pedido p');
        $this->db->join('almacen_proyecto pr','pr.id = p.id_proyecto','left');
        $this->db->join('almacen_articulo a','a.id = p.id_articulo','left');
        $this->db->join('almacen_grupo g','g.id = a.id_grupo','left');
        $this->db->join('almacen_unidad u','u.id = a.id_unidad','left');
        $this->db->where('p.id_cabecera', $id);
        $this->db->order_by('p.id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Modal
    public function retrieve_datamodal($id) {
        $this->db->select('p.*, a.id_grupo as id_grupo, pr.nombre proyecto');
        $this->db->from('almacen_pedido p');
        $this->db->join('almacen_articulo a','a.id = p.id_articulo','left');
        $this->db->join('almacen_proyecto pr','pr.id = p.id_proyecto','left');
        $this->db->where('p.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


}
