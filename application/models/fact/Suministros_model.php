<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Suministros_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_suministros');
    return $query->result_array();
  }

  function get_suministro($idsuministro){
    $query = $this->db->query('SELECT * FROM fact_suministros WHERE idsuministro=?',array($idsuministro));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_suministros" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_suministros',$data);
  }
  function actualizar($idsuministro, $data)
  {
    $this->db->where('idsuministro', $idsuministro);
    $this->db->update('fact_suministros', $data);
  }
  function eliminar($idsuministro)
  {
    $this->db->where('idsuministro', $idsuministro);
    $this->db->delete('fact_suministros');
  }

}
