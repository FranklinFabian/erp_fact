<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entrega_devolucion extends CI_Controller{

  public function index(){//MENU
    if(isLogin()){
      $data['main_content'] = 'entrega_devolucion/index_view';
      $data['title'] = 'Menu Entrega Devolución';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function entrega_orden_servicio(){
    if(isLogin()){
      $data['ordenes'] = $this->ordenes_model->get_ordenes_gestion(null, 1);
      $data['main_content'] = 'entrega_devolucion/entrega_orden_servicio_view';
      $data['title'] = 'Lista ordenes de servicio';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }// fin entrega_orden_servicio

  public function asigna_orden_servicio($idempleado, $selected){
    $empleado = $this->empleados_model->get_empleado($idempleado);
    $ids = explode(',', $selected);
    foreach ($ids as $key => $value) {
      $data_orden['fentrega']=date('Y-m-d H:i:s');
      $data_orden['pentrega']=$empleado['paterno'].' '.$empleado['materno'].' '.$empleado['nombre'];
      $this->ordenes_model->actualizar($value, $data_orden);
    }
  }

  public function devuelve_orden_servicio($selected){
    $ids = explode(',', $selected);
    foreach ($ids as $key => $value) {
      $data_orden['devuelto']=1;
      $data_orden['fdevuelto']=date('Y-m-d H:i:s');
      $this->ordenes_model->actualizar($value, $data_orden);
    }
  }

  public function devuelve_orden_servicio_cable($selected){
    $ids = explode(',', $selected);
    foreach ($ids as $key => $value) {
      $data_orden['devuelto']=1;
      $data_orden['fdevuelto']=date('Y-m-d H:i:s');
      $this->ordenes_model->actualizar($value, $data_orden);
    }
  }

  public function devolucion_orden_servicio(){
    if(isLogin()){
      $data['ordenes'] = $this->ordenes_model->get_ordenes_gestion_para_devolucion(null, 1);
      $data['main_content'] = 'entrega_devolucion/devolucion_orden_servicio_view';
      $data['title'] = 'Devolución ordenes de servicio';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function devolucion_orden_servicio_cable(){
    if(isLogin()){
      $data['ordenes'] = $this->ordenes_model->get_ordenes_gestion_para_devolucion(null, 2);
      $data['main_content'] = 'entrega_devolucion/devolucion_orden_servicio_cable_view';
      $data['title'] = 'Devolución ordenes de servicio cable';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function entrega_orden_servicio_cable(){
    if(isLogin()){
      $data['ordenes'] = $this->ordenes_model->get_ordenes_gestion(null, 2);
      $data['main_content'] = 'entrega_devolucion/entrega_orden_servicio_cable_view';
      $data['title'] = 'Lista ordenes de servicio';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function asigna_orden_servicio_cable($idempleado, $selected){
    $empleado = $this->empleados_model->get_empleado($idempleado);
    $ids = explode(',', $selected);
    foreach ($ids as $key => $value) {
      $data_orden['fentrega']=date('Y-m-d H:i:s');
      $data_orden['pentrega']=$empleado['paterno'].' '.$empleado['materno'].' '.$empleado['nombre'];
      $this->ordenes_model->actualizar($value, $data_orden);
    }
  }

  /////////////////////////////////// CONEXIONES
  public function entrega_orden_servicio_conexion($idservicio){
    if(isLogin()){
      $data['ordenes'] = $this->conexiones_model->get_conexiones_s($idservicio);
      $data['idservicio'] = $idservicio;
      $data['main_content'] = 'entrega_devolucion/entrega_orden_servicio_conexion_view';
      $data['title'] = 'Lista ordenes de servicio';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }
  public function asigna_orden_servicio_conexion($idempleado, $selected){
    $empleado = $this->empleados_model->get_empleado($idempleado);
    $ids = explode(',', $selected);
    foreach ($ids as $key => $value) {
      $data_orden['entregado']=1;
      $data_orden['fentregado']=date('Y-m-d H:i:s');
      $data_orden['pentregado']=$empleado['paterno'].' '.$empleado['materno'].' '.$empleado['nombre'];
      $this->conexiones_model->actualizar($value, $data_orden);
    }
  }
  public function devolucion_conexion($idservicio){
    if(isLogin()){
      $data['idservicio'] = $idservicio;
      $data['ordenes'] = $this->conexiones_model->get_conexiones_para_devolucion($idservicio);
      $data['main_content'] = 'entrega_devolucion/devolucion_conexion_view';
      $data['title'] = 'Devolución ordenes de servicio';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }
  public function devuelve_conexion($selected){
    $ids = explode(',', $selected);
    foreach ($ids as $key => $value) {
      $data_orden['devuelto']=1;
      $data_orden['fdevuelto']=date('Y-m-d H:i:s');
      $this->conexiones_model->actualizar($value, $data_orden);
    }
  }
  /////////////////////CORTES

  public function entrega_cortes(){
    if(isLogin()){
      $data['cortes'] = $this->cortes_model->get_cortes_s(1);
      $data['main_content'] = 'entrega_devolucion/entrega_cortes_view';
      $data['title'] = 'Lista ordenes de servicio';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }// fin entrega_cortes

  public function entrega_cortes_cable(){
    if(isLogin()){
      $data['cortes'] = $this->cortes_model->get_cortes_s(2);
      $data['main_content'] = 'entrega_devolucion/entrega_cortes_cable_view';
      $data['title'] = 'Lista ordenes de servicio cable';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }// fin entrega_cortes

  public function asigna_corte($idempleado, $selected){
    $empleado = $this->empleados_model->get_empleado($idempleado);
    $ids = explode(',', $selected);
    foreach ($ids as $key => $value) {
      $data_corte['entregado']=1;
      $data_corte['fentrega']=date('Y-m-d H:i:s');
      $data_corte['pentrega']=$empleado['paterno'].' '.$empleado['materno'].' '.$empleado['nombre'];
      $this->cortes_model->actualizar($value, $data_corte);
    }
  }

  public function devolucion_corte(){
    if(isLogin()){
      $data['cortes'] = $this->cortes_model->get_cortes_gestion_para_devolucion(1);
      $data['main_content'] = 'entrega_devolucion/devolucion_corte_view';
      $data['title'] = 'Devolución ordenes de servicio';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function devolucion_corte_cable(){
    if(isLogin()){
      $data['cortes'] = $this->cortes_model->get_cortes_gestion_para_devolucion(2);
      $data['main_content'] = 'entrega_devolucion/devolucion_corte_cable_view';
      $data['title'] = 'Devolución ordenes de servicio';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function devuelve_corte($selected){
    $ids = explode(',', $selected);
    foreach ($ids as $key => $value) {
      $data_corte['devuelto']=1;
      $data_corte['fdevuelto']=date('Y-m-d H:i:s');
      $this->cortes_model->actualizar($value, $data_corte);
    }
  }

  ////////////////// REPOSICIONES
  public function entrega_reposiciones(){
    if(isLogin()){
      $data['reposiciones'] = $this->reposiciones_model->get_reposiciones_s(1);
      $data['main_content'] = 'entrega_devolucion/entrega_reposiciones_view';
      $data['title'] = 'Lista de reposiciones de servicio';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }// fin entrega_cortes

  public function asigna_reposicion($idempleado, $selected){
    $empleado = $this->empleados_model->get_empleado($idempleado);
    $ids = explode(',', $selected);
    foreach ($ids as $key => $value) {
      $data_repo['entregado']=1;
      $data_repo['fentrega']=date('Y-m-d H:i:s');
      $data_repo['pentrega']=$empleado['paterno'].' '.$empleado['materno'].' '.$empleado['nombre'];
      $this->reposiciones_model->actualizar($value, $data_repo);
    }
  }

  public function devolucion_reposicion(){
    if(isLogin()){
      $data['reposiciones'] = $this->reposiciones_model->get_reposiciones_para_devolucion(1);
      $data['main_content'] = 'entrega_devolucion/devolucion_reposicion_view';
      $data['title'] = 'Devolución reposiciones';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  public function devuelve_reposicion($selected){
    $ids = explode(',', $selected);
    foreach ($ids as $key => $value) {
      $data_repo['devuelto']=1;
      $data_repo['fdevuelto']=date('Y-m-d H:i:s');
      $this->reposiciones_model->actualizar($value, $data_repo);
    }
  }

  public function entrega_reposiciones_cable(){
    if(isLogin()){
      $data['reposiciones'] = $this->reposiciones_model->get_reposiciones_s(2);
      $data['main_content'] = 'entrega_devolucion/entrega_reposiciones_cable_view';
      $data['title'] = 'Lista reposiciones de servicio cable';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }// fin entrega_cortes

  public function devolucion_reposicion_cable(){
    if(isLogin()){
      $data['reposiciones'] = $this->reposiciones_model->get_reposiciones_para_devolucion(2);
      $data['main_content'] = 'entrega_devolucion/devolucion_reposicion_cable_view';
      $data['title'] = 'Devolución ordenes de servicio';
      $this->load->view('template/template_view', $data);
    }
    else
      redirect(base_url());
  }

  
}//fin class
