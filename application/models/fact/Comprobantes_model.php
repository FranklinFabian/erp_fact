<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comprobantes_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_comprobantes');
    return $query->result_array();
  }

  function get_comprobantes($idcomprobante){
    $query = $this->db->query('SELECT * FROM fact_comprobantes WHERE idcomprobante=?',array($idcomprobante));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_comprobantes" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_comprobantes',$data);
  }
  function actualizar($idcomprobante, $data)
  {
    $this->db->where('idcomprobante', $idcomprobante);
    $this->db->update('fact_comprobantes', $data);
  }
  function eliminar($idcomprobante)
  {
    $this->db->where('idcomprobante', $idcomprobante);
    $this->db->delete('fact_comprobantes');
  }

}
