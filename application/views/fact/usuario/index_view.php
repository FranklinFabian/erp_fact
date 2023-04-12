<div class="header">
  <span class="titulo_pagina">Administración - Usuarios</span>
</div>
<p></p>
<div class="content">
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>usuario/nuevo_usuario" id="btn_nuevo" class="pure-button pure-button-primary" style="width:100%;">Nuevo Usuario</a></p></div>
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>admin/imp_usuarios" target="_blank" class="pure-button pure-button-primary" style="width:100%;">Imprimir</a></p></div>
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>admin/" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>

    </div>
    <table>
      <thead>
        <tr>
          <th>Nro.</th>
          <th>Nombre Completo</th>
          <th>Usuario</th>
          <th>Nivel</th>
          <th>Estado</th>
          <th>Editar</th>
          <th>Bloquear</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=1;
        $niveles = $this->config->item('niveles');
        foreach ($usuarios as $key => $value){

          echo '
            <tr>
              <td>'.$i++.'</td>
              <td>'.($value['apellido'].' '.$value['nombre']).'</td>
              <td>'.$value['usuario'].'</td>
              <td>'.$niveles[$value['nivel']].'</td>

              <td>'.($value['estado']=='1'?'Habilitado':'<span class="rojo">Deshabilitado</span>').'</td>
              <td> <button id="btn_editar" class="button-small pure-button button-warning" onclick="editar('.$value['id_empleado'].');">Editar</button></td>
              <td> <button id="btn_bloquear" class="button-small pure-button button-error"   onclick="bloquear('.$value['id_empleado'].');">Bloquear</button></td>
            </tr>
          ';
        }
        ?>
      </tbody>
    </table>
  </div>

<script>
function editar(id_empleado)
{
  location.href=BASE_URL+"usuario/editar_usuario/"+id_empleado;
}

function bloquear(id_empleado)
{
  if(confirm("¿Esta seguro de bloquear?"))
    location.href="<?php echo base_url();?>usuario/bloquear_usuario/"+id_empleado;
}
</script>
