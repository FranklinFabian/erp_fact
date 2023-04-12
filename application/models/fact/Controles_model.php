<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Controles_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_controles');
    return $query->result_array();
  }

  function get_controles($idcontrol){
    $query = $this->db->query('SELECT * FROM fact_controles WHERE idcontrol=?',array($idcontrol));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_controles" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_controles',$data);
  }
  function actualizar($idcontrol, $data)
  {
    $this->db->where('idcontrol', $idcontrol);
    $this->db->update('fact_controles', $data);
  }
  function eliminar($idcontrol)
  {
    $this->db->where('idcontrol', $idcontrol);
    $this->db->delete('fact_controles');
  }

}
