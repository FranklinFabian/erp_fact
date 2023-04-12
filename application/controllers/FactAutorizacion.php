<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FactAutorizacion extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');

        $this->load->library('grocery_CRUD');
        $this->load->library('breadcrumb');

        //Breadcrumbs for this controller
        $this->breadcrumb->add('Inicio', base_url());
        $this->breadcrumb->add('Autorización', base_url('FactAutorizacion'));
    }

    public function index()
    {
        $CI = &get_instance();
        $CI->auth->check_admin_auth();

        $crud = new grocery_CRUD();

        $crud->set_theme('flexigrid');

        $crud->set_table('fact_autorizaciones');
        $crud->set_subject('Autorización', 'Autorizaciones');
        $crud->columns('Autorizacion', 'Llave', 'Fecha_Inicial', 'Fecha_Final', 'Factura_Inicial', 'Estado', '_Creado_Por');
        // editando el registro
        $state = $crud->getState();
        if ($state == 'edit' || $state == 'update' || $state == 'update_validation') {
            $crud->columns('Autorizacion', 'Llave', 'Fecha_Inicial', 'Fecha_Final', 'Factura_Inicial', 'Estado', '_Actualizado_Por');
        }
        if ($state == 'ajax_list' || $state == 'list' || $state == 'success') {
            $crud->set_primary_key('user_id', 'users');
            $crud->set_relation('_Creado_Por', 'users', 'first_name');
        }
        else {
            $crud->fields('Autorizacion', 'Llave', 'Fecha_Inicial', 'Fecha_Final', 'Factura_Inicial', 'Estado', '_Creado_Por');
            $crud->set_rules('Autorizacion', 'Autorizacion', 'required');
            $crud->set_rules('Llave', 'Llave', 'required');
            $crud->set_rules('Fecha_Inicial', 'Fecha_Inicial', 'required');
            $crud->set_rules('Fecha_Final', 'Fecha_Final', 'required');
            $crud->set_rules('Factura_Inicial', 'Factura_Inicial', 'required');
        }

        $crud->field_type('_Creado_Por', 'hidden');
        $crud->field_type('_Actualizado_Por', 'hidden');

        $crud->callback_before_insert(array($this, 'autorizacion_before_i_callback'));
        $crud->callback_before_update(array($this, 'autorizacion_before_u_callback'));

        $crud->unset_jquery();
        $crud->unset_bootstrap();
        $crud->unset_clone();
        $crud->unset_read();

        $output = $crud->render();

        $data['grocery_crud'] = json_encode($output);

        $content = $CI->parser->parse('grocery_index', $data, true);

        $this->template->full_admin_html_view($content);
    }

    function autorizacion_before_i_callback($post_array, $pk = null)
    {
        $post_array['_Creado_Por'] = $this->session->userdata('user_id');

        return $post_array;
    }

    function autorizacion_before_u_callback($post_array, $pk = null)
    {
        $post_array['_Actualizado_Por'] = $this->session->userdata('user_id');

        return $post_array;
    }

}
