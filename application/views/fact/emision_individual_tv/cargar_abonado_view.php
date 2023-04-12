<div class="header">
  <span class="titulo_pagina">Localidad - Nuevo</span>
</div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
<div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url().$this->router->fetch_class();?>" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>

  <div class="pure-g" style="background-color: #fff; padding:.5em; border-radius:10px;">
    <div class="pure-u-1 pure-u-md-1-3"><strong>Abonado</strong> <?php echo $abonado['abonado'];?></div>
    <div class="pure-u-1 pure-u-md-1-3"><strong>Razón social</strong> <?php echo $cliente['razon_social'];?></div>
    <div class="pure-u-1 pure-u-md-1-3"><strong>Razón social</strong> <?php echo $direccion['calle'].' '.$abonado['numero'];?></div>

    <div class="pure-u-1 pure-u-md-1-3"><strong>Circuito</strong> <?php echo $centro['centro'];?></div>
    <div class="pure-u-1 pure-u-md-1-3"><strong>Poste</strong> <?php echo $poste['poste'];?></div>
    <div class="pure-u-1 pure-u-md-1-3"><strong>Medidor</strong> <?php echo $abonado['medidor'];?></div>

    <div class="pure-u-1 pure-u-md-1-3"><strong>Categoría</strong> <?php echo $categoria['categoria'];?></div>
    <div class="pure-u-1 pure-u-md-1-3"><strong>Estado</strong> <?php echo $estado['estado'];?></div>
    <div class="pure-u-1 pure-u-md-1-3"><strong>Cliente</strong> <?php echo $cliente['ci'];?></div>
  </div>

  <div style="padding: .5em;">
  <form method="post" class="pure-form pure-form-stacked" id="formulario" action="<?php echo base_url()?>emision_individual_tv/crear/<?php echo $abonado['idabonado']?>" data-parsley-validate>
  <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
    <fieldset>
      <div class="pure-g">
        <div class="pure-u-1 pure-u-md-1-2">
          <div class="pure-control-group">
            <label for="">Ingrese días:</label>
              <input type="number" value="" id="dias" name="dias"  required autofocus>
          </div>  
        </div>
        <div class="pure-u-1 pure-u-md-1-2">
          <div class="pure-control-group">
            <label for="" class="pure-radio">Emitir factura</label>
            <button type="submit" id="btn_emitir" class="pure-button button-success">Emitir factura</button>
          </div>  
        </div>
      </div>
    </fieldset>
  </form>

  </div>  
  
</div>
<script>
  $("#btn_emitir").click(function (){
    $("#btn_emitir").attr('disabled','disabled');
    $("#btn_emitir").html('Enviando...');
    $("#formulario").submit();
  });
</script>