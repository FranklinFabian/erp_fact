<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Directos_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_directos');
    return $query->result_array();
  }

  function get_directos($iddirecto){
    $query = $this->db->query('SELECT * FROM fact_directos WHERE iddirecto=?',array($iddirecto));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_directos" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_directos',$data);
  }
  function actualizar($iddirecto, $data)
  {
    $this->db->where('iddirecto', $iddirecto);
    $this->db->update('fact_directos', $data);
  }
  function eliminar($iddirecto)
  {
    $this->db->where('iddirecto', $iddirecto);
    $this->db->delete('fact_directos');
  }

}
