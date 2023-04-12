<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Devueltos_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_devueltos');
    return $query->result_array();
  }

  function get_devuelto($iddevuelto){
    $query = $this->db->query('SELECT * FROM fact_devueltos WHERE iddevuelto=?',array($iddevuelto));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_devueltos" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_devueltos',$data);
  }
  function actualizar($iddevuelto, $data)
  {
    $this->db->where('iddevuelto', $iddevuelto);
    $this->db->update('fact_devueltos', $data);
  }
  function eliminar($iddevuelto)
  {
    $this->db->where('iddevuelto', $iddevuelto);
    $this->db->delete('fact_devueltos');
  }

}
