<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Liberaciones_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_liberaciones');
    return $query->result_array();
  }

  function get_liberacion($idliberacion){
    $query = $this->db->query('SELECT * FROM fact_liberaciones WHERE idliberacion=?',array($idliberacion));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_liberaciones" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_liberaciones',$data);
  }
  function actualizar($idliberacion, $data)
  {
    $this->db->where('idliberacion', $idliberacion);
    $this->db->update('fact_liberaciones', $data);
  }
  function eliminar($idliberacion)
  {
    $this->db->where('idliberacion', $idliberacion);
    $this->db->delete('fact_liberaciones');
  }

}
