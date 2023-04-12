<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cma_orden_trabajo extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Ma_Ordenes_trabajo');
        $this->load->library('auth');
    }

    //Index page load
    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_orden_trabajo');
        $content = $CI->lma_orden_trabajo->add_form();
        $this->template->full_admin_html_view($content);
    }

    //Insertar ingresos
    public function insert() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_orden_trabajo');

        //Get current correlative
        $correlativo = $this->db->get_where("almacen_correlativo",array('nombre' => 'orden_trabajo'))->row_array();
        $correlativo_formateado = $correlativo['formato'] . str_pad($correlativo['numero'], 5, '0', STR_PAD_LEFT);

        //Conversion de fecha
        $date = new DateTime($this->input->post('fecha'));
        $fecha = $date->format('Y-m-d');

        $cabecera = array(
            'id_usuario'    => $this->session->user_id,
            'codigo' => $correlativo_formateado,
            'fecha' => $fecha,
            'id_proveedor' => $this->input->post('id_proveedor'),
            'observacion' => $this->input->post('observacion')
        );

        $this->db->insert('almacen_cabecera_orden_trabajo', $cabecera);
        $id_cabecera = $this->db->insert_id();

        //Update correlative
        $correlativo['numero'] = $correlativo['numero'] + 1;

        $actualizar_correlativo = array(
            'numero' => $correlativo['numero']
        );

        $this->db->update('almacen_correlativo', $correlativo, 'nombre = "orden_trabajo"');


        if (isset($_POST['add'])) {
            $this->session->set_userdata(array('message' => 'Insertado exitosamente.'));
            redirect(base_url('Cma_orden_trabajo/update_form/' . $id_cabecera ));
            exit;
        } else {
            redirect(base_url('Cma_orden_trabajo/administrar'));
            exit;
        }
    }

    // Update Form
    public function update_form($id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_orden_trabajo');
        $content = $CI->lma_orden_trabajo->edit_data($id);
        $this->template->full_admin_html_view($content);
    }

    // Update
    public function update() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Ma_Ordenes_trabajo');

        $id = $this->input->post('id');

        //Cabecera Ingreso
        $observacion = $this->input->post('observacion');

        //Conversion de fecha
        $date = new DateTime($this->input->post('fecha'));
        $fecha = $date->format('Y-m-d');

        $cabecera = array(
            'fecha'    => $fecha,
            'id_proveedor' => $this->input->post('id_proveedor'),
            'observacion' => $observacion
        );

        $this->db->update('almacen_cabecera_orden_trabajo', $cabecera, "id =". $id);

        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cma_orden_trabajo/update_form/' . $id));

    }

    //Vista Principal
    public function administrar()
    {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lma_orden_trabajo');
        $CI->load->model('Ma_Ordenes_trabajo');
        $content =$this->lma_orden_trabajo->list();
        $this->template->full_admin_html_view($content);
    }

    //DataTables
    public function dataList(){
        // GET data
        $this->load->model('Ma_Ordenes_trabajo');
        $postData = $this->input->post();
        $data = $this->Ma_Ordenes_trabajo->getList($postData);
        echo json_encode($data);
    }

    // Delete
    public function deletePadre() {
        $id = $this->input->post('id');

        //Verificar Relaciones registro
        $this->db->select('id');
        $this->db->from('almacen_orden_trabajo');
        $this->db->where('id_cabecera', $id);
        $this->db->get();
        $affected_row = $this->db->affected_rows();
        if ($affected_row == 0){

            // Borrar Registro
            $this->db->where('id', $id);
            $this->db->delete('almacen_cabecera_orden_trabajo');
            $res = 1;
        }else{
            $res = 0;
        }
        echo $res;
    }

    public function print($id){
        $CI = & get_instance();
        $CI->load->model('Ma_Ordenes_trabajo');
        $CI->load->library('pdfgenerator');

        $cabecera = $CI->Ma_Ordenes_trabajo->impresion_cabecera($id);
        $detalle = $CI->Ma_Ordenes_trabajo->impresion_detalle($id);

        $data = array(
            'cabecera'  => $cabecera,
            'detalles'  => $detalle
        );

        /*echo "<pre>";
        var_dump($data);
        exit;*/

        $content = $this->parser->parse('almacen/orden_trabajo/formulario_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'portrait');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('almacen_ot_'.$id, array("Attachment"=>1));
    }

    //DataTables
    public function dataTable($postData=null){
        $id_cabecera = $_POST["id_cabecera"];

        $postData = $this->input->post();

        ## Read value
        $draw = $postData['draw'];
        $start = $postData['start'];
        $rowperpage = $postData['length']; // Rows display per page
        $columnIndex = $postData['order'][0]['column']; // Column index
        $columnName = $postData['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $postData['order'][0]['dir']; // asc or desc
        $searchValue = $postData['search']['value']; // Search value


        ## Search
        $searchQuery = "";
        if($searchValue != ''){
            $searchQuery = " (ot.cantidad like '%".$searchValue."%' or ot.descripcion like '%".$searchValue."%' or ot.unidad like '%".$searchValue."%') ";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('almacen_orden_trabajo ot');
        $this->db->join('almacen_cabecera_orden_trabajo cot','cot.id = ot.id_cabecera','left');
        $this->db->where('ot.id_cabecera', $id_cabecera);
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('almacen_orden_trabajo ot');
        $this->db->join('almacen_cabecera_orden_trabajo cot','cot.id = ot.id_cabecera','left');
        $this->db->where('ot.id_cabecera', $id_cabecera);
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('
                ot.id id,
                ot.descripcion descripcion,
                ot.unidad unidad,
                ot.cantidad cantidad,
                ot.costo costo,
                (ot.cantidad * ot.costo) as total
                ');
        $this->db->from('almacen_orden_trabajo ot');
        $this->db->join('almacen_cabecera_orden_trabajo cot','cot.id = ot.id_cabecera','left');
        $this->db->where('ot.id_cabecera', $id_cabecera);
        if($searchValue != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();

        foreach($records as $record ){
            $button = '<div align="center">';
            $base_url = base_url();

            if($this->permission1->method('administrar_almacen_orden_trabajo','delete')->access()) {
                    $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
            }

            $button .=' <a href=" javascript:loadModal( ' . $record->id . ', \'update\' ); " class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="top" title=" Editar "><i class="fa fa-pencil" aria-hidden="true"></i></a>';


            $button .= '</div>';

            $data[] = array(
                'id'   =>$record->id,
                'descripcion'   =>$record->descripcion,
                'unidad'    =>$record->unidad,
                'cantidad'    =>$record->cantidad,
                'costo'   =>$record->costo,
                'total'   =>$record->total,
                'button'   =>$button,
            );
        }

        /*echo "<pre>";
        print_r($data);
        exit;*/

        ## Response
        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $data
        );

        echo json_encode($response);
    }

    public function modal_edit(){
        $this->load->model('Ma_Ordenes_trabajo');

        $id = $_GET['id'];
        $type = $_GET['type'];

        if($type == 'update'){
            $data['item'] = $this->Ma_Ordenes_trabajo->retrieve_datamodal($id)[0];
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
            $data['idP'] = $_GET['idP'];
        }

        $this->load->view('almacen/orden_trabajo/modal', $data);
    }

    public function update_datatable() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');

        $data['costo'] = floatval(str_replace(',', '.', str_replace('.', '', $data['costo'])));

        //echo "<pre>"; print_r($data); exit;

        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('almacen_orden_trabajo', $data);
        }else{
            $this->db->insert('almacen_orden_trabajo', $data);
        }

    echo 1;

    }


    public function deleteHijo(){
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('almacen_orden_trabajo');
        echo 1;
    }

}
