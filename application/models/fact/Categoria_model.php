<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Categoria_model extends CI_Model
{
  function get_all()
  {
    $query = $this->db->query('SELECT * FROM fact_categoria WHERE 1 ORDER BY nombre_categoria');
    return $query->result_array();
  }
  function get_all_habilitados()
  {
    $query = $this->db->query('SELECT * FROM fact_categoria WHERE estado_categoria="1" ORDER BY nombre_categoria');
    return $query->result_array();
  }
  function get_categoria($id_categoria)
  {
    $query = $this->db->query('SELECT * FROM fact_categoria WHERE id_categoria=?',array($id_categoria));
    return $query->row_array();
  }


  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_categoria" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }
  function insertar($data)
  {
    $this->db->insert('fact_categoria',$data);
  }
  function actualizar($id_categoria, $data)
  {
    $this->db->where('id_categoria', $id_categoria);
    $this->db->update('fact_categoria', $data);
  }
  function eliminar($id_categoria)
  {
    $this->db->where('id_categoria', $id_categoria);
    $this->db->delete('fact_categoria');
  }
  function buscar_id_categoria($id_categoria)
  {
    $query = $this->db->query('SELECT * FROM fact_categoria WHERE id_categoria=?', array($id_categoria));
    $resultado = $query->result_array();
    if(count($resultado)==0)
    return false;
          else
    return true;
  }

}
