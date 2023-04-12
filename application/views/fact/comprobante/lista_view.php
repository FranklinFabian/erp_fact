<div class="header">
  <span class="titulo_pagina">comprobantes - lista</span>
</div>
<p></p>
<div class="content">
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>comprobante/nuevo" id="btn_nuevo" class="pure-button pure-button-primary" style="width:100%;">Nuevo comprobante</a></p></div>
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>facturacion/" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    <table>
      <thead>
        <tr>
          <th>Nro.</th>
          <th>Fecha</th>
          <th>Abierto</th>
          <th>Editar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=1;
        foreach ($comprobantes as $key => $value){
          echo '
            <tr>
              <td>'.$i++.'</td>
              <td>'.(($value['fecha'])).'</td>
              <td>'.($value['abierto']).'</td>
              <td> <a id="btn_editar" class="button-small pure-button button-warning" href="'.base_url().'comprobante/editar/'.$value['idcomprobante'].'">Editar</button></td>
              <td> <a id="btn_eliminar" class="button-small pure-button button-error" href="javascript:eliminar('.$value['idcomprobante'].')">Eliminar</button></td>
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
    location.href="<?php echo base_url();?>comprobante/eliminar/"+id;
}
</script>
