<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mediciones_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_mediciones');
    return $query->result_array();
  }

  function get_medicion($idmedicion){
    $query = $this->db->query('SELECT * FROM fact_mediciones WHERE idmedicion=?',array($idmedicion));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_mediciones" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_mediciones',$data);
  }
  function actualizar($idmedicion, $data)
  {
    $this->db->where('idmedicion', $idmedicion);
    $this->db->update('fact_mediciones', $data);
  }
  function eliminar($idmedicion)
  {
    $this->db->where('idmedicion', $idmedicion);
    $this->db->delete('fact_mediciones');
  }

}
