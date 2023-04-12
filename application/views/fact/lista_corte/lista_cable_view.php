<div class="header">
  <span class="titulo_pagina">Listas tv cable</span>
</div>
<p></p>
<div class="content">
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>lista_corte/nuevo/2" id="btn_nuevo" class="pure-button pure-button-primary" style="width:100%;">Crear</a></p></div>
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="javascript:history.back()" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>

    <table style="margin-top: 2em;">
      <caption>LISTAS CREADAS (TV CABLE)</caption>
      <thead>
        <tr>
          <th>N° Circuito.</th>
          <th>Fecha creación</th>
          <th>Servicio</th>
          <th>Descargar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        //var_dump($lista_cortes);
        foreach ($lista_cortes as $key => $lista) {
          $fila = $this->cortes_model->get_fila_lista($idservicio, $lista['lista']);
          $abonado = $this->abonados_model->get_abonado($fila['idabonado']);
          $circuito = $this->centros_model->get_centro($abonado['idcentro']);
          echo '
            <tr>
              <td>'.('['.$circuito['codigo'].'] '.$circuito['centro']).'</td>
              <td>'.($fila['fecha']).'</td>
              <td>'.($idservicio==1?'ELECTRICIDAD':'TV CABLE').'</td>
              <td> <a id="btn_editar" class="button-small pure-button button-warning" href="'.base_url().'lista_corte/generar_pdf/'.$idservicio.'/'.$lista['lista'].'">Descargar</button></td>
            </tr>
          ';
        }
        ?>
      </tbody>
    </table>
  </div>

<script>
function eliminar(id){
  if(confirm("¿Esta seguro de eliminar?"))
    location.href="<?php echo base_url();?>localidad/eliminar/"+id;
}
</script>
