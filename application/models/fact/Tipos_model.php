<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tipos_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_tipos');
    return $query->result_array();
  }

  function get_tipos($idtipo){
    $query = $this->db->query('SELECT * FROM fact_tipos WHERE idtipo=?',array($idtipo));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_tipos" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_tipos',$data);
  }
  function actualizar($idtipo, $data)
  {
    $this->db->where('idtipo', $idtipo);
    $this->db->update('fact_tipos', $data);
  }
  function eliminar($idtipo)
  {
    $this->db->where('idtipo', $idtipo);
    $this->db->delete('fact_tipos');
  }

}
