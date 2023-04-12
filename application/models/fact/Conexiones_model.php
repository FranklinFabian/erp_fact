<?php
class Conexiones_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_conexiones WHERE 1');
    return $query->result_array();
  }
    
  function get_conexion($idconexion)
  {
    $query = $this->db->query('SELECT * FROM fact_conexiones WHERE idconexion=?', array($idconexion));
    return $query->row_array();
  }

  function get_conexion_idorden($idorden)
  {
    $query = $this->db->query('SELECT * FROM fact_conexiones WHERE idorden=?', array($idorden));
    return $query->row_array();
  }

  function get_ultima_fila($idservicio){
    $query = $this->db->query('SELECT * FROM fact_conexiones WHERE idservicio=? ORDER BY numero DESC LIMIT 1',array($idservicio));
    return $query->row_array();
  }

  function get_conexiones_servicio($idservicio){
    $query = $this->db->query('SELECT * FROM fact_conexiones WHERE idservicio=? AND estado="S" AND entregado IS NOT NULL ORDER BY numero DESC',array($idservicio));
    return $query->result_array();
  }

  function get_conexiones_s($idservicio){
    $query = $this->db->query('SELECT * FROM fact_conexiones WHERE idservicio=? AND estado="S" AND pentregado IS NULL ORDER BY numero DESC',array($idservicio));
    return $query->result_array();
  }

  function get_conexiones_para_devolucion($idservicio=null){
      $query = $this->db->query('SELECT * FROM fact_conexiones WHERE idservicio=? AND fdevuelto IS NULL AND pentregado IS NOT NULL', array($idservicio));
      return $query->result_array();
  }



  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_conexiones" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_conexiones',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('idconexion', $id);
    $this->db->update('fact_conexiones', $data);
  }

  function eliminar($idconexion){
    $this->db->where('idconexion', $idconexion);
    $this->db->delete('fact_conexiones');
  }

}//fin class
