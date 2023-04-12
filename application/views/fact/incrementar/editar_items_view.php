<div class="header" style="background:#581D8D;">
  <span class="titulo_pagina">INGRESO - EDITAR ITEMS INGRESO</span>
</div>
<p></p>

<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
<div class="content">
  <h2 class="content-head is-center">EDITAR ITEMS INGRESO Nro.: <?php echo $id_nro_adquisicion;?></h2>
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><button id="btn_add" class="pure-button button-secondary" style="width:100%;">Agregar ítem</button></p></div>
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>incrementar" class="pure-button button-black" style="width:100%;">Cancelar operación</a></p></div>
      <!--
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>cargo" class="pure-button button-secondary" style="width:100%;">Cargo</a></p></div>
      -->

    </div>

    <div id="add_ajax"></div>

      <table>
        <thead>
          <th width="5%">N°</th>
          <th width="45%">PRODUCTO</th>
          <th width="10%">OBS.</th>
          <th width="10%">CANTIDAD</th>
          <th width="10%">PRECIO UNID.</th>
          <th width="10%">EDITAR</th>
          <th width="10%">BORRAR</th>

        </thead>
        <tbody>
          <?php
            $html='';
            $i=1;
            $producto = $this->producto_model->get_all_habilitados();
            foreach ($producto as $key => $value)
              $data[$value['id_producto']] = substr($value['nombre_producto'], 0,50).'...';
            
            foreach ($items as $key => $value) {
              $js='id="id_prod_'.$value['id_adquisicion_producto'].' "';
              $selectActual = $value['id_producto'];
              $selectTag = form_dropdown('id_prod_'.$value['id_adquisicion_producto'],$data, $selectActual, $js);
              $html.='
                <tr>
                  <td>'.$i++.'</td>
                  <td>'.$value['nombre_producto'].'</td>
                  <td>'.$value['observacion'].'</td>
                  <td>'.$value['cantidad_ingreso'].'</td>
                  <td>'.number_format($value['precio_adquisicion'],2).'</td>
                  <td><a class="pure-button button-warning button-small" href="javascript:actualizar('.$value['id_adquisicion_producto'].')">Editar</a></td>
                  <td><a class="pure-button button-error button-small" href="javascript:eliminar('.$value['id_adquisicion_producto'].')">Borrar</a></td>
                </tr>
              ';
            }
            echo $html;
          ?>
        </tbody>
      </table>
</div>
<script type="text/javascript">
  function actualizar(id_adquisicion_producto){
    location.href=BASE_URL+"incrementar/editar_item/"+id_adquisicion_producto;
  }

  function eliminar(id_adquisicion_producto){
    if(confirm("¿Esta seguro de eliminar este ítem?")){
      location.href=BASE_URL+"incrementar/eliminar_item/"+id_adquisicion_producto;
    }
  }
$("#btn_add").click(function(){
  $("#add_ajax").css("background-color", "#d8e1e9")
  $("#add_ajax").html('<img src="'+BASE_URL+'public/img/loader.gif">');
  $("#add_ajax").load(BASE_URL+"incrementar/add_item/<?php echo $id_nro_adquisicion;?>");
});
</script>