<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ley1886_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_ley1886');
    return $query->result_array();
  }

  function get_ley1886($idley1886){
    $query = $this->db->query('SELECT * FROM fact_ley1886 WHERE idley1886=?',array($idley1886));
    return $query->row_array();
  }

  function get_habilitados(){
    $query = $this->db->query('SELECT * FROM fact_ley1886 WHERE vigente=1');
    return $query->result_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_ley1886" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_ley1886',$data);
  }
  function actualizar($idley1886, $data)
  {
    $this->db->where('idley1886', $idley1886);
    $this->db->update('fact_ley1886', $data);
  }
  function eliminar($idley1886)
  {
    $this->db->where('idley1886', $idley1886);
    $this->db->delete('fact_ley1886');
  }

}
