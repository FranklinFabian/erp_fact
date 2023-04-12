<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1>Seguridad</h1>
      <small>Reportes</small>
      <ol class="breadcrumb">
        <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
        <li><a href="#">Seguridad</a></li>
        <li class="active">Reportes</li>
      </ol>
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
              <h4>Reportes de seguridad</h4>
            </div>
          </div>

          <div class="panel-body">
            <form action="#" id="formulario">
              <div class="row">
                <div class="col-md-12">
                  <label for="modules_id">Módulos</label>
                  <select name="modules_id" id="modules_id" class="form-control" style="width: 100%;" multiple required>
                    <option value=""></option>
                    <?php foreach ($modules as $module) : ?>
                      <option value="<?php echo $module->id ?>"><?php echo $module->name ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="row mt-10">
                <div class="col-md-12">
                  <label for="sites_id">Sitios / Rutas</label>
                  <select name="sites_id" id="sites_id" class="form-control" style="width: 100%;" multiple required>
                    <!-- dinámico -->
                  </select>
                </div>
              </div>
              <div class="row mt-10">
                <div class="col-md-3">
                  <label for="initial_date">Fecha Inicio</label>
                  <input type="date" name="initial_date" id="initial_date" class="form-control" value="<?php echo $form_data['initial_date'] ?>" required>
                </div>
                <div class="col-md-3">
                  <label for="final_date">Fecha Final</label>
                  <input type="date" name="final_date" id="final_date" class="form-control" value="<?php echo $form_data['final_date'] ?>" required>
                </div>
                <div class="col-md-6">
                  <label for="users_id">Usuarios</label>
                  <select name="users_id" id="users_id" class="form-control" style="width: 100%;" multiple required>
                    <?php foreach($users as $user): ?>
                      <option value="<?php echo $user->user_id ?>" <?php echo in_array($user->user_id, $form_data['users_id']) ? 'selected':'' ?>><?php echo $user->first_name . " " . $user->last_name ?></option>
                    <?php endforeach; ?>
                    <option value="*" <?php echo in_array('*', $form_data['users_id']) ? 'selected':'' ?>>Todos</option>
                  </select>
                </div>
              </div>
              <div class="row text-center mt-10">
                <div class="col-md-12">
                  <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-bar-chart"></i> Generar Reporte</button>
                  <a href="<?php echo base_url('security/reports') ?>" class="btn btn-warning btn-sm"><i class="fa fa-refresh"></i> Limpiar Filtros</a>
                </div>
              </div>
            </form>
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive" style="margin-top: 10px">
                  <table id="tabla_data" class="display table table-bordered table-sm table-hover text-center" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th>Nro.</th>
                        <th>Fecha</th>
                        <th>Módulo/Sitio</th>
                        <th>Usuario</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($actions as $index => $action) : ?>
                        <tr>
                          <td><?php echo $index + 1; ?></td>
                          <td><?php echo $action->made_at_formatted; ?></td>
                          <td><?php echo $action->module_code . ' | ' . $action->site_description; ?></td>
                          <td><?php echo $action->user_fullname; ?></td>
                          <td>
                            <button class="btn btn-warning btn-xs" title="Más información " onclick="ver_mas_informacion('<?php echo $action->id; ?>')"><i class="fa fa-list"></i></button>
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
  </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->
<!-- Admin Home end -->

<!-- Modal ver más información -->
<div class="modal" id="modal_more_information" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Más información de la acción
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12" id="modal_data">
            <!-- dinámico -->
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
      </div>
    </div>
  </div>
</div>

