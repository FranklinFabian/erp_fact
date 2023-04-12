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
              <h4>Lecturas</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <a href="<?php echo base_url();?>fact/lectura" class="btn btn-primary">Seleccionar circuito</a>
                <a href="<?php echo base_url();?>fact/periodo/lista" class="btn btn-primary">Ver Periodo</a>
                <a href="<?php echo base_url();?>fact/periodo/nuevo" class="btn btn-primary">Nuevo periodo</a>
                
              </div>
            </div>


<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>


<p></p>
<div class="content">
    
<hr>
  <div id="div_ajax">
    <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
      <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
      <fieldset>
        <div class="pure-g">
        <p><div class="pure-u-1 pure-u-md-1-4">
            <div class="pure-control-group">
              <label for="zona">Seleccionar circuito:</label>
              <?php
                foreach ($centros as $key => $value) 
                  $data[$value['idcentro']] = $value['idcentro'].' - '.$value['centro'];
                $js='id="idcentro" autofocus';
                echo form_dropdown('idcentro',$data,'', $js);
              ?>
            </div>            
          </div></p>
          <p><div class="pure-u-1 pure-u-md-1-4">
            <div class="pure-controls">
              <label for="nombre_area">Seleccionar:</label>
              <button id="btn_seleccionar" type="button" class="pure-button button-success">Seleccionar</button>
            </div>
          </div></p>
        </div>
      </fieldset>
    </form>
  </div>

</div>
<script>
  $("#btn_seleccionar").click(function (){
    var idcentro = $("#idcentro").val();
    var $contenidoAjax = $('#div_ajax').html('<div><img src="<?php echo base_url();?>public/img/loader.gif" /></div><br>');
    var url = BASE_URL+"fact/lectura/cargar_centro/"+idcentro;
      $.ajax({
        type: "GET",
        url: url,
        success: function(data){
            $('#div_ajax').html(data);
        }
      });
  })
</script>
