<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lga_cliente {
    /*
     * * Retrieve  Quize List From DB 
     */
    public function list()
    {
        $CI =& get_instance();
        $data['var']    = 0;
        $list = $CI->parser->parse('gestion_asociado/cliente/lista',$data,true);
        return $list;
    }

    //Sub Category Add
    public function add_form() {
        $CI = & get_instance();
        $CI->load->model('Mga_Departamentos');
        $CI->load->model('Mga_Profesiones');
        $CI->load->model('Mga_Ocupaciones');
        $CI->load->model('Mga_Niveles_educacion');
        $CI->load->model('Mga_Estados_civiles');

        //Catalogos
        $data['departamentos'] = $CI->Mga_Departamentos->list();
        $data['profesiones'] = $CI->Mga_Profesiones->list();
        $data['ocupaciones'] = $CI->Mga_Ocupaciones->list();
        $data['niveles_educacion'] = $CI->Mga_Niveles_educacion->list();
        $data['estados_civiles'] = $CI->Mga_Estados_civiles->list();
        $form = $CI->parser->parse('gestion_asociado/cliente/add_form', $data, true);
        return $form;
    }

    //Product Edit Data
    public function edit_data($id) {
        $CI = & get_instance();
        $CI->load->model('Mga_Departamentos');
        $CI->load->model('Mga_Profesiones');
        $CI->load->model('Mga_Ocupaciones');
        $CI->load->model('Mga_Niveles_educacion');
        $CI->load->model('Mga_Estados_civiles');
        $CI->load->model('Mga_Clientes');

        $cliente = $CI->Mga_Clientes->retrieve_data_form($id);
        //Catalogos
        $data['departamentos'] = $CI->Mga_Departamentos->list();
        $data['profesiones'] = $CI->Mga_Profesiones->list();
        $data['ocupaciones'] = $CI->Mga_Ocupaciones->list();
        $data['niveles_educacion'] = $CI->Mga_Niveles_educacion->list();
        $data['estados_civiles'] = $CI->Mga_Estados_civiles->list();

        //Genero
        $data['generos'][0]['id'] = 'Femenino';
        $data['generos'][0]['nombre'] = 'Femenino';
        $data['generos'][1]['id'] = 'Masculino';
        $data['generos'][1]['nombre'] = 'Masculino';

        //Estado cliente
        $data['estados_clientes'][0]['id'] = 'Pendiente';
        $data['estados_clientes'][0]['nombre'] = 'Pendiente';
        $data['estados_clientes'][1]['id'] = 'Aprobado';
        $data['estados_clientes'][1]['nombre'] = 'Aprobado';
        $data['estados_clientes'][2]['id'] = 'Anulado';
        $data['estados_clientes'][2]['nombre'] = 'Anulado';

        //Data
        $data['title']                 = "Editar cliente";
        $data['id']                    = $cliente[0]['id'];
        $data['ci']                    = $cliente[0]['ci'];
        $data['id_expedido']           = $cliente[0]['id_expedido'];
        $data['razon_social']          = $cliente[0]['razon_social'];
        $data['fecha_nacimiento']      = $cliente[0]['fecha_nacimiento'];
        $data['genero']                = $cliente[0]['genero'];
        $data['nit']                   = $cliente[0]['nit'];
        $data['direccion']             = $cliente[0]['direccion'];
        $data['telefono']              = $cliente[0]['telefono'];
        $data['id_profesion']          = $cliente[0]['id_profesion'];
        $data['id_ocupacion']          = $cliente[0]['id_ocupacion'];
        $data['id_nivel_educacion']    = $cliente[0]['id_nivel_educacion'];
        $data['numero_dependientes']   = $cliente[0]['numero_dependientes'];
        $data['id_estado_civil']       = $cliente[0]['id_estado_civil'];
        $data['estado_cliente']       = $cliente[0]['estado_cliente'];
        $res = $CI->parser->parse('gestion_asociado/cliente/edit_form', $data, true);

        return $res;
    }



}

?>
