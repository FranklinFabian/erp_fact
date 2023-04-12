<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inicio extends CI_Controller {

  public function index()
  {
    if(isLogin()){      
      $this->load->model('empleado_model');
      $data['empleado'] = $this->empleado_model->get_empleado($this->session->userdata('id_empleado'));
      $data['main_content'] = 'inicio/success_view';
      $data['title'] = 'Bienvenido';
      $this->load->view('template/template_view', $data);
    }
    else{
      $data['main_content'] = 'inicio/index_view';
      $data['title'] = 'Inicio';
      $this->load->view('template/template_view', $data);
    }
  }
  public function login()
  {
    $this->load->model('empleado_model');
    if($this->input->post())
    {
      $nombre_usuario = $this->input->post('usuario');
      $password = $this->input->post('password');
      $usuario = $this->empleado_model->login($nombre_usuario, md5($password));
      if((count($usuario)!=0) && ($usuario['estado']!=0)){
        $session = array(
          'id_empleado' => $usuario['id_empleado'],
          'usuario' => $usuario['usuario'],
          'nivel' => $usuario['nivel'],
          'estado' => $usuario['estado']
        );
        $this->session->set_userdata($session);
        echo 'true';
      }
      else{
        echo "false uss:".$nombre_usuario." pass:".$password;
      }
    }
  }

  public function logout($csrf_hash)
  {
    if($csrf_hash==$this->security->get_csrf_hash())
    {
      $this->session->sess_destroy();
      redirect(base_url());
    }
    redirect(base_url());
  }

  public function cambiar_password()
  {
    if(isLogin())
    {
      $this->load->model('empleado_model');
      $data['password']=md5(trim($this->input->post("nuevo_password")));
      $this->empleado_model->actualizar($this->session->userdata('id_empleado'), $data);
      echo '<script>alert("Contraseña cambiada"); location.href="'.base_url().'";</script>';
    }
    else
    {
      $data['main_content'] = 'inicio/index_view';
      $data['title'] = 'Inicio';
      $this->load->view('template/template_view', $data);
    }

  }
/*
  public function pdf()
  {
    $html = '<h4>REPORTE</h4>';
    $html.= '<style>a{color:black;text-decoration: none;}</style>';
    $html.= $_POST['datos_a_enviar'];
    $html = str_replace('<table id="Exportar_a_Pdf">', '<table border="1" style="font-size: 7px;">', $html);

    $html = str_replace('<th>Ver órden</th>', '', $html);
    $html = str_replace('<th>Eliminar</th>', '', $html);
    $html = str_replace('color:green', 'color:black', $html);
    $html = str_replace('color:orange', 'color:black', $html);
    $html = str_replace('color:blue', 'color:black', $html);
    $this->load->library('Pdf');

    $pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Foto Arte');
    $pdf->SetTitle('Foto Arte titulo');
    $pdf->SetSubject('Foto sujeto');
    $pdf->AddPage();
    $nombre_archivo = utf8_decode('archivo.pdf');
    $pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Output($nombre_archivo, 'I');
  }
 */


}//fin class