<script>
  const actions = <?php echo json_encode($actions); ?>;
  const modules = <?php echo json_encode($modules); ?>;
  const sites = <?php echo json_encode($sites); ?>;
  const form_data = <?php echo json_encode($form_data); ?>;

  let selected_sites = [];

  $('#modules_id').on('change', function() {
    const modules_id = $('#modules_id').val() || [];
    add_sites(modules_id);
  });
  function add_sites(modules_id) {
    const sites_html = [];

    modules_id.forEach(module_id => {
      const module = modules.find(({
        id
      }) => id == module_id);

      const filtered_sites = sites.filter(item => item.module_id == module_id);
      const data_html = filtered_sites.map(item => `
        <option value="${item.id}">${item.description}</option>
      `).join('');

      sites_html.push(`<optgroup label="${module.name}">${data_html}</optgroup>`);
    });

    $('#sites_id').empty().append(sites_html.join(''));
    $('#sites_id').val(selected_sites);
  }
  $('#sites_id').on('change', function() {
    selected_sites = $('#sites_id').val();
  });
  $('#formulario').submit(function(e) {
    e.preventDefault();
    const modules = $('#modules_id').val().join(',');
    const sites = $('#sites_id').val().join(',');
    const initial_date = $('#initial_date').val();
    const final_date = $('#final_date').val();
    const users = $('#users_id').val();

    window.location = BASE_URL + 'security/reports?modules=' + modules + '&sites=' + sites + '&initial_date=' + initial_date + '&final_date=' + final_date + '&users=' + users;
  });

  function ver_mas_informacion(action_id) {
    const action = actions.find(item => item.id == action_id);
    const more_info = JSON.parse(action.more_info);

    const data_get = JSON.parse(action.data_get);
    const data_post = JSON.parse(action.data_post);
    const extra_data = JSON.stringify({ ...data_get, ...data_post }, undefined, 4);

    const data_html = `
      <p><b>Fecha:</b> ${action.made_at_formatted}</p>
      <p><b>Usuario:</b> ${action.user_fullname}</p>
      <p><b>Módulo:</b> ${action.module_name} (${action.module_code})</p>
      <p><b>Sitio/Acción:</b> ${action.site_name} - ${action.site_description}</p>
      <p><b>Plataforma:</b> ${more_info.HTTP_SEC_CH_UA_PLATFORM}</p>
      <p><b>Navegador:</b> ${more_info.HTTP_USER_AGENT}</p>
      <p><b>Dirección IP:</b> ${more_info.REMOTE_ADDR} | ${more_info.SERVER_ADDR}</p>
      ${action.method === 'GET' ?
        `<p class="text-center text-success"><b class="c-pointer" onclick="replicar_function(${action_id})"><i class="fa fa-share-square"></i> Replicar Función</b></p>`
        :`<p><b>Datos extra de la acción: </b>${output(syntaxHighlight(extra_data))}</p>`
      }
    `;

    $('#modal_data').html(data_html);
    $('#modal_more_information').modal('show');
  }

  function replicar_function(action_id) {
    const action = actions.find(item => item.id == action_id);
    const { empresa_gestion_id } = JSON.parse(action.data_session);

    if (action.method === 'GET') {
      swloading.start();
      $.ajax({
        type: "POST",
        url: BASE_URL + "security/update_session_data",
        data: { empresa_gestion_id },
        dataType: "json",
        success: function (response) {
          swloading.stop();
        },
        error: function (error) {
          swloading.stop();
          ok_alert_error(error);
        }
      });

      const mapForm = document.createElement("form");
      mapForm.target = "_blank";
      mapForm.method = "POST";
      mapForm.action = BASE_URL + action.path + '?' + action.query;

      const data_post = JSON.parse(action.data_post);
      for (let name in data_post) {
        const mapInput = document.createElement("input");
        mapInput.type = "text";
        mapInput.name = name;
        mapInput.value = data_post[name];

        mapForm.appendChild(mapInput);
      }

      document.body.appendChild(mapForm);
      mapForm.submit();
      mapForm.remove();
    }
  }

  function output(inp) {
    return `<code><pre>${inp}</pre></code>`;
  }
  function syntaxHighlight(json) {
    if (typeof json != 'string') {
      json = JSON.stringify(json, undefined, 2);
    }
    json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
    return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?)/g, function (match) {
      var cls = 'c-number';
      if (/^"/.test(match)) {
        if (/:$/.test(match)) {
          cls = 'c-key';
        } else {
          cls = 'c-string';
        }
      } else if (/true|false/.test(match)) {
        cls = 'c-boolean';
      } else if (/null/.test(match)) {
        cls = 'c-null';
      }
      return '<span class="' + cls + '">' + match + '</span>';
    });
  }

  $(document).ready(function() {
    $('#tabla_data').DataTable(DATA_TABLE_BUTTONS('Reporte de seguridad', [0, 1, 2, 3]));
    $('#modules_id').val(form_data.modules_id).change();
    $('#sites_id').val(form_data.sites_id).change();
  });
</script>
