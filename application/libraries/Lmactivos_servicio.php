<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lmactivos_servicio{
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Servicio');
        $list = $CI->Mactivos_Servicio->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Servicio',
            'list' => $list
        );
        $form = $CI->parser->parse('modulo_activos/servicio/add_form', $data, TRUE);
        return $form;
    }

    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Servicio');
        $details = $CI->Mactivos_Servicio->retrieve_editdata($id);
        $data = array(
            'title'     => 'Editar Servicio',
            'id'   => $details[0]['id'],
            'nombre' => $details[0]['nombre'],
            'estado' => $details[0]['estado'],
            'descripcion' => $details[0]['descripcion'],
        );
        $editShow = $CI->parser->parse('modulo_activos/servicio/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
