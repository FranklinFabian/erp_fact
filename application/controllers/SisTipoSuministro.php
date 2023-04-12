<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class SisTipoSuministro extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('grocery_CRUD');
    }

    public function index()
    {
        $CI = &get_instance();
        $CI->auth->check_admin_auth();

        $crud = new grocery_CRUD();

        $crud->set_theme('flexigrid');

        $crud->set_table('sis_tipos_suministros');
        $crud->set_subject('Tipo de Suministro', 'Tipo de Suministros');
        $crud->columns('Tipo_Suministro', '_Creado_Por');
        // editando el registro
        $state = $crud->getState();
        if ($state == 'edit' || $state == 'update' || $state == 'update_validation') {
            $crud->fields('Tipo_Suministro', '_Actualizado_Por');
        }
        if ($state == 'ajax_list' || $state == 'list' || $state == 'success') {
            $crud->set_primary_key('user_id', 'users');
            $crud->set_relation('_Creado_Por', 'users', 'first_name');
        } else {
            $crud->fields('Tipo_Suministro', '_Creado_Por');
            $crud->set_rules('Tipo_Suministro', 'Tipo_Suministro', 'required');
        }

        $crud->field_type('_Creado_Por', 'hidden');
        $crud->field_type('_Actualizado_Por', 'hidden');

        $crud->callback_before_insert(array($this, 'category_before_i_callback'));
        $crud->callback_before_update(array($this, 'category_before_u_callback'));

        $crud->unset_jquery();
        $crud->unset_bootstrap();
        $crud->unset_clone();
        $crud->unset_read();

        $output = $crud->render();

        $data['grocery_crud'] = json_encode($output);

        $content = $CI->parser->parse('grocery_index', $data, true);

        $this->template->full_admin_html_view($content);
    }

    function category_before_i_callback($post_array, $pk = null)
    {
        $post_array['_Creado_Por'] = $this->session->userdata('user_id');

        return $post_array;
    }

    function category_before_u_callback($post_array, $pk = null)
    {
        $post_array['_Actualizado_Por'] = $this->session->userdata('user_id');

        return $post_array;
    }
}
