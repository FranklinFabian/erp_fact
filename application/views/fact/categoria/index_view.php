<div class="header">
  <span class="titulo_pagina">Administración - Categorías</span>
</div>
<p></p>

<div class="content">
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>categoria/nuevo_categoria" id="btn_nuevo" class="pure-button pure-button-primary" style="width:100%;">Nueva Categoría</a></p></div>
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>categoria/imp_categorias" target="_blank" class="pure-button pure-button-primary" style="width:100%;">Imprimir</a></p></div>
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>admin/" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>

    </div>
    <table>
      <thead>
        <tr>
          <th>Nro.</th>
          <th>Categoría</th>
          <th>Estado</th>
          <th>Editar</th>
          <th>Bloquear</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=1;
        foreach ($aperturas_programaticas as $key => $value)
        {
          echo '
            <tr>
              <td>'.$i++.'</td>
              <td>'.($value['nombre_categoria']).'</td>
              <td>'.($value['estado_categoria']=='1'?'Habilitado':'<span class="rojo">Deshabilitado</span>').'</td>
              <td>   <button id="btn_editar" class="button-small pure-button button-warning" onclick="editar('.$value['id_categoria'].');">Editar</button></td>
              <td> <button id="btn_eliminar" class="button-small pure-button button-error"   onclick="bloquear('.$value['id_categoria'].');">Bloquear</button></td>
            </tr>
          ';
        }
        ?>
      </tbody>
    </table>
  </div>

<script>
function editar(id_categoria)
{
  location.href=BASE_URL+"categoria/editar_categoria/"+id_categoria;
}

function bloquear(id_categoria)
{
  if(confirm("¿Esta seguro de bloquear esta apertura?"))
    location.href="<?php echo base_url();?>categoria/bloquear_categoria/"+id_categoria;
}
</script>
