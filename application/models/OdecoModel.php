<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class OdecoModel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    //listar reclamos
    public function listar_reclamos($postData,$fecha_inicial,$fecha_final)
    {
      $response = array();      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length']; // Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value
      // Custom search filter 
      $searchSemestre = $postData['searchSemestre'];
      ## Search 
      $search_arr = array();
      $searchQuery = "";
      if($searchValue != ''){
          $searchQuery = " (aetn_reclamos.NUMERO like '%".$searchValue."%' or aetn_reclamos.FECHA_HORA_REC like '%".$searchValue."%'  or aetn_reclamos.CATEGORIA like'%".$searchValue."%' or aetn_reclamosabonado.Medio_recepcion like '%".$searchValue."%' or aetn_reclamosabonado.Nombre_reclamante like'%".$searchValue."%' or aetn_reclamosabonado.Fecha_evento_causa like '%".$searchValue."%' or aetn_reclamos.MOTIVO like'%".$searchValue."%' or aetn_reclamosabonado.Equipo like '%".$searchValue."%' or aetn_reclamosabonado.Direccion_reclamante like'%".$searchValue."%' or aetn_reclamosabonado.Ci_reclamante like'%".$searchValue."%' or 
              aetn_reclamosabonado.Telefono_1_reclamante like'%".$searchValue."%' ) ";
      }
      ## Total number of records without filtering
      $this->db->select('count(*) as allcount');
      $this->db->where(array('aetn_reclamos.FECHA_HORA_REC >=' => $fecha_inicial.' 00:00:00', 'aetn_reclamos.FECHA_HORA_REC <=' => $fecha_final.' 23:59:59'));
      $this->db->where('aetn_reclamos.ESTADO_DEL_REGISTRO', 'ACTIVO');
      $this->db->where('aetn_reclamos.ESTADO', 'RECEPCIONADO');
      $records = $this->db->get('aetn_reclamos')->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      $this->db->from('aetn_reclamos');
      $this->db->join('aetn_reclamosabonado', 'aetn_reclamosabonado.Id_reclamo = aetn_reclamos.NUMERO','left'); 
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('aetn_reclamos.ESTADO_DEL_REGISTRO', 'ACTIVO');
      $this->db->where('aetn_reclamos.ESTADO', 'RECEPCIONADO');
      $this->db->where(array('aetn_reclamos.FECHA_HORA_REC >=' => $fecha_inicial.' 00:00:00', 'aetn_reclamos.FECHA_HORA_REC <=' => $fecha_final.' 23:59:59'));
      $records = $this->db->get()->result();
      $totalRecordwithFilter = $records[0]->allcount;

      ## Fetch records
      $this->db->select('aetn_reclamos.*,aetn_reclamosabonado.*');
        $this->db->from('aetn_reclamos');
        $this->db->join('aetn_reclamosabonado', 'aetn_reclamosabonado.Id_reclamo = aetn_reclamos.NUMERO','left');  
        
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('aetn_reclamos.ESTADO_DEL_REGISTRO', 'ACTIVO');
      $this->db->where('aetn_reclamos.ESTADO', 'RECEPCIONADO');
      $this->db->where(array('aetn_reclamos.FECHA_HORA_REC >=' => $fecha_inicial.' 00:00:00', 'aetn_reclamos.FECHA_HORA_REC <=' => $fecha_final.' 23:59:59'));
      $this->db->order_by($columnName, $columnSortOrder);
      $this->db->limit($rowperpage, $start);
      $records = $this->db->get()->result();
      //print_r($records);exit();
      $data = array();
      $number = 1;
      foreach($records as $key => $record ){
        //generar botnes para las acciones
        $button = '';
          $base_url = base_url();
          $jsaction = "Esta seguro de Eliminar el Registro?";

             $button .=' <div class="form-group">';
               if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a href="'.$base_url.'odeco/ver_detalle_reclamo/'.$record->NUMERO.'/'.$searchSemestre.'" class="btn btn-warning btn-sm"  data-toggle="tooltip" data-placement="left" title="Ver/Editar Registro"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
              }
              if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a href="'.$base_url.'odeco/emitir_pronunciamiento/'.$record->NUMERO.'" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Emitir Pronunciamiento"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
              }
              if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a target="_blank" href="'.$base_url.'odeco/formulario_pdf/'.$record->NUMERO.'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Formulario Reclamo"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
              }
              if($this->permission1->method('manage_supplier','delete')->access())
              {
                 $button .=' <a href="#" class="btn btn-danger btn-sm" onclick="EliminarReclamo('.urlencode($record->NUMERO).');" data-toggle="tooltip" data-placement="right" title="Anular Registro"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
             }
        $button .='</ul></div>';
        $equipo = ($record->Equipo ==1)?'SI':'NO';
          $data[] = array( 
              "number" => $number,
              "numero"=>$record->NUMERO,
              "fecha_hora_rec"=>date('d/m/Y H:i',strtotime($record->FECHA_HORA_REC)),
              "medio_recepcion"=>$record->Medio_recepcion,
              "nombre_reclamante"=>$record->Nombre_reclamante,
              "fecha_evento_causa"=>(date('d/m/Y',strtotime($record->Fecha_evento_causa)).' '.date('H:i',strtotime($record->Hora_evento_causa))),
              "motivo"=>$record->MOTIVO,
              "equipo"=>$equipo,
              "direccion_reclamante"=>$record->Direccion_reclamante,
              "ci_reclamante"=>$record->Ci_reclamante,
              "telefono_1_reclamante"=>$record->Telefono_1_reclamante,
              "categoria"=>$record->CATEGORIA,
              'button'=>$button
          ); 
          $number++;
      }
      ## Response
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
      );
      return $response; 

    }
    //listar semestres activos
    public function listar_semestres()
    {
        $this->db->select('*');
        $this->db->from('aetn_semestres');
        $this->db->order_by('_Creado_El', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function semestre_actual()
    {
        $this->db->select('*');
        $this->db->from('aetn_semestres');
        $this->db->limit(1);
        $this->db->order_by('_Creado_El', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function semestre($sigla_semestre)
    {
        $this->db->select('*');
        $this->db->from('aetn_semestres');
        $this->db->where('Sigla',$sigla_semestre);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //reclamos atendidos
    public function listar_reclamos_atendidos($postData,$fecha_inicial,$fecha_final)
    {
        /*$this->db->select('aetn_reclamos.NUMERO,aetn_reclamos.FECHA_HORA_REC,aetn_reclamos.CATEGORIA,aetn_reclamos.TIEMPO_TRAMITE,aetn_reclamosabonado.*, aetn_reclamos.MOTIVO,aetn_reclamos.ESTADO');
        $this->db->from('aetn_reclamos');
        $this->db->join('aetn_reclamosabonado', 'aetn_reclamosabonado.Id_reclamo = aetn_reclamos.NUMERO');  
        $this->db->where('aetn_reclamos.ESTADO_DEL_REGISTRO', 'ACTIVO');
        $this->db->where('aetn_reclamos.ESTADO!=', 'RECEPCIONADO');
        $this->db->where(array('aetn_reclamos.FECHA_HORA_REC >=' => $fecha_inicial, 'aetn_reclamos.FECHA_HORA_REC <=' => $fecha_final));
        $this->db->order_by('FECHA_HORA_REC', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;*/

        $response = array();      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length']; // Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value
      // Custom search filter 
      $searchSemestre = $postData['searchSemestre'];
      ## Search 
      $search_arr = array();
      $searchQuery = "";
      if($searchValue != ''){
          $searchQuery = " (aetn_reclamos.NUMERO like '%".$searchValue."%' or aetn_reclamos.FECHA_HORA_REC like '%".$searchValue."%' or aetn_reclamosabonado.Medio_recepcion like '%".$searchValue."%' or aetn_reclamosabonado.Nombre_reclamante like'%".$searchValue."%' or aetn_reclamosabonado.Fecha_evento_causa like '%".$searchValue."%' or aetn_reclamos.MOTIVO like'%".$searchValue."%' or aetn_reclamosabonado.Equipo like '%".$searchValue."%' or aetn_reclamosabonado.Direccion_reclamante like'%".$searchValue."%' or aetn_reclamosabonado.Ci_reclamante like'%".$searchValue."%' or 
              aetn_reclamosabonado.Telefono_1_reclamante like'%".$searchValue."%' or aetn_reclamos.CATEGORIA like'%".$searchValue."%' ) ";
      }
      ## Total number of records without filtering
      $this->db->select('count(*) as allcount');
      $this->db->where(array('aetn_reclamos.FECHA_HORA_REC >=' => $fecha_inicial.' 00:00:00', 'aetn_reclamos.FECHA_HORA_REC <=' => $fecha_final.' 23:59:59'));
      $this->db->where('aetn_reclamos.ESTADO_DEL_REGISTRO', 'ACTIVO');
        $this->db->where('aetn_reclamos.ESTADO!=', 'RECEPCIONADO');
      $records = $this->db->get('aetn_reclamos')->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      $this->db->from('aetn_reclamos');
      $this->db->join('aetn_reclamosabonado', 'aetn_reclamosabonado.Id_reclamo = aetn_reclamos.NUMERO','left'); 
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('aetn_reclamos.ESTADO_DEL_REGISTRO', 'ACTIVO');
        $this->db->where('aetn_reclamos.ESTADO!=', 'RECEPCIONADO');
      $this->db->where(array('aetn_reclamos.FECHA_HORA_REC >=' => $fecha_inicial.' 00:00:00', 'aetn_reclamos.FECHA_HORA_REC <=' => $fecha_final.' 23:59:59'));
      $records = $this->db->get()->result();
      $totalRecordwithFilter = $records[0]->allcount;

      ## Fetch records
      $this->db->select('aetn_reclamos.NUMERO,aetn_reclamos.FECHA_HORA_REC,aetn_reclamos.CATEGORIA,aetn_reclamos.TIEMPO_TRAMITE,aetn_reclamosabonado.*, aetn_reclamos.MOTIVO,aetn_reclamos.ESTADO');
        $this->db->from('aetn_reclamos');
        $this->db->join('aetn_reclamosabonado', 'aetn_reclamosabonado.Id_reclamo = aetn_reclamos.NUMERO');  
        
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('aetn_reclamos.ESTADO_DEL_REGISTRO', 'ACTIVO');
        $this->db->where('aetn_reclamos.ESTADO!=', 'RECEPCIONADO');
      $this->db->where(array('aetn_reclamos.FECHA_HORA_REC >=' => $fecha_inicial.' 00:00:00', 'aetn_reclamos.FECHA_HORA_REC <=' => $fecha_final.' 23:59:59'));
      $this->db->order_by($columnName, $columnSortOrder);
      $this->db->limit($rowperpage, $start);
      $records = $this->db->get()->result();
      //print_r($records);exit();
      $data = array();
      $number = 1;
      foreach($records as $key => $record ){
        //generar botnes para las acciones
        $button = '';
          $base_url = base_url();
          $jsaction = "Esta seguro de Eliminar el Registro?";

             $button .=' <div class="form-group">';
               if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a href="'.$base_url.'odeco/ver_detalle_reclamo/'.$record->NUMERO.'/'.$searchSemestre.'" class="btn btn-info btn-sm" data-toggle="tooltip" data-placement="left" title="Ver Detalle"><i class="fa fa-search" aria-hidden="true"></i></a>';
              }
              if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a target="_blank" href="'.$base_url.'odeco/formulario_pdf/'.$record->NUMERO.'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Formulario Reclamo"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
              }
              if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a target="_blank" target="_blank" href="'.$base_url.'odeco/respuesta_pdf/'.$record->NUMERO.'" class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="left" title="Formulario Respuesta"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';
              }
              if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a href="'.$base_url.'odeco/editar_pronunciamiento/'.$record->NUMERO.'" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="left" title="Editar Pronunciamiento"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
              }

        $button .='</ul></div>';
        $equipo = ($record->Equipo ==1)?'SI':'NO';
        $var = $record->TIEMPO_TRAMITE; settype($var, 'string'); $datos = explode('.',$var); 
        $tiempo = $datos[0].'.'.(round($datos[1]*100/60));

          $data[] = array( 
              "number" => $number,
              "Numero"=>$record->NUMERO,
              "Fecha_hora_rec"=>date('d/m/Y H:i',strtotime($record->FECHA_HORA_REC)),
              "Medio_recepcion"=>$record->Medio_recepcion,
              "Nombre_reclamante"=>$record->Nombre_reclamante,
              "Fecha_evento_causa"=>(date('d/m/Y',strtotime($record->Fecha_evento_causa)).' '.date('H:i',strtotime($record->Hora_evento_causa))),
              "Motivo"=>$record->MOTIVO,
              "Equipo"=>$equipo,
              "Direccion_reclamante"=>$record->Direccion_reclamante,
              "Ci_reclamante"=>$record->Ci_reclamante,
              "Telefono_1_reclamante"=>$record->Telefono_1_reclamante,
              "Categoria"=>$record->CATEGORIA,
              "Tiempo"=>$tiempo,
              'button'=>$button
          ); 
          $number++;
      }
      ## Response
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
      );
      return $response; 
    }
    //tipo de reclamos
    public function tipo_reclamo() {
        $this->db->select('*');
        $this->db->from('aetn_codif_reclamo');
        $this->db->order_by('MOTIVO', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //oficinas odeco
    public function get_oficinaodeco() {
        $this->db->select('Id_Localidad, Localidad');
        $this->db->from('sis_localidades');
        $this->db->where('Estado', 'ACTIVO');
        $this->db->order_by('Id_Localidad', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //get numero/serie de abonados
    public function get_IdAbonado() {
        $this->db->select('Id_Abonado');
        $this->db->from('atcl_abonados');
        $this->db->where('Estado', 'ACTIVO');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //Datos de cliente Titular
    public function clientetitular_list($id_abonado) {
        $this->db->select('atcl_abonados.Serie_Medidor,atcl_clientes.Id_Cliente,atcl_clientes.Nombres,atcl_clientes.Nit,atcl_clientes.Telefono,atcl_abonados.Numero,fact_categorias.Sigla as Categoria,sis_localidades.Localidad,sis_localidades.Id_Localidad,sis_localidades.Sigla,sis_zonas.Zona, sis_zonas.Id_Zona, sis_calles.Calle');
        $this->db->from('atcl_abonados');
        $this->db->join('atcl_clientes', 'atcl_abonados.Cliente = atcl_clientes.Id_Cliente');
        $this->db->join('fact_categorias', 'atcl_abonados.Categoria = fact_categorias.Id_Categoria');
        $this->db->join('sis_localidades', 'sis_localidades.Id_Localidad = atcl_abonados.Localidad');
        $this->db->join('sis_zonas', 'sis_zonas.Id_Zona = atcl_abonados.Zona');
        $this->db->join('sis_calles', 'sis_calles.Id_Calle = atcl_abonados.Calle');
        $this->db->where('atcl_abonados.Id_Abonado', $id_abonado);
        //$this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //Registrar aetn
    public function registrar_reclamo($data) {
        
            $this->db->insert('aetn_reclamos', $data);
            $estado = $this->db->insert_id();
            if (!empty($estado)) {
                return $estado;
            }else {
                return FALSE;
            }
    }
    //Registrar aetn datos adicionales
    public function registrar_reclamo_adicional($data) {
        
            $this->db->insert('aetn_reclamosabonado', $data);
            $estado = $this->db->insert_id();
            if (!empty($estado)) {
                return $estado;
            }else {
                return FALSE;
            }
    }
    //registrar equipos danados
    public function registrar_equipos($data)
    {
        $this->db->insert('aetn_equipos', $data);
            $estado = $this->db->insert_id();
            if (!empty($estado)) {
                return $estado;
            }else {
                return FALSE;
            }
    }
    //Ver detalle de Reclamo
    public function get_detalle_reclamo($numero_reclamo) {
        $this->db->select('*');
        $this->db->from('aetn_reclamos');
        $this->db->where('NUMERO', $numero_reclamo);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //EMITIR PRONUNCIAMIENTO
    public function registrar_pronunciamiento($data,$idreclamo) 
    {
        $this->db->where('NUMERO', $idreclamo);
        $this->db->update('aetn_reclamos', $data);
        return true;
    }
    //anular reclamo
    public function anular_reclamo($idreclamo, $data)
    {
        $this->db->where('NUMERO', $idreclamo);
        $this->db->update('aetn_reclamos', $data);
        return true;
    }
    //listar reclamos por fechas
    public function listar_reclamos_reportes($start, $end) {

        $this->db->select('aetn_reclamos.*,aetn_reclamosabonado.*,atcl_clientes.Nombres');
        $this->db->from('aetn_reclamos');
        $this->db->join('atcl_abonados', 'atcl_abonados.Id_Abonado = aetn_reclamos.NRO_CUENTA');
        $this->db->join('aetn_reclamosabonado', 'aetn_reclamosabonado.Id_reclamo = aetn_reclamos.NUMERO');
        $this->db->join('atcl_clientes', 'atcl_abonados.Cliente = atcl_clientes.Id_Cliente');
        $this->db->where(array('aetn_reclamos.FECHA_HORA_REC >=' => $start, 'aetn_reclamos.FECHA_HORA_REC <=' => $end));
        $this->db->where('aetn_reclamos.ESTADO_DEL_REGISTRO', 'ACTIVO');
        $this->db->order_by('FECHA_HORA_REC', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function listar_reclamos_reportes_por_cuenta($nro_cuenta) {

        $this->db->select('aetn_reclamos.*,aetn_reclamosabonado.*,atcl_clientes.Nombres');
        $this->db->from('aetn_reclamos');
        $this->db->join('atcl_abonados', 'atcl_abonados.Id_Abonado = aetn_reclamos.NRO_CUENTA');
        $this->db->join('aetn_reclamosabonado', 'aetn_reclamosabonado.Id_reclamo = aetn_reclamos.NUMERO');
        $this->db->join('atcl_clientes', 'atcl_abonados.Cliente = atcl_clientes.Id_Cliente');
        $this->db->where('atcl_abonados.Id_Abonado', $nro_cuenta);
        $this->db->where('aetn_reclamos.ESTADO_DEL_REGISTRO', 'ACTIVO');
        $this->db->order_by('FECHA_HORA_REC', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    /**************** REPORTE PDF DE RECLAMOS **************************/
    public function detalles_reclamo($nro_reclamo)
    {
        $this->db->select('aetn_reclamos.*,aetn_reclamos.MOTIVO AS ASUNTO,,aetn_reclamosabonado.*,atcl_clientes.Id_Cliente,atcl_clientes.Nombres,atcl_clientes.Nit,atcl_clientes.Telefono,atcl_abonados.Numero,sis_localidades.Localidad,sis_localidades.Sigla,sis_zonas.Zona,sis_calles.Calle, atcl_abonados.Serie_Medidor,aetn_codif_reclamo.*');
        $this->db->from('aetn_reclamos');
        $this->db->join('aetn_reclamosabonado', 'aetn_reclamos.NUMERO = aetn_reclamosabonado.Id_reclamo');
        $this->db->join('atcl_abonados', 'atcl_abonados.Id_Abonado = atcl_abonados.Id_Abonado');
        $this->db->join('sis_localidades', 'sis_localidades.Id_Localidad = aetn_reclamosabonado.Localidad_reclamante');
        $this->db->join('atcl_clientes', 'atcl_abonados.Cliente = atcl_clientes.Id_Cliente');
        $this->db->join('sis_zonas', 'sis_zonas.Id_Zona = aetn_reclamosabonado.Zona_reclamante');
        $this->db->join('sis_calles', 'sis_calles.Id_Calle = atcl_abonados.Calle');
        $this->db->join('aetn_codif_reclamo', 'aetn_reclamos.COD_RECLAMO = aetn_codif_reclamo.MOTIVO');
        $this->db->where('aetn_reclamos.NUMERO', $nro_reclamo);
        //$this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function detalles_equipos($nro_reclamo)
    {
        $this->db->select('*');
        $this->db->from('aetn_equipos');
        $this->db->where('Id_reclamo', $nro_reclamo);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    /********************* Alimentadores *********************/
    public function listar_alimentadores($postData=null, $fecha_inicial, $fecha_final)
    {
      $response = array();      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length']; // Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value
      // Custom search filter 
      $searchSemestre = $postData['searchSemestre'];
      ## Search 
      $search_arr = array();
      $searchQuery = "";
      $otro = '';
      if($searchValue != ''){
          $searchQuery = " (COD_ALIMENTADOR like '%".$searchValue."%' or  
                COD_PROTECCION like'%".$searchValue."%' or SUBESTACION like '%".$searchValue."%' or  
                KVA_ALIMENTADOR like'%".$searchValue."%' or KV_ALIMENTADOR like '%".$searchValue."%' or  
                CONSUM_MT_1 like'%".$searchValue."%' or CONSUM_MT_2 like '%".$searchValue."%' or  
                CONSUM_BT_1 like'%".$searchValue."%' or CONSUM_BT_2 like'%".$searchValue."%' or COD_LOCALIDADES like '%".$searchValue."%' ) ";
      }
      /*if($searchSemestre != ''){
          $searchQuery = " YEAR(FECHA_REGISTRO) = '".$searchSemestre."' ";
      }*/
      //if(count($search_arr) > 0){
          //$searchQuery .= $otro;
      //}
      //print_r($searchQuery);exit();
      ## Total number of records without filtering
      $this->db->select('count(*) as allcount');
      $this->db->where(array('aetn_alimentadores.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_alimentadores.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $records = $this->db->get('aetn_alimentadores')->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where(array('aetn_alimentadores.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_alimentadores.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $records = $this->db->get('aetn_alimentadores')->result();
      $totalRecordwithFilter = $records[0]->allcount;
      ## Fetch records
      $this->db->select('*');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where(array('aetn_alimentadores.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_alimentadores.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      //$this->db->order_by('aetn_alimentadores.FECHA_REGISTRO', 'desc');
      $this->db->order_by($columnName, $columnSortOrder);

      $this->db->limit($rowperpage, $start);
      $records = $this->db->get('aetn_alimentadores')->result();
      //print_r($records);exit();
      $data = array();
      $number = 1;
      foreach($records as $key => $record ){
        //generar botnes para las acciones
        $button = '';
          $base_url = base_url();
             $button .=' <div class="form-group">';
               if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a href="'.$base_url.'odeco/ver_editar_alimentador/'.$record->COD_ALIMENTADOR.'" class="btn btn-warning btn-sm"  data-toggle="tooltip" data-placement="left" title="Ver/Editar Registro"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            }
               
             if($this->permission1->method('manage_supplier','delete')->access())
              {
                 $button .=' <a href="#" class="btn btn-danger btn-sm" onclick="EliminarAlimentador(\''.urlencode($record->COD_ALIMENTADOR).'\');" data-toggle="tooltip" data-placement="right" title="Anular Registro"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
             }

        $button .='</div>';

          $data[] = array( 
              "number" => $number,
              "cod_alimentador"=>urlencode($record->COD_ALIMENTADOR),
              "cod_proteccion"=>$record->COD_PROTECCION,
              "subestacion"=>$record->SUBESTACION,
              "kva_alimentador"=>$record->KVA_ALIMENTADOR,
              "kv_alimentador"=>$record->KV_ALIMENTADOR,
              "consum_mt_1"=>$record->CONSUM_MT_1,
              "consum_mt_2"=>$record->CONSUM_MT_2,
              "consum_bt_1"=>$record->CONSUM_BT_1,
              "consum_bt_2"=>$record->CONSUM_BT_2,
              "cod_localidades"=>$record->COD_LOCALIDADES,
              "fecha_registro"=>date('d/m/Y H:i',strtotime($record->FECHA_REGISTRO)),
              'button'=>$button
          ); 
          $number++;
      }
      //print_r($data);exit();
      ## Response
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
      );
      //print_r($response);exit();
      return $response; 
    }
    public function registrar_alimentador($data)
    {
        $this->db->insert('aetn_alimentadores', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return $estado;
        }else {
            return FALSE;
        }
    }
    public function anular_alimentador($cod_alimentador)
    {
        $this->db->where('COD_ALIMENTADOR', urldecode($cod_alimentador));
        $this->db->delete('aetn_alimentadores');
        return true;
    }
    public function get_detalle_alimentador($cod_alimentador)
    {
        $this->db->select('*');
        $this->db->from('aetn_alimentadores');
        $this->db->where('COD_ALIMENTADOR', urldecode($cod_alimentador));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function modificar_alimentador($data, $cod_alimentador)
    {
        $this->db->where('COD_ALIMENTADOR', $cod_alimentador);
        $this->db->update('aetn_alimentadores', $data);
        $estado = $this->db->insert_id();
        var_dump($estado);
        if (!empty($estado)) {
            return true;
        }else {
            return false;
        }
    }
    /********************* Elementos de Maniobra *********************/
    public function listar_maniobras($postData=null, $fecha_inicial, $fecha_final)
    {   

      $response = array();      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length']; // Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value

      // Custom search filter 
      $searchSemestre = $postData['searchSemestre'];
      //print_r($searchSemestre);
      //buscar semestre
      //print_r($fecha_inicial); print_r($fecha_final);exit();
      ## Search 
      $search_arr = array();
      $searchQuery = "";
      if($searchValue != ''){
          $searchQuery = " (COD_PROTECCION like '%".$searchValue."%' or COD_ALIMENTADOR like '%".$searchValue."%' or TIPO_PROTECCION like'%".$searchValue."%' or ESTADO like '%".$searchValue."%' or KVA_PROTECCION like'%".$searchValue."%' or KV_PROTECCION like '%".$searchValue."%' or COD_ZONA like'%".$searchValue."%' or PROTECCION_SUP like'%".$searchValue."%' or CONSUM_MT_1 like'%".$searchValue."%' or CONSUM_MT_2 like '%".$searchValue."%' or CONSUM_BT_1 like'%".$searchValue."%' or CONSUM_BT_2 like'%".$searchValue."%' or DIRECCION like '%".$searchValue."%' ) ";
      }
      ## Total number of records without filtering
      $this->db->select('count(*) as allcount');
      $this->db->where(array('aetn_maniobra.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_maniobra.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));    
      $records = $this->db->get('aetn_maniobra')->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where(array('aetn_maniobra.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_maniobra.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $records = $this->db->get('aetn_maniobra')->result();
      $totalRecordwithFilter = $records[0]->allcount;
      ## Fetch records
      $this->db->select('*');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where(array('aetn_maniobra.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_maniobra.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      //$this->db->order_by('aetn_maniobra.FECHA_REGISTRO', 'desc');
      $this->db->order_by($columnName, $columnSortOrder);

      $this->db->limit($rowperpage, $start);
      $records = $this->db->get('aetn_maniobra')->result();
      //print_r($records);exit();
      $data = array();
      $number = 1;
      foreach($records as $key => $record ){
        //generar botnes para las acciones
        $button = '';
          $base_url = base_url();
          $jsaction = "Esta seguro de Eliminar el Registro?";

             $button .=' <div class="form-group">';
               if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a href="'.$base_url.'odeco/ver_editar_maniobra/'.$record->COD_PROTECCION.'" class="btn btn-warning btn-sm"  data-toggle="tooltip" data-placement="left" title="Ver/Editar Registro"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            }
               if($this->permission1->method('manage_supplier','delete')->access()){
                 /*$button .=' <a href="'.$base_url.'odeco/anular_feriado/'.$record->COD_PROTECCION.'" class="btn btn-danger " onclick="'.$jsaction.'"><i class="fa fa-trash"></i> Eliminar</a>';*/
                 $button .=' <a href="#" class="btn btn-danger btn-sm" onclick="EliminarManiobra(\''.urlencode($record->COD_PROTECCION).'\');" data-toggle="tooltip" data-placement="right" title="Anular Registro"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
             }
        $button .='</ul></div>';

          $data[] = array( 
              "number" => $number,
              "cod_proteccion"=>$record->COD_PROTECCION,
              "cod_alimentador"=>$record->COD_ALIMENTADOR,
              "tipo_proteccion"=>$record->TIPO_PROTECCION,
              "estado"=>$record->ESTADO,
              "kva_proteccion"=>$record->KVA_PROTECCION,
              "kv_proteccion"=>$record->KV_PROTECCION,
              "cod_zona"=>$record->COD_ZONA,
              "proteccion_sup"=>$record->PROTECCION_SUP,
              "consum_mt_1"=>$record->CONSUM_MT_1,
              "consum_mt_2"=>$record->CONSUM_MT_2,
              "consum_bt_1"=>$record->CONSUM_BT_1,
              "consum_bt_2"=>$record->CONSUM_BT_2,
              "direccion"=>$record->DIRECCION,
              "fecha_registro"=>date('d/m/Y H:i',strtotime($record->FECHA_REGISTRO)),
              'button'=>$button
          ); 
          $number++;
      }
      //print_r($data);exit();
      ## Response
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
      );
      //print_r($response);exit();
      return $response; 
    }
    //traer alimentadores
    public function get_codalimentador()
    {
        $this->db->select('COD_ALIMENTADOR');
        $this->db->from('aetn_alimentadores');
        $this->db->order_by('FECHA_REGISTRO', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //traer cod LOC
    public function get_localidades()
    {
        $this->db->select('Localidad, Id_Localidad');
        $this->db->from('sis_localidades');
        $this->db->order_by('_Creado_El', 'asc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //traer cod zona
    public function get_codzona($Id_Localidad)
    {
        $this->db->select('Zona, Id_Zona, Sigla');
        $this->db->from('sis_zonas');
        $this->db->where('Localidad', $Id_Localidad);
        $this->db->order_by('_Creado_El', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //traer cod zonas
    public function get_codzonas()
    {
        $this->db->select('Zona, Id_Zona');
        $this->db->from('sis_zonas');
        $this->db->order_by('_Creado_El', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function registrar_maniobra($data)
    {
        $this->db->insert('aetn_maniobra', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return $estado;
        }else {
            return FALSE;
        }
    }
    public function anular_maniobra($cod_proteccion)
    {
        $this->db->where('COD_PROTECCION', urldecode($cod_proteccion));
        $this->db->delete('aetn_maniobra');
        return true;
    }
    public function get_detalle_maniobra($cod_proteccion)
    {
        $this->db->select('*');
        $this->db->from('aetn_maniobra');
        $this->db->where('COD_PROTECCION', urldecode($cod_proteccion));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function modificar_maniobra($data, $cod_proteccion)
    {
        $this->db->where('COD_PROTECCION', $cod_proteccion);
        $this->db->update('aetn_maniobra', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return true;
        }else {
            return false;
        }
    }
    /********************* Centros de Transformacion *********************/
    public function listar_centros($postData,$fecha_inicial,$fecha_final)
    {
      $response = array();      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length']; // Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value

      // Custom search filter 
      $searchSemestre = $postData['searchSemestre'];
      //print_r($searchSemestre);
      //buscar semestre
      //print_r($fecha_inicial); print_r($fecha_final);exit();
      ## Search 
      $search_arr = array();
      $searchQuery = "";
      if($searchValue != ''){
          $searchQuery = " (COD_CENTRO like '%".$searchValue."%' or TIPO_TRAFO like '%".$searchValue."%' or KVA_CENTRO like'%".$searchValue."%' or TIPO_USO like '%".$searchValue."%' or NIVEL_CALIDAD like'%".$searchValue."%' or COD_PROTECCION like '%".$searchValue."%' or COD_ALIMENTADOR like'%".$searchValue."%' or COD_PROPIEDAD like'%".$searchValue."%' or REL_TRAFO like'%".$searchValue."%' or POSICION_TAP like '%".$searchValue."%' or CONSUM_MT like'%".$searchValue."%' or CONSUM_BT like'%".$searchValue."%' or DIRECCION like '%".$searchValue."%' ) ";
      }
      ## Total number of records without filtering
      $this->db->select('count(*) as allcount');
      $this->db->where(array('aetn_centro_transfo.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_centro_transfo.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $records = $this->db->get('aetn_centro_transfo')->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where(array('aetn_centro_transfo.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_centro_transfo.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $records = $this->db->get('aetn_centro_transfo')->result();
      $totalRecordwithFilter = $records[0]->allcount;
      ## Fetch records
      $this->db->select('*');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where(array('aetn_centro_transfo.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_centro_transfo.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      //$this->db->order_by('aetn_centro_transfo.FECHA_REGISTRO', 'desc');
      $this->db->order_by($columnName, $columnSortOrder);

      $this->db->limit($rowperpage, $start);
      $records = $this->db->get('aetn_centro_transfo')->result();
      //print_r($records);exit();
      $data = array();
      $number = 1;
      foreach($records as $key => $record ){
        //generar botnes para las acciones
        $button = '';
          $base_url = base_url();
          $jsaction = "Esta seguro de Eliminar el Registro?";

             $button .=' <div class="form-group">';
               if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a href="'.$base_url.'odeco/ver_editar_centro/'.$record->COD_CENTRO.'" class="btn btn-warning btn-sm"  data-toggle="tooltip" data-placement="left" title="Ver/Editar Registro"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            }
               if($this->permission1->method('manage_supplier','delete')->access()){
                 /*$button .=' <a href="'.$base_url.'odeco/anular_feriado/'.$record->COD_CENTRO.'" class="btn btn-danger " onclick="'.$jsaction.'"><i class="fa fa-trash"></i> Eliminar</a>';*/
                 $button .=' <a href="#" class="btn btn-danger btn-sm" onclick="EliminarCentro(\''.urlencode($record->COD_CENTRO).'\');" data-toggle="tooltip" data-placement="right" title="Anular Registro"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
             }
        $button .='</ul></div>';

          $data[] = array( 
              "number" => $number,
              "cod_centro"=>$record->COD_CENTRO,
              "tipo_trafo"=>$record->TIPO_TRAFO,
              "kva_centro"=>$record->KVA_CENTRO,
              "tipo_uso"=>$record->TIPO_USO,
              "nivel_calidad"=>$record->NIVEL_CALIDAD,
              "cod_proteccion"=>$record->COD_PROTECCION,
              "cod_alimentador"=>$record->COD_ALIMENTADOR,
              "cod_propiedad"=>$record->COD_PROPIEDAD,
              "rel_trafo"=>$record->REL_TRAFO,
              "posicion_tap"=>$record->POSICION_TAP,
              "consum_mt"=>$record->CONSUM_MT,
              "consum_bt"=>$record->CONSUM_BT,
              "direccion"=>$record->DIRECCION,
              "fecha_registro"=>date('d/m/Y H:i',strtotime($record->FECHA_REGISTRO)),
              'button'=>$button
          ); 
          $number++;
      }
      //print_r($data);exit();
      ## Response
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
      );
      //print_r($response);exit();
      return $response; 
    }
    //traer alimentadores
    public function get_proteccion()
    {
        $this->db->select('COD_PROTECCION');
        $this->db->from('aetn_maniobra');
        $this->db->order_by('FECHA_REGISTRO', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    
    public function registrar_centro($data)
    {
        $this->db->insert('aetn_centro_transfo', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return $estado;
        }else {
            return FALSE;
        }
    }
    public function anular_centro($cod_centro)
    {
        $this->db->where('COD_CENTRO', urldecode($cod_centro));
        $this->db->delete('aetn_centro_transfo');
        return true;
    }
    public function get_detalle_centro($cod_centro)
    {
        $this->db->select('*');
        $this->db->from('aetn_centro_transfo');
        $this->db->where('COD_CENTRO', urldecode($cod_centro));
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    
    public function modificar_centro($data, $cod_centro)
    {
        $this->db->where('COD_CENTRO', $cod_centro);
        $this->db->update('aetn_centro_transfo', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return true;
        }else {
            return false;
        }
    }
    /********************* CORTES PROGRAMADOS *********************/
    public function listar_cortes($postData,$fecha_inicial,$fecha_final)
    {

      $response = array();      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length']; // Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value
      // Custom search filter 
      $searchSemestre = $postData['searchSemestre'];
      ## Search 
      $search_arr = array();
      $searchQuery = "";
      if($searchValue != ''){
          $searchQuery = " (aetn_corte_programado.NRO_PROGRAMADO like '%".$searchValue."%' or aetn_corte_programado.COD_ALIMENTADOR like '%".$searchValue."%' or aetn_corte_programado.COD_PROTECCION like'%".$searchValue."%' or aetn_corte_programado.FECHA_HORA_INI like '%".$searchValue."%' or aetn_corte_programado.FECHA_HORA_FIN like'%".$searchValue."%' or aetn_corte_programado.TIEMPO_INTERRUPCION like'%".$searchValue."%' or aetn_corte_programado.KVA_INTERRUMP like'%".$searchValue."%' or aetn_corte_programado.CONSUM_AFECTADOS like '%".$searchValue."%' ) ";
      }
      ## Total number of records without filtering
      $this->db->select('count(*) as allcount');
      $this->db->where(array('aetn_corte_programado.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_corte_programado.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $this->db->where('aetn_corte_programado.ESTADO', 'ACTIVO');
      $records = $this->db->get('aetn_corte_programado')->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('aetn_corte_programado.ESTADO', 'ACTIVO');
      $this->db->where(array('aetn_corte_programado.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_corte_programado.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $records = $this->db->get('aetn_corte_programado')->result();
      $totalRecordwithFilter = $records[0]->allcount;

      ## Fetch records
      $this->db->select('aetn_corte_programado.*, aetn_origen_tipo.DESCRIPCION AS DESCRIPCION_ORIGEN_TIPO, aetn_causa_tipo.DESCRIPCION AS DESCRIPCION_CAUSA_TIPO');
      $this->db->from('aetn_corte_programado');
        $this->db->join('aetn_origen_tipo', 'aetn_origen_tipo.ORIGEN_TIPO = aetn_corte_programado.ORIGEN_TIPO');
        $this->db->join('aetn_causa_tipo', 'aetn_causa_tipo.CAUSA_TIPO = aetn_corte_programado.CAUSA_TIPO');
        
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('aetn_corte_programado.ESTADO', 'ACTIVO');
      $this->db->where(array('aetn_corte_programado.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_corte_programado.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $this->db->order_by($columnName, $columnSortOrder);
      $this->db->limit($rowperpage, $start);
      $records = $this->db->get()->result();
      //print_r($records);exit();
      $data = array();
      $number = 1;
      foreach($records as $key => $record ){
        //generar botnes para las acciones
        $button = '';
          $base_url = base_url();
          $jsaction = "Esta seguro de Eliminar el Registro?";

             $button .=' <div class="form-group">';
               if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a href="'.$base_url.'odeco/ver_editar_corte/'.$record->NRO_PROGRAMADO.'" class="btn btn-warning btn-sm"  data-toggle="tooltip" data-placement="left" title="Ver/Editar Registro"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            }
               if($this->permission1->method('manage_supplier','delete')->access()){
                 $button .=' <a href="#" class="btn btn-danger btn-sm" onclick="EliminarCorte('.urlencode($record->NRO_PROGRAMADO).');" data-toggle="tooltip" data-placement="right" title="Anular Registro"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
             }
        $button .='</ul></div>';
        $div1 = '<b class="text-danger font-weight:bold">';
        $div2 = '</b> Minutos';
        $var = $record->TIEMPO_INTERRUPCION; settype($var, 'string'); $datos = explode('.',$var); 
        $tiempo = (($datos[0]*60) + $datos[1]);
          $data[] = array( 
              "number" => $number,
              "nro_programado"=>$record->NRO_PROGRAMADO,
              "cod_alimentador"=>$record->COD_ALIMENTADOR,
              "cod_proteccion"=>$record->COD_PROTECCION,
              "fecha_hora_ini"=>date('d/m/Y H:i',strtotime($record->FECHA_HORA_INI)),
              "fecha_hora_fin"=>date('d/m/Y H:i',strtotime($record->FECHA_HORA_FIN)),
              "descripcion_origen"=>$record->DESCRIPCION_ORIGEN_TIPO.' ('.$record->ORIGEN_TIPO.')',
              "descripcion_causa"=>$record->DESCRIPCION_CAUSA_TIPO.' ('.$record->CAUSA_TIPO.')',
              "tiempo_interrump"=>$div1.$tiempo.$div2,
              "kva_interrump"=>$record->KVA_INTERRUMP,
              "consum_afectados"=>$record->CONSUM_AFECTADOS,
              "fecha_registro"=>date('d/m/Y H:i',strtotime($record->FECHA_REGISTRO)),
              'button'=>$button
          ); 
          $number++;
      }
      ## Response
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
      );
      return $response; 
    }
    public function get_id_corte()
    {        
        $this->db->order_by('NRO_PROGRAMADO', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('aetn_corte_programado');
        if ($query->num_rows() > 0) {
            $datos = $query->row();
            $id_mas = ($datos->NRO_PROGRAMADO)+1;
            $last_id = str_pad($id_mas,5,'0',STR_PAD_LEFT);
            return $last_id;
        }else{
            $id_mas = 1;
            $last_id = str_pad($id_mas,5,'0',STR_PAD_LEFT);
            return $last_id;
        }
    }
    //get origen
    public function get_origen()
    {
        $this->db->select('*');
        $this->db->from('aetn_origen');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //get causa
    public function get_causa()
    {
        $this->db->select('*');
        $this->db->from('aetn_causa');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //AJax get_tipo_origen($id_origen)
    public function get_tipo_origen($id_origen)
    {
        $this->db->select('*');
        $this->db->from('aetn_origen_tipo');
        $this->db->where('ORIGEN', $id_origen);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //AJax get_tipo_causa($id_causa)
    public function get_tipo_causa($id_causa)
    {
        $this->db->select('*');
        $this->db->from('aetn_causa_tipo');
        $this->db->where('CAUSA', $id_causa);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function get_tipo_origen_all()
    {
        $this->db->select('*');
        $this->db->from('aetn_origen_tipo');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    //AJax get_tipo_causa($id_causa)
    public function get_tipo_causa_all()
    {
        $this->db->select('*');
        $this->db->from('aetn_causa_tipo');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function registrar_corte($data)
    {
        $this->db->insert('aetn_corte_programado', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return $estado;
        }else {
            return FALSE;
        }
    }
    public function anular_corte($nro_programado, $data)
    {
        $this->db->where('NRO_PROGRAMADO', urldecode($nro_programado));
        $this->db->update('aetn_corte_programado', $data);
        return true;
    }
    public function get_detalle_corte($nro_programado)
    {
        $this->db->select('aetn_corte_programado.*,aetn_origen.ORIGEN,aetn_origen.DESCRIPCION AS DESCRIPCION_ORIGEN,aetn_causa.CAUSA,aetn_causa.DESCRIPCION AS DESCRIPCION_CAUSA, aetn_origen_tipo.DESCRIPCION AS DESCRIPCION_ORIGEN_TIPO, aetn_causa_tipo.DESCRIPCION AS DESCRIPCION_CAUSA_TIPO');
        $this->db->from('aetn_corte_programado');
        $this->db->join('aetn_origen', 'aetn_origen.ORIGEN = aetn_corte_programado.COD_ORIGEN');
        $this->db->join('aetn_causa', 'aetn_causa.CAUSA = aetn_corte_programado.COD_CAUSA');
        $this->db->join('aetn_origen_tipo', 'aetn_origen_tipo.ORIGEN_TIPO = aetn_corte_programado.ORIGEN_TIPO');
        $this->db->join('aetn_causa_tipo', 'aetn_causa_tipo.CAUSA_TIPO = aetn_corte_programado.CAUSA_TIPO');
        $this->db->where('aetn_corte_programado.NRO_PROGRAMADO', $nro_programado);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    
    public function modificar_corte($data, $nro_programado)
    {
        $this->db->where('NRO_PROGRAMADO', $nro_programado);
        $this->db->update('aetn_corte_programado', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return true;
        }else {
            return false;
        }
    }
    /********************* LIBRO DE GUARDIA *********************/
    public function listar_libros($postData,$fecha_inicial,$fecha_final)
    {
        $response = array();      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length']; // Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value
      // Custom search filter 
      $searchSemestre = $postData['searchSemestre'];
      ## Search 
      $search_arr = array();
      $searchQuery = "";
      if($searchValue != ''){
          $searchQuery = " (aetn_libro_guardia.NRO_DIARIO like '%".$searchValue."%' or aetn_libro_guardia.NRO_PROGRAMADO like '%".$searchValue."%' or aetn_libro_guardia.TIPO_FALLA like'%".$searchValue."%' or aetn_libro_guardia.COD_ALIMENTADOR like '%".$searchValue."%' or aetn_libro_guardia.COD_PROTECCION like'%".$searchValue."%' or aetn_libro_guardia.FECHA_HORA_INI like '%".$searchValue."%' or aetn_libro_guardia.FECHA_HORA_FIN like'%".$searchValue."%' or aetn_libro_guardia.TIEMPO_INTERRUPCION like'%".$searchValue."%' or aetn_libro_guardia.CONSUM_AFECTADOS like'%".$searchValue."%' or aetn_libro_guardia.OBSERVACION like '%".$searchValue."%' ) ";
      }
      ## Total number of records without filtering
      $this->db->select('count(*) as allcount');
      $this->db->where(array('aetn_libro_guardia.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_libro_guardia.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $this->db->where('aetn_libro_guardia.ESTADO', 'ACTIVO');
      $records = $this->db->get('aetn_libro_guardia')->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('aetn_libro_guardia.ESTADO', 'ACTIVO');
      $this->db->where(array('aetn_libro_guardia.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_libro_guardia.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $records = $this->db->get('aetn_libro_guardia')->result();
      $totalRecordwithFilter = $records[0]->allcount;

      ## Fetch records
      $this->db->select('aetn_libro_guardia.*, aetn_origen_tipo.DESCRIPCION AS DESCRIPCION_ORIGEN_TIPO, aetn_causa_tipo.DESCRIPCION AS DESCRIPCION_CAUSA_TIPO');
        $this->db->from('aetn_libro_guardia');
        $this->db->join('aetn_origen_tipo', 'aetn_origen_tipo.ORIGEN_TIPO = aetn_libro_guardia.ORIGEN_TIPO');
        $this->db->join('aetn_causa_tipo', 'aetn_causa_tipo.CAUSA_TIPO = aetn_libro_guardia.CAUSA_TIPO');
        
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('aetn_libro_guardia.ESTADO', 'ACTIVO');
      $this->db->where(array('aetn_libro_guardia.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_libro_guardia.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $this->db->order_by($columnName, $columnSortOrder);
      $this->db->limit($rowperpage, $start);
      $records = $this->db->get()->result();
      //print_r($records);exit();
      $data = array();
      $number = 1;
      foreach($records as $key => $record ){
        //generar botnes para las acciones
        $button = '';
          $base_url = base_url();
          $jsaction = "Esta seguro de Eliminar el Registro?";

             $button .=' <div class="form-group">';
               if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a href="'.$base_url.'odeco/ver_editar_libro/'.$record->NRO_DIARIO.'/'.$searchSemestre.'" class="btn btn-warning btn-sm"  data-toggle="tooltip" data-placement="left" title="Ver/Editar Registro"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            }
               if($this->permission1->method('manage_supplier','delete')->access()){
                 $button .=' <a href="#" class="btn btn-danger btn-sm" onclick="EliminarLibro('.urlencode($record->NRO_DIARIO).');" data-toggle="tooltip" data-placement="right" title="Anular Registro"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
             }
        $button .='</ul></div>';
        $var = $record->TIEMPO_INTERRUPCION; settype($var, 'string'); $datos = explode('.',$var); 
        $tiempo = (($datos[0]*60) + $datos[1]);
        $nro_programado = ($record->NRO_PROGRAMADO != 0)? $record->NRO_PROGRAMADO:'<span class="text-danger">No Corresponde</span>';
          $data[] = array( 
              "number" => $number,
              "nro_diario"=>$record->NRO_DIARIO,
              "nro_programado"=>$nro_programado,
              "tipo_falla"=>$record->TIPO_FALLA,
              "cod_alimentador"=>$record->COD_ALIMENTADOR,
              "cod_proteccion"=>$record->COD_PROTECCION,
              "fecha_hora_ini"=>date('d/m/Y H:i',strtotime($record->FECHA_HORA_INI)),
              "fecha_hora_fin"=>date('d/m/Y H:i',strtotime($record->FECHA_HORA_FIN)),
              "descripcion_origen"=>$record->DESCRIPCION_ORIGEN_TIPO.' ('.$record->ORIGEN_TIPO.')',
              "descripcion_causa"=>$record->DESCRIPCION_CAUSA_TIPO.' ('.$record->CAUSA_TIPO.')',
              "tiempo_interrump"=>$record->TIEMPO_INTERRUPCION,
              "consum_afectados"=>$record->CONSUM_AFECTADOS,
              "observacion"=>$record->OBSERVACION,
              "fecha_registro"=>date('d/m/Y H:i',strtotime($record->FECHA_REGISTRO)),
              'button'=>$button
          ); 
          $number++;
      }
      ## Response
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
      );
      return $response; 
    }
    public function get_id_libro()
    {        
        $this->db->order_by('NRO_DIARIO', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('aetn_libro_guardia');
        if ($query->num_rows() > 0) {
            $datos = $query->row();
            $id_mas = ($datos->NRO_DIARIO)+1;
            $last_id = str_pad($id_mas,5,'0',STR_PAD_LEFT);
            return $last_id;
        }else{
            $id_mas = 1;
            $last_id = str_pad($id_mas,5,'0',STR_PAD_LEFT);
            return $last_id;
        }
    }
    public function get_cortes($fecha_inicial,$fecha_final)
    {
        $this->db->select('NRO_PROGRAMADO');
        $this->db->from('aetn_corte_programado'); 
        $this->db->where('ESTADO', 'ACTIVO');
        $this->db->where(array('FECHA_REGISTRO >=' => $fecha_inicial, 'FECHA_REGISTRO <=' => $fecha_final));
        $this->db->order_by('FECHA_REGISTRO', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function registrar_libro($data)
    {
        $this->db->insert('aetn_libro_guardia', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return $estado;
        }else {
            return FALSE;
        }
    }
    
    public function anular_libro($nro_libro, $data)
    {
        $this->db->where('NRO_DIARIO', urldecode($nro_libro));
        $this->db->update('aetn_libro_guardia', $data);
        return true;
    }
    public function get_detalle_libro($nro_diario)
    {
        $this->db->select('aetn_libro_guardia.*,aetn_origen.ORIGEN,aetn_origen.DESCRIPCION AS DESCRIPCION_ORIGEN,aetn_causa.CAUSA,aetn_causa.DESCRIPCION AS DESCRIPCION_CAUSA, aetn_origen_tipo.DESCRIPCION AS DESCRIPCION_ORIGEN_TIPO, aetn_causa_tipo.DESCRIPCION AS DESCRIPCION_CAUSA_TIPO');
        $this->db->from('aetn_libro_guardia');
        $this->db->join('aetn_origen', 'aetn_origen.ORIGEN = aetn_libro_guardia.COD_ORIGEN');
        $this->db->join('aetn_causa', 'aetn_causa.CAUSA = aetn_libro_guardia.COD_CAUSA');
        $this->db->join('aetn_origen_tipo', 'aetn_origen_tipo.ORIGEN_TIPO = aetn_libro_guardia.ORIGEN_TIPO');
        $this->db->join('aetn_causa_tipo', 'aetn_causa_tipo.CAUSA_TIPO = aetn_libro_guardia.CAUSA_TIPO');
        $this->db->where('aetn_libro_guardia.NRO_DIARIO', $nro_diario);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    
    public function modificar_libro($data, $nro_diario)
    {
        $this->db->where('NRO_DIARIO', $nro_diario);
        $this->db->update('aetn_libro_guardia', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return true;
        }else {
            return false;
        }
    } 
    /********************* INTERRUPCIONES *********************/
    public function listar_interrupciones($postData,$fecha_inicial,$fecha_final)
    {
        $response = array();      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length']; // Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value
      // Custom search filter 
      $searchSemestre = $postData['searchSemestre'];
      ## Search 
      $search_arr = array();
      $searchQuery = "";
      if($searchValue != ''){
          $searchQuery = " (aetn_interrupciones.NRO_INTERRUPCION like '%".$searchValue."%' or aetn_interrupciones.NRO_DIARIO like '%".$searchValue."%' or aetn_interrupciones.NRO_PROGRAMADO like '%".$searchValue."%' or aetn_interrupciones.TIPO_FALLA like'%".$searchValue."%' or aetn_interrupciones.COD_ALIMENTADOR like '%".$searchValue."%' or aetn_interrupciones.COD_PROTECCION like'%".$searchValue."%' or aetn_interrupciones.FECHA_HORA_INI like '%".$searchValue."%' or aetn_interrupciones.FECHA_HORA_FIN like'%".$searchValue."%' or aetn_interrupciones.TIEMPO_INTERRUPCION like'%".$searchValue."%' or 
              aetn_interrupciones.CONSUM_BT_1 like'%".$searchValue."%' or aetn_interrupciones.CONSUM_BT_2 like'%".$searchValue."%' or 
              aetn_interrupciones.CONSUM_MT_1 like'%".$searchValue."%' or aetn_interrupciones.CONSUM_MT_2 like'%".$searchValue."%' ) ";
      }
      ## Total number of records without filtering
      $this->db->select('count(*) as allcount');
      $this->db->where(array('aetn_interrupciones.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_interrupciones.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $this->db->where('aetn_interrupciones.ESTADO', 'ACTIVO');
      $records = $this->db->get('aetn_interrupciones')->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('aetn_interrupciones.ESTADO', 'ACTIVO');
      $this->db->where(array('aetn_interrupciones.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_interrupciones.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $records = $this->db->get('aetn_interrupciones')->result();
      $totalRecordwithFilter = $records[0]->allcount;

      ## Fetch records
      $this->db->select('aetn_interrupciones.*, aetn_origen_tipo.DESCRIPCION AS DESCRIPCION_ORIGEN_TIPO, aetn_causa_tipo.DESCRIPCION AS DESCRIPCION_CAUSA_TIPO');
        $this->db->from('aetn_interrupciones');
        $this->db->join('aetn_origen_tipo', 'aetn_origen_tipo.ORIGEN_TIPO = aetn_interrupciones.ORIGEN_TIPO');
        $this->db->join('aetn_causa_tipo', 'aetn_causa_tipo.CAUSA_TIPO = aetn_interrupciones.CAUSA_TIPO');
        
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('aetn_interrupciones.ESTADO', 'ACTIVO');
      $this->db->where(array('aetn_interrupciones.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_interrupciones.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $this->db->order_by($columnName, $columnSortOrder);
      $this->db->limit($rowperpage, $start);
      $records = $this->db->get()->result();
      //print_r($records);exit();
      $data = array();
      $number = 1;
      foreach($records as $key => $record ){
        //generar botnes para las acciones
        $button = '';
          $base_url = base_url();
          $jsaction = "Esta seguro de Eliminar el Registro?";

             $button .=' <div class="form-group">';
               if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a href="'.$base_url.'odeco/ver_editar_interrupcion/'.$record->NRO_INTERRUPCION.'/'.$searchSemestre.'" class="btn btn-warning btn-sm"  data-toggle="tooltip" data-placement="left" title="Ver/Editar Registro"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            }
               if($this->permission1->method('manage_supplier','delete')->access()){
                 $button .=' <a href="#" class="btn btn-danger btn-sm" onclick="EliminarInterrupcion('.urlencode($record->NRO_INTERRUPCION).');" data-toggle="tooltip" data-placement="right" title="Anular Registro"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
             }
        $button .='</ul></div>';
          $data[] = array( 
              "number" => $number,
              "nro_interrupcion"=>$record->NRO_INTERRUPCION,
              "tipo_falla"=>$record->TIPO_FALLA,
              "cod_alimentador"=>$record->COD_ALIMENTADOR,
              "cod_proteccion"=>$record->COD_PROTECCION,
              "fecha_hora_ini"=>date('d/m/Y H:i',strtotime($record->FECHA_HORA_INI)),
              "fecha_hora_fin"=>date('d/m/Y H:i',strtotime($record->FECHA_HORA_FIN)),
              "descripcion_origen"=>$record->DESCRIPCION_ORIGEN_TIPO.' ('.$record->ORIGEN_TIPO.')',
              "descripcion_causa"=>$record->DESCRIPCION_CAUSA_TIPO.' ('.$record->CAUSA_TIPO.')',
              "tiempo_interrump"=>$record->TIEMPO_INTERRUPCION,
              "consum_bt_1"=>$record->CONSUM_BT_1,
              "consum_bt_2"=>$record->CONSUM_BT_2,
              "consum_mt_1"=>$record->CONSUM_MT_1,
              "consum_mt_2"=>$record->CONSUM_MT_2,
              "fecha_registro"=>date('d/m/Y H:i',strtotime($record->FECHA_REGISTRO)),
              'button'=>$button
          ); 
          $number++;
      }
      ## Response
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
      );
      return $response; 
    }
    public function get_id_interrupciones()
    {        
        $this->db->order_by('NRO_INTERRUPCION', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('aetn_interrupciones');
        if ($query->num_rows() > 0) {
            $datos = $query->row();
            $id_mas = ($datos->NRO_INTERRUPCION)+1;
            $last_id = str_pad($id_mas,5,'0',STR_PAD_LEFT);
            return $last_id;
        }else{
            $id_mas = 1;
            $last_id = str_pad($id_mas,5,'0',STR_PAD_LEFT);
            return $last_id;
        }
    }
    public function get_libros($fecha_inicial,$fecha_final)
    {
        $this->db->select('NRO_DIARIO');
        $this->db->from('aetn_libro_guardia'); 
        $this->db->where('ESTADO', 'ACTIVO');
        $this->db->where(array('FECHA_REGISTRO >=' => $fecha_inicial, 'FECHA_REGISTRO <=' => $fecha_final));
        $this->db->order_by('FECHA_REGISTRO', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    
    public function registrar_interrupcion($data)
    {
        $this->db->insert('aetn_interrupciones', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return $estado;
        }else {
            return FALSE;
        }
    }
    
    public function anular_interrupcion($nro_interrupcion,$data)
    {
        $this->db->where('NRO_INTERRUPCION', urldecode($nro_interrupcion));
        $this->db->update('aetn_interrupciones',$data);
        return true;
    }
    public function get_detalle_interrupcion($nro_interrupcion)
    {
        $this->db->select('aetn_interrupciones.*,aetn_origen.ORIGEN,aetn_origen.DESCRIPCION AS DESCRIPCION_ORIGEN,aetn_causa.CAUSA,aetn_causa.DESCRIPCION AS DESCRIPCION_CAUSA, aetn_origen_tipo.DESCRIPCION AS DESCRIPCION_ORIGEN_TIPO, aetn_causa_tipo.DESCRIPCION AS DESCRIPCION_CAUSA_TIPO');
        $this->db->from('aetn_interrupciones');
        $this->db->join('aetn_origen', 'aetn_origen.ORIGEN = aetn_interrupciones.COD_ORIGEN');
        $this->db->join('aetn_causa', 'aetn_causa.CAUSA = aetn_interrupciones.COD_CAUSA');
        $this->db->join('aetn_origen_tipo', 'aetn_origen_tipo.ORIGEN_TIPO = aetn_interrupciones.ORIGEN_TIPO');
        $this->db->join('aetn_causa_tipo', 'aetn_causa_tipo.CAUSA_TIPO = aetn_interrupciones.CAUSA_TIPO');
        $this->db->where('aetn_interrupciones.NRO_INTERRUPCION', $nro_interrupcion);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    
    public function modificar_interrupcion($data, $nro_interrupcion)
    {
        $this->db->where('NRO_INTERRUPCION', $nro_interrupcion);
        $this->db->update('aetn_interrupciones', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return true;
        }else {
            return false;
        }
    } 
    /********************* RESTITUCIONES DE SUMINISTRO *********************/
    public function listar_restituciones($postData,$fecha_inicial,$fecha_final)
    {
        /*$this->db->select('*');
        $this->db->from('aetn_reposicion_suministros'); 
        $this->db->where('aetn_reposicion_suministros.ESTADO', 'ACTIVO');
        $this->db->order_by('aetn_reposicion_suministros.FECHA_REGISTRO', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;*/
      $response = array();      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length']; // Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value
      // Custom search filter 
      $searchSemestre = $postData['searchSemestre'];
      ## Search 
      $search_arr = array();
      $searchQuery = "";
      if($searchValue != ''){
          $searchQuery = " (aetn_reposicion_suministros.NRO_REPOSICION like '%".$searchValue."%' or aetn_reposicion_suministros.NRO_INTERRUPCION like '%".$searchValue."%' or aetn_reposicion_suministros.COD_PROTECCION like '%".$searchValue."%' or aetn_reposicion_suministros.FECHA_HORA_REPOS like'%".$searchValue."%' or aetn_reposicion_suministros.CONSUM_REP_BT_1 like '%".$searchValue."%' or aetn_reposicion_suministros.CONSUM_REP_BT_2 like'%".$searchValue."%' or aetn_reposicion_suministros.CONSUM_REP_MT_1 like '%".$searchValue."%' or aetn_reposicion_suministros.CONSUM_REP_MT_2 like'%".$searchValue."%' or aetn_reposicion_suministros.KVA_RESPUESTA_BT_1 like '%".$searchValue."%' or aetn_reposicion_suministros.KVA_RESPUESTA_BT_2 like'%".$searchValue."%' or aetn_reposicion_suministros.KVA_RESPUESTA_MT_1 like'%".$searchValue."%' or 
              aetn_reposicion_suministros.KVA_RESPUESTA_MT_2 like'%".$searchValue."%' or aetn_reposicion_suministros.TIEMPO like'%".$searchValue."%' or aetn_reposicion_suministros.MOTIVO like'%".$searchValue."%' or aetn_reposicion_suministros.OBSERVACION like'%".$searchValue."%' ) ";
      }
      ## Total number of records without filtering
      $this->db->select('count(*) as allcount');
      $this->db->where(array('aetn_reposicion_suministros.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_reposicion_suministros.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $this->db->where('aetn_reposicion_suministros.ESTADO', 'ACTIVO');
      $records = $this->db->get('aetn_reposicion_suministros')->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('aetn_reposicion_suministros.ESTADO', 'ACTIVO');
      $this->db->where(array('aetn_reposicion_suministros.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_reposicion_suministros.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $records = $this->db->get('aetn_reposicion_suministros')->result();
      $totalRecordwithFilter = $records[0]->allcount;

      ## Fetch records
      $this->db->select('aetn_reposicion_suministros.*');
        $this->db->from('aetn_reposicion_suministros');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('aetn_reposicion_suministros.ESTADO', 'ACTIVO');
      $this->db->where(array('aetn_reposicion_suministros.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_reposicion_suministros.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $this->db->order_by($columnName, $columnSortOrder);
      $this->db->limit($rowperpage, $start);
      $records = $this->db->get()->result();
      //print_r($records);exit();
      $data = array();
      $number = 1;
      foreach($records as $key => $record ){
        //generar botnes para las acciones
        $button = '';
          $base_url = base_url();
          $jsaction = "Esta seguro de Eliminar el Registro?";

             $button .=' <div class="form-group">';
               if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a href="'.$base_url.'odeco/ver_editar_restitucion/'.$record->NRO_REPOSICION.'/'.$searchSemestre.'" class="btn btn-warning btn-sm"  data-toggle="tooltip" data-placement="left" title="Ver/Editar Registro"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            }
               if($this->permission1->method('manage_supplier','delete')->access()){
                 $button .=' <a href="#" class="btn btn-danger btn-sm" onclick="EliminarRestitucion('.urlencode($record->NRO_REPOSICION).');" data-toggle="tooltip" data-placement="right" title="Anular Registro"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
             }
        $button .='</ul></div>';
          $data[] = array( 
              "number" => $number,
              "nro_reposicion"=>$record->NRO_REPOSICION,
              "nro_interrupcion"=>$record->NRO_INTERRUPCION,
              "cod_proteccion"=>$record->COD_PROTECCION,
              "fecha_hora_repos"=>date('d/m/Y H:i',strtotime($record->FECHA_HORA_REPOS)),
              "consum_rep_bt_1"=>$record->CONSUM_REP_BT_1,
              "consum_rep_bt_2"=>$record->CONSUM_REP_BT_2,
              "consum_rep_mt_1"=>$record->CONSUM_REP_MT_1,
              "consum_rep_mt_2"=>$record->CONSUM_REP_MT_2,
              "kva_respuesta_bt_1"=>$record->KVA_RESPUESTA_BT_1,
              "kva_respuesta_bt_2"=>$record->KVA_RESPUESTA_BT_2,
              "kva_respuesta_mt_1"=>$record->KVA_RESPUESTA_MT_1,
              "kva_respuesta_mt_2"=>$record->KVA_RESPUESTA_MT_2,
              "tiempo"=>$record->TIEMPO,
              "motivo"=>$record->MOTIVO,
              "observacion"=>$record->OBSERVACION,
              "fecha_registro"=>date('d/m/Y H:i',strtotime($record->FECHA_REGISTRO)),
              'button'=>$button
          ); 
          $number++;
      }
      ## Response
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
      );
      return $response; 
    }
    public function get_id_restituciones()
    {        
        $this->db->order_by('NRO_REPOSICION', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('aetn_reposicion_suministros');
        if ($query->num_rows() > 0) {
            $datos = $query->row();
            $id_mas = ($datos->NRO_REPOSICION)+1;
            $last_id = str_pad($id_mas,5,'0',STR_PAD_LEFT);
            return $last_id;
        }else{
            $id_mas = 1;
            $last_id = str_pad($id_mas,5,'0',STR_PAD_LEFT);
            return $last_id;
        }
    }
    public function get_interrupciones($fecha_inicial,$fecha_final)
    {
        $this->db->select('NRO_INTERRUPCION');
        $this->db->from('aetn_interrupciones');
        $this->db->where('ESTADO', 'ACTIVO');
        $this->db->where(array('FECHA_REGISTRO >=' => $fecha_inicial, 'FECHA_REGISTRO <=' => $fecha_final));
        $this->db->order_by('FECHA_REGISTRO', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function get_fecha_interrupcion($nro_interrupcion)
    {
        $this->db->select('FECHA_HORA_INI');
        $this->db->from('aetn_interrupciones');
        $this->db->where('NRO_INTERRUPCION', $nro_interrupcion);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    
    public function registrar_restitucion($data)
    {
        $this->db->insert('aetn_reposicion_suministros', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return $estado;
        }else {
            return FALSE;
        }
    }
    
    public function anular_restitucion($nro_restitucion,$data)
    {
        $this->db->where('NRO_REPOSICION', urldecode($nro_restitucion));
        $this->db->update('aetn_reposicion_suministros',$data);
        return true;
    }
    public function get_detalle_restitucion($nro_restitucion)
    {
        $this->db->select('*');
        $this->db->from('aetn_reposicion_suministros');
        $this->db->where('NRO_REPOSICION', $nro_restitucion);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    
    public function modificar_restitucion($data, $nro_restitucion)
    {
        $this->db->where('NRO_REPOSICION', $nro_restitucion);
        $this->db->update('aetn_reposicion_suministros', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return true;
        }else {
            return false;
        }
    } 
    /********************* RESTITUCIONES DE SUMINISTRO MT*********************/
    public function listar_restituciones_mt($postData,$fecha_inicial,$fecha_final)
    {
        /*$this->db->select('aetn_reposicion_suministros_mt.*,aetn_interrupciones.FECHA_HORA_INI');
        $this->db->from('aetn_reposicion_suministros_mt'); 
        $this->db->join('aetn_interrupciones', 'aetn_interrupciones.NRO_INTERRUPCION = aetn_reposicion_suministros_mt.NRO_INTERRUPCION');
        $this->db->where('aetn_reposicion_suministros_mt.ESTADO', 'ACTIVO');
        $this->db->order_by('aetn_reposicion_suministros_mt.FECHA_REGISTRO', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;*/
        $response = array();      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length']; // Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value
      // Custom search filter 
      $searchSemestre = $postData['searchSemestre'];
      ## Search 
      $search_arr = array();
      $searchQuery = "";
      if($searchValue != ''){
          $searchQuery = " (aetn_reposicion_suministros_mt.NRO_INTERRUPCION like '%".$searchValue."%' or aetn_reposicion_suministros_mt.FECHA_HORA_INI like '%".$searchValue."%' or aetn_reposicion_suministros_mt.NRO_REPOSICION like '%".$searchValue."%' or aetn_reposicion_suministros_mt.NRO_CUENTA like'%".$searchValue."%' or aetn_reposicion_suministros_mt.FECHA_HORA_REPOS like '%".$searchValue."%' or aetn_reposicion_suministros_mt.TIEMPO like'%".$searchValue."%' or aetn_reposicion_suministros_mt.OBSERVACION like '%".$searchValue."%' ) ";
      }
      ## Total number of records without filtering
      $this->db->select('count(*) as allcount');
      $this->db->where(array('aetn_reposicion_suministros_mt.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_reposicion_suministros_mt.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $this->db->where('aetn_reposicion_suministros_mt.ESTADO', 'ACTIVO');
      $records = $this->db->get('aetn_reposicion_suministros_mt')->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('aetn_reposicion_suministros_mt.ESTADO', 'ACTIVO');
      $this->db->where(array('aetn_reposicion_suministros_mt.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_reposicion_suministros_mt.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $records = $this->db->get('aetn_reposicion_suministros_mt')->result();
      $totalRecordwithFilter = $records[0]->allcount;

      ## Fetch records
      $this->db->select('aetn_reposicion_suministros_mt.*,aetn_interrupciones.FECHA_HORA_INI');
        $this->db->from('aetn_reposicion_suministros_mt'); 
        $this->db->join('aetn_interrupciones', 'aetn_interrupciones.NRO_INTERRUPCION = aetn_reposicion_suministros_mt.NRO_INTERRUPCION');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('aetn_reposicion_suministros_mt.ESTADO', 'ACTIVO');
      $this->db->where(array('aetn_reposicion_suministros_mt.FECHA_REGISTRO >=' => $fecha_inicial.' 00:00:00', 'aetn_reposicion_suministros_mt.FECHA_REGISTRO <=' => $fecha_final.' 23:59:59'));
      $this->db->order_by($columnName, $columnSortOrder);
      $this->db->limit($rowperpage, $start);
      $records = $this->db->get()->result();
      //print_r($records);exit();
      $data = array();
      $number = 1;
      foreach($records as $key => $record ){
        //generar botnes para las acciones
        $button = '';
          $base_url = base_url();
          $jsaction = "Esta seguro de Eliminar el Registro?";

             $button .=' <div class="form-group">';
               if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a href="'.$base_url.'odeco/ver_editar_restitucion_mt/'.$record->NRO_REPOSICION.'/'.$searchSemestre.'" class="btn btn-warning btn-sm"  data-toggle="tooltip" data-placement="left" title="Ver/Editar Registro"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            }
               if($this->permission1->method('manage_supplier','delete')->access()){
                 $button .=' <a href="#" class="btn btn-danger btn-sm" onclick="EliminarRestitucion('.urlencode($record->NRO_REPOSICION).');" data-toggle="tooltip" data-placement="right" title="Anular Registro"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
             }
        $button .='</ul></div>';
          $data[] = array( 
              "number" => $number,
              "nro_interrupcion"=>$record->NRO_INTERRUPCION,
              "fecha_hora_int"=>date('d/m/Y H:i',strtotime($record->FECHA_HORA_INI)),
              "nro_reposicion"=>$record->NRO_REPOSICION,
              "nro_cuenta"=>$record->NRO_CUENTA,
              "fecha_hora_repos"=>date('d/m/Y H:i',strtotime($record->FECHA_HORA_REPOS)),
              "tiempo"=>$record->TIEMPO,
              "observacion"=>$record->OBSERVACION,
              "fecha_registro"=>date('d/m/Y H:i',strtotime($record->FECHA_REGISTRO)),
              'button'=>$button
          ); 
          $number++;
      }
      ## Response
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
      );
      return $response; 
    }
    public function get_restituciones($fecha_inicial,$fecha_final)
    {
        $this->db->select('NRO_REPOSICION');
        $this->db->from('aetn_reposicion_suministros');
        $this->db->where('ESTADO', 'ACTIVO');
        $this->db->where(array('FECHA_REGISTRO >=' => $fecha_inicial, 'FECHA_REGISTRO <=' => $fecha_final));
        $this->db->order_by('FECHA_REGISTRO', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function get_abonado() {
        $this->db->select('atcl_abonados.Id_Abonado, atcl_clientes.Nombres');
        $this->db->from('atcl_abonados');
        $this->db->join('atcl_clientes', 'atcl_abonados.Cliente = atcl_clientes.Id_Cliente');
        $this->db->where('atcl_abonados.ESTADO', 'ACTIVO');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function registrar_restitucion_mt($data)
    {
        $this->db->insert('aetn_reposicion_suministros_mt', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return $estado;
        }else {
            return FALSE;
        }
    }
    
    public function anular_restitucion_mt($nro_restitucion, $data)
    {
        $this->db->where('NRO_REPOSICION', urldecode($nro_restitucion));
        $this->db->update('aetn_reposicion_suministros_mt', $data);
        return true;
    }
    public function get_detalle_restitucion_mt($nro_restitucion)
    {
        $this->db->select('*');
        $this->db->from('aetn_reposicion_suministros_mt');
        $this->db->where('NRO_REPOSICION', $nro_restitucion);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    
    public function modificar_restitucion_mt($nro_restitucion, $data)
    {
        $this->db->where('NRO_REPOSICION', $nro_restitucion);
        $this->db->update('aetn_reposicion_suministros_mt', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return true;
        }else {
            return false;
        }
    } 
    /********************* CRONOGRAMA DE INSTALACION DE EQUIPOS PT*********************/
    public function listar_cronogramas()
    {
        $this->db->select('*');
        $this->db->from('aetn_cronograma_equipos');
        $this->db->where('aetn_cronograma_equipos.ESTADO', 'ACTIVO');
        $this->db->order_by('aetn_cronograma_equipos.FECHA_REGISTRO', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function registrar_cronograma($data)
    {
        $this->db->insert('aetn_cronograma_equipos', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return $estado;
        }else {
            return FALSE;
        }
    }
    public function anular_cronograma($cod_ae, $data)
    {
        $this->db->where('CODIGO_AE', urldecode($cod_ae));
        $this->db->update('aetn_cronograma_equipos', $data);
        return true;
    }
    public function get_detalle_cronograma($cod_ae)
    {
        $this->db->select('*');
        $this->db->from('aetn_cronograma_equipos');
        $this->db->where('CODIGO_AE', $cod_ae);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function modificar_cronograma($cod_ae, $data)
    {
        $this->db->where('CODIGO_AE', $cod_ae);
        $this->db->update('aetn_cronograma_equipos', $data);
        return true;
    } 
    /********************* FERIADOS *********************/
    public function listar_feriados1()
    {
        $this->db->select('*');
        $this->db->from('aetn_feriados');
        $this->db->where('ESTADO', 'ACTIVO');
        $this->db->order_by('FECHA', 'ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    // Get DataTable data
    function listar_feriados($postData=null){

      $response = array();

      ## Read value
      $draw = $postData['draw'];
      $start = $postData['start'];
      $rowperpage = $postData['length']; // Rows display per page
      $columnIndex = $postData['order'][0]['column']; // Column index
      $columnName = $postData['columns'][$columnIndex]['data']; // Column name
      $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
      $searchValue = $postData['search']['value']; // Search value

      // Custom search filter 
      $searchAnio = $postData['searchAnio'];
      //print_r($searchAnio);
      ## Search 
      $search_arr = array();
      $searchQuery = "";
      $otro = '';
      if($searchValue != ''){
          $otro = " and (DESCRIPCION like '%".$searchValue."%' or  
                FECHA like'%".$searchValue."%' ) ";
      }
      if($searchAnio != ''){
          $searchQuery = " YEAR(FECHA) = '".$searchAnio."' ";
      }
      //if(count($search_arr) > 0){
          $searchQuery .= $otro;
      //}
      //print_r($searchQuery);exit();
      ## Total number of records without filtering
      $this->db->select('count(*) as allcount');
      $this->db->where($searchQuery);
      $this->db->where('ESTADO', 'ACTIVO');
      $records = $this->db->get('aetn_feriados')->result();
      $totalRecords = $records[0]->allcount;

      ## Total number of record with filtering
      $this->db->select('count(*) as allcount');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('ESTADO', 'ACTIVO');
      $records = $this->db->get('aetn_feriados')->result();
      $totalRecordwithFilter = $records[0]->allcount;
      ## Fetch records
      $this->db->select('*');
      if($searchQuery != '')
      $this->db->where($searchQuery);
      $this->db->where('ESTADO', 'ACTIVO');
      $this->db->order_by($columnName, $columnSortOrder);
      $this->db->limit($rowperpage, $start);
      $records = $this->db->get('aetn_feriados')->result();
      //print_r($records);exit();
      $data = array();
      $number = 1;
      foreach($records as $key => $record ){
        //generar botnes para las acciones
        $button = '';
          $base_url = base_url();
          $jsaction = "Esta seguro de Eliminar el Registro?";

             $button .=' <div class="form-group">';
               if($this->permission1->method('manage_supplier','update')->access()){
                $button .=' <a href="'.$base_url.'odeco/ver_editar_feriado/'.$record->ID_FERIADO.'" class="btn btn-warning btn-sm"  data-toggle="tooltip" data-placement="left" title="Ver/Editar Registro"><i class="fa fa-pencil" aria-hidden="true"></i></a>';
            }
               if($this->permission1->method('manage_supplier','delete')->access()){
                 /*$button .=' <a href="'.$base_url.'odeco/anular_feriado/'.$record->ID_FERIADO.'" class="btn btn-danger " onclick="'.$jsaction.'"><i class="fa fa-trash"></i> Eliminar</a>';*/
                 $button .=' <a href="#" class="btn btn-danger btn-sm" onclick="EliminarRegistro('.urlencode($record->ID_FERIADO).');" data-toggle="tooltip" data-placement="right" title="Anular Registro"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
             }
        $button .='</ul></div>';

          $data[] = array( 
              "number" => $number,
              "descripcion"=>$record->DESCRIPCION,
              "fecha"=>date('d/m/Y',strtotime($record->FECHA)),
              'button'=>$button
          ); 
          $number++;
      }
      //print_r($data);exit();
      ## Response
      $response = array(
          "draw" => intval($draw),
          "iTotalRecords" => $totalRecords,
          "iTotalDisplayRecords" => $totalRecordwithFilter,
          "aaData" => $data
      );
      //print_r($response);exit();
      return $response; 
  }
    public function registrar_feriado($data)
    {
        $this->db->insert('aetn_feriados', $data);
        $estado = $this->db->insert_id();
        if (!empty($estado)) {
            return $estado;
        }else {
            return FALSE;
        }
    }
    public function anular_feriado($id_feriado, $data)
    {
        $this->db->where('ID_FERIADO', urldecode($id_feriado));
        $this->db->update('aetn_feriados', $data);
        return true;
    }
    public function get_detalle_feriado($id_feriado)
    {
        $this->db->select('*');
        $this->db->from('aetn_feriados');
        $this->db->where('ID_FERIADO', $id_feriado);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    public function modificar_feriado($id_feriado, $data)
    {
        $this->db->where('ID_FERIADO', $id_feriado);
        $this->db->update('aetn_feriados', $data);
        return true;
    } 
    /********************* INDICADORES DE CALIDAD *********************/
    public function indicadores_individuales($mes_inicial,$mes_final)
    {
        $this->db->select('aetn_reposicion_suministros_mt.*,aetn_interrupciones.FECHA_HORA_INI');
        $this->db->from('aetn_reposicion_suministros_mt'); 
        $this->db->join('aetn_interrupciones', 'aetn_interrupciones.NRO_INTERRUPCION = aetn_reposicion_suministros_mt.NRO_INTERRUPCION');
        //$this->db->where(array('aetn_reposicion_suministros_mt.FECHA_HORA_REC >=' => $mes_inicial, 'aetn_reposicion_suministros_mt.FECHA_HORA_ <=' => $mes_final));
        $this->db->where('aetn_reposicion_suministros_mt.ESTADO', 'ACTIVO');
        $this->db->order_by('aetn_reposicion_suministros_mt.FECHA_REGISTRO', 'desc');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }
    function listarGestiones($empresa_id){
        $this->db->select('ge.gestion');
        $this->db->from('cofi_empresas_gestiones as ge');
        $this->db->where('empresa_id', $empresa_id);
        $res = $this->db->get();
        if ($res->num_rows() > 0) {
            return $res->result_array();
        } else {
            return false;
        }
    }   
    
    /**************************************************************************/
    //Retrieve customer Edit Data
    public function retrieve_category_editdata($category_id) {
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where('category_id', $category_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    //Update Categories
    public function update_category($data, $category_id) {
        $this->db->where('category_id', $category_id);
        $this->db->update('product_category', $data);
        return true;
    }

    // Delete customer Item
    public function delete_category($category_id) {
        $this->db->where('category_id', $category_id);
        $this->db->delete('product_category');
        return true;
    }

}
