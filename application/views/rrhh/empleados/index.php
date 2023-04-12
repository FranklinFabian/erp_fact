<!-- Admin Home Start -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1><?php echo module_name() ?></h1>
      <small><?php echo details_module('Empleados') ?></small>
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
    } ?>

    <!--Add Invoice -->
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">

          <!-- Header -->
          <div class="panel-heading">
            <div class="panel-title">
              <h4><strong>Empleados</strong></h4>
            </div>
          </div> <!-- Header End -->
          <!-- Body -->
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-12 text-center">
                <div class="btn-group btn-group-sm">
                  <button type="button" id="btn_nuevo_empleado" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Nuevo Empleado</button>
                </div>
              </div>
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table id="tabla_empleados" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
                    <thead>
                      <th class="text-center">#</th>
                      <th class="text-center">Ap. Paterno</th>
                      <th class="text-center">Ap. Materno</th>
                      <th class="text-center">Nombres</th>
                      <th class="text-center">C.I.</th>
                      <th class="text-center">Acciones</th>
                    </thead>
                    <tbody>
                      <?php foreach ($empleados as $index => $empleado): ?>
                        <tr>
                          <td style="vertical-align: middle;"><?php echo $index + 1; ?></td>
                          <td style="vertical-align: middle;"><?php echo $empleado->paterno; ?></td>
                          <td style="vertical-align: middle;"><?php echo $empleado->materno; ?></td>
                          <td style="vertical-align: middle;"><?php echo $empleado->nombre1 . ' ' . $empleado->nombre2; ?></td>
                          <td style="vertical-align: middle;"><?php echo $empleado->empleado . ' ' . $empleado->ci_extension; ?></td>
                          <td style="vertical-align: middle;" class="probando">
                            <button class="btn btn-primary btn-xs" onclick="mostrarEmpleado('<?php echo $empleado->id; ?>')" title="Ver detalles empleado"><i class="fa fa-eye" aria-hidden="true"></i></button>
                            <button class="btn btn-info btn-xs" onclick="editarEmpleado('<?php echo $empleado->id; ?>')" title="Editar empleado"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                            <!-- <button class="btn btn-danger btn-xs" onclick="eliminarEmpleado('<?php echo $empleado->id; ?>')"; title="Eliminar empleado"><i class="fa fa-close" aria-hidden="true"></i></button> -->
                            <div class="btn-group" role="group">
                              <button type="button" class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-plus-square" aria-hidden="true"></i>
                                <span class="caret"></span>
                              </button>
                              <ul class="dropdown-menu pull-right">
                                <!-- <li class="c-pointer"><a onclick="kardexSueldoEmpleado('<?= $empleado->id; ?>')"><i class="fa fa-file-text-o" aria-hidden="true"></i> Kardex de Sueldos</a></li> -->
                                <li class="c-pointer"><a onclick="imprimirHojaFiliacionEmpleado('<?= $empleado->empleado; ?>')"><i class="fa fa-print" aria-hidden="true"></i> Imprimir Hoja Filiación</a></li>
                                <li class="c-pointer"><a onclick="registroFamiliaEmpleado('<?= $empleado->id; ?>')"><i class="fa fa-users" aria-hidden="true"></i> Registro de Familia</a></li>
                              </ul>
                            </div>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div> <!-- Body End -->
        </div>
      </div>
    </div>
    <!-- Modal Registrar Nuevo Empleado -->
    <div class="modal fade fs-12" id="modal_nuevo_empleado" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><span class="titulo_form_empleado"></span> Empleado
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
              <input type="hidden" id="empleado_id_to_update">
            </h4>
          </div>
          <div class="modal-body">
            <form action="#" id="form_registrar_actualizar_empleado">
              <div class="row">
                <div class="form-group col-sm-2">
                  <label for="empleado">Nro. Documento (*)</label>
                  <input type="text" class="form-control fs-12" name="empleado" id="empleado" placeholder="Nro. Documento" required>
                </div>
                <div class="form-group col-sm-2">
                  <label for="ci_extension">Extensión</label>
                  <select class="form-control" name="ci_extension" id="ci_extension" style="width: 100%;" required>
                    <?php foreach ($enum_ci_extencion as $cie) : ?>
                      <option value="<?php echo $cie; ?>"><?php echo $cie; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-sm-2">
                  <label for="documento">Tipo Doc.</label>
                  <select class="form-control" name="documento" id="documento" style="width: 100%;" required>
                    <?php foreach ($enum_documento as $doc) : ?>
                      <option value="<?php echo $doc; ?>"><?php echo $doc; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-sm-2">
                  <label for="paterno">Ap. Paterno (*)</label>
                  <input type="text" class="form-control fs-12" name="paterno" id="paterno" placeholder="Ap. paterno" required>
                </div>
                <div class="form-group col-sm-2">
                  <label for="materno">Ap. Materno</label>
                  <input type="text" class="form-control fs-12" name="materno" id="materno" placeholder="Ap. materno">
                </div>
                <div class="form-group col-sm-2">
                  <label for="ap_casada">Ap. Casada</label>
                  <input type="text" class="form-control fs-12" name="ap_casada" id="ap_casada" placeholder="Ap. casada">
                </div>

                <div class="form-group col-sm-2">
                  <label for="nombre1">Nombre 1 (*)</label>
                  <input type="text" class="form-control fs-12" name="nombre1" id="nombre1" placeholder="Nombre 1" required>
                </div>
                <div class="form-group col-sm-2">
                  <label for="nombre2">Nombre 2</label>
                  <input type="text" class="form-control fs-12" name="nombre2" id="nombre2" placeholder="Nombre 2">
                </div>
                <div class="form-group col-sm-2">
                  <label for="telefono">Nro. Celular</label>
                  <input type="text" class="form-control fs-12" name="telefono" id="telefono" placeholder="Nro. de celular">
                </div>
                <div class="form-group col-sm-3">
                  <label for="direccion">Dirección</label>
                  <input type="text" class="form-control fs-12" name="direccion" id="direccion" placeholder="Dirección">
                </div>
                <div class="form-group col-sm-3">
                  <label for="zona">Zona</label>
                  <input type="text" class="form-control fs-12" name="zona" id="zona" placeholder="Zona">
                </div>

                <div class="form-group col-sm-2">
                  <label for="numero">Nro.</label>
                  <input type="text" class="form-control fs-12" name="numero" id="numero" placeholder="Nro.">
                </div>
                <div class="form-group col-sm-2">
                  <label for="profesion">Profesión</label>
                  <input type="text" class="form-control fs-12" name="profesion" id="profesion" placeholder="Profesión.">
                </div>
                <div class="form-group col-sm-2">
                  <label for="estado_civil">Estado Civil</label>
                  <select class="form-control" name="estado_civil" id="estado_civil" style="width: 100%;" required>
                    <?php foreach ($enum_estado_civil as $ec) : ?>
                      <option value="<?php echo $ec; ?>"><?php echo $ec; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-sm-2">
                  <label for="grado_instruccion">Grado Instruc.</label>
                  <input type="text" class="form-control fs-12" name="grado_instruccion" id="grado_instruccion" placeholder="G. Instrucción">
                </div>
                <div class="form-group col-sm-2">
                  <label for="nacionalidad">Nacionalidad</label>
                  <input type="text" class="form-control fs-12" name="nacionalidad" id="nacionalidad" value="BOLIVIANA" placeholder="Nacionalidad">
                </div>
                <div class="form-group col-sm-2">
                  <label for="sexo">Sexo</label>
                  <select class="form-control" name="sexo" id="sexo" style="width: 100%;" required>
                    <option value="M">VARON</option>
                    <option value="F">MUJER</option>
                  </select>
                </div>

                <div class="form-group col-sm-3">
                  <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                  <input type="date" class="form-control fs-12" name="fecha_nacimiento" id="fecha_nacimiento">
                </div>
                <div class="form-group col-sm-2">
                  <label for="lugar_nacimiento">Lugar Nac.</label>
                  <input type="text" class="form-control fs-12" name="lugar_nacimiento" id="lugar_nacimiento" placeholder="L. Nacimiento">
                </div>
                <div class="form-group col-sm-2">
                  <label for="club">Aporte Club</label>
                  <select class="form-control" name="club" id="club" style="width: 100%;" required>
                    <option value="0">NO</option>
                    <option value="1">SI</option>
                  </select>
                </div>
                <div class="form-group col-sm-2">
                  <label for="nua">N° NUA</label>
                  <input type="text" class="form-control fs-12" name="nua" id="nua" placeholder="Nro. NUA">
                </div>
                <div class="form-group col-sm-3">
                  <label for="cuenta">Nro. de Cuenta</label>
                  <input type="text" class="form-control fs-12" name="cuenta" id="cuenta" placeholder="Nro. Cuenta">
                </div>

                <div class="form-group col-sm-3">
                  <label for="trabajo_anterior">Trabajo Anterior</label>
                  <input type="text" class="form-control fs-12" name="trabajo_anterior" id="trabajo_anterior" placeholder="Trabajo anterior">
                </div>
                <div class="form-group col-sm-2">
                  <label for="discapacitado">Discapacitado</label>
                  <select class="form-control" name="discapacitado" id="discapacitado" style="width: 100%;" required>
                    <option value="0">NO</option>
                    <option value="1">SI</option>
                  </select>
                </div>
                <div class="form-group col-sm-2">
                  <label for="discapacitado_tutor">Tutor de PcD</label>
                  <select class="form-control" name="discapacitado_tutor" id="discapacitado_tutor" style="width: 100%;" required>
                    <option value="0">NO</option>
                    <option value="1">SI</option>
                  </select>
                </div>
                <div class="form-group col-sm-3">
                  <label for="caja_salud">Caja de Salud</label>
                  <select class="form-control" name="caja_salud" id="caja_salud" style="width: 100%;" required>
                    <?php foreach ($enum_caja_salud as $cs) : ?>
                      <option value="<?php echo $cs; ?>"><?php echo $cs; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-sm-2">
                  <label for="afp_aporta">AFP</label>
                  <select class="form-control" name="afp_aporta" id="afp_aporta" style="width: 100%;" required>
                    <?php foreach ($enum_afp_aporta as $afp) : ?>
                      <option value="<?php echo $afp; ?>"><?php echo $afp; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <div class="form-group col-sm-5">
                  <label for="clasificacion_laboral">Clasificación Laboral</label>
                  <select class="form-control" name="clasificacion_laboral" id="clasificacion_laboral" style="width: 100%;" required>
                    <?php foreach ($enum_clasificacion_laboral as $cl) : ?>
                      <option value="<?php echo $cl; ?>"><?php echo $cl; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-sm-2">
                  <label for="horas_pagadas">Hrs. Pagadas</label>
                  <input type="number" class="form-control fs-12" name="horas_pagadas" id="horas_pagadas" placeholder="Nro. horas" value="8" min="0">
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="form-group col-sm-3">
                  <label for="fecha_ingreso">Fecha de Ingreso (*)</label>
                  <input type="date" class="form-control fs-12" name="fecha_ingreso" id="fecha_ingreso" required>
                </div>
                <div class="form-group col-sm-3">
                  <label for="tipo_contrato">Tipo Contrato</label>
                  <select class="form-control" name="tipo_contrato" id="tipo_contrato" style="width: 100%;" required>
                    <?php foreach ($enum_tipo_contrato as $tc) : ?>
                      <option value="<?php echo $tc; ?>"><?php echo $tc; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-sm-3">
                  <label for="servicio">Servicio</label>
                  <select class="form-control" name="servicio" id="servicio" style="width: 100%;" required>
                    <?php foreach ($servicios as $servicio) : ?>
                      <option value="<?php echo $servicio->Id_Servicio; ?>"><?php echo $servicio->Servicio; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-sm-3">
                  <label for="item">Ítem</label>
                  <select class="form-control" name="item" id="item" style="width: 100%;" required>
                    <?php foreach ($items as $item) : ?>
                      <option value="<?php echo $item->id; ?>"><?php echo $item->cargo; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-sm-3">
                  <label for="contrato">Contrato</label>
                  <select class="form-control" name="contrato" id="contrato" style="width: 100%;" required>
                    <?php foreach ($enum_contrato as $c) : ?>
                      <option value="<?php echo $c; ?>"><?php echo $c; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-sm-3">
                  <label for="subsidio">Subsidio</label>
                  <select class="form-control" name="subsidio" id="subsidio" style="width: 100%;" required>
                    <?php foreach ($enum_subsidio as $s) : ?>
                      <option value="<?php echo $s; ?>"><?php echo $s; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-sm-3">
                  <label for="motivo_retiro">Motivo Retiro</label>
                  <select class="form-control" name="motivo_retiro" id="motivo_retiro" style="width: 100%;" required>
                    <?php foreach ($enum_motivo_retiro as $mr) : ?>
                      <option value="<?php echo $mr; ?>"><?php echo $mr; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group col-sm-3">
                  <label for="fecha_retiro">Fecha de Retiro</label>
                  <input type="date" class="form-control fs-12" name="fecha_retiro" id="fecha_retiro">
                </div>

                <div class="form-group col-sm-2">
                  <label for="jubilado">Jubilado</label>
                  <select class="form-control" name="jubilado" id="jubilado" style="width: 100%;" required>
                    <option value="0">NO</option>
                    <option value="1">SI</option>
                  </select>
                </div>
                <div class="form-group col-sm-3">
                  <label for="fecha_jubilado">Fecha de Jubilación</label>
                  <input type="date" class="form-control fs-12" name="fecha_jubilado" id="fecha_jubilado">
                </div>
              </div>
              <div class="mt-10 text-center">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn_form_empleado"></span></button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Mostrar Empleado -->
    <div class="modal fade fs-12" id="modal_mostrar_empleado" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Datos del Empleado
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
            </h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-6">
                <p><strong>Empleado: </strong> <span id="dm_empleado"></span></p>
                <p><strong>Nro. de Celular: </strong> <span id="dm_telefono"></span></p>
                <p><strong>Profesión: </strong> <span id="dm_profesion"></span></p>
                <p><strong>Sexo: </strong> <span id="dm_sexo"></span></p>
                <p><strong>Fecha de Nacimiento: </strong> <span id="dm_fecha_nacimiento"></span></p>
                <p><strong>Nro. Nua: </strong> <span id="dm_nua"></span></p>
                <p><strong>Grado Instrucción: </strong> <span id="dm_grado_instruccion"></span></p>
                <p><strong>Nro. de Cuenta: </strong> <span id="dm_cuenta"></span></p>
                <p><strong>Discapacitado: </strong> <span id="dm_discapacitado"></span></p>
                <p><strong>Caja de Salud: </strong> <span id="dm_caja_salud"></span></p>
                <p><strong>Horas Pagadas: </strong> <span id="dm_horas_pagadas"></span></p>
                <br>
                <p><strong>Fecha de Ingreso: </strong> <span id="dm_fecha_ingreso"></span></p>
                <p><strong>Servicio: </strong> <span id="dm_servicio"></span></p>
                <p><strong>Contrato: </strong> <span id="dm_contrato"></span></p>
                <p><strong>Motivo de Retiro: </strong> <span id="dm_motivo_retiro"></span></p>
                <p><strong>Jubilado: </strong> <span id="dm_jubilado"></span></p>
              </div>
              <div class="col-sm-6">
                <p><strong>CI: </strong> <span id="dm_nro_ci"></span></p>
                <p><strong>Dirección: </strong> <span id="dm_direccion"></span></p>
                <p><strong>Estado Civil: </strong> <span id="dm_estado_civil"></span></p>
                <p><strong>Nacionalidad: </strong> <span id="dm_nacionalidad"></span></p>
                <p><strong>Lugar de Nac.: </strong> <span id="dm_lugar_nacimiento"></span></p>
                <p><strong>AFP Aporta: </strong> <span id="dm_afp_aporta"></span></p>
                <p><strong>Aporte Club: </strong> <span id="dm_club"></span></p>
                <p><strong>Trabajo Anterior: </strong> <span id="dm_trabajo_anterior"></span></p>
                <p><strong>Tutor de PcD: </strong> <span id="dm_discapacitado_tutor"></span></p>
                <p><strong>Clasificación Laboral: </strong> <span id="dm_clasificacion_laboral"></span></p>
                <br>
                <br>
                <p><strong>Tipo Contrato: </strong> <span id="dm_tipo_contrato"></span></p>
                <p><strong>Ítem: </strong> <span id="dm_item"></span></p>
                <p><strong>Subsidio: </strong> <span id="dm_subsidio"></span></p>
                <p><strong>Fecha de Retiro: </strong> <span id="dm_fecha_retiro"></span></p>
                <p><strong>Fecha de Jubilación: </strong> <span id="dm_fecha_jubilado"></span></p>
              </div>
            </div>
            <div class="mt-10 text-center">
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Kardex de Sueldos Empleado -->
    <div class="modal fade fs-12" id="modal_kardex_sueldos" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Kardex de Sueldos
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
            </h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-12 text-center">
                <p>
                  <strong>Empleado: </strong><span class="kd_empleado"></span>,
                  <strong>Nombre: </strong><span class="kd_nombre"></span>,
                  <strong>Cargo: </strong><span class="kd_cargo"></span>
                </p>
              </div>
            </div>
            <div class="row">
              <div class="table-responsive">
                <table id="tabla_kardex_sueldos" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
                  <thead>
                    <tr>
                      <th>data1</th>
                      <th>data2</th>
                      <th>dataa3</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- dinámico js -->
                  </tbody>
                </table>
              </div>
            </div>
            <div class="mt-10 text-center">
              <button type="button" class="btn btn-success btn-sm"><i class="fa fa-times" aria-hidden="true"></i> Exportar</button>
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
            </div>
          </div>
          <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm btn_ir_inicio" data-dismiss="modal">Cancelar</button>
                    </div> -->
        </div>
      </div>
    </div>
    <!-- Modal Registro Familiares Empleado -->
    <div class="modal fade fs-12" id="modal_tabla_familiares" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Familiares
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
              <input type="hidden" id="documento_empleado_reg_familiar">
            </h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-sm-12">
                <p class="m-0"><strong>Empleado: </strong><span class="kd_empleado"></span></p>
                <p class="m-0"><strong>Nombre: </strong><span class="kd_nombre"></span></p>
                <p class="m-0"><strong>Cargo: </strong><span class="kd_cargo"></span></p>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 text-center">
                <div class="btn-group btn-group-sm">
                  <button type="button" onclick="registrarFamiliar()" id="btn_registro_familiar" class="btn btn-info btn-sm"><i class="fa fa-plus-square"></i> Nuevo Registro</button>
                </div>
              </div>
            </div>
            <div class="row mt-10">
              <div class="col-sm-12">
                <div class="table-responsive">
                  <table id="tabla_familiares" class="table table-hover table-bordered table-small" width="100%">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Nro. CI.</th>
                        <th>Nombre Completo</th>
                        <th>Relación</th>
                        <th>Fecha de Nacimiento</th>
                        <th>Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <!-- dinámico js -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
            <div class="mt-10 text-center">
              <!-- <button type="button" class="btn btn-success btn-sm"><i class="fa fa-times" aria-hidden="true"></i> Exportar</button> -->
              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Formulario Registro Familiares Empleado -->
    <div class="modal fade fs-12" id="modal_form_registro_familiares" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title"><span class="title_form_familiar"></span> Familiar
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
              </button>
              <input type="hidden" id="id_familiar_editar">
            </h4>
          </div>
          <div class="modal-body">
            <form action="" id="form_registrar_familiar">
              <div class="row">
                <div class="col-sm-12">
                  <label class="mt-10" for="nf_documento">Número de Documento</label>
                  <input id="nf_documento" class="form-control" required>

                  <label class="mt-10" for="nf_nombre_completo">Nombre Completo</label>
                  <input id="nf_nombre_completo" class="form-control" required>

                  <label class="mt-10" for="nf_relacion">Relación - Parentesco</label>
                  <select id="nf_relacion" class="form-control" style="width: 100%;" required>
                    <option value="H">Hijo</option>
                    <option value="C">Conyuge</option>
                  </select>

                  <label class="mt-10" for="nf_fecha_nacimiento">Fecha de Nacimiento</label>
                  <input type="date" id="nf_fecha_nacimiento" class="form-control" required>
                </div>
              </div>
              <div class="mt-10 text-center">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> <span class="btn_submit_form_familiar"></span></button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cerrar</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section> <!-- /.content -->
