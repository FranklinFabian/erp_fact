<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reposiciones_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_reposiciones');
    return $query->result_array();
  }

  function get_reposicion($idreposicion){
    $query = $this->db->query('SELECT * FROM fact_reposiciones WHERE idreposicion=?',array($idreposicion));
    return $query->row_array();
  }

  function get_rep_by_idcorte($idcorte){
    $query = $this->db->query('SELECT * FROM fact_reposiciones WHERE idcorte=?',array($idcorte));
    return $query->row_array();
  }

  function contar_idcorte($idcorte){
    $query = $this->db->query('SELECT * FROM fact_reposiciones WHERE idcorte=?',array($idcorte));
    return $query->row_array();
  }

  function get_reposiciones_s($idservicio){
    $query = $this->db->query('SELECT * FROM fact_reposiciones WHERE idservicio=? AND estado="S" AND (fentrega IS NULL) AND (devuelto IS NULL)  AND (fdevuelto IS NULL) ORDER BY fecha_pago DESC',array($idservicio));
    return $query->result_array();
  }

  // function get_cortes_gestion_para_devolucion($idservicio=null){
  //   $query = $this->db->query('SELECT * FROM cortes WHERE idservicio=? AND fdevuelto IS NULL AND pentrega IS NOT NULL', array($idservicio));
  //   return $query->result_array();
  // }


  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_reposiciones" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function get_ultima_fila($idservicio){
    $query = $this->db->query('SELECT * FROM fact_reposiciones WHERE idservicio=? ORDER BY idcorte DESC LIMIT 1',array($idservicio));
    return $query->row_array();
  }

  function get_reposiciones_para_devolucion($idservicio=null){
    $query = $this->db->query('SELECT * FROM fact_reposiciones WHERE idservicio=? AND fdevuelto IS NULL AND pentrega IS NOT NULL', array($idservicio));
    return $query->result_array();
  }

  function get_reposiciones_para_procesar($idservicio){
    $query = $this->db->query('SELECT * FROM fact_reposiciones WHERE idservicio=? AND estado="S" AND entregado IS NOT NULL ORDER BY numero DESC',array($idservicio));
    return $query->result_array();
  }


  function insertar($data)
  {
    $this->db->insert('fact_reposiciones',$data);
  }
  function actualizar($idreposicion, $data)
  {
    $this->db->where('idreposicion', $idreposicion);
    $this->db->update('fact_reposiciones', $data);
  }
  function eliminar($idreposicion)
  {
    $this->db->where('idreposicion', $idreposicion);
    $this->db->delete('fact_reposiciones');
  }

}
