<div class="header">
  <span class="titulo_pagina">INGRESO</span>
</div>
<p></p>

<div class="content">
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>incrementar/nuevo" id="btn_nuevo" class="pure-button pure-button-primary" style="width: 100%">Nuevo ingreso</a></p></div>
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="javascript:window.history.back();" id="btn_nuevo" class="pure-button button-secondary" style="width: 100%">Atras</a></p></div>
    </div>
    <hr>
  <h2 class="content-head is-center">INGRESO A ALMACEN</h2>
    
    <table>
      <thead>
        <tr>
          <th># INGR.</th>
          <th>FECHA.</th>
          <th>PROVEEDOR</th>
          <th>DOC. RESPALDO</th>
          <th>GLOSA</th>
          <th>RESPONSABLE</th>
          <th>DETALLE</th>
          <th>EDITAR DATOS</th>
          <th>EDITAR ITEMS</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=1;
        //$lista= array();
        foreach ($lista as $key => $value)
        {
          $empleado = $this->empleado_model->get_empleado($value['id_empleado']);
          echo '
            <tr>
              <td style="text-align:right">'.$value['id_nro_adquisicion'].'</td>
              <td style="text-align:right">'.(($value['fecha_adquisicion'])).'</td>
              <td>'.(substr($value['proveedor'], 0,10)).'...  '.'</td>
              <td>'.$value['doc_respaldo'].' '.$value['nro_doc_respaldo'].'</td>
              <td>'.substr($value['observacion'], 0,15).'...'.'</td>
              <td>'.substr(($empleado['nombre'].' '.$empleado['apellido']), 0, 10).'...'.'</td>
              <td style="text-align:center"><a href="'.base_url().'incrementar/ver_detalle/'.$value['id_nro_adquisicion'].'" target="_blank" window.open(this.href, this.target); return false;" >Ingr. '.$value['id_nro_adquisicion'].'</a></td>
              <td style="text-align:center"><a href="'.base_url().'incrementar/editar_datos/'.$value['id_nro_adquisicion'].'" class="pure-button button-warning button-small" >Datos</a></td>
              <td style="text-align:center"><a href="'.base_url().'incrementar/editar_items/'.$value['id_nro_adquisicion'].'" class="pure-button button-success button-small" >Items</a></td>
            </tr>
          ';
          $i++;
        }
        ?>
      </tbody>
    </table>
  </div>

<script>
function detalle(id_nro_adquisicion){
  location.href=BASE_URL+"incrementar/ver_detalle/"+id_nro_adquisicion;
}
</script>
