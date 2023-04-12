<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1>Facturacion</h1>
      <small>Facturación Y Cobranzas</small>
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
              <h4>Factores</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                
                <a href="<?php echo base_url();?>fact/facturacion/" class="btn btn-primary">Volver Atrás</a>
              </div>
              
            </div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
   
    <hr>  
    
      <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>

        <div class="pure-g">            
        <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="codigo">Periodo:</label>
                <?php
                  foreach ($periodos as $key => $value)
                    $data[$value['idperiodo']] = $value['idperiodo'].' - '.($value['emision']);
                  echo form_dropdown('idperiodo',$data);
                ?>
              </div>            
            </div></p>
        </div>

        <div class="pure-g">            
        <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="re_020">re_020:</label>
                <input id="re_020" name="re_020" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="re_100">re_100:</label>
                <input id="re_100" name="re_100" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="re_ade">re_ade:</label>
                <input id="re_ade" name="re_ade" type="text" required>
              </div>            
            </div></p>

            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="ge_020">ge_020:</label>
                <input id="ge_020" name="ge_020" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="ge_100">ge_100:</label>
                <input id="ge_100" name="ge_100" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="ge_ade">ge_ade:</label>
                <input id="ge_ade" name="ge_ade" type="text" required>
              </div>            
            </div></p>
            
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="i1_050">i1_050:</label>
                <input id="i1_050" name="i1_050" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="i1_ade">i1_ade:</label>
                <input id="i1_ade" name="i1_ade" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="i2_ade">i2_ade:</label>
                <input id="i2_ade" name="i2_ade" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="i2_dem">i2_dem:</label>
                <input id="i2_dem" name="i2_dem" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="ta_ade">ta_ade:</label>
                <input id="ta_ade" name="ta_ade" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="ba_020">ba_020:</label>
                <input id="ba_020" name="ba_020" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="ba_100">ba_100:</label>
                <input id="ba_100" name="ba_100" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="ba_ade">ba_ade:</label>
                <input id="ba_ade" name="ba_ade" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="sc_020">sc_020:</label>
                <input id="sc_020" name="sc_020" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="sc_100">sc_100:</label>
                <input id="sc_100" name="sc_100" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="sc_ade">sc_ade:</label>
                <input id="sc_ade" name="sc_ade" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="aseo">aseo:</label>
                <input id="aseo" name="aseo" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="alumbrado">alumbrado:</label>
                <input id="alumbrado" name="alumbrado" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="dignidad">dignidad:</label>
                <input id="dignidad" name="dignidad" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="ley1886">ley1886:</label>
                <input id="ley1886" name="ley1886" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="tv_ts">tv_ts:</label>
                <input id="tv_ts" name="tv_ts" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="tv_tp">tv_tp:</label>
                <input id="tv_tp" name="tv_tp" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="tv_c1">tv_c1:</label>
                <input id="tv_c1" name="tv_c1" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="tv_c1_adi">tv_c1_adi:</label>
                <input id="tv_c1_adi" name="tv_c1_adi" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="tv_c2">tv_c2:</label>
                <input id="tv_c2" name="tv_c2" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="tv_c2_adi">tv_c2_adi:</label>
                <input id="tv_c2_adi" name="tv_c2_adi" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="tv_c3">tv_c3:</label>
                <input id="tv_c3" name="tv_c3" type="text" required>
              </div>            
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="tv_c3_adi">tv_c3_adi:</label>
                <input id="tv_c3_adi" name="tv_c3_adi" type="text" required>
              </div>            
            </div></p>

        </div>

          <div class="pure-g">
          <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="">Crear nuevo:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Guardar</button>
              </div>
            </div></p>
            <p><div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="">Cancelar:</label>
                <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div>
            </div></p>
          </div>

        </fieldset>
      </form>
    </div>
<script>

$('#form_nuevo').submit(function(e){
  e.preventDefault();
  if($(this).parsley().isValid())
    {
      $("#btn_guardar").attr("disabled", true);
      var url = BASE_URL+"fact/factor/crear";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_nuevo').serialize(),
        success: function(data)
        {
          if(data=='ok')
            location.href=BASE_URL+"fact/factor/lista";
          else alert('Ocurrio un error');
        },
        error(error)
      {
        alert('Ocurrio un error');
      }
      });
    }//fin if
  return false;
});
</script>
