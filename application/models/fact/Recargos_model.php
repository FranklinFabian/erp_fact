<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Recargos_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_recargos');
    return $query->result_array();
  }

  function get_recargo($idrecargo){
    $query = $this->db->query('SELECT * FROM fact_recargos WHERE idrecargo=?',array($idrecargo));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_recargos" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_recargos',$data);
  }
  function actualizar($idrecargo, $data)
  {
    $this->db->where('idrecargo', $idrecargo);
    $this->db->update('fact_recargos', $data);
  }
  function eliminar($idrecargo)
  {
    $this->db->where('idrecargo', $idrecargo);
    $this->db->delete('fact_recargos');
  }

}
