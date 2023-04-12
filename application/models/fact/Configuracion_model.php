<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Configuracion_model extends CI_Model
{
  function get_all()
  {
    $query = $this->db->query('SELECT * FROM fact_configuracion LIMIT 1');
    return $query->row_array();
  }

  function current_num()
  {
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_configuracion" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_configuracion',$data);
  }
  function actualizar($id_configuracion, $data)
  {
    $this->db->where('id_configuracion', $id_configuracion);
    $this->db->update('fact_configuracion', $data);
  }

  function eliminar($id_configuracion)
  {
    $this->db->where('id_configuracion', $id_configuracion);
    $this->db->delete('fact_configuracion');
  }
  function valores_fabrica()
  {
    $query = $this->db->query('SET FOREIGN_KEY_CHECKS=0;');
    $query = $this->db->query('TRUNCATE TABLE `fact_configuracion`;');
    $query = $this->db->query('TRUNCATE TABLE `fact_empleado`;');
    $query = $this->db->query('TRUNCATE TABLE `fact_cuis`;');
    $query = $this->db->query('TRUNCATE TABLE `fact_punto_venta`;');
    $query = $this->db->query('SET FOREIGN_KEY_CHECKS=1;');
    $query = $this->db->query('INSERT INTO fact_empleado VALUES(1, "ADMIN", "ADMINISTRADOR", "admin", MD5("magomalo"), "2", "1", NULL )');
    $query = $this->db->query('INSERT INTO fact_punto_venta VALUES(1, 0, 0, 5, "DESCRIPCIÓN PUNTO VENTA", "MI PUNTO DE VENTA")');

  }
//INSERT INTO cliente VALUES(1, "SIN NOMBRE", "0");
}
