<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maniobras_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_maniobras');
    return $query->result_array();
  }

  function get_maniobra($idmaniobra){
    $query = $this->db->query('SELECT * FROM fact_maniobras WHERE idmaniobra=?',array($idmaniobra));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_maniobras" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_maniobras',$data);
  }
  function actualizar($idmaniobra, $data)
  {
    $this->db->where('idmaniobra', $idmaniobra);
    $this->db->update('fact_maniobras', $data);
  }
  function eliminar($idmaniobra)
  {
    $this->db->where('idmaniobra', $idmaniobra);
    $this->db->delete('fact_maniobras');
  }

}
