<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cma_ingreso extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Ma_Ingresos');
        $this->load->library('auth');
    }

    //Index page load
    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_ingreso');
        $content = $CI->lma_ingreso->add_form();
        $this->template->full_admin_html_view($content);
    }

    //Insertar ingresos
    public function insert() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_ingreso');

        //Get current correlative
        $correlativo = $this->db->get_where("almacen_correlativo",array('nombre' => 'ingreso'))->row_array();
        $correlativo_formateado = $correlativo['formato']. str_pad($correlativo['numero'], 5, '0', STR_PAD_LEFT);
        //echo "<pre>"; print_r($correlativo_formateado); exit;
        //Conversion de fecha
        $date = new DateTime($this->input->post('fecha'));
        $fecha = $date->format('Y-m-d');


        $cabecera = array(
            'id_usuario'    => $this->session->user_id,
            'codigo' => $correlativo_formateado,
            'fecha' => $fecha,
            'id_proveedor' => $this->input->post('id_proveedor'),
            'id_orden' => $this->input->post('id_orden'),
            'glosa' => $this->input->post('glosa'),
            'traspaso' => 'no',
            'tipo' => 'Ingreso',
            'estado' => 'Aprobado'
        );

        $this->db->insert('almacen_cabecera', $cabecera);
        $id_cabecera = $this->db->insert_id();



        //Retrive data from Orden de Compra
        $this->db->select('
        aoc.id_articulo,
        aoc.cantidad,
        aoc.costo costo_real,
        (aoc.costo * 0.87) costo_contable'
        );
        $this->db->from('almacen_cabecera_orden_compra acoc');
        $this->db->join('almacen_orden_compra aoc','aoc.id_cabecera = acoc.id','left');
        $this->db->where('acoc.id', $this->input->post('id_orden'));
        $records = $this->db->get()->result();
        foreach ($records as $record){
            $record->id_cabecera = $id_cabecera;
            $record->tipo = 'Ingreso';
            /*echo "<pre>";
            print_r($record);
            exit;*/

            $this->db->insert('almacen_movimiento', $record);
        }




        //Update correlative
        $correlativo['numero'] = $correlativo['numero'] + 1;

        $actualizar_correlativo = array(
            'numero' => $correlativo['numero']
        );

        $this->db->update('almacen_correlativo', $actualizar_correlativo, 'nombre = "ingreso"');


        if (isset($_POST['add'])) {
            $this->session->set_userdata(array('message' => 'Insertado exitosamente.'));
            redirect(base_url('Cma_ingreso/update_form/' . $id_cabecera ));
            exit;
        } else {
            redirect(base_url('Cma_ingreso/administrar'));
            exit;
        }
    }

    // Update Form
    public function update_form($id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_ingreso');
        $content = $CI->lma_ingreso->edit_data($id);
        $this->template->full_admin_html_view($content);
    }

    // Update
    public function update() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Ma_Ingresos');

        $id = $this->input->post('id');

        //Cabecera Ingreso
        $id_proveedor = $this->input->post('id_proveedor');
        $glosa = $this->input->post('glosa');

        //Conversion de fecha
        $date = new DateTime($this->input->post('fecha'));
        $fecha = $date->format('Y-m-d');

        $cabecera_ingreso = array(
            'fecha'    => $fecha,
            'id_proveedor'    => $id_proveedor,
            'id_orden' => $this->input->post('id_orden'),
            'glosa' => $glosa
        );

        $this->db->update('almacen_cabecera', $cabecera_ingreso, "id =". $id);

        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cma_ingreso/update_form/' . $id));

    }

    //Vista Principal
    public function administrar()
    {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lma_ingreso');
        $CI->load->model('Ma_Ingresos');
        $content =$this->lma_ingreso->list();
        $this->template->full_admin_html_view($content);
    }

    //DataTables
    public function dataList(){
        // GET data
        $this->load->model('Ma_Ingresos');
        $postData = $this->input->post();
        $data = $this->Ma_Ingresos->getList($postData);
        echo json_encode($data);
    }

    // Delete
    public function deletePrincipal() {
        $id = $this->input->post('id');

        //Verificar Relaciones registro
        $this->db->select('id');
        $this->db->from('almacen_movimiento');
        $this->db->where('id_cabecera', $id);
        $this->db->get();
        $affected_row = $this->db->affected_rows();
        if ($affected_row == 0){

            // Borrar Registro
            $this->db->where('id', $id);
            $this->db->delete('almacen_cabecera');
            $res = 1;
        }else{
            $res = 0;
        }
        echo $res;
    }

    public function print_ingreso($id){
        $CI = & get_instance();
        $CI->load->model('Ma_Ingresos');
        $CI->load->library('pdfgenerator');

        $cabecera = $CI->Ma_Ingresos->cabecera_ingreso($id);
        $detalle = $CI->Ma_Ingresos->detalle_ingreso($id);

        $data = array(
            'cabecera'  => $cabecera,
            'detalles'  => $detalle
        );

        /*echo "<pre>";
        print_r($data);
        exit;*/

        $content = $this->parser->parse('almacen/ingreso/ingreso_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'landscape');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('almacen_ingreso_'.$id, array("Attachment"=>1));
    }

    //DataTables
    public function dataTable($postData=null){
        $id_cabecera = $_POST["id_cabecera"];

        $postData = $this->input->post();

        $response = array();

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
            $searchQuery = " (a.nombre like '%".$searchValue."%'
            or g.nombre like '%".$searchValue."%'
            or m.costo_real like'%".$searchValue."%'
            or m.cantidad like'%".$searchValue."%'
            or m.costo_contable like'%".$searchValue."%') ";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('almacen_movimiento m');
        $this->db->join('almacen_cabecera c','c.id = m.id_cabecera','left');
        $this->db->join('almacen_articulo a','a.id = m.id_articulo','left');
        $this->db->join('almacen_grupo g','g.id = a.id_grupo','left');
        $this->db->where('m.tipo', 'ingreso');
        $this->db->where('c.traspaso', 'no');
        $this->db->where('c.estado', 'Aprobado');
        $this->db->where('id_cabecera', $id_cabecera);
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecords = $records[0]->allcount;

        ## Total number of record with filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('almacen_movimiento m');
        $this->db->join('almacen_cabecera c','c.id = m.id_cabecera','left');
        $this->db->join('almacen_articulo a','a.id = m.id_articulo','left');
        $this->db->join('almacen_grupo g','g.id = a.id_grupo','left');
        $this->db->where('m.tipo', 'ingreso');
        $this->db->where('c.traspaso', 'no');
        $this->db->where('c.estado', 'Aprobado');
        $this->db->where('id_cabecera', $id_cabecera);
        if($searchValue != '')
            $this->db->where($searchQuery);
        $records = $this->db->get()->result();
        $totalRecordwithFilter = $records[0]->allcount;

        ## Fetch records
        $this->db->select('m.id id,
                a.nombre articulo,
                a.id id_articulo,
                g.nombre grupo,
                m.costo_real costo_real,
                m.costo_contable costo_contable,
                m.cantidad cantidad,
                (m.costo_real * m.cantidad) as total_real,
                round(m.costo_contable * m.cantidad, 2) as total_contable,
                ');
        $this->db->from('almacen_movimiento m');
        $this->db->join('almacen_cabecera c','c.id = m.id_cabecera','left');
        $this->db->join('almacen_articulo a','a.id = m.id_articulo','left');
        $this->db->join('almacen_grupo g','g.id = a.id_grupo','left');
        $this->db->where('m.tipo', 'ingreso');
        $this->db->where('c.traspaso', 'no');
        $this->db->where('c.estado', 'Aprobado');
        $this->db->where('id_cabecera', $id_cabecera);
        if($searchValue != '')
            $this->db->where($searchQuery);
        $this->db->order_by($columnName, $columnSortOrder);
        $this->db->limit($rowperpage, $start);
        $records = $this->db->get()->result();
        $data = array();

        foreach($records as $record ){
            $button = '<div align="center">';

            if($this->permission1->method('administrar_almacen_ingreso','delete')->access()) {

                //Check the last row inserted
                $last_row_inserted = $this->check_last_row($record);
                if ($last_row_inserted){
                    $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
                }else{
                    $button .= '<a href="#" disabled="disabled" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>';
                }

            }

            $button .= '</div>';

            $data[] = array(
                'id'   =>$record->id,
                'articulo'   =>$record->articulo,
                'grupo'   =>$record->grupo,
                'costo_real'   =>$record->costo_real,
                'costo_contable'   =>$record->costo_contable,
                'cantidad'   =>$record->cantidad,
                'total_real'   =>$record->total_real,
                'total_contable'   =>$record->total_contable,
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

        $this->load->model('Ma_Ingresos');
        $this->load->model('Ma_Articulos');
        $this->load->model('Ma_Grupos');
        $id = $_GET['id'];
        $type = $_GET['type'];

        if($type == 'update'){
            $data['item'] = $this->Ma_Ingresos->retrieve_datamodal($id)[0];
            $data['articulos'] = $this->Ma_Articulos->list_filtrada($data['item']['id_grupo']);
            $data['type'] = 'update';
        }else{
            $data['type'] = 'new';
            $data['idP'] = $_GET['idP'];
            $data['articulos'] = $this->Ma_Articulos->list();
        }

        //echo "<pre>"; print_r($data); exit;
        $data['grupos'] = $this->Ma_Grupos->list_dropdown();
        $this->load->view('almacen/ingreso/modal', $data);
    }

    public function update_datatable() {
        $type = $this->input->post('type');
        $data = $this->input->post('item');
        $data['tipo'] = "Ingreso";

            $data['id_cuenta_contable'] = 0;
            $data['id_cuenta_auxiliar'] = 0;
            $data['id_proyecto'] = 0;

        $data['costo_real'] = floatval(str_replace(',', '.', str_replace('.', '', $data['costo_real'])));
        $data['costo_contable'] = $data['costo_real'] * 0.87;


        //Consultamos si el primer registro del articulo en la tabla seguimiento
        $primer_registro = $this->Ma_Ingresos->verificar_primer_registro($data['id_articulo']);
        if ($primer_registro){
            $data['saldo_cantidad'] = $data['cantidad'];
            $data['saldo_valor_unitario'] = $data['costo_contable'];
            $data['saldo_valor_total'] = $data['cantidad'] * $data['costo_contable'];
        }else{
            //Obtenemos el ultimo registro del articulo en curso de la tabla seguimiento
            $ultimo_registro = $this->Ma_Ingresos->obtener_ultimmo_registro($data['id_articulo']);
            $data['saldo_cantidad'] = $ultimo_registro->saldo_cantidad + $data['cantidad'];
            $data['saldo_valor_unitario'] = round(($ultimo_registro->saldo_valor_total + ($data['cantidad'] * $data['costo_contable']))/($ultimo_registro->saldo_cantidad + $data['cantidad']),2);
            $data['saldo_valor_total'] = $data['saldo_cantidad'] * $data['saldo_valor_unitario'];
        }
        //echo "<pre>"; print_r($data); exit;

        if ($type == 'update'){
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('almacen_movimiento', $data);
        }else{
            $this->db->insert('almacen_movimiento', $data);
        }

    echo 1;

    }

    public function check_last_row($data){
        $id = $data->id;
        $articulo = $data->id_articulo;
        $this->db->select('*');
        $this->db->from('almacen_movimiento');
        $this->db->where('id_articulo', $articulo);
        $this->db->order_by('id','desc');
        $this->db->limit('1');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $data){
                if($data['id'] == $id){
                    return true;
                }
            }
        }

    }

    public function deleteSecundario(){
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->delete('almacen_movimiento');
        echo 1;
    }

}
