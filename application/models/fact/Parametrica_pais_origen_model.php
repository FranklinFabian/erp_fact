<?php
class Parametrica_pais_origen_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_pais_origen WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_pais_origen WHERE 1 ORDER BY nro_parametrica_pais_origen DESC ');
    return $query->result_array();
  }
  
  function get_parametrica_pais_origen($id_parametrica_pais_origen)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_pais_origen WHERE id_parametrica_pais_origen=?', array($id_parametrica_pais_origen));
    return $query->row_array();
  }

  function buscar_codigo_parametrica_pais_origen($codigo_clasificador)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_pais_origen WHERE codigo_clasificador =?', array($codigo_clasificador));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_parametrica_pais_origen" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_parametrica_pais_origen',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_parametrica_pais_origen', $id);
    $this->db->update('fact_parametrica_pais_origen', $data);
  }

  function eliminar($id_parametrica_pais_origen){
    $this->db->where('id_parametrica_pais_origen', $id_parametrica_pais_origen);
    $this->db->delete('fact_parametrica_pais_origen');
  }

}//fin class
