<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Salida_model extends CI_Model
{
  function get_all()
  {
    $query = $this->db->query('SELECT * FROM fact_salida');
    return $query->result_array();
  }
  function get_all_id_orden($id_orden)
  {
    $query = $this->db->query('SELECT * FROM fact_salida WHERE id_orden=?',array($id_orden));
    return $query->row_array();
  }
  /*
  function mis_salidaes($id_empleado)
  {
    $query = $this->db->query('SELECT * FROM salida WHERE id_empleado=? ORDER BY id_salida DESC',array($id_empleado));
    return $query->result_array();
  }  
  function get_all_all($id_salida)
  {
    $query = $this->db->query('SELECT * FROM salida, items_salida WHERE salida.id_salida=items_salida.id_salida AND salida.id_salida=?',array($id_salida));
    return $query->result_array();
  }
  function get_all_fecha($fecha)
  {
    $query = $this->db->query('SELECT * FROM salida WHERE DATE_FORMAT(`fecha_salida`, "%Y-%m-%d")=? ORDER BY fecha_salida DESC',array($fecha));
    return $query->result_array();
  }
  */
  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_salida" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }
  function insertar($data)
  {
    $this->db->insert('fact_salida',$data);
  }
  function actualizar($id_salida, $data)
  {
    $this->db->where('id_salida', $id_salida);
    $this->db->update('fact_salida', $data);
  }
  function eliminar($id_salida)
  {
    $this->db->where('id_salida', $id_salida);
    $this->db->delete('fact_salida');
  }
  function buscar_id_salida($id_salida)
  {
    $query = $this->db->query('SELECT * FROM fact_salida WHERE id_salida=?', array($id_salida));
    $resultado = $query->result_array();
    if(count($resultado)==0)
    return false;
          else
    return true;
  }

}
