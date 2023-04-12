<div class="header">
  <span class="titulo_pagina">Nuevo beneficiario ley1886</span>
</div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url();?>beneficiario/" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>

    <hr>
<?php
  $edad = calculaAnios(($cliente['nacimiento']), date('d/m/Y'));
  $arr_edad = explode(',',$edad);
  $cumple = false;
  if($arr_edad[0]>=$this->config->item('edad_ley1886'))
    $cumple=TRUE;
?>  
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3">
        <h4><span style="color:#000">CLIENTE: </span><?php echo $cliente['ci']?> </h4>
        <h4><span style="color:#000">NOMBRE: </span><?php echo $cliente['razon_social']?></h4>
        <h4><span style="color:#000">FECHA NACIMIENTO: </span><?php echo ($cliente['nacimiento']).' '.$arr_edad[0].' Años y '.$arr_edad[1].' meses';?></h4>
        <?php echo $cumple?'':'(Edad insuficiente para ser beneficiario directo)';?>
      </div>
    </div>
    <hr>
    <?php if($cumple):?>
      <h2 style="text-align:center; background-color:#fff; border-radius:5px; padding:.5em;">BENEFICIARIO DIRECTO</h2>
    <?php else:?>
      <h2 style="text-align:center; background-color:#fff; border-radius:5px; padding:.5em;">BENEFICIARIO INDIRECTO</h2>
    <?php endif;?>

      <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
        <?php if(!$cumple):?>
          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="ci">CI Beneficiario indirecto:</label>
                <input id="ci" name="ci" type="number" placeholder="Ej. 4043274">
                <input id="iddirecto" name="iddirecto" type="hidden" value="2">
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="buscar">Buscar:</label>
                <button id="btn_buscar" type="button" class="pure-button pure-button-primary button-small">Buscar</button>
              </div>
            </div>
          </div>
          
          <div id="div_ajax"></div>
        <?php else:?>
          <input id="iddirecto" name="iddirecto" type="hidden" value="1">
        <?php endif;?>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="idcliente">ID cliente:</label>
                <input id="idcliente" name="idcliente" type="text" value="<?php echo $cumple?$cliente['idcliente']:'';?>" readonly required>
              </div>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="idabonado">Medidor:</label>
                <?php
                  $data_medidor[null]="Seleccione";
                  foreach ($abonados as $key => $value) {
                    $direccion = $this->calles_model->get_all_all($value['idcalle']);
                    $data_medidor[$value['idabonado']] = $value['medidor'].' - '.$direccion['zona'].' / '.$direccion['calle'];
                  }
                  $js_medidor='required=""';
                  echo form_dropdown('idabonado', $data_medidor,'',$js_medidor);
                ?>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="idley1886">Ley1886:</label>
                <?php
                  $data_ley[null]="Seleccione";
                  foreach ($ley1886 as $key => $value) {
                    $data_ley[$value['idley1886']] = ($value['inicio']).' - '.($value['final']);
                  }
                  $js_ley='required="" id="idley1886"';
                  echo form_dropdown('idley1886', $data_ley,'',$js_ley);
                ?>
              </div>
            </div>

          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_area">Crear nuevo:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Guardar</button>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_area">Cancelar:</label>
                <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div>
            </div>
          </div>

        </fieldset>
      </form>
    </div>
<script>
  function establecer_id_cliente(idcliente){
    //alert("Llego evento");
    $("#idcliente").val(idcliente);
  }
$("#btn_buscar").click(function (){
  $("#idcliente").val('');
  $("#div_ajax").load(BASE_URL+'beneficiario/buscar_ci/'+$("#ci").val());
});

$('#form_nuevo').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#btn_guardar").attr("disabled", true);
      
      var url = BASE_URL+"beneficiario/crear";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data)
        {
          if(data=='ok')
            location.href=BASE_URL+"ley1886";
          else alert('Ocurrio un error');
        }
      });
    }//fin if
  return false;
});
</script>
