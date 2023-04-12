<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calculo_tv_model extends CI_Model
{
  function get_abonados_tv($idservicio){
    $query = $this->db->query('SELECT idabonado, abonado, cantidad, fechainsta, fechacorte, fecharepos, idcategoria
                               FROM abonados
                               WHERE (abonados.idservicio=?) AND abonados.idestado="2"
                               ',array($idservicio));
    return $query->result_array();
  }

  function get_abonados_extra_tv($idservicio, $fecha_ini, $fecha_fin){
    $query = $this->db->query('SELECT idabonado, abonado, cantidad, fechainsta, fechacorte, fecharepos, idcategoria
                               FROM abonados
                               WHERE (abonados.idservicio=?) AND abonados.idestado<>"2" AND
                                     (fechacorte between "'.$fecha_ini.'" AND "'.$fecha_fin.'" ) OR  (fecharepos between '.$fecha_ini.' AND '.$fecha_fin.' )
                               ',array($idservicio));
    return $query->result_array();
  }

  //llama al procedimiento almacenado
  function llamada($idabonado, $idperiodo, $fecha_inicio, $fecha_fin){

    $sql = "call calcular_tv_cable(?, ?, ?, ?, @dias_servicio, @importe );";
    $params = array($idabonado, $idperiodo, $fecha_inicio, $fecha_fin);
    $this->db->query($sql, $params);
    $sqlGetOutParam = "SELECT @dias_servicio as dias_servicio, @importe as importe;";
    $result = $this->db->query($sqlGetOutParam);
    
    return $result->row_array();
  }

  //verifica si existe registro
  function verifica_adelantado($idabonado, $idperiodo){
    $query = $this->db->query('SELECT idlectura, idabonado, idperiodo, estado FROM lecturas
                               WHERE lecturas.idabonado=? AND lecturas.idperiodo=? AND lecturas.idservicio=2 
                               ',array($idabonado, $idperiodo ));
    return $query->row_array();
  }

  //saca monto reposicion de cortes y reposiciones
  function get_reposicion($idabonado){
    $query = $this->db->query('SELECT reposiciones.costo, reposiciones.idreposicion FROM abonados, cortes, reposiciones
                               WHERE abonados.idabonado=? AND abonados.idabonado=cortes.idabonado AND cortes.idcorte=reposiciones.idcorte AND 
                                     cortes.estado="E" AND reposiciones.estado="E" '
                               ,array($idabonado));
    return $query->row_array();
  }


}
