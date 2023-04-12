<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Costos_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_costos');
    return $query->result_array();
  }

  function get_costo($idcosto){
    $query = $this->db->query('SELECT * FROM fact_costos WHERE idcosto=?',array($idcosto));
    return $query->row_array();
  }

  function get_costo_by_idgestion($idgestion){
    $query = $this->db->query('SELECT * FROM fact_costos WHERE idgestion=?',array($idgestion));
    return $query->row_array();
  }

  function get_costo_repo($idperiodo, $idgestion){
    $query = $this->db->query('SELECT * FROM fact_costos WHERE idperiodo=? AND idgestion=?',array($idperiodo, $idgestion));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_costos" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_costos',$data);
  }
  function actualizar($idcosto, $data)
  {
    $this->db->where('idcosto', $idcosto);
    $this->db->update('fact_costos', $data);
  }
  function eliminar($idcosto)
  {
    $this->db->where('idcosto', $idcosto);
    $this->db->delete('fact_costos');
  }

}
