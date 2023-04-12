<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_selected_company('Utilidades') ?></small>
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
    <?php
      $this->session->unset_userdata('error_message');
    }
    ?>

    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
          <div class="panel-heading">
            <div class="panel-title">
              <h4>Tasas de Cambio</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-12" id="payment_from_1">
                <form action="#" id="formulario">
                  <div class="form-group col-md-6 col-md-offset-3">
                    <label for="anio-mes">Seleccione el mes:</label>
                    <input type="month" class="form-control" id="anio-mes" step="1" min="<?php echo selected_year() . "-01" ?>" max="<?php echo selected_year() . "-12" ?>" value="<?php echo selected_year() . "-01"; ?>">
                  </div>
                  <div class="col-md-12 text-center">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-pencil"></i> Administrar Tasas de Cambio</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
<!-- Admin Home end -->

<script>
  $('#formulario').submit(function (e) {
    e.preventDefault();
    const [year, month] = $('#anio-mes').val().split('-');
    window.location.href = BASE_URL + 'cofi/utilidades/tasa_de_cambio_administrar/' + year + '/' + month;
  });
</script>
