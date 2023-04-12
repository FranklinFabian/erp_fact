<div class="header">
  <span class="titulo_pagina">Requisito - Nuevo</span>
</div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url().$this->router->fetch_class().'/lista';?>" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    <hr>

    <form method="post" class="pure-form pure-form-stacked" id="form_buscar" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
          <div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="razon_social">Razón Social:</label>
                <input id="razon_social" name="razon_social" type="text" placeholder="Ej. Rafa">
              </div>            
            </div>
            <div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-controls">
                <label for="buscar">Buscar:</label>
                <button id="buscar" type="submit" class="pure-button pure-button-primary">Buscar</button>
              </div>
            </div>
          </div>
        </fieldset>
    </form>

    <div id="div_ajax"><!--ajax -->
    </div><!--Fin ajax -->
    
      
    </div>
<script>
  function generar_requisito(id){
    var $contenidoAjax = $('#div_ajax').html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
    var url = BASE_URL+"requisito/generar_nuevo_requisito/"+id;
    $.get(url, function (data){
      $('#div_ajax').html(data);
    });
  } 


$('#form_buscar').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#buscar").attr("disabled", true);
      var $contenidoAjax = $('#div_ajax').html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
      var url = BASE_URL+"requisito/buscar_cliente/";
      
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_buscar').serialize(),
        success: function(data){
          //if(data=="ok")
            $('#div_ajax').html(data)//location.href=BASE_URL+"punto_venta/";
          $("#buscar").removeAttr("disabled");
          //else $('#ajax').html(data);
        }
      });
    }//fin if
  return false;
});
</script>
