<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lmactivos_tipo_responsable{
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Tipo_Responsable');
        $list = $CI->Mactivos_Tipo_Responsable->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Tipo de Responsable',
            'list' => $list
        );
        $form = $CI->parser->parse('modulo_activos/tipo_responsable/add_form', $data, TRUE);
        return $form;
    }

    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Tipo_Responsable');
        $details = $CI->Mactivos_Tipo_Responsable->retrieve_editdata($id);
        $data = array(
            'title'     => 'Editar Tipo de Responsable',
            'id'   => $details[0]['id'],
            'nombre' => $details[0]['nombre'],
            'estado' => $details[0]['estado'],
            'descripcion' => $details[0]['descripcion'],
        );
        $editShow = $CI->parser->parse('modulo_activos/tipo_responsable/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
