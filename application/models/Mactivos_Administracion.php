<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mactivos_Administracion extends CI_Model {

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
            $searchQuery .= " and ar.fecha_alta >= '" . $fecha_inicio ."'" ;
        }

        if($postData['fecha_fin'] != ''){
            $date = new DateTime($postData['fecha_fin']);
            $fecha_fin = $date->format('Y-m-d');
            $searchQuery .= " and ar.fecha_alta <= '" . $fecha_fin ."'" ;
        }

        if(trim($postData['cuenta']) != ''){
            $searchQuery .= " and ar.id_cuenta = '" . $postData['cuenta'] ."'" ;
        }

        if(trim($postData['ubicacion']) != ''){
            $searchQuery .= " and ar.id_ubicacion = '" . $postData['ubicacion'] ."'" ;
        }

        if(trim($postData['estado']) != ''){
            $searchQuery .= " and ar.estado = '" . $postData['estado'] ."'" ;
        }

        if($searchValue != ''){
            $searchQuery = " (acu.nombre like '%".$searchValue."%' 
            or acr.nombre like '%".$searchValue."%' 
            or acubi.nombre like'%".$searchValue."%' 
            or acuni.nombre like'%".$searchValue."%') ";
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('activos_registro ar');
        $this->db->join('activos_catalogo_cuenta acu','acu.id = ar.id_cuenta','left');
        $this->db->join('activos_catalogo_responsable acr','acr.id = ar.id_responsable','left');
        $this->db->join('activos_catalogo_ubicacion acubi','acubi.id = ar.id_ubicacion','left');
        $this->db->join('activos_catalogo_unidad acuni','acuni.id = ar.id_unidad','left');
        if($searchValue != '' || $searchQuery !='')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('activos_registro ar');
        $this->db->join('activos_catalogo_cuenta acu','acu.id = ar.id_cuenta','left');
        $this->db->join('activos_catalogo_responsable acr','acr.id = ar.id_responsable','left');
        $this->db->join('activos_catalogo_ubicacion acubi','acubi.id = ar.id_ubicacion','left');
        $this->db->join('activos_catalogo_unidad acuni','acuni.id = ar.id_unidad','left');
        if($searchValue != '' || $searchQuery !='')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('ar.id id,
                acu.nombre cuenta,
                acr.nombre responsable,
                acubi.nombre ubicacion,
                acuni.nombre unidad,
                ar.id_articulo_almacen almacen,
                ar.estado estado,
                ar.descripcion descripcion,
                ar.cantidad cantidad,
                ar.fecha_alta fecha_alta,
                ar.costo costo,
                ar.codigo_activo codigo_activo,
                ');
        $this->db->from('activos_registro ar');
        $this->db->join('activos_catalogo_cuenta acu','acu.id = ar.id_cuenta','left');
        $this->db->join('activos_catalogo_responsable acr','acr.id = ar.id_responsable','left');
        $this->db->join('activos_catalogo_ubicacion acubi','acubi.id = ar.id_ubicacion','left');
        $this->db->join('activos_catalogo_unidad acuni','acuni.id = ar.id_unidad','left');

        if($searchValue != '' || $searchQuery !='')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();

        foreach($records as $record ){
            $button = '<div align="center">';

            if($this->permission1->method('administrar_activos_administracion','delete')->access()) {
                $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
            }
            $button .= '&nbsp;&nbsp;<a href=" javascript:loadModal( ' . $record->id . ', \'update\' ); " class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title=" Editar " ><i class="fa fa-pencil"></i></a>';

            $button .= '</div>';

            $data[] = array(
                'id'   =>$record->id,
                'cuenta'   =>$record->cuenta,
                'responsable'   =>$record->responsable,
                'ubicacion'   =>$record->ubicacion,
                'unidad'   =>$record->unidad,
                'almacen'   =>$record->almacen,
                'estado'   =>$record->estado,
                'descripcion'   =>$record->descripcion,
                'cantidad'   =>$record->cantidad,
                'fecha_alta'   =>$record->fecha_alta,
                'costo'   =>$record->costo,
                'codigo_activo'   =>$record->codigo_activo,
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
        $this->db->select('
        acr.*,
        acg.id id_grupo,
        acs.id id_servicio,
        acu.id_lugar id_lugar
        ');
        $this->db->from('activos_registro acr');
        $this->db->join('activos_catalogo_cuenta acc','acc.id = acr.id_cuenta','left');
        $this->db->join('activos_catalogo_grupo acg','acg.id = acc.id_grupo','left');
        $this->db->join('activos_catalogo_servicio acs','acs.id = acg.id_servicio','left');
        $this->db->join('activos_catalogo_ubicacion acu','acu.id = acr.id_ubicacion','left');
        $this->db->where('acr.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function list_almacen_fecha($var) {
        $this->db->select('am.id id, ar.nombre nombre');
        $this->db->from('almacen_movimiento am');
        $this->db->join('almacen_cabecera ac','ac.id = am.id_cabecera','left');
        $this->db->join('almacen_articulo ar','ar.id = am.id_articulo','left');
        $this->db->where('fecha', $var);
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }

    public function list_activos() {
        $this->db->select('*');
        $this->db->from('activos_registro');
        $this->db->order_by('id','asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return FALSE;
    }






}
