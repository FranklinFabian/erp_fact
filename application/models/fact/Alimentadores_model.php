<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Alimentadores_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_alimentadores');
    return $query->result_array();
  }

  function get_alimentador($idalimentador){
    $query = $this->db->query('SELECT * FROM fact_alimentadores WHERE idalimentador=?',array($idalimentador));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_alimentadores" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_alimentadores',$data);
  }
  function actualizar($idalimentador, $data)
  {
    $this->db->where('idalimentador', $idalimentador);
    $this->db->update('fact_alimentadores', $data);
  }
  function eliminar($idalimentador)
  {
    $this->db->where('idalimentador', $idalimentador);
    $this->db->delete('fact_alimentadores');
  }

}
