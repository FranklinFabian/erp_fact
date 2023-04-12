<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lmactivos_unidad{
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Unidad');
        $list = $CI->Mactivos_Unidad->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Unidad',
            'list' => $list
        );
        $form = $CI->parser->parse('modulo_activos/unidad/add_form', $data, TRUE);
        return $form;
    }

    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Unidad');
        $details = $CI->Mactivos_Unidad->retrieve_editdata($id);
        $data = array(
            'title'     => 'Editar Unidad',
            'id'   => $details[0]['id'],
            'nombre' => $details[0]['nombre'],
            'estado' => $details[0]['estado'],
            'descripcion' => $details[0]['descripcion'],
        );
        $editShow = $CI->parser->parse('modulo_activos/unidad/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
