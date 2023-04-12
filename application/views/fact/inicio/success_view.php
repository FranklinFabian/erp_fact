<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
<style>
  #flotante{
  position: fixed;
  z-index: 100;
  margin-left:55%; 
  width: 380px;
  
  margin-top: .5em;
  border-radius: 10px;
  font-size: 11px;
  background-color: #faffbc;
  box-shadow: 10px 10px 10px -6px #333;
}
#flotante ul{
  margin: 0;
  padding: 0 0 0 15px;
}
#flotante ul li{
  list-style:none;
  padding: 0;
  margin: 0;
}

</style>

<div class="header">
  <span class="titulo_pagina"><?php echo $this->config->item('producto');?></span>
</div>
<br>
<div class="content">

  <div class="fondo">
    
  <div class="pure-g" style="height: 400px;">
    <div class="pure-u-1-3"></div>
    <div class="pure-u-1-3"> <img src="<?php echo base_url();?>public/img/logo.png" style="width: 140px; padding: 1em 0 0 6em"> </div>
    <div class="pure-u-1-3"></div>    

    <div class="pure-u-1-3"></div>
    <div class="pure-u-1-3"> <h3 style="color: white; padding-left: 6em">Bienvenido(a)</h3> </div>
    <div class="pure-u-1-3"></div>    
  </div>

  <div style="background:white;margin-top:10px;padding:10px;">
    <strong>NOMBRE(S):</strong> <?php echo $empleado['nombre'];?>
    <br><strong>APELLIDOS:</strong> <?php echo $empleado['apellido'];?>
    <p><button class="pure-button button-secondary" id="cambiar_password_btn">Cambiar contraseña</button></p>
    <div style="display: none" id="cambiar_password">
      <form method="post" class="pure-form" action="<?php echo base_url();?>inicio/cambiar_password" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <input id="nuevo_password" name="nuevo_password" type="password" placeholder="Nueva contraseña" required>
          <button type="submit" class="pure-button button-success" >Cambiar</button>
          <button type="reset" class="pure-button button-error" id="cancelar_btn">Cancelar</button>
          </fieldset>
      </form>
    </div>
    
  </div>
  
  </div>

</div>
<script>
  $("#cambiar_password_btn").click(function (){
    $("#cambiar_password").fadeIn();
    $("#nuevo_password").focus();
  });
  $("#cancelar_btn").click(function (){
    $("#nuevo_password").val("");
    $("#cambiar_password").fadeOut();
  });
</script>
