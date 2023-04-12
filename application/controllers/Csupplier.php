<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Csupplier extends CI_Controller {

    public $supplier_id;

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('lsupplier');
        $this->load->library('session');
        $this->load->model('Suppliers');
        $this->auth->check_admin_auth();
    }

    public function index() {
        $content = $this->lsupplier->supplier_add_form();
        $this->template->full_admin_html_view($content);
    }

    //Insert supplier
    public function insert_supplier() {
       
        $data = array(
            'supplier_name' => $this->input->post('supplier_name'),
            'address'       => $this->input->post('address'),
            'mobile'        => $this->input->post('mobile'),
            'details'       => $this->input->post('details'),
            'status'        => 1
        );
         
        $this->db->insert('supplier_information',$data);


            $supplier_id = $this->db->insert_id();
          $coa = $this->Suppliers->headcode();
        if($coa->HeadCode!=NULL){
            $headcode=$coa->HeadCode+1;
        }
        else{
            $headcode="502000001";
        }
             $c_acc=$supplier_id.'-'.$this->input->post('supplier_name');
        $createby=$this->session->userdata('user_id');
        $createdate=date('Y-m-d H:i:s');
        $supplier_coa = [
              'HeadCode'       => $headcode,
            'HeadName'         => $c_acc,
            'PHeadName'        => 'Account Payable',
            'HeadLevel'        => '3',
            'IsActive'         => '1',
            'IsTransaction'    => '1',
            'IsGL'             => '0',
            'HeadType'         => 'L',
            'IsBudget'         => '0',
            'IsDepreciation'   => '0',
            'DepreciationRate' => '0',
            'CreateBy'         => $createby,
            'CreateDate'       => $createdate,
        ];
            //Previous balance adding -> Sending to supplier model to adjust the data.
            $this->db->insert('acc_coa',$supplier_coa);
            $this->Suppliers->previous_balance_add($this->input->post('previous_balance'), $supplier_id,$c_acc,$this->input->post('supplier_name'));
            
            $this->session->set_userdata(array('message' => display('successfully_added')));
            if (isset($_POST['add-supplier'])) {
                redirect(base_url('Csupplier/manage_supplier'));
                exit;
            } elseif (isset($_POST['add-supplier-another'])) {
                redirect(base_url('Csupplier'));
                exit;
            }
     
    }

    //Manage supplier
    public function manage_supplier() {
        $CI =& get_instance();
        $this->auth->check_admin_auth();
        $CI->load->library('lsupplier');
        $CI->load->model('Suppliers');
        $content =$this->lsupplier->supplier_list();
        $this->template->full_admin_html_view($content);
    }

        public function CheckSupplierList(){
        // GET data
        $this->load->model('Suppliers');
        $postData = $this->input->post();
        $data = $this->Suppliers->getSupplierList($postData);
        echo json_encode($data);
    } 

    // search supplier 
    public function search_supplier() {
        $supplier_id = $this->input->post('supplier_id');
        $content = $this->lsupplier->supplier_search($supplier_id);
        $this->template->full_admin_html_view($content);
    }

    //Supplier Update Form
    public function supplier_update_form($supplier_id) {
        $content = $this->lsupplier->supplier_edit_data($supplier_id);

        $this->template->full_admin_html_view($content);
    }

    // Supplier Update
    public function supplier_update() {
        $supplier_id = $this->input->post('supplier_id');
        $old_headnam = $supplier_id.'-'.$this->input->post('oldname');
        $c_acc=$supplier_id.'-'.$this->input->post('supplier_name');
        $data = array(
            'supplier_name' => $this->input->post('supplier_name'),
            'address'       => $this->input->post('address'),
            'mobile'        => $this->input->post('mobile'),
            'details'       => $this->input->post('details')
        );
         $supplier_coa = [
             'HeadName'         => $c_acc
        ];
        $result = $this->Suppliers->update_supplier($data, $supplier_id);
        if ($result == TRUE) {
        $this->db->where('HeadName', $old_headnam);
        $this->db->update('acc_coa', $supplier_coa);
        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Csupplier/manage_supplier'));
        exit;
    }else{
        $this->session->set_userdata(array('error_message' => display('please_try_again'))); 
         redirect(base_url('Csupplier/manage_supplier'));
    }
    }

    //Supplier Search Item
    public function supplier_search_item() {
        $supplier_id = $this->input->post('supplier_id');
        $content = $this->lsupplier->supplier_search_item($supplier_id);
        $this->template->full_admin_html_view($content);
    }

    // Supplier Delete from System
    public function supplier_delete($supplier_id) {
        $this->Suppliers->delete_supplier($supplier_id);
        $this->Suppliers->delete_supplier_ledger($supplier_id);
        $this->session->set_userdata(array('message' => display('successfully_delete')));
       redirect(base_url('Csupplier/manage_supplier'));
    }

    // Supplier details findings !!!!!!!!!!!!!! Inactive Now !!!!!!!!!!!!
    public function supplier_details($supplier_id) {
        $content = $this->lsupplier->supplier_detail_data($supplier_id);
        $this->supplier_id = $supplier_id;
        $this->template->full_admin_html_view($content);
    }

    //Supplier Ledger Book
    public function supplier_ledger() {
        $start = $this->input->post('from_date');
        $end = $this->input->post('to_date');

        $supplier_id = $this->input->post('supplier_id');
       

        $content = $this->lsupplier->supplier_ledger($supplier_id, $start, $end);

        $this->template->full_admin_html_view($content);
    }

    public function supplier_ledger_report() {
        $config["base_url"] = base_url('Csupplier/supplier_ledger_report/');
        $config["total_rows"] = $this->Suppliers->count_supplier_product_info();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        $content = $this->lsupplier->supplier_ledger_report($links, $config["per_page"], $page);
        $this->template->full_admin_html_view($content);
    }

    // Supplier wise sales report details
    public function supplier_sales_details() {
        $start = $this->input->post('from_date');
        $end = $this->input->post('to_date');
        $supplier_id = $this->uri->segment(3);

        $content = $this->lsupplier->supplier_sales_details($supplier_id, $start, $end);
        $this->template->full_admin_html_view($content);
    }

    // Supplier wise sales report summary
    public function supplier_sales_summary() {
        #
        #pagination starts
        #
        $supplier_id = $this->uri->segment(4);
        $config["base_url"] = base_url('Csupplier/supplier_sales_summary/' . $supplier_id . "/");
        $config["total_rows"] = $this->Suppliers->supplier_sales_summary_count($supplier_id);
        $config["per_page"] = 10;
        $config["uri_segment"] = 4;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content = $this->lsupplier->supplier_sales_summary($supplier_id, $links, $config["per_page"], $page);

        $this->supplier_id = $supplier_id;
        $this->template->full_admin_html_view($content);
    }

    // Actual Ledger based on sales & deposited amount
    public function sales_payment_actual() {
        #
        #pagination starts
        $supplier_id = $this->uri->segment(3);

        $config["base_url"] = base_url('Csupplier/sales_payment_actual/' . $supplier_id . "/");
        $config["total_rows"] = $this->Suppliers->sales_payment_actual_count();
        $config["per_page"] = 10;
        $config["uri_segment"] = 6;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content = $this->lsupplier->sales_payment_actual($supplier_id, $links, $config["per_page"], $page);

        $this->supplier_id = $supplier_id;
        $this->template->full_admin_html_view($content);
    }

    // search report 
    public function search_supplier_report() {
        $start = $this->input->post('from_date');
        $end = $this->input->post('to_date');

        $content = $this->lpayment->result_datewise_data($start, $end);
        $this->template->full_admin_html_view($content);
    }

    //Supplier sales details all from menu
    public function supplier_sales_details_all() {
        $config["base_url"] = base_url('Csupplier/supplier_sales_details_all/');
        $config["total_rows"] = $this->Suppliers->supplier_sales_details_count_all();
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content = $this->lsupplier->supplier_sales_details_allm($links, $config["per_page"], $page);

        $this->template->full_admin_html_view($content);
    }



        public function supplier_sales_details_datewise() {
        $fromdate = $this->input->get('from_date');
        $todate = $this->input->get('to_date');      
        $config["base_url"] = base_url('Csupplier/supplier_sales_details_datewise/');
        $config["total_rows"] = $this->Suppliers->supplier_sales_details_datewise_count($fromdate,$todate);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $config["num_links"] = 5;
        /* This Application Must Be Used With BootStrap 3 * */
        $config['full_tag_open'] = "<ul class='pagination'>";
        $config['full_tag_close'] = "</ul>";
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open'] = "<li>";
        $config['next_tag_close'] = "</li>";
        $config['prev_tag_open'] = "<li>";
        $config['prev_tagl_close'] = "</li>";
        $config['first_tag_open'] = "<li>";
        $config['first_tagl_close'] = "</li>";
        $config['last_tag_open'] = "<li>";
        $config['last_tagl_close'] = "</li>";
        /* ends of bootstrap */
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $links = $this->pagination->create_links();
        #
        #pagination ends
        #  
        $content = $this->lsupplier->supplier_sales_details_datewise($links, $config["per_page"], $page,$fromdate,$todate);

        $this->template->full_admin_html_view($content);
    }

    // supplier ledger for supplier information 
    public function supplier_ledger_info($supplier_id) {
        $content = $this->lsupplier->supplier_ledger_info($supplier_id);
        $this->supplier_id = $supplier_id;
        $this->template->full_admin_html_view($content);
    }
