<?php
class Parametrica_evento_significativo_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_evento_significativo WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_parametrica_evento_significativo WHERE 1 ORDER BY nro_parametrica_evento_significativo DESC ');
    return $query->result_array();
  }
  
  function get_parametrica_evento_significativo($id_parametrica_evento_significativo)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_evento_significativo WHERE id_parametrica_evento_significativo=?', array($id_parametrica_evento_significativo));
    return $query->row_array();
  }

  function buscar_codigo_parametrica_evento_significativo($codigo_clasificador)
  {
    $query = $this->db->query('SELECT * FROM fact_parametrica_evento_significativo WHERE codigo_clasificador =?', array($codigo_clasificador));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_parametrica_evento_significativo" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_parametrica_evento_significativo',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_parametrica_evento_significativo', $id);
    $this->db->update('fact_parametrica_evento_significativo', $data);
  }

  function eliminar($id_parametrica_evento_significativo){
    $this->db->where('id_parametrica_evento_significativo', $id_parametrica_evento_significativo);
    $this->db->delete('fact_parametrica_evento_significativo');
  }

}//fin class
