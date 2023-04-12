<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ccortereposicion extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('adquisiciones/Cortereposicion');
        $this->load->library('auth');
        $this->auth->check_admin_auth();
    }

    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('adquisiciones/Lcortereposicion');
        $content = $CI->lcortereposicion->edit_data();

        $this->template->full_admin_html_view($content);
    }

    public function modal_edit(){
        $id = $_GET['id'];
        $type = $_GET['type'];

        $this->load->model('adquisiciones/Cliente');
        $this->load->model('adquisiciones/Abonado');
        $this->load->model('adquisiciones/Abonado');


        $data['clientes'] = $this->Cliente->clientes();
        $data['abonados'] = $this->Abonado->abonados();
        $data['tipos'] = $this->Cortereposicion->tipos();


        if($type == 'update'){
            $data['item'] = $this->Cortereposicion->retrieve_datamodal($id)[0];
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
        }
        $this->load->view('adquisiciones/cortereposicion/modal', $data);
    }

    public function update() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');

        $data['id_usuario'] = $this->session->userdata("user_id");

        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('adq_corte_reposicion', $data);
        }else{

            $data['fecha'] = date("Y-m-d");
            $this->db->insert('adq_corte_reposicion', $data);
        }

        $this->db->affected_rows() != 1 ? $res = 0 : $res = 1;

        echo $res;

    }


    public function delete() {
        $id = $this->input->post('id');

        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('adq_corte_reposicion');
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
        $data = $this->Cortereposicion->getList($postData);
        echo json_encode($data);
    }


    public function print($id){
        $CI = & get_instance();
        $CI->load->model('Cortereposicion');
        $CI->load->library('pdfgenerator');

        $cabecera = $CI->Cortereposicion->impresion_cabecera($id);
        //$detalle = $CI->Ma_Ordenes_compra->impresion_detalle($id);

        $data = array(
            'cabecera'  => $cabecera
            //'detalles'  => $detalle
        );
        /*echo "<pre>";
        var_dump($data);
        exit;*/

        $content = $this->parser->parse('adquisiciones/cortereposicion/formulario_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'portrait');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('adquisiones_formulario_'.$id, array("Attachment"=>1));
    }

}
