<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cga_certificado extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Mga_Certificados');
        $this->load->library('auth');
    }

    //Index page load
    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lga_certificado');
        $content = $CI->lga_certificado->add_form();
        $this->template->full_admin_html_view($content);
    }

    // Update Form
    public function update_form($id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lga_certificado');
        $content = $CI->lga_certificado->edit_data($id);
        $this->template->full_admin_html_view($content);
    }

    //Vista Principal
    public function administrar()
    {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lga_certificado');
        $CI->load->model('Mga_Certificados');
        $content =$this->lga_certificado->list();
        $this->template->full_admin_html_view($content);
    }

    //DataTables
    public function dataList(){
        // GET data
        $this->load->model('Mga_Certificados');
        $postData = $this->input->post();
        $data = $this->Mga_Certificados->getList($postData);
        echo json_encode($data);
    }

    public function print($id){
        $CI = & get_instance();
        $CI->load->model('Mga_Certificados');
        $CI->load->library('pdfgenerator');

        $certificado = $CI->Mga_Certificados->reporte_certificado($id);
        $cliente = $CI->Mga_Certificados->vista_cliente($id);

        $data = array(
            'cliente'  => $cliente,
            'certificados'  => $certificado,
            'id' => $cliente[0]['id'],
            'fotografia' => $cliente[0]['fotografia']
        );

        $content = $this->parser->parse('gestion_asociado/certificado/lista_certificados_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'portrait');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('lista_certificados'.$id, array("Attachment"=>1));
    }

    public function print_certificado($id){
        $CI = & get_instance();
        $CI->load->model('Mga_Certificados');
        $CI->load->library('pdfgenerator');
        $certificado = $CI->Mga_Certificados->reporte_certificado($id);
        $cliente = $CI->Mga_Certificados->reporte_cliente($id);

        /*echo "<pre>";
        print_r($cliente);
        exit;*/
        $data = array(
            'cliente'  => $cliente,
            'certificados'  => $certificado,
            'id' => $cliente[0]['id'],
            'fotografia' => $cliente[0]['fotografia']
        );

        $content = $this->parser->parse('gestion_asociado/certificado/certificado_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'portrait');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('certificado'.$id, array("Attachment"=>1));
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
            gc.codigo like '%".$searchValue."%' 
            or DATE_FORMAT(gc.fecha, '%d-%m-%Y') like'%".$searchValue."%' 
            or DATE_FORMAT(gc.fecha_entrega, '%d-%m-%Y') like'%".$searchValue."%') ";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('ga_certificado gc');
        $this->db->join('ga_suscripcion gs','gs.id = gc.id_suscripcion','left');
        $this->db->where('gs.id_cliente', $idP);
        $this->db->where_in('gc.estado', array('Generado', 'Entregado'));
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('ga_certificado gc');
        $this->db->join('ga_suscripcion gs','gs.id = gc.id_suscripcion','left');
        $this->db->where('gs.id_cliente', $idP);
        $this->db->where_in('gc.estado', array('Generado', 'Entregado'));
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('
        gc.*,
        DATE_FORMAT(gc.fecha, "%d-%m-%Y") as fecha_formato,
        DATE_FORMAT(gc.fecha_entrega, "%d-%m-%Y") as fecha_entrega_formato,
        gs.codigo as codigo_suscripcion');
        $this->db->from('ga_certificado gc');
        $this->db->join('ga_suscripcion gs','gs.id = gc.id_suscripcion','left');
        $this->db->where('gs.id_cliente', $idP);
        $this->db->where_in('gc.estado', array('Generado', 'Entregado'));
        if($searchValue != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();

        foreach($records as $record ){
            $button = '<div align="center">';

            if ($record->estado == 'Generado'){
                $button .=' <a href=" javascript:loadModal( ' . $record->id . ', \'update\' ); " class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title=" Entregar "><i class="ti-wand" aria-hidden="true"></i></a>';
            }

            $button .=' <a href="'. base_url() .'Cga_certificado/print_certificado/'.$record->id.'" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="right" title="Imprimir" target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>';

            $button .= '</div>';

            $data[] = array(
                'id'            =>$record->id,
                'codigo'        =>$record->codigo,
                'fecha'         =>$record->fecha_formato,
                'estado'        =>$record->estado,
                'fecha_entrega' =>$record->fecha_entrega_formato,
                'codigo_suscripcion' =>$record->codigo_suscripcion,
                'button'        =>$button,
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
        $this->load->model('Mga_Certificados');
        $id = $_GET['id'];
        $type = $_GET['type'];

        if($type == 'update'){
            $data['item'] = $this->Mga_Certificados->retrieve_datamodal($id)[0];
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
            $data['idP'] = $_GET['idP'];
        }
        //echo "<pre>"; print_r($data); exit;
        $this->load->view('gestion_asociado/certificado/modal', $data);
    }

    public function update_datatable() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');

        //Preconfiguración de valores
        //Get current date
        $data['fecha_entrega'] = date('Y-m-d');

        //Tipo predefinido
        $data['estado'] = 'Entregado';

        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('ga_certificado', $data);
        }else{
            $this->db->insert('ga_certificado', $data);
        }
        echo 1;
    }

}
