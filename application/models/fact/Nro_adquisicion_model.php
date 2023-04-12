<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nro_adquisicion_model extends CI_Model
{
  function get_all()
  {
    $query = $this->db->query('SELECT * FROM fact_nro_adquisicion');
    return $query->result_array();
  }

  function get_id_nro_adquisicion($id_nro_adquisicion)
  {
    $query = $this->db->query('SELECT * FROM fact_nro_adquisicion WHERE id_nro_adquisicion=?', array($id_nro_adquisicion));
    return $query->row_array();
  }

  function get_all_id_nro_adquisicion($id_nro_adquisicion)
  {
    $query = $this->db->query('SELECT * FROM fact_nro_adquisicion, fact_adquisicion_producto, fact_producto WHERE fact_nro_adquisicion.id_nro_adquisicion=fact_adquisicion_producto.id_nro_adquisicion AND fact_adquisicion_producto.id_producto=fact_producto.id_producto AND fact_nro_adquisicion.id_nro_adquisicion=?', array($id_nro_adquisicion));
    return $query->row_array();
  }

  function get_all_all()
  {
    $query = $this->db->query('SELECT * FROM fact_nro_adquisicion WHERE 1 ORDER BY id_nro_adquisicion DESC');
    return $query->result_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_nro_adquisicion" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }
  function insertar($data)
  {
    $this->db->insert('fact_nro_adquisicion',$data);
  }
  function actualizar($id_nro_adquisicion, $data)
  {
    $this->db->where('id_nro_adquisicion', $id_nro_adquisicion);
    $this->db->update('fact_nro_adquisicion', $data);
  }
  function eliminar($id_nro_adquisicion)
  {
    $this->db->where('id_nro_adquisicion', $id_nro_adquisicion);
    $this->db->delete('fact_nro_adquisicion');
  }

}
