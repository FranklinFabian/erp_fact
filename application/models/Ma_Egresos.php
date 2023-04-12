<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ma_Egresos extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    //DataTables
    public function getList($postData=null){

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
        $searchQuery = "";
        if($searchValue != ''){
            $searchQuery = " (c.codigo like '%".$searchValue."%' or DATE_FORMAT(c.fecha, '%d-%m-%Y') like'%".$searchValue."%' or c.glosa like'%".$searchValue."%') ";
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('almacen_cabecera c');
        $this->db->join('almacen_movimiento m','m.id_cabecera = c.id','left');
        $this->db->where('c.tipo', 'egreso');
        $this->db->where('c.traspaso', 'no');
        $this->db->where('c.estado', 'aprobado');
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('almacen_cabecera c');
        $this->db->join('almacen_movimiento m','m.id_cabecera = c.id','left');
        $this->db->where('c.tipo', 'egreso');
        $this->db->where('c.traspaso', 'no');
        $this->db->where('c.estado', 'aprobado');
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('c.id id,
                c.codigo,
                DATE_FORMAT(c.fecha, "%d-%m-%Y") as fecha_formateada,
                c.glosa
                ');
        $this->db->from('almacen_cabecera c');
        $this->db->join('almacen_movimiento m','m.id_cabecera = c.id','left');
        $this->db->where('c.tipo', 'egreso');
        $this->db->where('c.traspaso', 'no');
        $this->db->where('c.estado', 'aprobado');
        if($searchValue != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();

        foreach($records as $record ){
            $button = '<div align="center">';
            $base_url = base_url();
            $jsaction = "return confirm('Are You Sure ?')";

            if($this->permission1->method('administrar_almacen_egreso','delete')->access()){
                $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger " data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
            }

            $button .=' <a href="'.$base_url.'Cma_egreso/update_form/'.$record->id.'" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title=" Ingresar "><i class="fa fa-eye" aria-hidden="true"></i></a>';

            $button .=' <a href="'.$base_url.'Cma_egreso/print_egreso/'.$record->id.'" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="right" title=" Imprimir " target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>';


            $button .= '</div>';

            $data[] = array(
                'id'       =>$record->id,
                'codigo'   =>$record->codigo,
                'fecha_formateada'    =>$record->fecha_formateada,
                'glosa'    =>$record->glosa,
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
    public function retrieve_cabecera_egreso($id) {
        $this->db->select('*');
        $this->db->from('almacen_cabecera');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Ingreso
    public function retrieve_egreso($id) {
        $this->db->select('m.*');
        $this->db->from('almacen_movimiento m');
        $this->db->where('m.id_cabecera', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    //Cabecera
    public function cabecera_egreso($id) {
        $this->db->select('c.*, c.codigo as codigo, c.solicitante as solicitante, p.nombre as nombre_proveedor, p.direccion as direccion_proveedor, p.telefono as telefono_proveedor, p.correo as correo_proveedor, DATE_FORMAT(c.fecha, "%d-%m-%Y") as fecha_formateada');
        $this->db->from('almacen_cabecera c');
        $this->db->join('almacen_proveedor p','p.id = c.id_proveedor','left');
        $this->db->where('c.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Detalle
    public function detalle_egreso($id) {
        $this->db->select('m.*, p.nombre as proyecto, cc.nombre as cuenta_contable, a.nombre as nombre_articulo, g.nombre as grupo, a.codigo as codigo_articulo, u.nombre as nombre_unidad');
        $this->db->from('almacen_movimiento m');
        $this->db->join('cofi_cuentas cc','cc.id = m.id_cuenta_contable','left');
        $this->db->join('almacen_articulo a','a.id = m.id_articulo','left');
        $this->db->join('almacen_grupo g','g.id = a.id_grupo','left');
        $this->db->join('almacen_unidad u','u.id = a.id_unidad','left');
        $this->db->join('almacen_proyecto p','p.id = m.id_proyecto','left');
        $this->db->where('m.id_cabecera', $id);
        $this->db->order_by('m.id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }






    //Ingreso
    public function retrieve_datamodal($id) {
        $this->db->select('m.*, a.id_grupo as id_grupo');
        $this->db->from('almacen_movimiento m');
        $this->db->join('almacen_articulo a','a.id = m.id_articulo','left');
        $this->db->where('m.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


    //Movimiento
    public function movimiento($id) {
        $this->db->select('m.*');
        $this->db->from('almacen_movimiento m');
        $this->db->where('m.id_articulo', $id);
        $this->db->where('m.tipo', 'Ingreso');
        $this->db->order_by('m.id', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Movimiento Revers
    public function movimiento_reverse($id) {
        $this->db->select('*');
        $this->db->from('almacen_movimiento ');
        $this->db->where('id_articulo', $id);
        $this->db->where('tipo', 'Ingreso');
        $this->db->order_by('id', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function obtener_ultimmo_registro($id) {
        $this->db->select('*');
        $this->db->from('almacen_movimiento m');
        $this->db->where('m.id_articulo', $id);
        $this->db->order_by('m.id', 'desc');
        $this->db->limit('1');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
        return false;

    }

    public function list_pedidos() {
        $this->db->select('*, DATE_FORMAT(fecha, "%d-%m-%Y") as fecha_formateada');
        $this->db->from('almacen_cabecera_pedido');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }


}
