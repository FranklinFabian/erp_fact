<?php
class Mensaje_servicio_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_mensaje_servicio WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_mensaje_servicio WHERE 1 ORDER BY nro_mensaje_servicio DESC ');
    return $query->result_array();
  }
  
  function get_mensaje_servicio($id_mensaje_servicio)
  {
    $query = $this->db->query('SELECT * FROM fact_mensaje_servicio WHERE id_mensaje_servicio=?', array($id_mensaje_servicio));
    return $query->row_array();
  }

  function buscar_codigo_mensaje_servicio($codigo_clasificador)
  {
    $query = $this->db->query('SELECT * FROM fact_mensaje_servicio WHERE codigo_clasificador =?', array($codigo_clasificador));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_mensaje_servicio" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_mensaje_servicio',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_mensaje_servicio', $id);
    $this->db->update('fact_mensaje_servicio', $data);
  }

  function eliminar($id_mensaje_servicio){
    $this->db->where('id_mensaje_servicio', $id_mensaje_servicio);
    $this->db->delete('fact_mensaje_servicio');
  }

}//fin class
