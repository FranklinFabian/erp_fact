<div class="header">
  <span class="titulo_pagina">Administración - Productos</span>
</div>
<p></p>

<div class="content">
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>producto/nuevo_producto" id="btn_nuevo" class="pure-button pure-button-primary" style="width:100%;">Nuevo Producto</a></p></div>
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>producto/imp_productos" target="_blank" class="pure-button pure-button-primary" style="width:100%;">Imprimir</a></p></div>
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>admin/" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    
    </div>
    <table>
      <thead>
        <tr>
          <th>Nro.</th>
          <th>Producto</th>
          <th>Código Barras</th>
          <th>Unidad</th>
          <th>P. Venta</th>
          <!--<th>Precio</th>-->
          <th>Habilitado</th>
          <!--<th>A.P.</th>-->
          <th>Editar</th>
        </tr>
      </thead>
      <tbody>
        
        <?php
        $i=1;
        foreach ($productos as $key => $value)
        {
          $unidad = $this->parametrica_unidad_medida_model->get_parametrica_unidad_medida($value['id_unidad_medida']);
          echo '
            <tr>
              <td>'.$i++.'</td>
              <td>'.($value['nombre_producto']).'</td>
              <td>'.($value['cod_producto']).'</td>
              <td>'.($unidad['descripcion']).'</td>
              <td style="text-align:right">'.(number_format($value['precio_venta'],'2',',','.')).'</td>
              <td>'.($value['estado_producto']=='1'?'Habilitado':'<span style="color:red">Deshabilitado</span>').'</td>
              <td>   <button id="btn_editar" class="button-small pure-button button-warning" onclick="editar('.$value['id_producto'].');">Editar</button></td>
            </tr>
          ';
        }
        ?>
      </tbody>
    </table>
  </div>

<script>
function editar(id_producto)
{
  location.href=BASE_URL+"producto/editar_producto/"+id_producto;
}

function eliminar(id_producto)
{
  if(confirm("¿Esta seguro de eliminar?"))
    location.href="<?php echo base_url();?>producto/eliminar_producto/"+id_producto;
}
</script>
