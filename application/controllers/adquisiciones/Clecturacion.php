<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Clecturacion extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('adquisiciones/Lecturacion');
         $this->load->library('auth');
    }

    //Index page load
  /*  public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_orden_compra');
        $content = $CI->lma_orden_compra->add_form();
        $this->template->full_admin_html_view($content);
    }*/

    //Insertar ingresos
    public function insert() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_orden_compra');

        //Get current correlative
        $correlativo = $this->db->get_where("almacen_correlativo",array('nombre' => 'orden_compra'))->row_array();
        $correlativo_formateado = $correlativo['formato'] . str_pad($correlativo['numero'], 5, '0', STR_PAD_LEFT);

        //Conversion de fecha
        $date = new DateTime($this->input->post('fecha'));
        $fecha = $date->format('Y-m-d');

        $cabecera = array(
            'id_usuario'    => $this->session->user_id,
            'codigo' => $correlativo_formateado,
            'fecha' => $fecha,
            'id_proveedor' => $this->input->post('id_proveedor'),
            'observacion' => $this->input->post('observacion')
        );

        $this->db->insert('almacen_cabecera_orden_compra', $cabecera);
        $id_cabecera = $this->db->insert_id();

        //Update correlative
        $correlativo['numero'] = $correlativo['numero'] + 1;

        $actualizar_correlativo = array(
            'numero' => $correlativo['numero']
        );

        $this->db->update('almacen_correlativo', $actualizar_correlativo, 'nombre = "orden_compra"');


        if (isset($_POST['add'])) {
            $this->session->set_userdata(array('message' => 'Insertado exitosamente.'));
            redirect(base_url('Cma_orden_compra/update_form/' . $id_cabecera ));
            exit;
        } else {
            redirect(base_url('Cma_orden_compra/administrar'));
            exit;
        }
    }

    // Update Form
    public function update_form($id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('adquisiciones/Llecturacion');
        $content = $CI->llecturacion->edit_data($id);
        $this->template->full_admin_html_view($content);
    }

    // Update
    public function update() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Ma_Ordenes_compra');

        $id = $this->input->post('id');

        //Cabecera Ingreso
        $observacion = $this->input->post('observacion');

        //Conversion de fecha
        $date = new DateTime($this->input->post('fecha'));
        $fecha = $date->format('Y-m-d');

        $cabecera = array(
            'fecha'    => $fecha,
            'id_proveedor' => $this->input->post('id_proveedor'),
            'observacion' => $observacion
        );

        $this->db->update('almacen_cabecera_orden_compra', $cabecera, "id =". $id);

        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cma_orden_compra/update_form/' . $id));

    }




    //Vista Principal
    public function index()
    {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('adquisiciones/Llecturacion');
        $CI->load->model('Lecturacion');
        $content =$this->llecturacion->list();
        $this->template->full_admin_html_view($content);
    }

    //DataTables
    public function dataList(){
        // GET data
        $postData = $this->input->post();
        $data = $this->Lecturacion->getList($postData);
        echo json_encode($data);
    }

    // Delete
   /* public function deletePadre() {
        $id = $this->input->post('id');

        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('adq_categoria');
        if ( $this->db->error()['code'] == 0 ){
            $res = 1;
        }else{
            $res = 0;
        }

        echo $res;
    }*/

    public function print($id){
        $CI = & get_instance();
        $CI->load->library('pdfgenerator');

        $cabecera = $CI->Lecturacion->impresion_cabecera($id);
        $detalle = $CI->Lecturacion->impresion_detalle($id);

        $data = array(
            'cabecera'  => $cabecera,
            'detalles'  => $detalle
        );

        /*echo "<pre>";
        print_r($data);
        exit;*/

        $content = $this->parser->parse('adquisiciones/lecturacion/formulario_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'landscape');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('adquisiciones_lecturacion_'.$id, array("Attachment"=>1));
    }

    //DataTables
    public function dataTable($postData=null){
        $id_cabecera = $_POST["id_cabecera"];

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
            $searchQuery = " (DATE_FORMAT(al.fecha, '%d-%m-%Y') like '%".$searchValue."%'
            or al.fecha like '%".$searchValue."%'
            or al.lectura_anterior like '%".$searchValue."%'
            or al.potencia like'%".$searchValue."%'
            or al.lectura_actual like'%".$searchValue."%'
            or al.multiplicador like'%".$searchValue."%'
            or al.consumo like'%".$searchValue."%'
            or aest.nombre like'%".$searchValue."%'
            or asin.nombre like'%".$searchValue."%'
            or aobs.nombre like'%".$searchValue."%'
            or al.observacion like'%".$searchValue."%'
            or al.nota like'%".$searchValue."%'

            )  ";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('adq_lecturacion al');
        $this->db->join('adq_estado aest','aest.id = al.estimado','left');
        $this->db->join('adq_estado asin','asin.id = al.sin_factura','left');
        $this->db->join('adq_estado aobs','aobs.id = al.observada','left');
        $this->db->where('al.id_abonado', $id_cabecera);
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('adq_lecturacion al');
        $this->db->join('adq_estado aest','aest.id = al.estimado','left');
        $this->db->join('adq_estado asin','asin.id = al.sin_factura','left');
        $this->db->join('adq_estado aobs','aobs.id = al.observada','left');
        $this->db->where('al.id_abonado', $id_cabecera);
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('
                al.*,
                aest.nombre as estimado,
                asin.nombre as sin_factura,
                aobs.nombre as observada,
                DATE_FORMAT(al.fecha, "%d-%m-%Y") as fecha,
                ');
        $this->db->from('adq_lecturacion al');
        $this->db->join('adq_estado aest','aest.id = al.estimado','left');
        $this->db->join('adq_estado asin','asin.id = al.sin_factura','left');
        $this->db->join('adq_estado aobs','aobs.id = al.observada','left');
        $this->db->where('al.id_abonado', $id_cabecera);
        if($searchValue != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();

        foreach($records as $record ){
            $button = '<div align="center">';
            $base_url = base_url();

            if($this->permission1->method('administrar_adquisiciones_lecturacion','delete')->access()) {
                    $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
            }

            $button .=' <a href=" javascript:loadModal( ' . $record->id . ', \'update\' ); " class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title=" Editar "><i class="fa fa-pencil" aria-hidden="true"></i></a>';


            $button .= '</div>';

            $data[] = array(
                'id'   =>$record->id,
                'fecha'   =>$record->fecha,
                'lectura_anterior'   =>$record->lectura_anterior,
                'potencia'    =>$record->potencia,
                'lectura_actual'    =>$record->lectura_actual,
                'multiplicador'   =>$record->multiplicador,
                'consumo'   =>$record->consumo,
                'estimado'   =>$record->estimado,
                'sin_factura'   =>$record->sin_factura,
                'observada'   =>$record->observada,
                'observacion'   =>$record->observacion,
                'nota'   =>$record->nota,
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

        echo json_encode($response);
    }

    public function modal_edit(){
        $id = $_GET['id'];
        $type = $_GET['type'];

        $data['estados_estimados'] = $this->Lecturacion->estados();
        $data['estados_facturas'] = $this->Lecturacion->estados();
        $data['estados_observadas'] = $this->Lecturacion->estados();

        if($type == 'update'){
            $data['item'] = $this->Lecturacion->retrieve_datamodal($id)[0];
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
            $data['idP'] = $_GET['idP'];
        }

        $this->load->view('adquisiciones/lecturacion/modal', $data);
    }

    public function update_datatable() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');

        //$data['costo'] = floatval(str_replace(',', '.', str_replace('.', '', $data['costo'])));


        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('adq_lecturacion', $data);
        }else{
            $data['id_usuario'] = $this->session->userdata("user_id");
            $data['fecha'] = date("Y-m-d");
            $this->db->insert('adq_lecturacion', $data);
        }

    echo 1;

    }


    public function deleteHijo(){
        $id = $this->input->post('id');

        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('adq_lecturacion');
        if ( $this->db->error()['code'] == 0 ){
            $res = 1;
        }else{
            $res = 0;
        }

        echo $res;
    }

}
