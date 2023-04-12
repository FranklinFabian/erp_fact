<div class="header">
  <span class="titulo_pagina">Anulación de facturas</span>
</div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="javascript:history.back()" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>      
    </div>
    <p>
    <strong>CLIENTE: </strong> <?php echo $cliente['razon_social'];?><br>
    <strong>CUF: </strong> <?php echo $factura['cuf'];?><br>
    <strong>MONTO: </strong> <?php echo number_format($factura['monto_total'],2,',','.');?><br>

    </p>

      <form method="post" class="pure-form pure-form-stacked" action="<?php echo base_url()?>gestion_factura/anular_fact/<?php echo $factura['cuf'];?>/<?php echo $sector;?>" id="form_anular" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
            <div class="pure-u-1 pure-u-md-1-1">
              <div class="pure-control-group">
                <label for="usuario">Documento sector:</label>
                <?php
                  foreach ($doc_sec as $key => $value) 
                    $data_doc[$value['id_parametrica_tipo_documento_sector']] = '(cod: '.$value['codigo_clasificador'].') - '.$value['descripcion'];
                  
                  echo form_dropdown('id_parametrica_tipo_documento_sector',$data_doc, $sector);
                ?>
              </div>

            <div class="pure-u-1 pure-u-md-1-1">
              <div class="pure-control-group">
                <label for="usuario">Motivo de anulación:</label>
                <?php
                  foreach ($motivos as $key => $value) 
                    $data_doc[$value['id_parametrica_motivo_anulacion']] = '(cod: '.$value['codigo_clasificador'].') - '.$value['descripcion'];
                  echo form_dropdown('id_parametrica_motivo_anulacion',$data_doc);
                ?>
              </div>
            </div>

          </div>
          <p></p>
          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                
                <button id="btn_enviar" type="submit" class="pure-button button-error">ANULAR FACTURA</button>
              </div>
            </div>
          </div>

        </fieldset>
      </form>

      

    </div>
<script>
$(document).keydown(function(e) {
    if (e.keyCode == 27) return false;
});

$('#form_anular').submit(function(){
  if($(this).parsley().isValid())
    {
        $("#btn_enviar").attr("disabled", true);
        $("#btn_enviar").text("Anulando factura");
        $('#form_anular').submit();
    }//fin if
  return false;
});
</script>
