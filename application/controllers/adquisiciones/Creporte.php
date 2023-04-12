<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Creporte extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('adquisiciones/Reporte');
        $this->load->library('adquisiciones/Lreporte');
        $this->load->library('auth');
        $this->auth->check_admin_auth();
    }


    public function index() {
        $content = $this->lreporte->form();
        $this->template->full_admin_html_view($content);
    }


    public function lista_clientes(){
        $CI = & get_instance();
        $this->load->model('Reporte');
        $CI->load->library('pdfgenerator');

        $detalles = $CI->Reporte->detalle_cliente();

        $data = array(
            'detalles'  => $detalles
        );

        /*echo "<pre>";
        print_r($data); exit;*/

        $content = $this->parser->parse('adquisiciones/reporte/cliente_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'portrait');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('clientes_' . date('d/m/Y') . '.pdf', array("Attachment"=>1));

    }


    public function lista_abonados(){
        $CI = & get_instance();
        $this->load->model('Reporte');
        $CI->load->library('pdfgenerator');

        //Conversiones de fecha
        $date_inicio = new DateTime($this->input->post('fec_inicio'));
        $fecha_inicio = $date_inicio->format('Y-m-d');

        $date_fin = new DateTime($this->input->post('fec_fin'));
        $fecha_fin = $date_fin->format('Y-m-d');



        $detalles = $CI->Reporte->detalle_abonado($fecha_inicio, $fecha_fin);

        $data = array(
            'detalles'  => $detalles,
            'fecha_inicio' => $this->input->post('fec_inicio'),
            'fecha_fin' => $this->input->post('fec_fin')
        );



        $content = $this->parser->parse('adquisiciones/reporte/abonado_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'landscape');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('abonados_' . date('d/m/Y') . '.pdf', array("Attachment"=>1));

    }


    public function lista_ordenes(){
        $CI = & get_instance();
        $this->load->model('Reporte');
        $CI->load->library('pdfgenerator');

        //Conversiones de fecha
        $date_inicio = new DateTime($this->input->post('fec_inicio'));
        $fecha_inicio = $date_inicio->format('Y-m-d');

        $date_fin = new DateTime($this->input->post('fec_fin'));
        $fecha_fin = $date_fin->format('Y-m-d');



        $detalles = $CI->Reporte->detalle_orden($fecha_inicio, $fecha_fin);

        $data = array(
            'detalles'  => $detalles,
            'fecha_inicio' => $this->input->post('fec_inicio'),
            'fecha_fin' => $this->input->post('fec_fin')
        );

        /*echo "<pre>";
        print_r($data); exit;*/


        $content = $this->parser->parse('adquisiciones/reporte/orden_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'landscape');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('ordenes_' . date('d/m/Y') . '.pdf', array("Attachment"=>1));

    }


    public function lista_cortes(){
        $CI = & get_instance();
        $this->load->model('Reporte');
        $CI->load->library('pdfgenerator');

        //Conversiones de fecha
        $date_inicio = new DateTime($this->input->post('fec_inicio'));
        $fecha_inicio = $date_inicio->format('Y-m-d');

        $date_fin = new DateTime($this->input->post('fec_fin'));
        $fecha_fin = $date_fin->format('Y-m-d');



        $detalles = $CI->Reporte->detalle_corte($fecha_inicio, $fecha_fin);

        $data = array(
            'detalles'  => $detalles,
            'fecha_inicio' => $this->input->post('fec_inicio'),
            'fecha_fin' => $this->input->post('fec_fin')
        );

      /*  echo "<pre>";
        print_r($data); exit;*/


        $content = $this->parser->parse('adquisiciones/reporte/corte_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'landscape');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('reportes_' . date('d/m/Y') . '.pdf', array("Attachment"=>1));

    }











}
