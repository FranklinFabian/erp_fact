<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lmactivos_empresa{
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Empresa');
        $list = $CI->Mactivos_Empresa->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Empresa',
            'list' => $list
        );
        $form = $CI->parser->parse('modulo_activos/empresa/add_form', $data, TRUE);
        return $form;
    }

    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Empresa');
        $details = $CI->Mactivos_Empresa->retrieve_editdata($id);
        $data = array(
            'title'     => 'Editar Empresa',
            'id'   => $details[0]['id'],
            'nombre' => $details[0]['nombre'],
            'direccion' => $details[0]['direccion'],
            'telefono' => $details[0]['telefono'],
            'abreviatura' => $details[0]['abreviatura'],
            'estado' => $details[0]['estado'],
            'descripcion' => $details[0]['descripcion'],
        );
        $editShow = $CI->parser->parse('modulo_activos/empresa/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
