<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Empleados_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_empleados');
    return $query->result_array();
  }

  function get_all_vigente(){
    $query = $this->db->query('SELECT * FROM fact_empleados WHERE vigente=1 ORDER BY paterno');
    return $query->result_array();
  }

  function get_empleado($idempleado){
    $query = $this->db->query('SELECT * FROM fact_empleados WHERE idempleado=?',array($idempleado));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_empleados" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_empleados',$data);
  }
  function actualizar($idempleado, $data)
  {
    $this->db->where('idempleado', $idempleado);
    $this->db->update('fact_empleados', $data);
  }
  function eliminar($idempleado)
  {
    $this->db->where('idempleado', $idempleado);
    $this->db->delete('fact_empleados');
  }

}
