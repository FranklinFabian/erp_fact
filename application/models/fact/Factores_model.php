<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Factores_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_factores');
    return $query->result_array();
  }

  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_factores WHERE 1 ORDER BY idperiodo DESC');
    return $query->result_array();
  }

  function get_factor($idfactor){
    $query = $this->db->query('SELECT * FROM fact_factores WHERE idfactor=?',array($idfactor));
    return $query->row_array();
  }

  function get_factor_periodo($idperiodo){
    $query = $this->db->query('SELECT * FROM fact_factores WHERE idperiodo=?',array($idperiodo));
    return $query->row_array();
  }

  function get_factor_circu($idfactor){
    $query = $this->db->query('SELECT * FROM fact_factores, fact_centros
                                        WHERE fact_factores.idcentro=fact_centros.idcentro AND
                                        fact_factores.idfactor=?',array($idfactor));
    return $query->row_array();
  }

  function get_factor_centro($idcentro){
    $query = $this->db->query('SELECT * FROM fact_factores WHERE idcentro=? ORDER BY factor',array($idcentro));
    return $query->result_array();
  }


  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_factores" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_factores',$data);
  }
  function actualizar($idfactor, $data)
  {
    $this->db->where('idfactor', $idfactor);
    $this->db->update('fact_factores', $data);
  }
  function eliminar($idfactor)
  {
    $this->db->where('idfactor', $idfactor);
    $this->db->delete('fact_factores');
  }

}
