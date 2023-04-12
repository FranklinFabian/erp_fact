<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cmactivos_depreciacion extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Mactivos_Depreciacion');
        $this->load->library('auth');
    }

    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lmactivos_depreciacion');
        $content = $CI->lmactivos_depreciacion->edit_data();
        $this->template->full_admin_html_view($content);
    }
       
    //DataTables
    public function dataList(){
        $this->load->model('Mactivos_Depreciacion');
        $postData = $this->input->post();
        $data = $this->Mactivos_Depreciacion->getList($postData);
        echo json_encode($data);
    }

}
