<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1>Facturacion</h1>
      <small>Atención al consumidor</small>
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
              <h4>Nuevo Alimentador</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <a href="<?php echo base_url();?>fact/alimentador/lista" class="btn btn-primary">Volver Atrás</a>
               
              </div>
              
            </div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
   
      <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
                        
          <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="cod_alimentador">Cód. Alimentador:</label>
                <input id="cod_alimentador" name="cod_alimentador" type="text" placeholder="Ej. cod_alimentador" required>
              </div>            
            </div></p>

            <p> <div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="subestacion">Sub Estación:</label>
                <input id="subestacion" name="subestacion" type="text" placeholder="Ej. Mi subestacion" required>
              </div>            
            </div></p>

            <p> <div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="kva_alimentador">kva alimentador:</label>
                <input id="kva_alimentador" name="kva_alimentador" type="number" placeholder="Ej. 1" required>
              </div>            
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="kv_alimentador">kv alimentador:</label>
                <input id="kv_alimentador" name="kv_alimentador" type="number" placeholder="Ej. 1" required>
              </div>            
            </div></p>

            <p> <div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="consum_mt_1">Consumo MT 1:</label>
                <input id="consum_mt_1" name="consum_mt_1" type="number" placeholder="Ej. 2" required>
              </div>            
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="consum_mt_2">Consumo MT 2:</label>
                <input id="consum_mt_2" name="consum_mt_2" type="number" placeholder="Ej. 2" required>
              </div>            
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="consum_bt_1">Consumo BT 1:</label>
                <input id="consum_bt_1" name="consum_bt_1" type="number" placeholder="Ej. 3" required>
              </div>            
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-control-group">
                <label for="consum_bt_2">Consumo BT 2:</label>
                <input id="consum_bt_2" name="consum_bt_2" type="number" placeholder="Ej. 3" required>
              </div>            
            </div></p>
          </div>

          <p><div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-1">
              <div class="pure-control-group">
                <label for="cod_localidades">Cón. Localidades:</label>
                <input style="width: 50%;" id="cod_localidades" name="cod_localidades" type="text" placeholder="Ej. Localidades" required>
              </div>            
            </div></p>
          </div>

          <p><div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-controls">
                <label for="nombre_area">Crear nuevo:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Guardar</button>
              </div>
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-4">
              <div class="pure-controls">
                <label for="nombre_area">Cancelar:</label>
                <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div>
            </div></p>
          </div>

        </fieldset>
      </form>
    </div>
<script>

$('#form_nuevo').submit(function(){
  if($(this).parsley().isValid())
    {
      $("#btn_guardar").attr("disabled", true);
      
      var url = BASE_URL+"fact/alimentador/crear";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data)
        {
          if(data=='ok')
            location.href=BASE_URL+"fact/alimentador/lista";
          else alert('Ocurrio un error');
        }
      });
    }//fin if
  return false;
});
</script>
