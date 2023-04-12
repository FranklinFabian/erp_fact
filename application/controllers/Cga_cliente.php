<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cga_cliente extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Mga_Clientes');
        $this->load->library('auth');
    }

    //Index page load
    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lga_cliente');
        $content = $CI->lga_cliente->add_form();
        $this->template->full_admin_html_view($content);
    }

    //Insertar ingresos
    public function insert() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lga_cliente');
        $this->load->library('upload');

        //Get current correlative
        $correlativo = $this->db->get_where("ga_correlativo",array('nombre' => 'cliente'))->row_array();
        $correlativo_formateado = $correlativo['formato']. str_pad($correlativo['numero'], 5, '0', STR_PAD_LEFT);

        //echo "<pre>"; print_r($correlativo_formateado); exit;

        //Conversion de fecha
        $fecha_nacimiento = new DateTime($this->input->post('fecha_nacimiento'));
        $fecha_nacimiento = $fecha_nacimiento->format('Y-m-d');

        $fecha_registro = new DateTime($this->input->post('fecha_registro'));
        $fecha_registro = $fecha_registro->format('Y-m-d');

        //Validación de blancos
        if ($this->input->post('id_profesion') == ""){
            $id_profesion = null;
        }else{
            $id_profesion = $this->input->post('id_profesion');
        }

        if ($this->input->post('id_ocupacion') == ""){
            $id_ocupacion = null;
        }else{
            $id_ocupacion = $this->input->post('id_ocupacion');
        }

        if ($this->input->post('id_nivel_educacion') == ""){
            $id_nivel_educacion = null;
        }else{
            $id_nivel_educacion = $this->input->post('id_nivel_educacion');
        }

        if ($_FILES['fotografia']['name'])
            $fotografia = 1;

        $data = array(
            'codigo'    => $correlativo_formateado,
            'ci' => $this->input->post('ci'),
            'id_expedido' => $this->input->post('id_expedido'),
            'razon_social' => $this->input->post('razon_social'),
            'fecha_nacimiento' => $fecha_nacimiento,
            'genero' => $this->input->post('genero'),
            'nit' => $this->input->post('nit'),
            'direccion' => $this->input->post('direccion'),
            'telefono' => $this->input->post('telefono'),
            'id_profesion' => $id_profesion,
            'id_ocupacion' => $id_ocupacion ,
            'id_nivel_educacion' => $id_nivel_educacion,
            'numero_dependientes' => $this->input->post('numero_dependientes'),
            'id_estado_civil' => $this->input->post('id_estado_civil'),
            'estado_cliente' => 'pendiente',
            'fecha_registro' => $fecha_registro,
            'tipo_socio' => 'pendiente',
            'fotografia' => $fotografia
        );

        $this->db->insert('ga_cliente', $data);
        $id = $this->db->insert_id();

        if (($_FILES['fotografia']['name'])) {
            $config = array();
            $config['file_name'] = $id;
            $config['upload_path'] = 'assets/uploads/gestion_asociado/';
            $config['allowed_types'] = 'jpg|jpeg';
            $config['max_size'] = '1000000';
            $config['max_width'] = '1024000';
            $config['max_height'] = '768000';
            $config['overwrite'] = true;

            $this->upload->initialize($config);
            $this->upload->do_upload('fotografia');
        }


        //Update correlative
        $correlativo['numero'] = $correlativo['numero'] + 1;

        $actualizar_correlativo = array(
            'numero' => $correlativo['numero']
        );

        $this->db->update('ga_correlativo', $actualizar_correlativo, 'nombre = "cliente"');


        if (isset($_POST['add'])) {
            $this->session->set_userdata(array('message' => 'Insertado exitosamente.'));
            redirect(base_url('Cga_cliente/update_form/' . $id ));
            exit;
        } else {
            redirect(base_url('Cga_cliente/administrar'));
            exit;
        }
    }

    // Update Form
    public function update_form($id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lga_cliente');
        $content = $CI->lga_cliente->edit_data($id);
        $this->template->full_admin_html_view($content);
    }

    // Update
    public function update() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lga_cliente');
        $this->load->library('upload');

        //Get current id
        $id = $this->input->post('id');

        if (($_FILES['fotografia']['name'])) {
            $config = array();
            $config['file_name'] = $id;
            $config['upload_path'] = 'assets/uploads/gestion_asociado/';
            $config['allowed_types'] = 'jpg|jpeg';
            $config['max_size'] = '1000000';
            $config['max_width'] = '1024000';
            $config['max_height'] = '768000';
            $config['overwrite'] = true;

            $this->upload->initialize($config);
            $this->upload->do_upload('fotografia');
            $fotografia = 1;
        }

        //Conversion de fecha
        $fecha_nacimiento = new DateTime($this->input->post('fecha_nacimiento'));
        $fecha_nacimiento = $fecha_nacimiento->format('Y-m-d');

        //Validación de blancos
        if ($this->input->post('id_profesion') == ""){
            $id_profesion = null;
        }else{
            $id_profesion = $this->input->post('id_profesion');
        }

        if ($this->input->post('id_ocupacion') == ""){
            $id_ocupacion = null;
        }else{
            $id_ocupacion = $this->input->post('id_ocupacion');
        }

        if ($this->input->post('id_nivel_educacion') == ""){
            $id_nivel_educacion = null;
        }else{
            $id_nivel_educacion = $this->input->post('id_nivel_educacion');
        }


        $data = array(
            'ci' => $this->input->post('ci'),
            'id_expedido' => $this->input->post('id_expedido'),
            'razon_social' => $this->input->post('razon_social'),
            'fecha_nacimiento' => $fecha_nacimiento,
            'genero' => $this->input->post('genero'),
            'nit' => $this->input->post('nit'),
            'direccion' => $this->input->post('direccion'),
            'telefono' => $this->input->post('telefono'),
            'id_profesion' => $id_profesion,
            'id_ocupacion' => $id_ocupacion,
            'id_nivel_educacion' => $id_nivel_educacion,
            'numero_dependientes' => $this->input->post('numero_dependientes'),
            'id_estado_civil' => $this->input->post('id_estado_civil'),
            'estado_cliente' => $this->input->post('estado_cliente'),
            'tipo_socio' => 'pendiente',
            'fotografia' => $fotografia

        );

        $this->db->update('ga_cliente', $data, "id =". $id);

        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cga_cliente/update_form/' . $id));

    }

    //Vista Principal
    public function administrar()
    {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lga_cliente');
        $CI->load->model('Mga_Clientes');
        $content =$this->lga_cliente->list();
        $this->template->full_admin_html_view($content);
    }

    //DataTables
    public function dataList(){
        // GET data
        $this->load->model('Mga_Clientes');
        $postData = $this->input->post();
        $data = $this->Mga_Clientes->getList($postData);
        echo json_encode($data);
    }

    // Delete
    public function deletePrincipal() {
        $this->db->db_debug = FALSE;
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('ga_cliente');
        if ( $this->db->error()['code'] == 0 ){
            $res = 1;
        }else{
            $res = 0;
        }
        echo $res;
    }

    public function print($id){
        $CI = & get_instance();
        $CI->load->model('Mga_Clientes');
        $CI->load->library('pdfgenerator');

        $ficha = $CI->Mga_Clientes->reporte_ficha($id);
        $data = array(
            'ficha'  => $ficha,
            'id' => $ficha[0]['id'],
            'fotografia' => $ficha[0]['fotografia']
        );

        $content = $this->parser->parse('gestion_asociado/cliente/ficha_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'portrait');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('ficha_cliente'.$id, array("Attachment"=>1));
    }
}
