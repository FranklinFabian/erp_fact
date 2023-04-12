<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cga_suscripcion extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Mga_Suscripciones');
        $this->load->library('auth');
    }

    //Index page load
    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lga_suscripcion');
        $content = $CI->lga_suscripcion->add_form();
        $this->template->full_admin_html_view($content);
    }

    // Update Form
    public function update_form($id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lga_suscripcion');
        $content = $CI->lga_suscripcion->edit_data($id);
        $this->template->full_admin_html_view($content);
    }

    //Vista Principal
    public function administrar()
    {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lga_suscripcion');
        $CI->load->model('Mga_Suscripciones');
        $content =$this->lga_suscripcion->list();
        $this->template->full_admin_html_view($content);
    }

    //DataTables
    public function dataList(){
        // GET data
        $this->load->model('Mga_Suscripciones');
        $postData = $this->input->post();
        $data = $this->Mga_Suscripciones->getList($postData);
        echo json_encode($data);
    }

    public function print($id){
        $CI = & get_instance();
        $CI->load->model('Mga_Suscripciones');
        $CI->load->library('pdfgenerator');

        $cliente = $CI->Mga_Suscripciones->reporte_ficha_cliente($id);
        $suscripcion = $CI->Mga_Suscripciones->reporte_ficha_suscripcion($id);
        $data = array(
            'cliente'  => $cliente,
            'suscripciones'  => $suscripcion,
            'id' => $cliente[0]['id'],
            'fotografia' => $cliente[0]['fotografia']
        );

        $content = $this->parser->parse('gestion_asociado/suscripcion/ficha_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'portrait');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('ficha_suscripcion'.$id, array("Attachment"=>1));
    }

    //DataTables
    public function dataTable($postData=null){
        $idP = $_POST["idP"];

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
            codigo like '%".$searchValue."%' 
            or nota like'%".$searchValue."%'
            or DATE_FORMAT(fecha, '%d-%m-%Y') like'%".$searchValue."%' 
            or tipo like'%".$searchValue."%') ";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('ga_suscripcion m');
        $this->db->where('id_cliente', $idP);
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('ga_suscripcion m');
        $this->db->where('id_cliente', $idP);
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('*, DATE_FORMAT(fecha, "%d-%m-%Y") as fecha_formato');
        $this->db->from('ga_suscripcion m');
        $this->db->where('id_cliente', $idP);
        if($searchValue != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();

        foreach($records as $record ){
            $button = '<div align="center">';

            if($this->permission1->method('administrar_gestion_asociado_suscripcion','delete')->access()) {
                    $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
            }
            $button .=' <a href=" javascript:loadModal( ' . $record->id . ', \'update\' ); " class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title=" Editar "><i class="fa fa-pencil" aria-hidden="true"></i></a>';

            $button .= '</div>';

            $data[] = array(
                'id'   =>$record->id,
                'codigo'   =>$record->codigo,
                'costo'   =>$record->costo,
                'nota'   =>$record->nota,
                'fecha'   =>$record->fecha_formato,
                'tipo'   =>$record->tipo,
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
        $this->load->model('Mga_Suscripciones');
        $id = $_GET['id'];
        $type = $_GET['type'];

        if($type == 'update'){
            $data['item'] = $this->Mga_Suscripciones->retrieve_datamodal($id)[0];
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
            $data['idP'] = $_GET['idP'];
        }
        //echo "<pre>"; print_r($data); exit;
        $this->load->view('gestion_asociado/suscripcion/modal', $data);
    }

    public function update_datatable() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');

        //Preconfiguración de valores
        //Get current value certificado
        $data['costo'] = $this->db->get("ga_valor_certificado")->row()->monto;

        //Get current date
        $data['fecha'] = date('Y-m-d');

        //Tipo predefinido
        $data['tipo'] = 'Nueva';

        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('ga_suscripcion', $data);
        }else{
            //Get current correlative
            $correlativo = $this->db->get_where("ga_correlativo",array('nombre' => 'suscripcion'))->row_array();
            $data['codigo'] = $correlativo['formato']. str_pad($correlativo['numero'], 5, '0', STR_PAD_LEFT);

            $this->db->insert('ga_suscripcion', $data);

            //Update correlative
            $correlativo['numero'] = $correlativo['numero'] + 1;
            $actualizar_correlativo = array(
                'numero' => $correlativo['numero']
            );

            $this->db->update('ga_correlativo', $actualizar_correlativo, 'nombre = "suscripcion"');
        }
        echo 1;
    }

    public function delete(){
        $this->db->db_debug = FALSE;
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('ga_suscripcion');
        if ( $this->db->error()['code'] == 0 ){
            $res = 1;
        }else{
            $res = 0;
        }
        echo $res;
    }
}
