<?php
class Actividad_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_actividad WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_actividad WHERE 1 ORDER BY nro_actividad DESC ');
    return $query->result_array();
  }
  
  function get_actividad($id_actividad)
  {
    $query = $this->db->query('SELECT * FROM fact_actividad WHERE id_actividad=?', array($id_actividad));
    return $query->row_array();
  }

  function buscar_codigo_caeb($codigo_caeb)
  {
    $query = $this->db->query('SELECT * FROM fact_actividad WHERE codigo_caeb=?', array($codigo_caeb));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_actividad" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_actividad',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_actividad', $id);
    $this->db->update('fact_actividad', $data);
  }

  function eliminar($id_actividad){
    $this->db->where('id_actividad', $id_actividad);
    $this->db->delete('fact_actividad');
  }

}//fin class
