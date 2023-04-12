<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empleado_model extends CI_Model
{
  function login($user, $pass)
  {
    $query = $this->db->query('SELECT * FROM fact_empleado WHERE usuario=? AND password=?', array($user,$pass));
    return $query->row_array();
  }
  function get_all()
  {
    $query = $this->db->query('SELECT * FROM fact_empleado WHERE 1 ORDER BY apellido, nombre');
    return $query->result_array();
  }
  function get_all_all($id_empleado)
  {
    $query = $this->db->query('SELECT * FROM fact_empleado, fact_cargo, fact_sub_area, fact_area 
                                WHERE fact_empleado.id_cargo=fact_cargo.id_cargo AND
                                      fact_cargo.id_sub_area=fact_sub_area.id_sub_area AND
                                      fact_sub_area.id_area=fact_area.id_area AND 
                                      fact_empleado.id_empleado=?',array($id_empleado));
    return $query->row_array();
  }
  function get_all_habilitados()
  {
    $query = $this->db->query('SELECT * FROM fact_empleado WHERE fact_empleado.estado="1"');
    return $query->result_array();
  }
  function get_empleado($id_empleado)
  {
    $query = $this->db->query('SELECT * FROM fact_empleado WHERE id_empleado=?',array($id_empleado));
    return $query->row_array();
  }


  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_empleado" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }
  function insertar($data)
  {
    $this->db->insert('fact_empleado',$data);
  }
  function actualizar($id_empleado, $data)
  {
    $this->db->where('id_empleado', $id_empleado);
    $this->db->update('fact_empleado', $data);
  }
  function eliminar($id_empleado)
  {
    $this->db->where('id_empleado', $id_empleado);
    $this->db->delete('fact_empleado');
  }
  function buscar_id_empleado($id_empleado)
  {
    $query = $this->db->query('SELECT * FROM fact_empleado WHERE id_empleado=?', array($id_empleado));
    $resultado = $query->result_array();
    if(count($resultado)==0)
    return false;
          else
    return true;
  }

}
