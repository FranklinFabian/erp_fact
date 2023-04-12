<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Abonados_model extends CI_Model
{
  function get_all(){
    $query = $this->db->query('SELECT * FROM fact_abonados');
    return $query->result_array();
  }

  function get_abonado($idabonado){
    $query = $this->db->query('SELECT * FROM fact_abonados WHERE idabonado=?',array($idabonado));
    return $query->row_array();
  }

  function get_abonado_elect($idcliente){
    $query = $this->db->query('SELECT * FROM fact_abonados WHERE idcliente=? AND idservicio=1',array($idcliente));
    return $query->row_array();
  }

  function get_abonos_cliente($idcliente){
    $query = $this->db->query('SELECT * FROM fact_abonados WHERE idcliente=?',array($idcliente));
    return $query->result_array();
  }

  function get_abonos_centro($idcentro){
    $query = $this->db->query(' SELECT fact_abonados.idabonado, fact_abonados.abonado, fact_abonados.medidor, fact_calles.calle, fact_zonas.zona, fact_cliente.razon_social
                                FROM fact_abonados, fact_calles, fact_zonas, fact_cliente
                                WHERE idcentro=? AND fact_abonados.idservicio=1 AND (fact_abonados.idcalle=fact_calles.idcalle AND fact_calles.idzona=fact_zonas.idzona AND fact_abonados.idcliente=fact_cliente.idcliente) AND fact_abonados.idestado="2"
                                ORDER BY fact_zonas.zona, fact_calles.calle, fact_razon_social, abonado
                              ',array($idcentro));
    return $query->result_array();
  }

  function get_idabonado_by_serv_centro($idservicio, $idcentro){
    $query = $this->db->query(' SELECT fact_abonados.idabonado, fact_abonados.abonado, fact_abonados.idcentro, razon_social, fact_abonados.idcalle, calle, zona
                                FROM fact_abonados, fact_cliente, fact_calles, fact_zonas
                                WHERE fact_abonados.idservicio=? AND idcentro=? AND fact_abonados.idestado="2" AND (fact_cliente.idcliente=fact_abonados.idcliente AND fact_abonados.idcalle=fact_calles.idcalle AND fact_calles.idzona=fact_zonas.idzona)
                                ORDER BY zona, calle, razon_social
                              ',array($idservicio, $idcentro));
    return $query->result_array();
  }

  function get_servicios_contratados_cliente($idcliente){
    $query = $this->db->query('SELECT DISTINCT idservicio FROM `fact_abonados` WHERE `idcliente`=?',array($idcliente));
    return $query->result_array();
  }

  function get_abonos_cliente_servicio($idcliente, $idservicio){
    $query = $this->db->query('SELECT * FROM fact_abonados WHERE idcliente=? AND idservicio=? ',array($idcliente, $idservicio));
    return $query->result_array();
  }

  function get_abonos_elect_cliente($idcliente){
    $query = $this->db->query('SELECT * FROM fact_abonados WHERE idservicio=1 AND idcliente=?',array($idcliente));
    return $query->result_array();
  }
  
  function get_ultimo_correlativo_abonado($idservicio){
    $query = $this->db->query('SELECT * FROM fact_abonados WHERE idservicio=? ORDER BY idabonado DESC LIMIT 1',array($idservicio));
    return $query->row_array();
  }

  function buscar_medidor($medidor){
    $query = $this->db->query('SELECT * FROM fact_abonados WHERE medidor=?',array($medidor));
    return $query->row_array();
  }

  function current_num(){
    $query = $this->db->query('SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA=DATABASE() AND   TABLE_NAME="fact_abonados" ');
    $resultado= $query->row_array();
    return $resultado['AUTO_INCREMENT'];
  }

  function insertar($data)
  {
    $this->db->insert('fact_abonados',$data);
  }
  function actualizar_abonado_lista($idcentro, $data)
  {
    $this->db->where('idcentro', $idcentro);
    $this->db->update('fact_abonados', $data);
  }
  function actualizar($idabonado, $data)
  {
    $this->db->where('idabonado', $idabonado);
    $this->db->update('fact_abonados', $data);
  }
  function eliminar($idabonado)
  {
    $this->db->where('idabonado', $idabonado);
    $this->db->delete('fact_abonados');
  }

}
