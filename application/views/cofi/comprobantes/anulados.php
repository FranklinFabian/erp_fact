<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_selected_company('Comprobantes') ?></small>
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
              <h4>Comprobantes Anulados</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="table-responsive">
              <table id="tablaComprobantes" class="table table-bordered table-hover table-main" cellspacing="0">
                <thead>
                  <tr>
                    <th>
                      <select class="input-search" name="search">
                        <option value="">TODOS</option>
                        <?php foreach($comprobantes_tipos as $ct): ?>
                          <option value="<?php echo $ct->nombre ?>"><?php echo $ct->nombre ?></option>
                        <?php endforeach; ?>
                      </select>
                    </th>
                    <th><input type="search" class="input-search" placeholder="Número" /></th>
                    <th><input type="date" class="input-search" placeholder="Fecha" /></th>
                    <th><input type="search" class="input-search" placeholder="Glosa" /></th>
                    <th><input type="search" class="input-search" placeholder="Motivo" /></th>
                    <th width="10%">
                      <button class="btn btn-warning btn-xs" onclick="clean_filters()"><i class="fa fa-repeat"></i> Limpiar</button>
                    </th>
                  </tr>
                  </thead>
                  <thead>
                  <tr>
                    <th>Comprobante</th>
                    <th>Número</th>
                    <th>Fecha</th>
                    <th>Glosa</th>
                    <th>Motivo Anulación</th>
                    <th width="10%">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($comprobantes as $comprobante) : ?>
                    <tr>
                      <td class="center"><?php echo $comprobante->comprobante_tipo_nombre; ?></td>
                      <td class="center"><?php echo numero_comprobante($comprobante->correlativo); ?></td>
                      <td class="center"><?php echo date('d/m/Y', strtotime($comprobante->fecha)); ?></td>
                      <td class="center"><?php echo $comprobante->glosa; ?></td>
                      <td class="center"><?php echo $comprobante->motivo_anulado; ?></td>
                      <td class="center">
                        <a target="_blank" href="<?php echo base_url('cofi/comprobantes/pdf') . '?id=' . base64_encode($comprobante->id) ?>" class="btn btn-success btn-xs" title="Imprimir comprobante"><i class="fa fa-print" aria-hidden="true"></i></a>
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

  </section>
</div>
<!-- Admin Home end -->

<script>
  $(document).ready(function() {
    const tabla_comprobantes = $('#tablaComprobantes').DataTable(DATA_TABLE);
    tabla_comprobantes.columns().every(function() {
      const that = this;
      $('input[type="search"], select[name="search"], input[type="date"]', this.header()).on('keyup change clear', function() {
        let value = this.value;
        if (this.type === 'date') {
          value = value.split('-').reverse().join('/');
        }
        if (that.search() !== value) {
          that.search(value).draw();
        }
      });
    });
  });
  function clean_filters() {
    $('input[type="search"]').val('').keyup();
    $('select[class="input-search"]').val('').change();
    $('input[type="date"]').val('').change();
  }
</script>