</div> <!-- /.content-wrapper -->

<script>
  const empleados = <?php echo json_encode($empleados); ?>;
  const nombres_db = ['empleado', 'ci_extension', 'documento', 'paterno', 'materno', 'ap_casada', 'nombre1', 'nombre2', 'telefono', 'direccion', 'zona', 'numero', 'profesion', 'estado_civil', 'grado_instruccion', 'nacionalidad', 'sexo', 'fecha_nacimiento', 'lugar_nacimiento', 'club', 'nua', 'cuenta', 'trabajo_anterior', 'discapacitado', 'discapacitado_tutor', 'caja_salud', 'afp_aporta', 'clasificacion_laboral', 'horas_pagadas', 'fecha_ingreso', 'tipo_contrato', 'servicio', 'item', 'contrato', 'subsidio', 'motivo_retiro', 'fecha_retiro', 'jubilado', 'fecha_jubilado'];
  let lista_familiares_empleado = [];
  let data_empleado = {};
  /* Registrar Nuevo Empleado */
  $('#btn_nuevo_empleado').on('click', function() {
    // Habiiatr el ingreso del nro de Documento del empleado
    $('#empleado').prop('readonly', false);
    // Reiniciar form
    $('#form_registrar_actualizar_empleado')[0].reset();
    nombres_db.forEach((nom) => {
      $('#' + nom).change(); // aplicar en select2, val(''); //.change(); // .change() -> select2
    });
    $('#empleado_id_to_update').val('');
    $('.titulo_form_empleado').text('Registrar Nuevo');
    $('.btn_form_empleado').text('Registrar');
    $('#modal_nuevo_empleado').modal('show');
  });
  $('#form_registrar_actualizar_empleado').submit(function(e) {
    e.preventDefault();
    const data_form = $('#form_registrar_actualizar_empleado').serializeArray();
    let data_form_send = {};
    data_form.forEach((item) => {
      data_form_send[item.name] = item.value;
    });
    // Validar si es Registro o Actualización
    const option = $('.btn_form_empleado').text();
    let msj_option = '',
      url_option = '',
      id_empleado, msj_alerta = '';
    if (option == 'Registrar') { // Registrar
      // Validar empleado (nro_ci) empleado debe ser único
      const res = empleados.find(emp => emp.empleado == $('#empleado').val());
      if (res) {
        time_alert('error', 'Error Nro. de Documento!', 'Ya existe un empleado registrado en el número de documento proporcionado.', 3000)
        return;
      }
      msj_option = 'Se registrará un nuevo empleado.<br>El número de documento proporcionado debe ser único, no podrá editarlo más adelante.';
      url_option = '<?php echo base_url('rrhh/empleados/registrar'); ?>';
      id_empleado = 0;
      msj_alerta = 'Registrado';
    } else { // Actualizar
      msj_option = 'Se actualizará los datos del empleado.';
      url_option = '<?php echo base_url('rrhh/empleados/actualizar'); ?>';
      id_empleado = $('#empleado_id_to_update').val();
      msj_alerta = 'Actualizado';
    }
    msg_confirmation('warning', '¿Está seguro?', msj_option)
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "post",
            url: url_option,
            data: {
              data_form: data_form_send,
              empleado_id: id_empleado
            },
            dataType: "json",
            success: function(response) {
              swloading.stop();
              time_alert('success', `${msj_alerta}!`, `El empleado fué ${msj_alerta.toLowerCase()} exitosamente.`, 2000)
                .then(() => location.reload());
            },
            error: function(error) {
              swloading.stop();
              ok_alert_error(error);
            }
          });
        }
      });
  });

  function mostrarEmpleado(id_empleado) {
    const empleado = empleados.find((emp) => emp.id === id_empleado);
    nombres_db.forEach((nom) => {
      if (empleado[nom] == null)
        $('#dm_' + nom).text(' ');
      else
        $('#dm_' + nom).text(empleado[nom]);
    });
    $('#dm_empleado').text(`${empleado.paterno} ${empleado.materno} ${empleado.nombre1} ${empleado.nombre2}`);
    $('#dm_nro_ci').text(`${empleado.empleado} ${empleado.ci_extension} (${empleado.documento})`);
    $('#dm_direccion').text(`${empleado.direccion}, ${empleado.zona} # ${empleado.numero}`);
    $('#dm_fecha_nacimiento').text(empleado.fecha_nacimiento.split('-').reverse().join('/'));
    $('#dm_item').text(`${empleado.nombre_item}`);
    $('#modal_mostrar_empleado').modal('show');
  }

  function editarEmpleado(id_empleado) {
    // Inhabiiatr la edición del nro de Documento del empleado
    $('#empleado').prop('readonly', true);

    $('#empleado_id_to_update').val(id_empleado);
    $('.titulo_form_empleado').text('Editar');
    $('.btn_form_empleado').text('Actualizar');
    const empleado = empleados.find((emp) => emp.id === id_empleado);
    nombres_db.forEach((nom) => {
      $('#' + nom).val(empleado[nom]).change(); // .change() -> select2
    });
    $('#modal_nuevo_empleado').modal('show');
  }

  function eliminarEmpleado(id_empleado) {
    msg_confirmation('warning', '¿Está seguro?', 'No podrá revertir los cambios.')
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "post",
            url: "<?php echo base_url('rrhh/empleados/eliminar'); ?>",
            data: {
              empleado_id: id_empleado
            },
            dataType: "text",
            success: function(response) {
              swloading.stop();
              time_alert('success', 'Eliminado!', 'El empleado fué eliminado exitosamente.', 2000)
                .then(() => location.reload());
            },
            error: function(error) {
              swloading.stop();
              ok_alert_error(error);
            }
          });
        }
      });
  }

  function kardexSueldoEmpleado(id_empleado) {
    const empleado = empleados.find((emp) => emp.id === id_empleado);
    $('.kd_empleado').text(`${empleado.empleado}`);
    $('.kd_nombre').text(`${empleado.paterno} ${empleado.materno} ${empleado.nombre1} ${empleado.nombre2}`);
    $('.kd_cargo').text(`${empleado.nombre_item}`);
    $('#modal_kardex_sueldos').modal('show');
    //const url_ks = "<?php echo base_url('rrhh/empleados/kardex_sueldos'); ?>?data="+btoa(id_empleado);
  }

  function imprimirHojaFiliacionEmpleado(empleado) {
    const url_ks = "<?= base_url('rrhh/empleados/hoja_filiacion'); ?>?id=" + btoa(empleado);
    window.open(url_ks);
  }
  /* Registrar o Actualizar Familiar de Empleado */
  $('#form_registrar_familiar').submit(function(e) {
    e.preventDefault();
    const data_familiar = {
      empleado: $('#documento_empleado_reg_familiar').val(),
      documento: $('#nf_documento').val(),
      nombre_completo: $('#nf_nombre_completo').val(),
      relacion: $('#nf_relacion').val(),
      fecha_nacimiento: $('#nf_fecha_nacimiento').val()
    }
    let msj_conf = '',
      url = '',
      id_fa, msj_alert = '';
    if ($('.btn_submit_form_familiar').text() == 'Registrar') {
      msj_conf = 'Se registrará un nuevo familiar.';
      url = '<?php echo base_url('rrhh/empleados/registrar_familiar'); ?>';
      id_fa = 0;
      msj_alert = 'Registrado';
    } else { // Actualizar datos del familiar
      msj_conf = 'Se actualizarán los datos del familiar.';
      url = '<?php echo base_url('rrhh/empleados/actualizar_familiar'); ?>';
      id_fa = $('#id_familiar_editar').val();
      msj_alert = 'Actualizado';
      const i = lista_familiares_empleado.indexOf((item) => item.id == id_fa);
      lista_familiares_empleado.splice(i, 1);
    }
    msg_confirmation('warning', '¿Está seguro?', msj_conf)
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "post",
            url: url,
            data: {
              data: data_familiar,
              familiar_id: id_fa
            },
            dataType: "json",
            success: function(response) {
              swloading.stop();
              time_alert('success', `${msj_alert}!`, `Los datos del familiar fué ${msj_alert.toLowerCase()} correctamente.`, 2000)
                .then(() => {
                  lista_familiares_empleado.push(response); // añadimos el familiar
                  llenarTablaFamiliaresEmpleado();
                  $('#modal_form_registro_familiares').modal('hide');
                  $('#form_registrar_familiar')[0].reset();
                });
            },
            error: function(error) {
              swloading.stop();
              ok_alert_error(error);
            }
          });
        }
      });
  });

  function registrarFamiliar() {
    $('.title_form_familiar').text('Registrar');
    $('.btn_submit_form_familiar').text('Registrar');
    $('#form_registrar_familiar')[0].reset();
    $('#modal_form_registro_familiares').modal('show');
  }

  function llenarTablaFamiliaresEmpleado() {
    $('#tabla_familiares tbody').empty();
    lista_familiares_empleado.forEach((familiar, index) => {
      const fila_nota = `
                <tr>
                    <td>${index+1}</td>
                    <td>${familiar.documento}</td>
                    <td>${familiar.nombre_completo}</td>
                    <td>${familiar.relacion}</td>
                    <td>${String(familiar.fecha_nacimiento).split('-').reverse().join('/')}</td>
                    <td>
                        <button onclick="editarFamiliarEmpleado(${familiar.id})" class="btn btn-primary btn-xs" title="Editar Registro"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                        <button onclick="eliminarFamiliarEmpleado(${familiar.id})" class="btn btn-danger btn-xs" title="Eliminar Registro"><i class="fa fa-close" aria-hidden="true"></i></button>
                    </td>
                </tr>
            `;
      $('#tabla_familiares tbody').append(fila_nota);
    })
    if (lista_familiares_empleado.length == 0)
      $('#tabla_familiares tbody').append('<tr><td colspan="6">No hay familiares registrados</td></tr>');
  }

  function registroFamiliaEmpleado(id_empleado) {
    const empleado = empleados.find((emp) => emp.id === id_empleado);
    $('.kd_empleado').text(`${empleado.empleado}`);
    $('.kd_nombre').text(`${empleado.paterno} ${empleado.materno} ${empleado.nombre1} ${empleado.nombre2}`);
    $('.kd_cargo').text(`${empleado.nombre_item}`);
    $('#documento_empleado_reg_familiar').val(empleado.empleado);
    swloading.start('Cargando.');
    $.ajax({
      type: "post",
      url: "<?php echo base_url('rrhh/empleados/get_familiares'); ?>",
      data: {
        emp: empleado.empleado
      },
      dataType: "json",
      success: function(response) {
        swloading.stop();
        lista_familiares_empleado = response;
        llenarTablaFamiliaresEmpleado();
        $('#modal_tabla_familiares').modal('show');
      },
      error: function(error) {
        swloading.stop();
        ok_alert_error(error);
      }
    });
  }

  function editarFamiliarEmpleado(familiar_id) {
    const familiar = lista_familiares_empleado.find((element) => element.id == familiar_id);
    $('#documento_empleado_reg_familiar').val(familiar.empleado);
    $('#nf_documento').val(familiar.documento);
    $('#nf_nombre_completo').val(familiar.nombre_completo);
    $('#nf_relacion').val(familiar.relacion).change();
    $('#nf_fecha_nacimiento').val(familiar.fecha_nacimiento);
    $('.title_form_familiar').text('Editar');
    $('.btn_submit_form_familiar').text('Actualizar');
    $('#id_familiar_editar').val(familiar_id);
    $('#modal_form_registro_familiares').modal('show');
  }

  function eliminarFamiliarEmpleado(familiar_id) {
    msg_confirmation('warning', '¿Está seguro?', 'No podrá revertir los cambios.')
      .then((response) => {
        if (response) {
          swloading.start();
          $.ajax({
            type: "post",
            url: "<?php echo base_url('rrhh/empleados/eliminar_familiar'); ?>",
            data: {
              familiar_id
            },
            dataType: "text",
            success: function(response) {
              swloading.stop();
              time_alert('success', 'Eliminado!', 'El familiar fué eliminado exitosamente.', 2000)
                .then(() => {
                  const i = lista_familiares_empleado.indexOf((item) => item.id == familiar_id);
                  lista_familiares_empleado.splice(i, 1);
                  llenarTablaFamiliaresEmpleado();
                });
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
    $('#tabla_empleados').DataTable(DATA_TABLE);
  });
</script>
