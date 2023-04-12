<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lmactivos_ubicacion{
// ========== its for unit add form page load start ===========
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Ubicacion');
        $CI->load->model('Mactivos_Lugar');
        $list = $CI->Mactivos_Ubicacion->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Ubicacion',
            'list' => $list
        );
        $data['lugares'] = $CI->Mactivos_Lugar->dropdown();
        $form = $CI->parser->parse('modulo_activos/ubicacion/add_form', $data, TRUE);
        return $form;
    }
//============ close ================================

//============ its for  unit_editable_data start==================
    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Mactivos_Ubicacion');
        $CI->load->model('Mactivos_Lugar');
        $details = $CI->Mactivos_Ubicacion->retrieve_editdata($id);
        $data = array(
            'title'     => 'Editar ubicación',
            'id'   => $details[0]['id'],
            'id_lugar' => $details[0]['id_lugar'],
            'nombre' => $details[0]['nombre'],
            'descripcion'    => $details[0]['descripcion'],
            'estado'    => $details[0]['estado'],
        );
        $data['lugares'] = $CI->Mactivos_Lugar->dropdown();
        $editShow = $CI->parser->parse('modulo_activos/ubicacion/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
