<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Abonado extends CI_Model {

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
            aa.id like '%".$searchValue."%'
            or ac.cid like'%".$searchValue."%'
            or ac.razon_social like'%".$searchValue."%'

            or DATE_FORMAT(aa.fecha_registro, '%d-%m-%Y') like'%".$searchValue."%'

            or acat.nombre like'%".$searchValue."%'
            or aloc.nombre like'%".$searchValue."%'
            or azon.nombre like'%".$searchValue."%'
            or aa.direccion like'%".$searchValue."%'
            or aa.numero like'%".$searchValue."%'
            or act.nombre like'%".$searchValue."%'
            or apos.nombre like'%".$searchValue."%'
            or aa.distancia_poste like'%".$searchValue."%'
            or aa.medidor like'%".$searchValue."%'
            or aa.lectura like'%".$searchValue."%'
            or aa.multiplicador like'%".$searchValue."%'
            or asum.nombre like'%".$searchValue."%'
            or acon.nombre like'%".$searchValue."%'
            or amed.nombre like'%".$searchValue."%'
            or alib.nombre like'%".$searchValue."%'
            or aest.nombre like'%".$searchValue."%'
            or aa.ci_inquilino like'%".$searchValue."%'
            or aa.nombre_inquilino like'%".$searchValue."%'
            or aa.cel_inquilino like'%".$searchValue."%'
            or aestad.nombre like'%".$searchValue."%'
            or aestad.nombre like'%".$searchValue."%'
            or DATE_FORMAT(aa.fecha_ley_adulto, '%d-%m-%Y') like'%".$searchValue."%'
            ) ";
        }

        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('adq_abonado aa');
        $this->db->join('adq_cliente ac','ac.id = aa.id_cliente','left');
        $this->db->join('adq_categoria acat','acat.id = aa.id_categoria','left');
        $this->db->join('adq_zona azon','azon.id = aa.id_zona','left');
        $this->db->join('adq_localidad aloc','aloc.id = azon.id_localidad','left');
        $this->db->join('adq_poste apos','apos.id = aa.id_poste','left');
        $this->db->join('adq_centro_transformacion act','act.id = apos.id_centro_transformacion','left');
        $this->db->join('adq_suministro asum','asum.id = aa.id_suministro','left');
        $this->db->join('adq_consumidor acon','acon.id = aa.id_consumidor','left');
        $this->db->join('adq_medicion amed','amed.id = aa.id_medicion','left');
        $this->db->join('adq_liberacion alib','alib.id = aa.id_liberacion','left');
        $this->db->join('adq_estado aest','aest.id = aa.id_existe_inquilino','left');
        $this->db->join('adq_estado aestad','aestad.id = aa.id_ley_adulto','left');

        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('adq_abonado aa');
        $this->db->join('adq_cliente ac','ac.id = aa.id_cliente','left');
        $this->db->join('adq_categoria acat','acat.id = aa.id_categoria','left');
        $this->db->join('adq_zona azon','azon.id = aa.id_zona','left');
        $this->db->join('adq_localidad aloc','aloc.id = azon.id_localidad','left');
        $this->db->join('adq_poste apos','apos.id = aa.id_poste','left');
        $this->db->join('adq_centro_transformacion act','act.id = apos.id_centro_transformacion','left');
        $this->db->join('adq_suministro asum','asum.id = aa.id_suministro','left');
        $this->db->join('adq_consumidor acon','acon.id = aa.id_consumidor','left');
        $this->db->join('adq_medicion amed','amed.id = aa.id_medicion','left');
        $this->db->join('adq_liberacion alib','alib.id = aa.id_liberacion','left');
        $this->db->join('adq_estado aest','aest.id = aa.id_existe_inquilino','left');
        $this->db->join('adq_estado aestad','aestad.id = aa.id_ley_adulto','left');
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('
            aa.id,
            ac.cid as cid,
            ac.razon_social as razon_social,
            DATE_FORMAT(aa.fecha_registro, "%d-%m-%Y") as fecha_registro,
            acat.nombre as categoria,
            aloc.nombre as localidad,
            azon.nombre as zona,
            aa.direccion as direccion,
            aa.numero as numero,
            act.nombre as transformador,
            apos.nombre as poste,
            aa.distancia_poste as distancia_poste,
            aa.medidor as medidor,
            aa.lectura as lectura,
            aa.multiplicador as multiplicador,
            asum.nombre as suministro,
            acon.nombre as consumidor,
            amed.nombre as medicion,
            alib.nombre as liberacion,
            aest.nombre as existe_inquilino,
            aa.ci_inquilino as ci_inquilino,
            aa.nombre_inquilino as nombre_inquilino,
            aa.cel_inquilino as cel_inquilino,
            aestad.nombre as existe_ley_adulto,
            DATE_FORMAT(aa.fecha_ley_adulto, "%d-%m-%Y") as fecha_ley_adulto,
                ');
        $this->db->from('adq_abonado aa');
        $this->db->join('adq_cliente ac','ac.id = aa.id_cliente','left');
        $this->db->join('adq_categoria acat','acat.id = aa.id_categoria','left');
        $this->db->join('adq_zona azon','azon.id = aa.id_zona','left');
        $this->db->join('adq_localidad aloc','aloc.id = azon.id_localidad','left');
        $this->db->join('adq_poste apos','apos.id = aa.id_poste','left');
        $this->db->join('adq_centro_transformacion act','act.id = apos.id_centro_transformacion','left');
        $this->db->join('adq_suministro asum','asum.id = aa.id_suministro','left');
        $this->db->join('adq_consumidor acon','acon.id = aa.id_consumidor','left');
        $this->db->join('adq_medicion amed','amed.id = aa.id_medicion','left');
        $this->db->join('adq_liberacion alib','alib.id = aa.id_liberacion','left');
        $this->db->join('adq_estado aest','aest.id = aa.id_existe_inquilino','left');
        $this->db->join('adq_estado aestad','aestad.id = aa.id_ley_adulto','left');

        if($searchValue != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();

        foreach($records as $record ){
            $button = '<div align="center">';

            if($this->permission1->method('administrar_adquisiciones_abonado','delete')->access()) {
                $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
            }
            $button .= '&nbsp;&nbsp;<a href=" javascript:loadModal( ' . $record->id . ', \'update\' ); " class="btn btn-xs btn-info" data-toggle="tooltip" data-placement="top" title=" Editar " ><i class="fa fa-pencil"></i></a>';

            $button .= '</div>';

            $data[] = array(
                'id'   =>$record->id,
                'cid'   =>$record->cid,
                'razon_social'   =>$record->razon_social,
                'fecha_registro'   =>$record->fecha_registro,
                'categoria'   =>$record->categoria,
                'localidad'   =>$record->localidad,
                'zona'   =>$record->zona,
                'direccion'   =>$record->direccion,
                'numero'   =>$record->numero,
                'poste'   =>$record->poste,
                'transformador'   =>$record->transformador,
                'distancia_poste'   =>$record->distancia_poste,
                'medidor'   =>$record->medidor,
                'lectura'   =>$record->lectura,
                'multiplicador'   =>$record->multiplicador,
                'suministro'   =>$record->suministro,
                'consumidor'   =>$record->consumidor,
                'medicion'   =>$record->medicion,
                'existe_inquilino'   =>$record->existe_inquilino,
                'liberacion'   =>$record->liberacion,
                'ci_inquilino'   =>$record->ci_inquilino,
                'nombre_inquilino'   =>$record->nombre_inquilino,
                'cel_inquilino'   =>$record->cel_inquilino,
                'existe_ley_adulto'   =>$record->existe_ley_adulto,
                'fecha_ley_adulto'   =>$record->fecha_ley_adulto,
                
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
        $this->db->select('aa.*, az.id_localidad as id_localidad, ap.id_centro_transformacion as id_transformador');
        $this->db->from('adq_abonado aa');
        $this->db->join('adq_zona az','az.id = aa.id_zona','left');
        $this->db->join('adq_poste ap','ap.id = aa.id_poste','left');
        $this->db->where('aa.id', $id);
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



}
