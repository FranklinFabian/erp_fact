<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mga_Clientes extends CI_Model {

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
            $searchQuery = " (
            gc.codigo like '%".$searchValue."%' or
            gc.ci like '%".$searchValue."%' or
            gc.razon_social like '%".$searchValue."%' or
            gc.genero like '%".$searchValue."%' or
            gc.nit like '%".$searchValue."%' or
            gc.direccion like '%".$searchValue."%' or
            gc.telefono like '%".$searchValue."%' or
            gc.numero_dependientes like '%".$searchValue."%' or
            gc.estado_cliente like '%".$searchValue."%' or
            gc.tipo_socio like '%".$searchValue."%' or
            gc.codigo_socio like '%".$searchValue."%' or
            DATE_FORMAT(gc.fecha_registro, '%d-%m-%Y') like'%".$searchValue."%' or
            DATE_FORMAT(gc.fecha_nacimiento, '%d-%m-%Y') like'%".$searchValue."%' or
            DATE_FORMAT(gc.fecha_socio, '%d-%m-%Y') like'%".$searchValue."%' or
            go.nombre like'%".$searchValue."%' or
            gne.nombre like'%".$searchValue."%' or
            gp.nombre like'%".$searchValue."%' or
            gec.nombre like'%".$searchValue."%' or
            gd.nombre like'%".$searchValue."%') ";
         }

         ## Total number of records without filtering
         $this->db->select('count(*) as allcount');
         $this->db->from('ga_cliente gc');
         $this->db->join('ga_ocupacion go','go.id = gc.id_ocupacion','left');
         $this->db->join('ga_nivel_educacion gne','gne.id = gc.id_nivel_educacion','left');
         $this->db->join('ga_profesion gp','gp.id = gc.id_profesion','left');
         $this->db->join('ga_estado_civil gec','gec.id = gc.id_estado_civil','left');
         $this->db->join('ga_departamento gd','gd.id = gc.id_expedido','left');
         if($searchValue != '')
         $this->db->where($searchQuery);
         $records = $this->db->get()->result();
         $totalRecords = $records[0]->allcount;

         ## Total number of record with filtering
         $this->db->select('count(*) as allcount');
         $this->db->from('ga_cliente gc');
         $this->db->join('ga_ocupacion go','go.id = gc.id_ocupacion','left');
         $this->db->join('ga_nivel_educacion gne','gne.id = gc.id_nivel_educacion','left');
         $this->db->join('ga_profesion gp','gp.id = gc.id_profesion','left');
         $this->db->join('ga_estado_civil gec','gec.id = gc.id_estado_civil','left');
         $this->db->join('ga_departamento gd','gd.id = gc.id_expedido','left');
         if($searchValue != '')
            $this->db->where($searchQuery);
         $records = $this->db->get()->result();
         $totalRecordwithFilter = $records[0]->allcount;

         ## Fetch records
         $this->db->select('
                gc.*,
                DATE_FORMAT(gc.fecha_registro, "%d-%m-%Y") as fecha_registro_formato,
                DATE_FORMAT(gc.fecha_nacimiento, "%d-%m-%Y") as fecha_nacimiento_formato,
                DATE_FORMAT(gc.fecha_socio, "%d-%m-%Y") as fecha_socio_formato,
                go.nombre as ocupacion,
                gne.nombre as nivel_educacion,
                gp.nombre as profesion,
                gec.nombre as estado_civil,
                gd.nombre as departamento
                ');
         $this->db->from('ga_cliente gc');
         $this->db->join('ga_ocupacion go','go.id = gc.id_ocupacion','left');
         $this->db->join('ga_nivel_educacion gne','gne.id = gc.id_nivel_educacion','left');
         $this->db->join('ga_profesion gp','gp.id = gc.id_profesion','left');
         $this->db->join('ga_estado_civil gec','gec.id = gc.id_estado_civil','left');
         $this->db->join('ga_departamento gd','gd.id = gc.id_expedido','left');
         if($searchValue != '')
         $this->db->where($searchQuery);
         $this->db->order_by($columnName, $columnSortOrder);
         $this->db->limit($rowperpage, $start);
         $records = $this->db->get()->result();
         $data = array();

         foreach($records as $record ){
          $button = '<div align="center">';
          $base_url = base_url();

             if($this->permission1->method('administrar_gestion_asociado_cliente','delete')->access()){
                 $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger " data-toggle="tooltip" data-placement="left" title="Borrar" ><i class="fa fa-trash"></i></a>';
             }

             $button .=' <a href="'.$base_url.'Cga_cliente/update_form/'.$record->id.'" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></a>';

             $button .=' <a href="'.$base_url.'Cga_cliente/print/'.$record->id.'" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="right" title="Imprimir" target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>';


             $button .= '</div>';

             $data[] = array(
                 'id'                   =>$record->id,
                 'ci'                   =>$record->ci,
                 'codigo'               =>$record->codigo,
                 'departamento'         =>$record->departamento,
                 'razon_social'         =>$record->razon_social,
                 'fecha_nacimiento'     =>$record->fecha_nacimiento_formato,
                 'genero'               =>$record->genero,
                 'nit'                  =>$record->nit,
                 'direccion'            =>$record->direccion,
                 'telefono'             =>$record->telefono,
                 'profesion'            =>$record->profesion,
                 'ocupacion'            =>$record->ocupacion,
                 'nivel_educacion'      =>$record->nivel_educacion,
                 'numero_dependientes'  =>$record->numero_dependientes,
                 'estado_civil'         =>$record->estado_civil,
                 'estado_cliente'       =>$record->estado_cliente,
                 'fecha_registro'       =>$record->fecha_registro_formato,
                 'tipo_socio'           =>$record->tipo_socio,
                 'codigo_socio'         =>$record->codigo_socio,
                 'fecha_socio'          =>$record->fecha_socio_formato,
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

    //Ingreso
    public function retrieve_data_form($id) {
        $this->db->select('*');
        $this->db->from('ga_cliente');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Reporte pdf ficha
    public function reporte_ficha($id) {
        $this->db->select('gc.*,
                DATE_FORMAT(gc.fecha_registro, "%d-%m-%Y") as fecha_registro_formato,
                DATE_FORMAT(gc.fecha_nacimiento, "%d-%m-%Y") as fecha_nacimiento_formato,
                DATE_FORMAT(gc.fecha_socio, "%d-%m-%Y") as fecha_socio_formato,
                go.nombre as ocupacion,
                gne.nombre as nivel_educacion,
                gp.nombre as profesion,
                gec.nombre as estado_civil,
                gd.nombre as departamento');
        $this->db->from('ga_cliente gc');
        $this->db->join('ga_ocupacion go','go.id = gc.id_ocupacion','left');
        $this->db->join('ga_nivel_educacion gne','gne.id = gc.id_nivel_educacion','left');
        $this->db->join('ga_profesion gp','gp.id = gc.id_profesion','left');
        $this->db->join('ga_estado_civil gec','gec.id = gc.id_estado_civil','left');
        $this->db->join('ga_departamento gd','gd.id = gc.id_expedido','left');
        $this->db->where('gc.id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

}
