<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lma_proveedor{
// ========== its for unit add form page load start ===========
    public function add_form(){
        $CI = & get_instance();
        $CI->load->model('Ma_Proveedores');
        $CI->load->model('Ma_Departamentos');
        $list = $CI->Ma_Proveedores->list();
        $i = 0;
        if(!empty($list)){
            foreach ($list as $keys => $values){
                $i++;
                $list[$keys]['sl'] = $i + $CI->uri->segment(3);
            }
        }
        $data = array(
            'title'     => 'Proveedor',
            'list' => $list
        );
        $data['departamentos'] = $CI->Ma_Departamentos->dropdown();
        $form = $CI->parser->parse('almacen/proveedores/add_form', $data, TRUE);
        return $form;
    }
//============ close ================================

//============ its for  unit_editable_data start==================
    public function editable_data($id){
        $CI = & get_instance();
        $CI->load->model('Ma_Proveedores');
        $CI->load->model('Ma_Departamentos');
        $details = $CI->Ma_Proveedores->retrieve_editdata($id);
        $data = array(
            'title'     => 'Editar proveedor',
            'id'   => $details[0]['id'],
            'nombre' => $details[0]['nombre'],
            'direccion' => $details[0]['direccion'],
            'telefono' => $details[0]['telefono'],
            'correo' => $details[0]['correo'],
            'id_ciudad' => $details[0]['id_ciudad'],
            'nit' => $details[0]['nit'],
            'banco' => $details[0]['banco'],
            'cuenta' => $details[0]['cuenta'],
            'descripcion'    => $details[0]['descripcion'],
        );
        $data['departamentos'] = $CI->Ma_Departamentos->dropdown();
        $editShow = $CI->parser->parse('almacen/proveedores/edit_form', $data, TRUE);
        return $editShow;

    }

}

?>
