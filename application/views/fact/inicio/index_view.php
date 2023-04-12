<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
<div class="header"></div>

<div style="background-color: #600001; color:white; text-align:center; padding-bottom: 2em;">
  <h1><?php echo $this->config->item('producto');?></h1>
  <h2><?php echo $this->config->item('slogan');?></h2>
</div>

<div class="cover-background">
  <div class="form-ingreso-padre">
  <div class="form-ingreso">
    <h2 style="text-align: center;">INGRESO</h2>
    <form class="pure-form pure-form-stacked" id="form_login" data-parsley-validate>
      <fieldset>
        <div class="pure-control-group">
          <label for="usuario">Usuario:</label>
          <input class="responsivo" id="usuario" name="usuario" type="text" placeholder="Ej. rafa" required>
        </div>
        <div class="pure-control-group">
          <label for="usuario">Contraseña:</label>
          <input class="responsivo" id="password" name="password" type="password" placeholder="Ej. contraseña" required>
        </div>
        <br>
        <div class="pure-control-group">
          <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>" >
          <div id="login_ajax" style="text-align:center"></div>
        </div>
        <div class="pure-controls">
          <button type="submit" class="pure-button pure-button-primary responsivo">Ingresar</button>
        </div>
      </fieldset>
    </form>
    </div>
    </div>
</div>
<script type="text/javascript">
$("#usuario").focus();
$('#form_login').submit(function(){
  if($(this).parsley().isValid())
    {
      var url = BASE_URL+"inicio/login";
      var $contenidoAjax = $('#login_ajax').html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_login').serialize(),
        success: function(data)
        {
          $contenidoAjax.html(data);
          console.log(data);
          if($("#login_ajax").html()=='true')
          {
            $("#login_ajax").html('<div class="ui-state-highlight ui-corner-all" style="margin-top: 20px; padding: 0 .7em;"><p><span class="ui-icon ui-icon-check" style="float: left; margin-right: .3em;"></span><strong>¡Correcto!</strong> Redirigiendo...</p></div>');
            location.href = base_url;
          }
          else
          {
            $("#login_ajax").html('<div class="ui-state-error ui-corner-all" style="padding: 0 .7em; text-align:left;"><p><span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span><strong>Error:</strong> Al introducir el usuario o contraseña.</p></div>');
          }
        }
      });
    }
  return false;
});
</script>
