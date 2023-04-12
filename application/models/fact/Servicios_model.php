<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Servicios_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_servicios');
    return $query->result_array();
  }

  function get_servicio($idservicio){
    $query = $this->db->query('SELECT * FROM fact_servicios WHERE idservicio=?',array($idservicio));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_servicios" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_servicios',$data);
  }
  function actualizar($idservicio, $data)
  {
    $this->db->where('idservicio', $idservicio);
    $this->db->update('fact_servicios', $data);
  }
  function eliminar($idservicio)
  {
    $this->db->where('idservicio', $idservicio);
    $this->db->delete('fact_servicios');
  }

}
