<?php
class Cufd_model extends CI_Model{
  
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_cufd WHERE 1');
    return $query->result_array();
  }
  
  function get_all_desc(){
    $query = $this->db->query('SELECT * FROM fact_cufd WHERE 1 ORDER BY nro_cufd DESC ');
    return $query->result_array();
  }
  
  function get_cufd($id_cufd)
  {
    $query = $this->db->query('SELECT * FROM fact_cufd WHERE id_cufd=?', array($id_cufd));
    return $query->row_array();
  }

  function get_cufd_by_id_pv($id_punto_venta)
  {
    $query = $this->db->query('SELECT * FROM fact_cufd WHERE id_punto_venta=? ORDER BY id_cufd DESC LIMIT 1', array($id_punto_venta));
    return $query->row_array();
  }

  function buscar_codigo_cufd($codigo)
  {
    $query = $this->db->query('SELECT * FROM fact_cufd WHERE codigo =?', array($codigo));
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_cufd" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data){
    $this->db->insert('fact_cufd',$data);
  }
  
  function actualizar($id, $data)
  {
    $this->db->where('id_cufd', $id);
    $this->db->update('fact_cufd', $data);
  }

  function eliminar($id_cufd){
    $this->db->where('id_cufd', $id_cufd);
    $this->db->delete('fact_cufd');
  }

}//fin class
