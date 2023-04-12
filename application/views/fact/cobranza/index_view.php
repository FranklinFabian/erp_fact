<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1>Facturacion</h1>
      <small>Facturacion y Cobranzas</small>
      <?php echo $this->breadcrumb->render() ?>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Alert Message -->
    <?php $message = $this->session->userdata('message');
    if (isset($message)) { ?>
      <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $message ?>
      </div>
    <?php $this->session->unset_userdata('message');
    }
    $error_message = $this->session->userdata('error_message');
    if (isset($error_message)) { ?>
      <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $error_message ?>
      </div>
    <?php $this->session->unset_userdata('error_message');
    }
    ?>

    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
          <div class="panel-heading">
            <div class="panel-title">
              <h4>Cobranzas</h4>
            </div>
          </div>
          <div class="panel-body">
            
            
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>


<p></p>
<div class="content">
    <form method="post" class="pure-form pure-form-stacked" id="form_buscar" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
            <p><div class="pure-u-1 pure-u-md-1-5">
              <div class="pure-control-group">
                <label for="apellidos">Apellidos:</label>
                <input id="apellidos" name="apellidos" type="text" placeholder="Ej. lopez" autofocus>
                &nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;
                <label for="nombres">Nombres:</label>
                <input id="nombres" name="nombres" type="text" placeholder="Ej. juan">
                &nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;
                <label for="abonado">Abonado:</label>
                <input id="abonado" name="abonado" type="text" placeholder="Ej. 12345">
                &nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;
                <label for="medidor">Medidor:</label>
                <input id="medidor" name="medidor" type="text" placeholder="Ej. 12345">
                &nbsp;
&nbsp;
&nbsp;
&nbsp;
&nbsp;
                <label for="nombre_area">Buscar:</label>
                <button id="btn_guardar" type="submit" class="pure-button pure-button-primary">Buscar</button>
              </div>            
            </div></p>
            
            </div>
        </fieldset>
      </form>    
    
    <div id="div_ajax"><!--ajax -->
    </div><!--Fin ajax -->
  
</div>

<script>
  /* Busqueda */
$('#form_buscar').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#buscar").attr("disabled", true);
      var $contenidoAjax = $('#div_ajax').html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
      var url = BASE_URL+"fact/cobranza/buscar_cliente/";
      
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_buscar').serialize(),
        success: function(data){
            $('#div_ajax').html(data)//location.href=BASE_URL+"punto_venta/";
          $("#buscar").removeAttr("disabled");
        }
      });
    }//fin if
  return false;
});

/* kardex */
function cargar_kardex(idabonado){

  var $contenidoAjax = $('#div_ajax').html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
  var url = BASE_URL+"fact/cobranza/ver_kardex/";
      
      $.ajax({
        type: "GET",
        url: url,
        data: {'idabonado': idabonado},

        success: function(data){
            $('#div_ajax').html(data);
        }
      });

}

</script>
