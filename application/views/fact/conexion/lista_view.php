<div class="header">
  <span class="titulo_pagina">calles - lista</span>
</div>
<p></p>
<div class="content">
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>calle/nuevo" id="btn_nuevo" class="pure-button pure-button-primary" style="width:100%;">Nueva calle</a></p></div>
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>localidad/" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    <table>
      <thead>
        <tr>
          <th>Nro.</th>
          <th>Código</th>
          <th>Calle</th>
          <th>Zona</th>
          <th>Editar</th>
          <th>Eliminar</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=1;
        foreach ($calles as $key => $value){
          $zonas = $this->zonas_model->get_zona($value['idzona']);
          echo '
            <tr>
              <td>'.$i++.'</td>
              <td>'.($value['codigo']).'</td>
              <td>'.($value['calle']).'</td>
              <td>'.($zonas['zona']).'</td>
              <td> <a id="btn_editar" class="button-small pure-button button-warning" href="'.base_url().'calle/editar/'.$value['idcalle'].'">Editar</button></td>
              <td> <a id="btn_eliminar" class="button-small pure-button button-error" href="javascript:eliminar('.$value['idcalle'].')">Eliminar</button></td>
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
    location.href="<?php echo base_url();?>calle/eliminar/"+id;
}
</script>
