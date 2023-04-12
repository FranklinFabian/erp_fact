<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ma_Proformas extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //Count Product
    public function count() {
        return $this->db->count_all("almacen_proforma");
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
            //$searchQuery = " (p.nombre like '%".$searchValue."%' or c.codigo like '%".$searchValue."%' or DATE_FORMAT(c.fecha, '%d-%m-%Y') like'%".$searchValue."%') ";
             $searchQuery = " (c.codigo like '%".$searchValue."%' or DATE_FORMAT(c.fecha, '%d-%m-%Y') like'%".$searchValue."%') ";
         }

         ## Total number of records without filtering
         $this->db->select('count(*) as allcount');
         $this->db->from('almacen_proforma c');
         $this->db->join('almacen_proforma_items cot','cot.id_proforma = c.id','left');
         $this->db->join('fact_cliente ac','ac.idcliente = c.id_cliente','left');

        if($searchValue != '')
         $this->db->where($searchQuery);
         $records = $this->db->get()->result();
         $totalRecords = $records[0]->allcount;

         ## Total number of record with filtering
         $this->db->select('count(*) as allcount');
         $this->db->from('almacen_proforma c');
         $this->db->join('almacen_proforma_items cot','cot.id_proforma = c.id','left');
         $this->db->join('fact_cliente ac','ac.idcliente = c.id_cliente','left');
         if($searchValue != '')
            $this->db->where($searchQuery);
         $records = $this->db->get()->result();
         $totalRecordwithFilter = $records[0]->allcount;

         ## Fetch records
         $this->db->select('c.id as id,
                c.codigo,
                DATE_FORMAT(c.fecha, "%d-%m-%Y") as fecha_formateada,
                ');
         $this->db->from('almacen_proforma c');
         $this->db->join('almacen_proforma_items cot','cot.id_proforma = c.id','left');
         $this->db->join('fact_cliente ac','ac.idcliente = c.id_cliente','left');

        if($searchValue != '')
         $this->db->where($searchQuery);
         $this->db->group_by('c.id');
         $this->db->order_by($columnName, $columnSortOrder);
         $this->db->limit($rowperpage, $start);
         $records = $this->db->get()->result();
         $data = array();
         $sl =1;

         foreach($records as $record ){
          $button = '<div align="center">';
          $base_url = base_url();
          $jsaction = "return confirm('Are You Sure ?')";

             if($this->permission1->method('administrar_almacen_proforma','delete')->access()){
                 $button .= '<a href="'.$base_url.'Cma_proforma/delete/'.$record->id.'" class="btn btn-xs btn-danger "  onclick="'.$jsaction.'"><i class="fa fa-trash"></i></a>';
             }

             $button .=' <a href="'.$base_url.'Cma_proforma/update_form/'.$record->id.'" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="left" title="'. display('update').'"><i class="fa fa-pencil" aria-hidden="true"></i></a>';

             $button .=' <a href="'.$base_url.'Cma_proforma/print_proforma/'.$record->id.'" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="left" title="'. display('print').'" target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>';

             $button .=' <a href="'.$base_url.'Cma_proforma/json_form/'.$record->id.'" class="btn btn-warning btn-xs" data-toggle="tooltip" data-placement="left" title="'. display('json').'" target=”_blank”><i class="fa fa-check-square" aria-hidden="true"></i></a>';

             $button .= '</div>';


             $data[] = array(
                 'sl'       =>$sl,
                 'id'       =>$record->id,
                 'codigo'   =>$record->codigo,
                 'fecha_formateada'    =>$record->fecha_formateada,
                 //'id_cliente'   =>$record->id_cliente,
                 'button'   =>$button,
             );
             $sl++;
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

    //Cabecera proforma
    public function retrieve_proforma($id) {
        $this->db->select('*');
        $this->db->from('almacen_proforma');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function retrieve_print_proforma($id) {
        $this->db->select('almacen_proforma.*, fact_cliente.*, users.first_name, users.first_name');
        $this->db->from('almacen_proforma');
        $this->db->join('fact_cliente', 'fact_cliente.idcliente = almacen_proforma.id_cliente');
        $this->db->where('almacen_proforma.id', $id);
        $this->db->join('users', 'users.id = almacen_proforma.id_usuario');
        //$this->db->join('adq_catalogo_tipodoc', 'adq_cliente.id_tipo_doc = adq_catalogo_tipodoc.id');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }




    //Proforma items
    public function retrieve_proforma_items($id) {
        $this->db->select('ROW_NUMBER() OVER () AS numero_item, pi.*');
        $this->db->from('almacen_proforma_items pi');
        $this->db->where('pi.id_proforma', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function retrieve_print_proforma_items($id) {
        $this->db->select('pi.*, aa.nombre');
        $this->db->from('almacen_proforma_items pi');
        $this->db->join('almacen_articulo aa', 'aa.id = pi.id_articulo');
        $this->db->where('pi.id_proforma', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Delete proforma items
    public function delete($id) {
        echo $id; // Imprime el id en la pantalla para verificar que está llegando correctamente
        $this->db->select('id');
        $this->db->from('almacen_proforma_items');
        $this->db->where('id_proforma', $id);
        $query = $this->db->get();
        $affected_row = $query->num_rows();

        if ($affected_row == 0) {
            $this->db->where('id', $id);
            $this->db->delete('almacen_proforma');
            $this->session->set_userdata(array('message' => display('successfully_delete')));
            return true;
        } else {
            $this->session->set_userdata(array('error_message' => display('you_cant_delete_this_item')));
            return false;
        }
    }

   /* //Proforma
    public function proforma($id) {
        $this->db->select('c.*, a.id as id, a.nombre as nombre_articulo, a.codigo as codigo_articulo, u.nombre as nombre_unidad');
        $this->db->from('almacen_cotizacion c');
        $this->db->join('almacen_articulo a','a.id = c.id_articulo','left');
        $this->db->join('almacen_unidad u','u.id = a.id_unidad','left');
        $this->db->where('c.id_cabecera_cotizacion', $id);
        $this->db->group_by("c.id_articulo");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Cabecera proforma
    public function cabecera_proforma($id) {
        $this->db->select('c.*, LPAD(c.codigo, 4, 0) as codigo, DATE_FORMAT(c.fecha, "%d-%m-%Y") as fecha_formateada');
        $this->db->from('almacen_cabecera_cotizacion c');
        $this->db->where('c.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }*/

    //Lista de Proveedores para el reporte
    public function proveedores($id) {
        $this->db->select(' p.id id, p.nombre nombre, c.costo costo');
        $this->db->from('almacen_cotizacion c');
        $this->db->join('almacen_proveedor p','p.id = c.id_proveedor','left');
        $this->db->where('c.id_cabecera_cotizacion', $id);
        $this->db->group_by("c.id_proveedor");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    //Lista de Costos para el reporte
    public function costos($id) {
        $this->db->select(' c.id_articulo id, c.costo nombre, c.id_proveedor as id_proveedor');
        $this->db->from('almacen_cotizacion c');
        $this->db->join('almacen_proveedor p','p.id = c.id_proveedor','left');
        $this->db->where('c.id_cabecera_cotizacion', $id);
        //$this->db->group_by("c.id_proveedor");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Lista de Proveedores para el reporte
    public function proveedores_totales($id) {
        $this->db->select(' sum(c.costo * c.cantidad)  costo');
        $this->db->from('almacen_cotizacion c');
        $this->db->join('almacen_proveedor p','p.id = c.id_proveedor','left');
        $this->db->where('c.id_cabecera_cotizacion', $id);
        $this->db->group_by("c.id_proveedor");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function cabecera_cotizacion($id_cotizacion, $id_proveedor) {
        $this->db->select('DATE_FORMAT(cc.fecha, "%d-%m-%Y") as fecha_formateada , p.nombre proveedor');
        $this->db->from('almacen_proforma_items pi');
        $this->db->join('almacen_proforma p','p.id = pi.id_proforma','left');
        $this->db->join('almacen_proveedor p','p.id = pi.id_proveedor','left');
        $this->db->where('pi.id_proforma', $id_cotizacion);
        $this->db->where('pi.id_proveedor', $id_proveedor);
        $this->db->group_by("pi.id_proveedor");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function cuerpo_cotizacion($id_cotizacion, $id_proveedor) {
        $this->db->select('c.cantidad cantidad, u.nombre unidad, a.nombre articulo, c.costo costo, (c.cantidad * c.costo) importe');
        $this->db->from('almacen_cotizacion c');
        $this->db->join('almacen_cabecera_cotizacion cc','cc.id = c.id_cabecera_cotizacion','left');
        $this->db->join('almacen_articulo a','a.id = c.id_articulo','left');
        $this->db->join('almacen_unidad u','u.id = a.id_unidad','left');
        $this->db->where('c.id_cabecera_cotizacion', $id_cotizacion);
        $this->db->where('c.id_proveedor', $id_proveedor);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function lista_items ($id){
        $this->db->select('c.*, a.nombre,p.id_usuario,p.id_cliente');
        $this->db->from('almacen_proforma_items c');
        $this->db->join('almacen_articulo a','a.id = c.id_articulo','left');
        $this->db->join('almacen_proforma p','p.id = c.id_proforma','left');
        $this->db->where('c.id_proforma', $id);
      //  $this->db->group_by("c.id_articulo");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function lista_cliente ($cliente){
        $this->db->select('c.*');
        $this->db->from('fact_cliente c');
        $this->db->where('c.idcliente', $cliente);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function lista_usuario ($usuario){
        $this->db->select(' c.* ');
        $this->db->from('users c');
        $this->db->where('c.id', $usuario);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

}
