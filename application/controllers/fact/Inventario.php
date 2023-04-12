<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventario extends CI_Controller
{
  public function index()
  {
    if(isAdmin())
    {
      $data['main_content'] = 'inventario/index_view';
      $data['title'] = 'Inventario';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

}//fin class
