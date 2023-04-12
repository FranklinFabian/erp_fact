<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ordenes_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_ordenes');
    return $query->result_array();
  }

  function get_ordenes($idabonado){
    $query = $this->db->query('SELECT * FROM fact_ordenes WHERE idabonado=?',array($idabonado));
    return $query->result_array();
  }

  function get_lista_impresion($idservicio){
    $query = $this->db->query('SELECT * FROM fact_ordenes WHERE idservicio=? AND impreso=0',array($idservicio));
    return $query->result_array();
  }

  function get_ordenes_s($idservicio){
    $query = $this->db->query('SELECT * FROM fact_ordenes WHERE idservicio=? AND estado="S" AND (fentrega IS NOT NULL) AND (devuelto IS NOT NULL)  AND (fdevuelto IS NOT NULL) ORDER BY fecha DESC',array($idservicio));
    return $query->result_array();
  }

  function get_ordenes_gestion($idgestion=null, $idservicio=null){
    if(is_null($idgestion)){
      $query = $this->db->query('SELECT * FROM fact_ordenes WHERE idservicio=? AND pentrega IS NULL', array($idservicio));
      return $query->result_array();
    }else{
      return 0;
    }

  }

  function get_ordenes_gestion_para_devolucion($idgestion=null, $idservicio=null){
    if(is_null($idgestion)){
      $query = $this->db->query('SELECT * FROM fact_ordenes WHERE idservicio=? AND fdevuelto IS NULL AND pentrega IS NOT NULL', array($idservicio));
      return $query->result_array();
    }else{
      return 0;
    }

  }

  function get_orden($idorden){
    $query = $this->db->query('SELECT * FROM fact_ordenes WHERE idorden=?',array($idorden));
    return $query->row_array();
  }

  function get_ultima_fila($idservicio){
    $query = $this->db->query('SELECT * FROM fact_ordenes WHERE idservicio=? ORDER BY idorden DESC LIMIT 1',array($idservicio));
    return $query->row_array();
  }

  function get_costo($idorden){
    $query = $this->db->query('SELECT * FROM fact_ordenes WHERE idorden=?',array($idorden));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_ordenes" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_ordenes',$data);
  }
  function actualizar($idorden, $data)
  {
    $this->db->where('idorden', $idorden);
    $this->db->update('fact_ordenes', $data);
  }
  function eliminar($idorden)
  {
    $this->db->where('idorden', $idorden);
    $this->db->delete('fact_ordenes');
  }

}
