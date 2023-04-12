<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cma_egreso extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->model('Ma_Egresos');
        $this->load->library('auth');
    }

    //Index page load
    public function index() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_egreso');
        $content = $CI->lma_egreso->add_form();
        $this->template->full_admin_html_view($content);
    }

    //Insertar egresos
    public function insert() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_egreso');

        //Get current correlative
        $correlativo = $this->db->get_where("almacen_correlativo",array('nombre' => 'egreso'))->row_array();
        $correlativo_formateado = $correlativo['formato']. str_pad($correlativo['numero'], 5, '0', STR_PAD_LEFT);

        //Conversion de fecha
        $date = new DateTime($this->input->post('fecha'));
        $fecha = $date->format('Y-m-d');

        $cabecera = array(
            'id_usuario'    => $this->session->user_id,
            'codigo' => $correlativo_formateado,
            'fecha' => $fecha,
            'glosa' => $this->input->post('glosa'),
            'solicitante' => $this->input->post('solicitante'),
            'id_pedido' => $this->input->post('id_pedido'),
            'traspaso' => 'no',
            'tipo' => 'Egreso',
            'estado' => 'Aprobado'
        );

        $this->db->insert('almacen_cabecera', $cabecera);
        $id_cabecera = $this->db->insert_id();

        //Update correlative
        $correlativo['numero'] = $correlativo['numero'] + 1;

        $actualizar_correlativo = array(
            'numero' => $correlativo['numero']
        );

        $this->db->update('almacen_correlativo', $actualizar_correlativo, 'nombre = "egreso"');


        if (isset($_POST['add'])) {
            $this->session->set_userdata(array('message' => 'Insertado exitosamente.'));
            redirect(base_url('Cma_egreso/update_form/' . $id_cabecera ));
            exit;
        } else {
            redirect(base_url('Cma_egreso/administrar'));
            exit;
        }
    }

    // Update Form
    public function update_form($id) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lma_egreso');
        $content = $CI->lma_egreso->edit_data($id);
        $this->template->full_admin_html_view($content);
    }

    // Update
    public function update() {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->model('Ma_Egresos');

        $id = $this->input->post('id');

        //Cabecera Egreso
        $glosa = $this->input->post('glosa');
        $solicitante = $this->input->post('solicitante');

        //Conversion de fecha
        $date = new DateTime($this->input->post('fecha'));
        $fecha = $date->format('Y-m-d');

        $cabecera = array(
            'fecha'    => $fecha,
            'id_pedido' => $this->input->post('id_pedido'),
            'glosa' => $glosa,
            'solicitante' => $solicitante
        );

        $this->db->update('almacen_cabecera', $cabecera, "id =". $id);

        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cma_egreso/update_form/' . $id));

    }

    //Vista Principal
    public function administrar()
    {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lma_egreso');
        $CI->load->model('Ma_Egresos');
        $content =$this->lma_egreso->list();
        $this->template->full_admin_html_view($content);
    }

    //DataTables
    public function dataList(){
        // GET data
        $this->load->model('Ma_Egresos');
        $postData = $this->input->post();
        $data = $this->Ma_Egresos->getList($postData);
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

    public function print_egreso($id){
        $CI = & get_instance();
        $CI->load->model('Ma_Egresos');
        $this->load->model('Ma_Cuentas_contables');
        $this->load->model('Ma_Cuentas_auxiliares');
        $CI->load->library('pdfgenerator');

        $cabecera = $CI->Ma_Egresos->cabecera_egreso($id);
        $detalle = $CI->Ma_Egresos->detalle_egreso($id);

        $data = array(
            'cabecera'  => $cabecera,
            'detalles'  => $detalle
        );

        /*echo "<pre>";
        print_r($data);
        exit;*/

        $content = $this->parser->parse('almacen/egreso/egreso_pdf', $data, true);
        $pdf = new DOMPDF();
        $pdf->set_option('enable_php', TRUE);
        $pdf->set_paper('letter', 'landscape');
        $pdf->load_html($content);
        $pdf->render();
        $pdf->stream('almacen_egreso_'.$id, array("Attachment"=>1));
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
            $searchQuery = " (a.nombre like '%".$searchValue."%' or g.nombre like '%".$searchValue."%' or p.nombre like '%".$searchValue."%' or cc.nombre like'%".$searchValue."%' or ca.nombre like'%".$searchValue."%'
            or m.cantidad like'%".$searchValue."%' or m.costo_contable like'%".$searchValue."%') ";
        }


        ## Total number of records without filtering
        $this->db->select('count(*) as allcount');
        $this->db->from('almacen_movimiento m');
        $this->db->join('almacen_cabecera c','c.id = m.id_cabecera','left');
        $this->db->join('almacen_articulo a','a.id = m.id_articulo','left');
        $this->db->join('almacen_grupo g','g.id = a.id_grupo','left');
        $this->db->join('almacen_proyecto p','p.id = m.id_proyecto','left');
        $this->db->join('almacen_cuenta_contable cc','cc.id = m.id_cuenta_contable','left');
        $this->db->join('almacen_cuenta_auxiliar ca','ca.id = m.id_cuenta_auxiliar','left');
        $this->db->where('m.tipo', 'egreso');
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
        $this->db->join('almacen_proyecto p','p.id = m.id_proyecto','left');
        $this->db->join('almacen_cuenta_contable cc','cc.id = m.id_cuenta_contable','left');
        $this->db->join('almacen_cuenta_auxiliar ca','ca.id = m.id_cuenta_auxiliar','left');
        $this->db->where('m.tipo', 'egreso');
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
                p.nombre proyecto,
                cc.nombre cuenta_contable,
                ca.nombre cuenta_auxiliar,
                m.cantidad cantidad,
                m.costo_contable costo_contable,
                round(m.costo_contable * m.cantidad, 2) as total_contable');
        $this->db->from('almacen_movimiento m');
        $this->db->join('almacen_cabecera c','c.id = m.id_cabecera','left');
        $this->db->join('almacen_articulo a','a.id = m.id_articulo','left');
        $this->db->join('almacen_grupo g','g.id = a.id_grupo','left');
        $this->db->join('almacen_proyecto p','p.id = m.id_proyecto','left');
        $this->db->join('cofi_cuentas cc','cc.id = m.id_cuenta_contable','left');
        $this->db->join('almacen_cuenta_auxiliar ca','ca.id = m.id_cuenta_auxiliar','left');
        $this->db->where('m.tipo', 'egreso');
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

            if($this->permission1->method('administrar_almacen_egreso','delete')->access()){

                //Check the last row inserted
                $last_row_inserted = $this->check_last_row($record);
                if ($last_row_inserted){
                    $button .= '<a href=" javascript:itemDelete( ' . $record->id . ' ); " class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="left" title=" Borrar " ><i class="fa fa-trash"></i></a>';
                }else{
                    $button .= '<a href="#" disabled="disabled" class="btn btn-xs btn-danger"><i class="fa fa-trash"></i></a>';
                }

            }

            //$button .=' <a href=" javascript:loadModal( ' . $record->id . ', \'update\' ); " class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="right" title=" Actualizar "><i class="fa fa-pencil" aria-hidden="true"></i></a>';

            $button .= '</div>';

            $data[] = array(
                'id'   =>$record->id,
                'articulo'   =>$record->articulo,
                'grupo'   =>$record->grupo,
                'proyecto'    =>$record->proyecto,
                'cuenta_contable'    =>$record->cuenta_contable,
                'cuenta_auxiliar'   =>$record->cuenta_auxiliar,
                'cantidad'   =>$record->cantidad,
                'costo_contable'   =>$record->costo_contable,
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
        $this->load->model('Ma_Egresos');
        $this->load->model('Ma_Articulos');
        $this->load->model('Ma_Proyectos');
        $this->load->model('Ma_Cuentas_contables');
       // $this->load->model('Ma_Cuentas_auxiliares');
        $this->load->model('Ma_Grupos');

        $id = $_GET['id'];
        $type = $_GET['type'];

        if($type == 'update'){
            $data['item'] = $this->Ma_Egresos->retrieve_datamodal($id)[0];
            $data['type'] = 'update';
            $data['stock'] = $this->Ma_Articulos->retrieve_stock_ingreso($data['item']['id_articulo'])[0]['cantidad'] - $this->Ma_Articulos->retrieve_stock_egreso($data['item']['id_articulo'])[0]['cantidad'];
            $data['articulos'] = $this->Ma_Articulos->list_filtrada($data['item']['id_grupo']);
        }else{
            $data['type'] = 'new';
            $data['idP'] = $_GET['idP'];
            $data['articulos'] = $this->Ma_Articulos->list();

        }

        $data['grupos'] = $this->Ma_Grupos->list();
        $data['proyectos'] = $this->Ma_Proyectos->list();
        $data['cuentas_contables'] = $this->Ma_Cuentas_contables->list();
        //$data['cuentas_auxiliares'] = $this->Ma_Cuentas_auxiliares->list();

        /*echo "<pre>";
        print_r($data['item']);
        exit;*/

        $this->load->view('almacen/egreso/modal', $data);
    }

    public function update_datatable() {
        $this->load->model('Ma_Egresos');
        $type = $this->input->post('type');
        $data = $this->input->post('item');
        $data['tipo'] = "Egreso";

        //if ($data['id_cuenta_auxiliar'] == ""){

        $data['id_cuenta_auxiliar'] = 0;

        //}

        //Obtenemos el ultimo registro del articulo en curso de la tabla seguimiento
        $ultimo_registro = $this->Ma_Egresos->obtener_ultimmo_registro($data['id_articulo']);
        //echo "<pre>"; print_r($ultimo_registro); exit;
        $data['costo_real'] = 0;
        $data['costo_contable'] = $ultimo_registro->saldo_valor_unitario;
        $data['saldo_cantidad'] = $ultimo_registro->saldo_cantidad - $data['cantidad'];
        $data['saldo_valor_unitario'] = $ultimo_registro->saldo_valor_unitario;
        $data['saldo_valor_total'] = $data['saldo_cantidad'] * $data['saldo_valor_unitario'];

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
        $this->db->select('*');
        $this->db->from('almacen_movimiento');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $this->db->where('id', $id);
            $this->db->delete('almacen_movimiento');
            echo 1;
        }

    }



}
