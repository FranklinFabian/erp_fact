<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autorizaciones_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_autorizaciones');
    return $query->result_array();
  }

  function get_autorizacion($idautorizacion){
    $query = $this->db->query('SELECT * FROM fact_autorizaciones WHERE idautorizacion=?',array($idautorizacion));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_autorizaciones" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_autorizaciones',$data);
  }
  function actualizar($idautorizacion, $data)
  {
    $this->db->where('idautorizacion', $idautorizacion);
    $this->db->update('fact_autorizaciones', $data);
  }
  function eliminar($idautorizacion)
  {
    $this->db->where('idautorizacion', $idautorizacion);
    $this->db->delete('fact_autorizaciones');
  }

}
