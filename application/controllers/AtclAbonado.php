<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AtclAbonado extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');

        $this->load->library('grocery_CRUD');
        $this->load->library('breadcrumb');

        //Breadcrumbs for this controller
        $this->breadcrumb->add('Inicio', base_url());
        $this->breadcrumb->add('Registro de Abonado', base_url('AtclAbonado'));
    }

    public function index()
    {
        $CI = &get_instance();
        $CI->auth->check_admin_auth();
        $data = array();

        $content = $this->parser->parse('atencion_cliente/abonado/index', $data, true);
        $this->template->full_admin_html_view($content);
    }


}
