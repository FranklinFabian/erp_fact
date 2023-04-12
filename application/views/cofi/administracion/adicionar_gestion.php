<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_selected_company('Administración') ?></small>
      <?php echo $this->breadcrumb->render() ?>
    </div>
  </section>

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
              <h4>Adicionar Gestión</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-offset-2 col-md-8">
                <div class="table-responsive">
                  <table id="tabla_data" class="table table-bordered table-main table-hover" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Empresa</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($empresas as $empresa) : ?>
                        <tr>
                          <td class="center"><?php echo $empresa->nombre; ?></td>
                          <td class="center">
                            <button class="btn btn-info btn-sm" title="Adicionar Gestión" onclick="adicionar_gestion('<?php echo $empresa->id; ?>', '<?php echo (intVal($empresa->ultimaGestion) + 1); ?>', '<?php echo $empresa->nombre; ?>')">
                              <i class="fa fa-plus"></i> Adicionar gestión <?php echo (intVal($empresa->ultimaGestion) + 1); ?>
                            </button>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<!-- Admin Home end -->

<script>
  function adicionar_gestion(empresa_id, gestion, nombre_empresa) {
    msg_confirmation('warning', '¿Está seguro?', `Va a adicionar la gestión <b>${gestion}</b> para <b>${nombre_empresa}</b>. No podrá revertir los cambios.`)
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "POST",
            url: BASE_URL + 'cofi/administracion/registrar_gestion',
            data: { empresa_id, gestion },
            dataType: "json",
            success: function(response) {
              swloading.stop();
              if (response.status) {
                time_alert('success', 'Registrado!', 'Nueva gestión adicionada correctamente.', 2500)
                  .then(() => window.location.reload());
              }
            },
            error: function(error) {
              swloading.stop();
              ok_alert_error(error);
            }
          });
        }
      });
  }
  $(document).ready(function() {
    $('#tabla_data').DataTable(DATA_TABLE);
  });
</script>
