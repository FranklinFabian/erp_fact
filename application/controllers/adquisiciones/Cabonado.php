<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cabonado extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('adquisiciones/Abonado');
        $this->load->library('auth');
        $this->auth->check_admin_auth();
    }

    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('adquisiciones/Labonado');
        $content = $CI->labonado->edit_data();

        $this->template->full_admin_html_view($content);
    }

    public function modal_edit(){
        $id = $_GET['id'];
        $type = $_GET['type'];

        $this->load->model('adquisiciones/Cliente');
        $this->load->model('adquisiciones/Categoria');
        $this->load->model('adquisiciones/Localidad');
        $this->load->model('adquisiciones/Zona');
        $this->load->model('adquisiciones/CentroTransformacion');
        $this->load->model('adquisiciones/Poste');
        $this->load->model('adquisiciones/Suministro');
        $this->load->model('adquisiciones/Consumidor');
        $this->load->model('adquisiciones/Medicion');
        $this->load->model('adquisiciones/Liberacion');
        $this->load->model('adquisiciones/Distancia');
        $this->load->model('adquisiciones/Gestion');
        $this->load->model('adquisiciones/Beneficiario');

        $data['clientes'] = $this->Cliente->clientes();
        $data['categorias'] = $this->Categoria->categorias();
        $data['localidades'] = $this->Localidad->localidades();

        $data['transformadores'] = $this->CentroTransformacion->transformadores();

        $data['suministros'] = $this->Suministro->suministros();
        $data['consumidores'] = $this->Consumidor->consumidores();
        $data['mediciones'] = $this->Medicion->mediciones();
        $data['liberaciones'] = $this->Liberacion->liberaciones();
        $data['estados'] = $this->Abonado->estados();
        $data['distancias'] = $this->Distancia->distancias();
        $data['gestiones'] = $this->Gestion->gestiones();
        //$data['beneficiarios'] = $this->Beneficiario->beneficiarios();

        if($type == 'update'){
            $data['item'] = $this->Abonado->retrieve_datamodal($id)[0];
            $data['zonas'] = $this->Zona->zonas($data['item']['id_localidad']);
            $data['postes'] = $this->Poste->postes($data['item']['id_transformador']);
            $data['item']['edad'] = $this->calculoEdad($data['item']['id_cliente']);
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
        }
        $this->load->view('adquisiciones/abonado/modal', $data);
    }

    public function update() {
        $this->load->model('adquisiciones/Beneficiario');


        $type = $this->input->post('type');
        $data = $this->input->post('item');

       // print_r($data);exit();


        if ($data['id_existe_inquilino'] == 2){
            $data['ci_inquilino'] = null;
            $data['nombre_inquilino'] = null;
            $data['cel_inquilino'] = null;
        }

        if ($data['id_ley_adulto'] == 1){
            $data['fecha_ley_adulto'] = date("Y-m-d");
            $beneficiario = array();
            foreach ($data as $key => $value) {
                switch ($key) {
                    case 'fecha_ley_adulto':
                        $beneficiario['fecha'] = $value;
                        break;
                    case 'id':
                        $beneficiario['id_abonado'] = $value;
                        break;
                    case 'id_cliente':
                        $beneficiario['id_cliente'] = $value;
                        break;
                    case 'id_gestion':
                        $beneficiario['id_gestion'] = $value;
                        break;
                }
            }
           // print_r($beneficiario);exit();
// Insertar los valores en la tabla
            $this->Beneficiario->insert($beneficiario);

        }else{
            $data['fecha_ley_adulto'] = null;
        }

       // print_r($beneficiario);exit();

        if ($data['multiplicador'] == ''){
            $data['multiplicador'] = 1;
        }

        $data['id_usuario'] = $this->session->userdata("user_id");

       /* print_r($data);
        exit();*/
        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('adq_abonado', $data);

        }else{

            $data['fecha_registro'] = date("Y-m-d");
            $this->db->insert('adq_abonado', $data);
        }

        $this->db->affected_rows() != 1 ? $res = 0 : $res = 1;

        echo $res;

    }


    public function delete() {
        $id = $this->input->post('id');

        $this->db->db_debug = FALSE;
        $this->db->where('id', $id);
        $this->db->delete('adq_abonado');
        if ( $this->db->error()['code'] == 0 ){
            $res = 1;
        }else{
            $res = 0;
        }

        echo $res;

    }

    //DataTables
    public function dataList(){
        $postData = $this->input->post();
        $data = $this->Abonado->getList($postData);
        echo json_encode($data);
    }

    public function calculoEdad($id){
        $this->db->select('nacimiento');
        $this->db->from('fact_cliente');
        $this->db->where('id',$id);
        $row =$this->db->get()->row()->nacimiento;

        // Creates DateTime objects
        $datetime1 = date_create($row);
        $datetime2 = date_create(date("Y-m-d"));

        // Calculates the difference between DateTime objects
        $interval = date_diff($datetime1, $datetime2);

        // Printing result in years
        $res =$interval->format('%y');
        return $res;
    }

    public function listaFiltrada(){
        $id = $this->input->get('id');
        $this->db->select('*');
        $this->db->from('adq_abonado');
        $this->db->where('id_cliente', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            echo json_encode($query->result_array());
        }
        return FALSE;
    }



}
