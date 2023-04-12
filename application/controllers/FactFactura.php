<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FactFactura extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');

        $this->load->library('grocery_CRUD');
        $this->load->model('Fact_Emision_model');


        //Breadcrumbs for this controller
        $this->breadcrumb->add('Inicio', base_url());
        $this->breadcrumb->add('Factura', base_url('FactFactura'));
    }

    public function index()
    {
        $CI = &get_instance();
        $CI->auth->check_admin_auth();

        $data = array(
            'emision' => Fact_Emision_model::where('Abierto', '1')->get()->first()
        );
        $content = $CI->parser->parse('atencion_cliente/deuda/index', $data, true);
        $this->template->full_admin_html_view($content);
    }

    public function generar()
    {
        $id_abonado = $this->input->post('abonado');
        $id_emision = $this->input->post('emision');

        $CI = &get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('factgenerafactura');

        $userid = $this->session->user_id;

        $data = $CI->factgenerafactura->calcular_deudas($id_abonado, $id_emision, $userid);

        if ($data['error']) {
            $this->session->set_flashdata('error_message', $data['msg']);
        } else {
            $this->session->set_flashdata('message', $data['msg']);
        }
        redirect("FactFactura");
    }


}
