<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lmactivos_lugar{
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Lugar');
        $list = $CI->Mactivos_Lugar->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Lugar',
            'list' => $list
        );
        $form = $CI->parser->parse('modulo_activos/lugar/add_form', $data, TRUE);
        return $form;
    }

    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Lugar');
        $details = $CI->Mactivos_Lugar->retrieve_editdata($id);
        $data = array(
            'title'     => 'Editar Lugar',
            'id'   => $details[0]['id'],
            'nombre' => $details[0]['nombre'],
            'estado' => $details[0]['estado'],
            'descripcion' => $details[0]['descripcion'],
        );
        $editShow = $CI->parser->parse('modulo_activos/lugar/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
