<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lmactivos_grupo{
// ========== its for unit add form page load start ===========
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Grupo');
        $CI->load->model('Mactivos_Servicio');
        $list = $CI->Mactivos_Grupo->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Grupo',
            'list' => $list
        );
        $data['servicios'] = $CI->Mactivos_Servicio->dropdown();
        $form = $CI->parser->parse('modulo_activos/grupo/add_form', $data, TRUE);
        return $form;
    }
//============ close ================================

//============ its for  unit_editable_data start==================
    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Grupo');
        $CI->load->model('Mactivos_Servicio');
        $details = $CI->Mactivos_Grupo->retrieve_editdata($id);
        $data = array(
            'title'     => 'Editar grupo',
            'id'   => $details[0]['id'],
            'id_servicio' => $details[0]['id_servicio'],
            'nombre' => $details[0]['nombre'],
            'descripcion'    => $details[0]['descripcion'],
            'estado'    => $details[0]['estado'],
        );
        $data['servicios'] = $CI->Mactivos_Servicio->dropdown();
        $editShow = $CI->parser->parse('modulo_activos/grupo/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
