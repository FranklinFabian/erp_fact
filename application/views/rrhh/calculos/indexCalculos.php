<!-- Admin Home Start -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-world"></i>
        </div>
        <div class="header-title">
            <h1><?php echo module_name() ?></h1>
            <small><?php echo details_module('Factores') ?></small>
            <?php echo $this->breadcrumb->render() ?>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Alert Message -->
        <?php $message = $this->session->userdata('message');
        if (isset($message)){ ?>
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
        <div class="row">
            <div class="col-sm-12">
            </div>
        </div>

        <!--Add Invoice -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <!-- Header -->
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><strong><?php echo "Calculos"; ?></strong><span class="tipo_cobro"></span></h4>
                        </div>
                    </div> <!-- Header End -->
                    <!-- Body -->
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-3 col-xs-6 text-center">
                                <h4>Planillas Salariales</h4>
                                <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modal_planillas_salariales">Salarios</button>
                            </div>
                            <!-- <div class="col-sm-3 col-xs-6 text-center"> // TODO: Incremento Salarial
                                <h4>Incremento Salarial</h4>
                                <button type="button" class="btn btn-info btn-block" data-toggle="modal" data-target="#modal_incremento_salarial">Incremento Salarial</button>
                            </div> -->
                            <!-- <div class="col-sm-3 col-xs-6 text-center"> // TODO: Aguinaldos
                                <h4>Planilla Aguinaldos</h4>
                                <button type="button" class="btn btn-info btn-block" id="btn_aguinaldos">Aguinaldos</button>
                            </div> -->
                            <!-- <div class="col-sm-3 col-xs-6 text-center">
                                <h4>Bono Refrigerio</h4>
                                <button type="button" class="btn btn-info btn-block" id="btn_refrigerio">Refrigerio</button>
                            </div> -->
                        </div>
                    </div> <!-- Body End -->
                </div>
            </div>

            <!-- Modal Planillas Salariales - Calculo Salarios -->
            <div class="modal fade fs-12" id="modal_planillas_salariales" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Calculo Salarios
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                                </button>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <form action="#" id="form_calcular_planillas_salariales">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label for="planillas_salariales_mes">Mes</label>
                                        <select name="empleado" id="planillas_salariales_mes" class="form-control" style="width:100%;" required>
                                            <?php foreach($data_meses as $m): ?>
                                                <option value="<?php echo $m->mes; ?>"><?php echo date('d/m/Y', strtotime($m->mes)); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mt-20 text-center">
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Calcular</button>
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Incremento Salarial - Calculo Incremento Salarial -->
            <div class="modal fade fs-12" id="modal_incremento_salarial" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Calculo Incremento Salarial
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                                </button>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <form action="#" id="form_incremento_salarial">
                                <div class="row">
                                    <div class="col-sm-12 pl-5">
                                        <?php list($anio, $mes, $dia) = explode('-', $data_meses[0]->mes); ?>
                                        <?php for($i=1; $i<= $mes; $i++): ?>
                                            <?php $dias_mes = date("t", strtotime($anio.'-'.$i.'-01')); ?>
                                            <div class="">
                                                <label class="c-pointer">
                                                    <input name="incremento_salarial_meses[]" type="checkbox" value="<?php echo $anio.'-'.$i.'-'.$dias_mes; ?>">&nbsp;&nbsp;<?php echo $dias_mes.'/'.str_pad($i, 2, '0', STR_PAD_LEFT).'/'.$anio; ?>
                                                </label>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <div class="mt-10 text-center">
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Calcular</button>
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Planilla Aguinaldos - Aguinaldos -->
            <div class="modal fade fs-12" id="modal_planilla_aguinaldos" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Aguinaldos
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                                </button>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <form action="#" id="form_aguinaldos">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="aguinaldo_servicio">Servicio</label>
                                        <select name="empleado" id="aguinaldo_servicio" class="form-control" style="width:100%;" required>
                                            <?php foreach($data_empleados as $e): ?>
                                                <option value="<?php echo $e->empleado; ?>"><?php echo $e->paterno.' '.$e->materno.' '.$e->nombre1.' '.$e->nombre2; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="aguinaldo_empleado">Empleado</label>
                                        <select name="empleado" id="aguinaldo_empleado" class="form-control" style="width:100%;" required>
                                            <?php foreach($data_empleados as $e): ?>
                                                <option value="<?php echo $e->empleado; ?>"><?php echo $e->empleado.' - '.$e->paterno.' '.$e->materno.' '.$e->nombre1.' '.$e->nombre2; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Item</label>
                                        <p class="form-control mostrarTexto fs-12 aguinaldo_item"></p>
                                    </div>
                                    <div class="col-sm-5">
                                        <label class="mt-10">Nombre Ítem</label>
                                        <p class="form-control mostrarTexto fs-12 aguinaldo_nombre_item"></p>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="mt-10">Nombre Sección</label>
                                        <p class="form-control mostrarTexto fs-12 aguinaldo_nombre_seccion"></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="mt-10">Ingreso</label>
                                        <p class="form-control mostrarTexto fs-12 aguinaldo_fecha_ingreso"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label for="">Gestión</label>
                                        <p class="form-control mostrarTexto"></p>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="">Fecha Inicio Calculo</label>
                                        <p class="form-control mostrarTexto"></p>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <label for="">&nbsp;</label>
                                        <button type="button" class="btn btn-info form-control">Calcular</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="">Sueldo 1</label>
                                        <p class="form-control mostrarTexto"></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="">Sueldo 2</label>
                                        <p class="form-control mostrarTexto"></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="">Sueldo 3</label>
                                        <p class="form-control mostrarTexto"></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="">Promedio</label>
                                        <p class="form-control mostrarTexto"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="mt-10" for="aguinaldo_dias_trabajo">Días Trabajo</label>
                                        <input type="number" step="0.01" min="0" name="" id="aguinaldo_dias_trabajo" class="form-control fs-12" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="mt-10" for="aguinaldo_dias_falta">Días Falta</label>
                                        <input type="number" step="0.01" min="0" name="" id="aguinaldo_dias_falta" class="form-control fs-12" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="mt-10" for="aguinaldo_aguinaldo">Aguinaldo</label>
                                        <input type="number" step="0.01" name="" id="aguinaldo_aguinaldo" class="form-control fs-12 mostrarTexto" required>
                                    </div>
                                </div>
                                <div class="mt-10 text-center">
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Calcular</button>
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Bono Refrigerio - Refrigerio -->
            <div class="modal fade fs-12" id="modal_bono_refrigerio" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Refrigerio
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i></span>
                                </button>
                            </h4>
                        </div>
                        <div class="modal-body">
                            <form action="#" id="form_bono_refrigerio">
                            <div class="row">
                                    <div class="col-sm-4">
                                        <label for="refrigerio_servicio">Servicio</label>
                                        <select name="empleado" id="refrigerio_servicio" class="form-control" style="width:100%;" required>
                                            <?php foreach($data_empleados as $e): ?>
                                                <option value="<?php echo $e->empleado; ?>"><?php echo $e->paterno.' '.$e->materno.' '.$e->nombre1.' '.$e->nombre2; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="refrigerio_empleado">Empleado</label>
                                        <select name="empleado" id="refrigerio_empleado" class="form-control" style="width:100%;" required>
                                            <?php foreach($data_empleados as $e): ?>
                                                <option value="<?php echo $e->empleado; ?>"><?php echo $e->empleado.' - '.$e->paterno.' '.$e->materno.' '.$e->nombre1.' '.$e->nombre2; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Item</label>
                                        <p class="form-control mostrarTexto fs-12 aguinaldo_item"></p>
                                    </div>
                                    <div class="col-sm-5">
                                        <label class="mt-10">Nombre Ítem</label>
                                        <p class="form-control mostrarTexto fs-12 aguinaldo_nombre_item"></p>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="mt-10">Nombre Sección</label>
                                        <p class="form-control mostrarTexto fs-12 aguinaldo_nombre_seccion"></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="mt-10">Ingreso</label>
                                        <p class="form-control mostrarTexto fs-12 aguinaldo_fecha_ingreso"></p>
                                    </div>
                                </div>
                                <!-- <div class="row">
                                    <div class="col-sm-4">
                                        <label for="">Gestión</label>
                                        <p class="form-control mostrarTexto"></p>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for="">Fecha Inicio Calculo</label>
                                        <p class="form-control mostrarTexto"></p>
                                    </div>
                                    <div class="col-sm-4 text-center">
                                        <label for="">&nbsp;</label>
                                        <button type="button" class="btn btn-info form-control">Calcular</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label for="">Sueldo 1</label>
                                        <p class="form-control mostrarTexto"></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="">Sueldo 2</label>
                                        <p class="form-control mostrarTexto"></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="">Sueldo 3</label>
                                        <p class="form-control mostrarTexto"></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <label for="">Promedio</label>
                                        <p class="form-control mostrarTexto"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <label class="mt-10" for="aguinaldo_dias_trabajo">Días Trabajo</label>
                                        <input type="number" step="0.01" min="0" name="" id="aguinaldo_dias_trabajo" class="form-control fs-12" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="mt-10" for="aguinaldo_dias_falta">Días Falta</label>
                                        <input type="number" step="0.01" min="0" name="" id="aguinaldo_dias_falta" class="form-control fs-12" required>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="mt-10" for="aguinaldo_aguinaldo">Aguinaldo</label>
                                        <input type="number" step="0.01" name="" id="aguinaldo_aguinaldo" class="form-control fs-12 mostrarTexto" required>
                                    </div>
                                </div> -->
                                <div class="mt-10 text-center">
                                    <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-check" aria-hidden="true"></i> Calcular</button>
                                    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section> <!-- /.content -->

</div> <!-- /.content-wrapper -->

<script type="text/javascript">
    const data_meses            = <?php echo json_encode($data_meses); ?>;
    const data_empleados        = <?php echo json_encode($data_empleados); ?>;
    // Salarios
    $('#form_calcular_planillas_salariales').submit(function (e) {
        e.preventDefault();
        const mes = $('#planillas_salariales_mes').val();
        msg_confirmation('warning', '¿Está seguro?', 'Se realizarán los calculos salariales para el mes seleccionado.')
        .then((response) => {
            if(response) {
                swloading.start('Calculando.');
                $.ajax({
                    type: "post",
                    url: "<?= base_url('rrhh/calculos/planilla_salarial'); ?>",
                    data: {mes},
                    dataType: "json",
                    success: function (response) {
                        swloading.stop();
                        time_alert('success', 'Calculado!', 'Cálculos realizados exitosamente.', 2500)
                        .then(() => {
                            $('#modal_planillas_salariales').modal('hide');
                        });
                    },
                    error: function (error) {
                        swloading.stop();
                        ok_alert_error(error);
                    }
                });
            }
        });
    });

    // Incremento Salarial
    $('#form_incremento_salarial').submit(function (e) {
        e.preventDefault();
        const meses = $('[name="incremento_salarial_meses[]"]:checked').map(function(){
            return this.value;
        }).get();
        if(meses.length == 0) {
            time_alert('error', 'Error!', 'Debe seleccionar como mínimo un mes para realizar los calculos del incremento salarial.', 2000)
            return;
        }
        msg_confirmation('warning', '¿Está seguro?', 'Se realizarán los calculos para el incremento salarial para los meses seleccionados.')
        .then((response) => {
            if(response) {
                swloading.start('Calculando.');
                $.ajax({
                    type: "post",
                    url: "<?= base_url('rrhh/calculos/incremento_salarial') ?>",
                    data: {meses},
                    dataType: "json",
                    success: function (response) {
                        swloading.stop();
                        time_alert('success', 'Calculado!', 'Cálculos realizados exitosamente.', 2500)
                        .then(() => {
                            $('#modal_incremento_salarial').modal('hide');
                        });
                    },
                    error: function (error) {
                        swloading.stop();
                        ok_alert_error(error);
                    }
                });
            }
        });
    });
    // Aguinaldo
    $('#btn_aguinaldos').on('click', function () {
        return; // TODO planilla aguinaldo
        $('#aguinaldo_empleado').change();
        $('#modal_planilla_aguinaldos').modal('show');
    });
    $('#aguinaldo_empleado').on('change', function () {
        console.log()
        const emp = data_empleados.find(element => element.empleado == $('#aguinaldo_empleado').val());
        if(emp) {
            $('.aguinaldo_item').text(emp.item);
            $('.aguinaldo_nombre_item').text(emp.nombre_item);
            $('.aguinaldo_nombre_seccion').text(emp.nombre_seccion);
            $('.aguinaldo_fecha_ingreso').text(emp.fecha_ingreso.split('-').reverse().join('/'));
        } else {
            $('.aguinaldo_item').text(' - ');
            $('.aguinaldo_nombre_item').text('Seleccione un empleado');
            $('.aguinaldo_nombre_seccion').text('Seleccione un empleado');
            $('.aguinaldo_fecha_ingreso').text('Seleccione un empleado');
        }
    });
    $('#form_aguinaldos').submit(function (e) {
        e.preventDefault();
        //const mes = $('#fffffffff').val();
        msg_confirmation('warning', '¿Está seguro?', 'Se realizarán los calculos para el incremento salarial para los meses seleccionados.')
            .then((response) => {
                if(response) {
                    swloading.start('Realizando calculos, espere por favor.');
                    swloading.stop();
                    console.log('calculando incrementos salariales');
                }
            })
    });

    // Refrigerio
    $('#btn_refrigerio').on('click', function () {
        $('#modal_bono_refrigerio').modal('show');
    });

    $(document).ready(function () {
    });
</script>