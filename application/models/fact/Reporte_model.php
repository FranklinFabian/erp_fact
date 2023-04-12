<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporte_model extends CI_Model
{
  function get_000_020($idperiodo){
    $query = $this->db->query('SELECT * FROM fact_lecturas
                               WHERE (kwh BETWEEN 0 AND 20) AND idperiodo=? AND imp_total > 0 AND idservicio=1 AND idcategoria=1
    ', array($idperiodo));
    return $query->result_array(); // (kwh BETWEEN 0 AND 20) AND 
  }
  function get_021_100($idperiodo){
    $query = $this->db->query('SELECT * FROM fact_lecturas
                               WHERE (kwh BETWEEN 21 AND 100) AND idperiodo=? AND imp_total > 0 AND idservicio=1 AND idcategoria=1
    ', array($idperiodo));
    return $query->result_array(); // (kwh BETWEEN 0 AND 20) AND 
  }
  function get_101_ade($idperiodo){
    $query = $this->db->query('SELECT * FROM fact_lecturas
                               WHERE (kwh >= 101) AND idperiodo=? AND imp_total > 0 AND idservicio=1 AND idcategoria=1
    ', array($idperiodo));
    return $query->result_array(); // (kwh BETWEEN 0 AND 20) AND 
  }
//////////////////GENERAL
function get_gen_000_020($idperiodo){
  $query = $this->db->query('SELECT * FROM fact_lecturas
                             WHERE (kwh BETWEEN 0 AND 20) AND idperiodo=? AND imp_total > 0 AND idservicio=1 AND idcategoria=2
  ', array($idperiodo));
  return $query->result_array(); // (kwh BETWEEN 0 AND 20) AND 
}
function get_gen_021_100($idperiodo){
  $query = $this->db->query('SELECT * FROM fact_lecturas
                             WHERE (kwh BETWEEN 21 AND 100) AND idperiodo=? AND imp_total > 0 AND idservicio=1 AND idcategoria=2
  ', array($idperiodo));
  return $query->result_array(); // (kwh BETWEEN 0 AND 20) AND 
}
function get_gen_101_ade($idperiodo){
  $query = $this->db->query('SELECT * FROM fact_lecturas
                             WHERE (kwh >= 101) AND idperiodo=? AND imp_total > 0 AND idservicio=1 AND idcategoria=2
  ', array($idperiodo));
  return $query->result_array(); // (kwh BETWEEN 0 AND 20) AND 
}

//////////////////IND MENOR
function get_ind_menor_000_050($idperiodo){
  $query = $this->db->query('SELECT * FROM fact_lecturas
                             WHERE (kwh BETWEEN 0 AND 50) AND idperiodo=? AND imp_total > 0 AND idservicio=1 AND idcategoria=3
  ', array($idperiodo));
  return $query->result_array(); // (kwh BETWEEN 0 AND 50) AND 
}
function get_ind_menor_021_100($idperiodo){
  $query = $this->db->query('SELECT * FROM fact_lecturas
                             WHERE (kwh BETWEEN 21 AND 100) AND idperiodo=? AND imp_total > 0 AND idservicio=1 AND idcategoria=3
  ', array($idperiodo));
  return $query->result_array();
}
function get_ind_menor_51_ade($idperiodo){
  $query = $this->db->query('SELECT * FROM fact_lecturas
                             WHERE (kwh >= 51) AND idperiodo=? AND imp_total > 0 AND idservicio=1 AND idcategoria=3
  ', array($idperiodo));
  return $query->result_array();
}

///////////////////////////////////// IND MAYOR
function get_ind_mayor_000_ade($idperiodo){
  $query = $this->db->query('SELECT * FROM fact_lecturas
                             WHERE (kwh >= 0) AND idperiodo=? AND imp_total > 0 AND idservicio=1 AND idcategoria=4
  ', array($idperiodo));
  return $query->result_array();
}

///////////////////////////////////// ALUMBRADO PUBLICO
function get_alum_publi_000_ade($idperiodo){
  $query = $this->db->query('SELECT * FROM fact_lecturas
                             WHERE (kwh >= 0) AND idperiodo=? AND imp_total > 0 AND idservicio=1 AND idcategoria=5
  ', array($idperiodo));
  return $query->result_array();
}

///////////////////////////////////// LEY 1886
function get_ley1886($idperiodo){
  $query = $this->db->query('SELECT * FROM fact_lecturas
                             WHERE (kwh >= 0) AND idperiodo=? AND imp_total > 0 AND idservicio=1 AND idcategoria=7
  ', array($idperiodo));
  return $query->result_array();
}


}
