<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Beneficiarios_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_beneficiarios');
    return $query->result_array();
  }

  function get_beneficiario($idbeneficiario){
    $query = $this->db->query('SELECT * FROM fact_beneficiarios WHERE idbeneficiario=?',array($idbeneficiario));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_beneficiarios" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_beneficiarios',$data);
  }
  function actualizar($idbeneficiario, $data)
  {
    $this->db->where('idbeneficiario', $idbeneficiario);
    $this->db->update('fact_beneficiarios', $data);
  }
  function eliminar($idbeneficiario)
  {
    $this->db->where('idbeneficiario', $idbeneficiario);
    $this->db->delete('fact_beneficiarios');
  }

}
