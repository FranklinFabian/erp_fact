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
              <h4>Lista de Comprobantes</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="table-responsive" style="margin-top: 10px">
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
                    <th width="20%">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($comprobantes as $comprobante) : ?>
                    <tr>
                      <td class="center"><?php echo $comprobante->comprobante_tipo_nombre; ?></td>
                      <td class="center"><?php echo numero_comprobante($comprobante->correlativo); ?></td>
                      <td class="center"><?php echo date('d/m/Y', strtotime($comprobante->fecha)); ?></td>
                      <td class="center"><?php echo $comprobante->glosa; ?></td>
                      <td class="center">
                        <a target="_blank" href="<?php echo base_url('cofi/comprobantes/pdf') . '?id=' . base64_encode($comprobante->id) ?>" class="btn btn-success btn-xs" title="Imprimir comprobante"><i class="fa fa-print" aria-hidden="true"></i></a>
                        <a href="<?php echo base_url('cofi/comprobantes/editar') . '?id=' . base64_encode($comprobante->id) ?>" class="btn btn-primary btn-xs" title="Editar comprobante"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        <button onclick="anular_comprobante('<?php echo $comprobante->id; ?>')" class="btn btn-danger btn-xs" title="Anular comprobante"><i class="fa fa-close" aria-hidden="true"></i></button>
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
  function anular_comprobante(comprobante_id) {
    msg_confirmation('warning', '¿Está seguro?', 'No podrá revertir los cambios.')
      .then((response) => {
        if (response) {
          get_motivo_and_anular(comprobante_id);
        }
      });
  }
  async function get_motivo_and_anular(comprobante_id) {
    const {
      value: text
    } = await Swal.fire({
      title: 'Ingrese el motivo de la anulación.',
      input: 'textarea',
      inputPlaceholder: 'Ingrese el motivo por el cual está anulando el comprobante...',
      inputAttributes: {
        'aria-label': 'Type your message here'
      },
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: '<i class="fa fa-check" aria-hidden="true"></i> Aceptar',
      cancelButtonText: '<i class="fa fa-close" aria-hidden="true"></i> Cancelar',
      inputValidator: (value) => {
        if (!value) {
          return 'Debe escribir el motivo!'
        }
      }
    });
    if (text) {
      swloading.start('Anulando.');
      $.ajax({
        type: "POST",
        dataType: 'text',
        url: BASE_URL + 'cofi/comprobantes/anular/' + comprobante_id,
        data: { motivo: text },
        success: function(response) {
          swloading.stop();
          time_alert('success', 'Anulado!', 'El comprobante fue anulado correctamente.', 2500)
            .then(() => window.location.reload());
        },
        error: function(error) {
          swloading.stop();
          ok_alert_error(error);
        }
      });
    }
  }
</script>
