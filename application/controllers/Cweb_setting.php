<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cweb_setting extends CI_Controller {

    public $menu;

    function __construct() {
        parent::__construct();
        $this->db->query('SET SESSION sql_mode = ""');
        $this->load->library('auth');
        $this->load->library('lweb_setting');
        $this->load->library('session');
        $this->load->library('ciqrcode');
        $this->load->model('Web_settings');
        $this->auth->check_admin_auth();
        $this->template->current_menu = 'web_setting';

      
    }

    public function index() {
        $content = $this->lweb_setting->setting_add_form();
        $this->template->full_admin_html_view($content);
    }

    // Update setting
    public function update_setting() {
        $this->load->model('Web_settings');

        if ($_FILES['logo']['name']) {
            //Chapter chapter add start

        $config['upload_path']    = './my-assets/image/logo/';
        $config['allowed_types']  = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG'; 
        $config['encrypt_name']   = TRUE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('logo')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('Cweb_setting'));
            } else {
            $data = $this->upload->data();  
            $logo = $config['upload_path'].$data['file_name']; 
            $config['image_library']  = 'gd2';
            $config['source_image']   = $logo;
            $config['create_thumb']   = false;
            $config['maintain_ratio'] = TRUE;
            $config['width']          = 200;
            $config['height']         = 200;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $logo = base_url() . $logo;

            }
        }

        if ($_FILES['favicon']['name']) {
            //Chapter chapter add start
            $config['upload_path']   = './my-assets/image/logo/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG';
            $config['max_size']      = "*";
            $config['max_width']     = "*";
            $config['max_height']    = "*";
            $config['encrypt_name']  = TRUE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('favicon')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('Cweb_setting'));
            } else {
                $image = $this->upload->data();
                $favicon = base_url() . "my-assets/image/logo/" . $image['file_name'];
            }
        }

        if ($_FILES['invoice_logo']['name']) {
            //Chapter chapter add start

        $config['upload_path']    = './my-assets/image/logo/';
        $config['allowed_types']  = 'gif|jpg|png|jpeg|JPEG|GIF|JPG|PNG'; 
        $config['encrypt_name']   = TRUE;

            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('invoice_logo')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_userdata(array('error_message' => $this->upload->display_errors()));
                redirect(base_url('Cweb_setting'));
            } else {
            $data = $this->upload->data();  
            $invoice_logo = $config['upload_path'].$data['file_name']; 
            $config['image_library']  = 'gd2';
            $config['source_image']   = $invoice_logo;
            $config['create_thumb']   = false;
            $config['maintain_ratio'] = TRUE;
            $config['width']          = 200;
            $config['height']         = 200;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();
            $invoice_logo = base_url() . $invoice_logo;

            }
        }

        $old_logo = $this->input->post('old_logo');
        $old_invoice_logo = $this->input->post('old_invoice_logo');
        $old_favicon = $this->input->post('old_favicon');

        $data = array(
    'logo'              => (!empty($logo) ? $logo : $old_logo),
    'invoice_logo'      => (!empty($invoice_logo) ? $invoice_logo : $old_invoice_logo),
    'favicon'           => (!empty($favicon) ? $favicon : $old_favicon),
    'currency'          => $this->input->post('currency'),
    'currency_position' => $this->input->post('currency_position'),
    'footer_text'       => $this->input->post('footer_text'),
    'language'          => $this->input->post('language'),
    'rtr'               => $this->input->post('rtr'),
    'timezone'          => $this->input->post('timezone'),
    'captcha'           => $this->input->post('captcha'),
    'site_key'          => $this->input->post('site_key'),
    'secret_key'        => $this->input->post('secret_key'),
    'discount_type'     => $this->input->post('discount_type'),
        );

        $this->Web_settings->update_setting($data);

        $this->session->set_userdata(array('message' => display('successfully_updated')));
        redirect(base_url('Cweb_setting'));
        exit;
    }


        public function app_setting() {
         $data['qr_image'] = "";
         $data['server_image'] = "";
         $data['hotspotqrimg'] = "";
          $app_settingdata = $this->Web_settings->app_settingsdata();
           $this->load->library('ciqrcode');
            $qr_image=rand().'.png';
            $params['data'] = $app_settingdata[0]['localhserver'];
            $params['level'] = 'L';
            $params['size'] = 8;
            $params['savename'] =FCPATH."my-assets/image/qr/".$qr_image;
            if($this->ciqrcode->generate($params))
            {
                $localqr = $qr_image;
            }


             $serverqr=rand().'.png';
            $params['data'] = $app_settingdata[0]['onlineserver'];
            $params['level'] = 'O';
            $params['size'] = 8;
            $params['savename'] =FCPATH."my-assets/image/qr/".$serverqr;
            if($this->ciqrcode->generate($params))
            {
                $server_qrimg = $serverqr;
            }



             $hotspotqr=rand().'.png';
            $params['data'] = $app_settingdata[0]['hotspot'];
            $params['level'] = 'U';
            $params['size'] = 8;
            $params['savename'] =FCPATH."my-assets/image/qr/".$hotspotqr;
            if($this->ciqrcode->generate($params))
            {
                $hotspot_qrimg = $hotspotqr;
            }


             $data = array(
            'title'           => display('print_qrcode'),
            'qr_image'        => $localqr,
            'server_image'    => $server_qrimg,
            'hotspotqrimg'    => $hotspot_qrimg,
            'localhserver'    => $app_settingdata[0]['localhserver'],
            'onlineserver'    => $app_settingdata[0]['onlineserver'],
            'hotspot'         => $app_settingdata[0]['hotspot'],
            'id'              => $app_settingdata[0]['id'],
        ); 


        $content = $this->parser->parse('web_setting/app_setting', $data, true);

        $this->template->full_admin_html_view($content);
    }

    public function update_app_setting(){

        $id = $this->input->post('id');
        $data  = array(
        'localhserver' => $this->input->post('localurl'),
        'onlineserver' => $this->input->post('onlineurl'),
        'hotspot'      => $this->input->post('hotspoturl'),

        );
        if(!empty($this->input->post('localurl')) || !empty($this->input->post('onlineurl')) || !empty($this->input->post('hotspoturl')))

     if(!empty($id)){
            $this->db->where('id',$id)
                     ->update('app_setting',$data);
                 }else{
                    $this->db->insert('app_setting',$data);
                 }

         $this->session->set_flashdata('message', 'Successfully Updated');
         redirect(base_url('Cweb_setting/app_setting'));          
    }

      //    =========== its for mail settings ===============
    public function mail_setting() {
        $data['title'] = display('mail_configuration');
        $data['mail_setting'] = $this->db->select('*')->from('email_config')->where('id', 1)->get()->result();
//        
        $content = $this->parser->parse('web_setting/mail_setting', $data, true);
        $this->template->full_admin_html_view($content);
    }

//    ============ its for mail_config_update ============
    public function mail_config_update() {
        $protocol = $this->input->post('protocol');
        $smtp_host = $this->input->post('smtp_host');
        $smtp_port = $this->input->post('smtp_port');
        $smtp_user = $this->input->post('smtp_user');
        $smtp_pass = $this->input->post('smtp_pass');
        $mailtype = $this->input->post('mailtype');
        $invoice  = $this->input->post('isinvoice');
        $service  = $this->input->post('isservice');
        $quotation  = $this->input->post('isquotation');

        $mail_data = array(
            'protocol' => $protocol,
            'smtp_host' => $smtp_host,
            'smtp_port' => $smtp_port,
            'smtp_user' => $smtp_user,
            'smtp_pass' => $smtp_pass,
            'mailtype'  => $mailtype,
            'isinvoice' => $invoice,
            'isservice' => $service,
            'isquotation'=>$quotation,
        );
//        dd($paypal_data);
        $this->db->where('id', 1)->update('email_config', $mail_data);
        $this->session->set_userdata(array('message' => display('update_successfully')));
        redirect(base_url('Cweb_setting/mail_setting'));
    }


}
