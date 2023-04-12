<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Corden extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('adquisiciones/Orden');
        $this->load->library('auth');
        $this->auth->check_admin_auth();
    }

    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('adquisiciones/Lorden');
        $content = $CI->lorden->edit_data();

        $this->template->full_admin_html_view($content);
    }

    public function modal_edit(){
        $id = $_GET['id'];
        $type = $_GET['type'];

        $this->load->model('adquisiciones/Cliente');
        $this->load->model('adquisiciones/Abonado');
        $this->load->model('adquisiciones/Servicio');
        $this->load->model('adquisiciones/EstadoServicio');


        $data['clientes'] = $this->Cliente->clientes();
        $data['abonados'] = $this->Abonado->abonados();
        $data['servicios'] = $this->Servicio->servicios();
        $data['estados_servicio'] = $this->EstadoServicio->estados_servicio();
        $data['estados'] = $this->Orden->estados();
        $data['empleados'] = $this->Orden->empleados();

        if($type == 'update'){
            $data['item'] = $this->Orden->retrieve_datamodal($id)[0];
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
        }
        $this->load->view('adquisiciones/orden/modal', $data);
    }

    public function update() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');

        if ($data['fecha_inicio'] != "")
            $data['fecha_inicio'] = date("Y-m-d", strtotime($data['fecha_inicio']));

        if ($data['fecha_fin'] != "")
            $data['fecha_fin'] = date("Y-m-d", strtotime($data['fecha_fin']));

        $data['id_usuario'] = $this->session->userdata("user_id");

        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('adq_orden_servicio', $data);
        }else{

            $data['fecha_registro'] = date("Y-m-d");
            $this->db->insert('adq_orden_servicio', $data);
        }

        $this->db->affected_rows() != 1 ? $res = 0 : $res = 1;

        echo $res;

    }


    public function delete() {
        $id = $this->input->post('id');

        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('adq_orden_servicio');
        if ( $this->db->error()['code'] == 0 ){
            $res = 1;
        }else{
            $res = 0;
        }

        echo $res;
    }

    //DataTables
    public function dataList(){
        $postData = $this->input->post();
        $data = $this->Orden->getList($postData);
        echo json_encode($data);
    }


    public function print($id){
        $CI = & get_instance();
        $CI->load->model('Orden');
        $CI->load->library('pdfgenerator');

        $cabecera = $CI->Orden->impresion_cabecera($id);
        //$detalle = $CI->Ma_Ordenes_compra->impresion_detalle($id);

        $data = array(
            'cabecera'  => $cabecera
            //'detalles'  => $detalle
        );
        /*echo "<pre>";
        var_dump($data);
        exit;*/

        $content = $this->parser->parse('adquisiciones/orden/formulario_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'portrait');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('adquisiones_orden_servicio_'.$id, array("Attachment"=>1));
    }

    public function printtcpdf($id) {
        $CI = & get_instance();
        $CI->load->model('Orden');

        // Cargar la librería TCPDF
        $CI->load->library('tcpdf');

        // Obtener los datos de la cabecera
        $cabecera = $CI->Orden->impresion_cabecera($id);

        // Generar el contenido del PDF
        $data = array(
            'cabecera' => $cabecera,

        );
        $content = $CI->parser->parse('adquisiciones/orden/formulario_pdf', $data, true);

        // Configurar las opciones de TCPDF
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Adquisiciones Orden Servicio ' . $id);
        $pdf->SetSubject('Adquisiciones Orden Servicio ' . $id);
        $pdf->SetFont('helvetica', '', 12);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->AddPage();

        // Agregar el contenido al PDF
        $pdf->writeHTML($content, true, false, true, false, '');

        // Generar el PDF y descargarlo
        $pdf->Output('adquisiones_orden_servicio_' . $id . '.pdf', 'D');
    }

}