// ============================= CSV SUPPLIER UPLOAD  ======================================
        //CSV Manufacturer Add From here
    function uploadCsv_Supplier()
    {
        $filename = $_FILES['upload_csv_file']['name'];
        
        $ext = end(explode('.', $filename));
        $ext = substr(strrchr($filename, '.'), 1);
        if($ext == 'csv'){
        $count=0;
        $fp = fopen($_FILES['upload_csv_file']['tmp_name'],'r') or die("can't open file");

        if (($handle = fopen($_FILES['upload_csv_file']['tmp_name'], 'r')) !== FALSE)
        {
  
         while($csv_line = fgetcsv($fp,1024)){
                //keep this if condition if you want to remove the first row
                for($i = 0, $j = count($csv_line); $i < $j; $i++)
                {                  
                   $insert_csv = array();
                   $insert_csv['supplier_name'] = (!empty($csv_line[0])?$csv_line[0]:null);
                   $insert_csv['address'] = (!empty($csv_line[1])?$csv_line[1]:'');
                   $insert_csv['mobile'] = (!empty($csv_line[2])?$csv_line[2]:'');
                   $insert_csv['details'] = (!empty($csv_line[3])?$csv_line[3]:'');
                   $insert_csv['previousbalance'] = (!empty($csv_line[4])?$csv_line[4]:0);
                }
                $depid = date('Ymdis');
                $supplierdata = array(
                    'supplier_name'    => $insert_csv['supplier_name'],
                    'address'          => $insert_csv['address'],
                    'mobile'           => $insert_csv['mobile'],
                    'details'          => $insert_csv['details'],
                    'status'           => 1
                );

                 
                       

                if ($count > 0) {
                    // print_r($supplierdata);exit();
                    $this->db->insert('supplier_information',$supplierdata);

                $supplier_id    = $this->db->insert_id();
                $transaction_id = $this->auth->generator(10);

                       $ledgerdata = array(
                    'transaction_id' => $transaction_id,
                    'supplier_id'    => $supplier_id,
                    'chalan_no'      => 'Adjustment ',
                    'deposit_no'     => NULL,
                    'amount'         => $insert_csv['previousbalance'],
                    'description'    => "Previous adjustment with software",
                    'payment_type'   => "NA",
                    'cheque_no'      => "NA",
                    'date'           => date("Y-m-d"),
                    'status'         => 1,
                    'd_c'            => 'c'
                );

        $coa = $this->Suppliers->headcode();
        if($coa->HeadCode!=NULL){
            $headcode=$coa->HeadCode+1;
        }
        else{
            $headcode="5020001";
        }
        $c_acc=$supplier_id.'-'.$insert_csv['supplier_name'];
        $createby=$this->session->userdata('user_id');
        $createdate=date('Y-m-d H:i:s');

         $supplier_coa = [
              'HeadCode'       => $headcode,
            'HeadName'         => $c_acc,
            'PHeadName'        => 'Account Payable',
            'HeadLevel'        => '3',
            'IsActive'         => '1',
            'IsTransaction'    => '1',
            'IsGL'             => '0',
            'HeadType'         => 'L',
            'IsBudget'         => '0',
            'IsDepreciation'   => '0',
            'DepreciationRate' => '0',
            'CreateBy'         => $createby,
            'CreateDate'       => $createdate,
        ];

                     $this->db->insert('acc_coa', $supplier_coa);
                    $this->db->insert('supplier_ledger', $ledgerdata);
                    }  
                $count++; 
            }
            
        }
                        $this->db->select('*');
                        $this->db->from('supplier_information');
                        $this->db->where('status',1);
                    $query = $this->db->get();
                    foreach ($query->result() as $row) {
                        $json_supplier[] = array('label'=>$row->supplier_name,'value'=>$row->supplier_id);
                    }
                    $cache_file = './my-assets/js/admin_js/json/supplier.json';
                    $supplierlist = json_encode($json_supplier);
                    file_put_contents($cache_file,$supplierlist);
        fclose($fp) or die("can't close file");
        $this->session->set_userdata(array('message'=>display('successfully_added')));
        redirect(base_url('Csupplier/manage_supplier'));
    }else{
        $this->session->set_userdata(array('error_message'=>'Please Import Only Csv File'));
        redirect(base_url('Csupplier/manage_supplier'));
    }
    
    }
    //Supplier pdf download
         public function supplier_downloadpdf(){
        $CI = & get_instance();
        $CI->load->model('Suppliers');
        $CI->load->model('Web_settings');
        $CI->load->model('Invoices');
        $CI->load->library('pdfgenerator'); 
        $supplier_list = $CI->Suppliers->supplier_list();
        if (!empty($supplier_list)) {
            $i = 0;
            if (!empty($supplier_list)) {
                foreach ($supplier_list as $k => $v) {
                    $i++;
                    $supplier_list[$k]['sl'] = $i + $CI->uri->segment(3);
                }
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Invoices->retrieve_company();
        $data = array(
            'title'         => display('supplier_list'),
            'supplier_list' => $supplier_list,
            'currency'      => $currency_details[0]['currency'],
            'logo'          => $currency_details[0]['logo'],
            'position'      => $currency_details[0]['currency_position'],
            'company_info'  => $company_info
        );
            $this->load->helper('download');
            $content = $this->parser->parse('supplier/supplier_list_pdf', $data, true);
            $time = date('Ymdhi');
            $dompdf = new DOMPDF();
            $dompdf->load_html($content);
            $dompdf->render();
            $output = $dompdf->output();
            file_put_contents('assets/data/pdf/'.'supplierlist'.$time.'.pdf', $output);
            $file_path = 'assets/data/pdf/'.'supplierlist'.$time.'.pdf';
           $file_name = 'Supplierlist'.$time.'.pdf';
            force_download(FCPATH.'assets/data/pdf/'.$file_name, null);
    }
    // csv export
     public function exportCSV() {
        // file name 
        $this->load->model('Suppliers');
        $filename = 'supplier_' . date('Ymd') . '.csv';
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");
        // get data 
        $usersData = $this->Suppliers->supplier_csv_file();
        // file creation 
        $file = fopen('php://output', 'w');

        $header = array('Name','Address', 'Mobile', 'Details','status');
        fputcsv($file, $header);
        foreach ($usersData as $line) {
            fputcsv($file, $line);
        }
        fclose($file);
        exit;
    }


        /// Supplier Advance Form
      public function supplier_advance(){
    $data['title'] = display('supplier_advance');
    $data['supplier_list'] = $this->Suppliers->supplier_list_advance();
    $content = $this->parser->parse('supplier/supplier_advance', $data, true);
    $this->template->full_admin_html_view($content); 
  }
  // supplier advane insert
  public function insert_supplier_advance(){
    $advance_type = $this->input->post('type');
    if($advance_type ==1){
        $dr = $this->input->post('amount');
        $tp = 'd';
    }else{
        $cr = $this->input->post('amount');
        $tp = 'c';
    }
    
            $createby=$this->session->userdata('user_id');
            $createdate=date('Y-m-d H:i:s');
            $transaction_id=$this->auth->generator(10);
            $supplier_id = $this->input->post('supplier_id');
            $supifo = $this->db->select('*')->from('supplier_information')->where('supplier_id',$supplier_id)->get()->row();
    $headn = $supplier_id.'-'.$supifo->supplier_name;
    $coainfo = $this->db->select('*')->from('acc_coa')->where('HeadName',$headn)->get()->row();
    $supplier_headcode = $coainfo->HeadCode;
               

          $supplier_ledger = array(
                    'transaction_id' => $transaction_id,
                    'supplier_id'    => $supplier_id,
                    'chalan_no'      => NULL,
                    'deposit_no'     => NULL,
                    'amount'         => $this->input->post('amount'),
                    'description'    => "Advance ",
                    'payment_type'   => "NA",
                    'cheque_no'      => "NA",
                    'date'           => date("Y-m-d"),
                    'status'         => 1,
                    'd_c'            => $tp
                );       

                   $supplier_accledger = array(
      'VNo'            =>  $transaction_id,
      'Vtype'          =>  'Advance',
      'VDate'          =>  date("Y-m-d"),
      'COAID'          =>  $supplier_headcode,
      'Narration'      =>  'supplier Advance For '.$supifo->supplier_name,
      'Debit'          =>  (!empty($dr)?$dr:0),
      'Credit'         =>  (!empty($cr)?$cr:0),
      'IsPosted'       => 1,
      'CreateBy'       => $this->session->userdata('user_id'),
      'CreateDate'     => date('Y-m-d H:i:s'),
      'IsAppove'       => 1
    );
                    $cc = array(
      'VNo'            =>  $transaction_id,
      'Vtype'          =>  'Advance',
      'VDate'          =>  date("Y-m-d"),
      'COAID'          =>  1020101,
      'Narration'      =>  'Cash in Hand  For '.$supifo->supplier_name.' Advance',
      'Debit'          =>  (!empty($dr)?$dr:0),
      'Credit'         =>  (!empty($cr)?$cr:0),
      'IsPosted'       =>  1,
      'CreateBy'       =>  $this->session->userdata('user_id'),
      'CreateDate'     =>  date('Y-m-d H:i:s'),
      'IsAppove'       =>  1
    ); 
                   $this->db->insert('supplier_ledger',$supplier_ledger);
                   $this->db->insert('acc_transaction',$supplier_accledger);
                   $this->db->insert('acc_transaction',$cc);
                    redirect(base_url('Csupplier/supplier_advancercpt/'.$transaction_id));

  }


    public function supplier_advancercpt($receiptid) {
        $CI = & get_instance();
        $CI->auth->check_admin_auth();
        $CI->load->library('lsupplier');
        $content = $CI->lsupplier->advance_details_data($receiptid);
        $this->template->full_admin_html_view($content);
    }

}
