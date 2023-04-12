<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calles_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_calles');
    return $query->result_array();
  }

  function get_all_asc(){
    $query = $this->db->query('SELECT fact_localidades.localidad, fact_zonas.zona, fact_calles.calle, fact_calles.idcalle FROM  fact_calles, fact_zonas, fact_localidades
                                        WHERE fact_calles.idzona=fact_zonas.idzona AND fact_zonas.idlocalidad=fact_localidades.idlocalidad
                                        ORDER BY fact_localidades.localidad, fact_zonas.zona, fact_calles.calle
                                      ');
    return $query->result_array();
  }

  function get_calle($idcalle){
    $query = $this->db->query('SELECT * FROM fact_calles WHERE idcalle=?',array($idcalle));
    return $query->row_array();
  }

  function get_all_all($idcalle){
    $query = $this->db->query('SELECT * FROM fact_calles, fact_zonas, fact_localidades 
                                        WHERE idcalle=? AND fact_calles.idzona=fact_zonas.idzona AND fact_zonas.idlocalidad=fact_localidades.idlocalidad
                                        ',array($idcalle));
    return $query->row_array();
  }

  function get_calle_zona($idzona){
    $query = $this->db->query('SELECT * FROM fact_calles WHERE idzona=? ORDER BY calle',array($idzona));
    return $query->result_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_calles" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_calles',$data);
  }
  function actualizar($idcalle, $data)
  {
    $this->db->where('idcalle', $idcalle);
    $this->db->update('fact_calles', $data);
  }
  function eliminar($idcalle)
  {
    $this->db->where('idcalle', $idcalle);
    $this->db->delete('fact_calles');
  }

}
