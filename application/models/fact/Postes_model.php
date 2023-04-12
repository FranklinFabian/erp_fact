<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Postes_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_postes');
    return $query->result_array();
  }

  function get_poste($idposte){
    $query = $this->db->query('SELECT * FROM fact_postes WHERE idposte=?',array($idposte));
    return $query->row_array();
  }

  function get_poste_circu($idposte){
    $query = $this->db->query('SELECT * FROM fact_postes, fact_centros
                                        WHERE fact_postes.idcentro=fact_centros.idcentro AND
                                        fact_postes.idposte=?',array($idposte));
    return $query->row_array();
  }

  function get_poste_centro($idcentro){
    $query = $this->db->query('SELECT * FROM fact_postes WHERE idcentro=? ORDER BY poste',array($idcentro));
    return $query->result_array();
  }


  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_postes" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_postes',$data);
  }
  function actualizar($idposte, $data)
  {
    $this->db->where('idposte', $idposte);
    $this->db->update('fact_postes', $data);
  }
  function eliminar($idposte)
  {
    $this->db->where('idposte', $idposte);
    $this->db->delete('fact_postes');
  }

}
