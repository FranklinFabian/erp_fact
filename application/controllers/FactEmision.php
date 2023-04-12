<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class FactEmision extends CI_Controller
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

        $crud->set_table('fact_emisiones');
        $crud->set_subject('Emisión', 'Emisiones');
        $crud->columns('Emision', 'Vencimiento', 'Medicion', 'Siguiente_Emision', 'Abierto', '_Creado_Por');
        // editando el registro
        $state = $crud->getState();
        if ($state == 'edit' || $state == 'update' || $state == 'update_validation') {
            $crud->fields('Emision', 'Vencimiento', 'Medicion', 'Siguiente_Emision', 'Abierto', '_Actualizado_Por');
        }
        if ($state == 'ajax_list' || $state == 'list' || $state == 'success') {
            $crud->set_primary_key('user_id', 'users');
            $crud->set_relation('_Creado_Por', 'users', 'first_name');
        } else {
            $crud->fields('Emision', 'Vencimiento', 'Medicion', 'Siguiente_Emision', 'Abierto', '_Creado_Por');
            $crud->set_rules('Emision', 'Emision', 'required');
            $crud->set_rules('Vencimiento', 'Vencimiento', 'required');
        }

        $crud->field_type('_Creado_Por', 'hidden');
        $crud->field_type('_Actualizado_Por', 'hidden');
//        $crud->change_field_type('Abierto','true_false');
        $crud->callback_add_field('Abierto',array($this,'field_callback_radio_button'));
        $crud->callback_edit_field('Abierto',array($this,'field_callback_radio_button'));

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

    function field_callback_radio_button($value)
    {
        if($value == '1') {
            return '<input type="radio" name="Abierto" value=" '.$value.' " checked="checked" /> SI &nbsp;
       <input type="radio"  name="Abierto" value="0" /> No ';
        } else {
            return '<input type="radio" name="Abierto" value="1" /> SI &nbsp;
        <input type="radio" name="Abierto" value="0" checked="checked" /> No';
        }
    }
}
