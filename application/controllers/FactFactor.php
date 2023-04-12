<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FactFactor extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');

        $this->load->library('grocery_CRUD');
        $this->load->library('breadcrumb');
        $this->load->model('Fact_Factor_model');

        //auth for all this controller
        $this->auth->check_admin_auth();

        //Breadcrumbs for this controller
        $this->breadcrumb->add('Inicio', base_url());
        $this->breadcrumb->add('Factores', base_url('FactFactor'));
    }

    public function index()
    {
        $data = array();

        $content = $this->parser->parse('facturacion/factor/index', $data, true);
        $this->template->full_admin_html_view($content);
    }

    public function agregarFactor()
    {
        $config = array(
            array('field' => 'emision',
                'label' => 'emision',
                'rules' => 'required'
            ),
            array('field' => 'RE_020',
                'label' => 'RE_020',
                'rules' => 'trim|required'
            ),
            array('field' => 'RE_100',
                'label' => 'RE_100',
                'rules' => 'trim|required'
            ),
            array('field' => 'RE_ADE',
                'label' => 'RE_ADE',
                'rules' => 'trim|required'
            ),
            array('field' => 'GE_020',
                'label' => 'GE_020',
                'rules' => 'trim|required'
            ),
            array('field' => 'GE_100',
                'label' => 'GE_100',
                'rules' => 'trim|required'
            ),
            array('field' => 'GE_ADE',
                'label' => 'GE_ADE',
                'rules' => 'trim|required'
            ),
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'emision' => form_error('emision'),
                'RE_020' => form_error('RE_020'),
                'RE_100' => form_error('RE_100'),
                'RE_ADE' => form_error('RE_ADE'),
                'GE_020' => form_error('GE_020'),
                'GE_100' => form_error('GE_100'),
                'GE_ADE' => form_error('GE_ADE'),
            );

        } else {
            $data = array(
                'Emision' => $this->input->post('emision'),
                'RE_020' => $this->input->post('RE_020'),
                'RE_100' => $this->input->post('RE_100'),
                'RE_ADE' => $this->input->post('RE_ADE'),
                'GE_020' => $this->input->post('GE_020'),
                'GE_100' => $this->input->post('GE_100'),
                'GE_ADE' => $this->input->post('GE_ADE'),
            );
            if ($this->Fact_Factor_model->insert($data)) {
                $result['error'] = false;
                $result['msg'] = 'Usuario agregado satisfactoriamente';
            }

        }
        echo json_encode($result);
    }

    
}
