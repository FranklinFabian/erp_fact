<?php
class Producto_servicio_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_producto_servicio WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_producto_servicio WHERE 1 ORDER BY nro_producto_servicio DESC ');
    return $query->result_array();
  }
  
  function get_producto_servicio($id_producto_servicio)
  {
    $query = $this->db->query('SELECT * FROM fact_producto_servicio WHERE id_producto_servicio=?', array($id_producto_servicio));
    return $query->row_array();
  }

  function buscar_codigo_producto_servicio($codigo_actividad, $codigo_producto, $descripcion_producto)
  {
    $query = $this->db->query('SELECT * FROM fact_producto_servicio WHERE codigo_actividad =? AND codigo_producto =? AND descripcion_producto =?', array($codigo_actividad, $codigo_producto, $descripcion_producto));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_producto_servicio" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_producto_servicio',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_producto_servicio', $id);
    $this->db->update('fact_producto_servicio', $data);
  }

  function eliminar($id_producto_servicio){
    $this->db->where('id_producto_servicio', $id_producto_servicio);
    $this->db->delete('fact_producto_servicio');
  }

}//fin class
