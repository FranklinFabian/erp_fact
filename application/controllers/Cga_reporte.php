<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cga_reporte extends CI_Controller {


    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Mga_Reportes');
        $this->load->library('lga_reporte');
    }


    public function cliente() {
        $content = $this->lga_reporte->add_form_reporte_cliente();
        $this->template->full_admin_html_view($content);
    }


    public function reporte_cliente_pdf(){
        $CI = & get_instance();
        $CI->load->model('Mga_Reportes');
        $CI->load->library('pdfgenerator');

        $datos = $CI->Mga_Reportes->cliente();

        $data = array(
            'datos'  => $datos
        );

        /*echo "<pre>";
        print_r($data); exit;*/

        $content = $this->parser->parse('gestion_asociado/reporte/reporte_cliente_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'landscape');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('reporte_clientes_' . date('d/m/Y'), array("Attachment"=>1));

    }


}
