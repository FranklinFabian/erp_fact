<?php
class Documento_sector_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_documento_sector WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_documento_sector WHERE 1 ORDER BY nro_documento_sector DESC ');
    return $query->result_array();
  }
  
  function get_documento_sector($id_documento_sector)
  {
    $query = $this->db->query('SELECT * FROM fact_documento_sector WHERE id_documento_sector=?', array($id_documento_sector));
    return $query->row_array();
  }

  function buscar_codigo_documento_sector($codigo_actividad, $codigo_documento_sector )
  {
    $query = $this->db->query('SELECT * FROM fact_documento_sector WHERE codigo_actividad =? AND codigo_documento_sector=?', array($codigo_actividad, $codigo_documento_sector));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_documento_sector" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_documento_sector',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_documento_sector', $id);
    $this->db->update('fact_documento_sector', $data);
  }

  function eliminar($id_documento_sector){
    $this->db->where('id_documento_sector', $id_documento_sector);
    $this->db->delete('fact_documento_sector');
  }

}//fin class
