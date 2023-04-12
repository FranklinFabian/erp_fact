<div class="content-wrapper" id="app-orden-trabajo">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-users"></i>
        </div>
        <div class="header-title">
            <h1>Atención al Cliente</h1>
            <small>Orden de Trabajo</small>
            <?php echo $this->breadcrumb->render(); ?>
        </div>
    </section>

    <section class="content">
        <div id="ordenTrabajo">

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="cliente" class="col-sm-2 col-form-label">Cliente: </label>
                                        <div class="col-sm-10">
                                            <autocomplete
                                                    ref="autocomplete"
                                                    source="<?php echo base_url() ?>rest/AtencionCliente/clientes/"
                                                    results_value="Id_Cliente"
                                                    results_display="Nombres"
                                                    input_class="form-control"
                                                    @selected="checkCliente"
                                                    placeholdeR="Seleccione Cliente..."
                                            >
                                                <!--                                                    @selected="cliente = $event"-->
                                            </autocomplete>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div v-show="formAbonado">

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="codigo" class="col-sm-4 col-form-label">Código</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" name="codigo" type="text" id="codigo"
                                                       :value="clienteSel.Codigo" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="nit" class="col-sm-4 col-form-label">NIT</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" name="nit" type="text" id="nit"
                                                       :value="clienteSel.Nit" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="telefono" class="col-sm-4 col-form-label">Teléfono</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" name="telefono" type="text" id="telefono"
                                                       :value="clienteSel.Telefono" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="abonado" class="col-sm-4 col-form-label">Abonado</label>
                                            <div class="col-sm-8">
                                                <select class="form-control dont-select-me"
                                                        name="abonado" id="abonado" v-model="abonado"
                                                        @change="getAbonado">
                                                    <option v-for="option in abonados"
                                                            :value="option.Id_Abonado">
                                                        {{option.Id_Abonado}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="medidor" class="col-sm-4 col-form-label">Medidor</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" name="medidor" type="text" id="medidor"
                                                       :value="abonadoSel.Serie_Medidor" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="categoria" class="col-sm-4 col-form-label">Categoria</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" name="categoria" type="text" id="categoria"
                                                       :value="abonadoSel.categoria.Descripcion" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-2 col-form-label">Ubicación</label>
                                            <div class="col-sm-2">
                                                <input class="form-control" name="poste" type="text" id="poste"
                                                       readonly>
                                            </div>
                                            <div class="col-sm-6">
                                                <input class="form-control" name="direccion" type="text" id="direccion"
                                                       readonly>
                                            </div>
                                            <div class="col-sm-2">
                                                <input class="form-control" name="calle" type="text" id="calle"
                                                       readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group row">
                                            <label for="abonado" class="col-sm-12 text- col-form-label">Estado: <span
                                                        :class="{'text-success':abonadoSel.Estado_Abonado=='CUENTA NORMAL', 'text-primary':abonadoSel.Estado_Abonado=='SIN CONEXION','text-danger':abonadoSel.Estado_Abonado=='SUSPENDIDO'}">
                                                    {{abonadoSel.Estado_Abonado}}
                                                </span>
                                            </label>

                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group row">
                                            <label for="medidor" class="col-sm-8 col-form-label">Ley 1886?</label>
                                            <div class="col-sm-4">
                                                <input type="checkbox">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group row">
                                            <label for="inquilino" class="col-sm-4 col-form-label">Inquilino</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" name="inquilino" type="text" id="inquilino"
                                                       readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div v-show="formAbonado">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="column">
                            <?php if ($this->permission1->method('add_product_csv', 'create')->access()) { ?>
                                <button class="btn btn-info m-b-5 m-r-2" data-toggle="modal"
                                        data-target="#modalOrden" @click="getCosto()"><i class="fa fa-plus"></i> Nueva Orden
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-bd lobidrag">
                            <div class="panel-body form">

                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#home">Ordenes</a></li>
                                    <li><a data-toggle="tab" href="#menu1" @click="getConexiones">Conexiones</a></li>
                                    <li><a data-toggle="tab" href="#menu2">Cortes</a></li>
                                    <li><a data-toggle="tab" href="#menu3">Reposiciones</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active">
                                        <div class="table-responsive" style="margin-top: 10px">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Orden</th>
                                                    <th class="text-center">Servicio</th>
                                                    <th class="text-center">Descripción</th>
                                                    <th class="text-center">Costo</th>
                                                    <th class="text-center">Fecha Inicio</th>
                                                    <th class="text-center">Fecha Fin</th>
                                                    <th class="text-center">Estado</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(orden, i) in ordenes">
                                                    <td>{{ orden.Id_Orden }}</td>
                                                    <td>{{ orden.servicio.Servicio }}</td>
                                                    <td>{{ orden.servicio.Servicio }}</td>
                                                    <td>{{ orden.Costo }}</td>
                                                    <td>{{ orden.Fecha_Inicio }}</td>
                                                    <td>{{ orden.Fecha_Fin }}</td>
                                                    <td>
                                                        <span :class="{'text-primary':orden.Estado=='SOLICITADO','text-success':orden.Estado=='EFECTUADO'}">{{ orden.Estado }}</span>
                                                    </td>
                                                    <td>
                                                        <button v-if="orden.Estado=='SOLICITADO'" class="btn btn-default"
                                                                data-toggle="tooltip"
                                                                data-placement="top" data-original-title="Procesar"
                                                                @click="modalOrden(orden.Id_Orden)">
                                                            <i class="fa fa-cogs"></i>
                                                        </button>
                                                        <button v-if="orden.Estado=='EFECTUADO' && orden.servicio.Id_Servicio==1" class="btn btn-primary"
                                                                data-toggle="tooltip"
                                                                data-placement="top" data-original-title="Crear Conexión"
                                                                @click="modalCrearConexion(orden.Id_Orden)"><i
                                                                class="fa fa-unlink"></i></button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="menu1" class="tab-pane fade">
                                        <div class="table-responsive" style="margin-top: 10px">
                                            <table class="table table-bordered table-hover">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Orden</th>
                                                    <th class="text-center">Fecha Inicio</th>
                                                    <th class="text-center">Fecha Fin</th>
                                                    <th class="text-center">Estado</th>
                                                    <th class="text-center">Acciones</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(conexion, i) in conexiones">
                                                    <td>{{ conexion.Orden }}</td>
                                                    <td>{{ conexion.Fecha_Inicio }}</td>
                                                    <td>{{ conexion.Fecha_Fin }}</td>
                                                    <td>
                                                        <span :class="{'text-primary':conexion.Estado=='SOLICITADO','text-success':conexion.Estado=='EFECTUADO'}">{{ conexion.Estado }}</span>
                                                    </td>
                                                    <td>
                                                        <button v-if="conexion.Estado=='SOLICITADO'" class="btn btn-primary"
                                                                data-toggle="tooltip"
                                                                data-placement="top" data-original-title="Procesar Conexión"
                                                                @click="modalProcesarConexion(conexion.Orden)"><i
                                                                    class="fa fa-link"></i></button>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div id="menu2" class="tab-pane fade">
                                        <h3>NA</h3>
                                    </div>
                                    <div id="menu3" class="tab-pane fade">
                                        <h3>NA</h3>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NUEVA ORDEN DE TRABAJO -->
            <div class="modal fade" id="modalOrden" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                 aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Nueva Orden</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div v-show="costoServicioError" class="alert alert-danger" role="alert">
                                {{costoServicioError}}
                            </div>

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="md-form">
                                        <label for="servicio">Servicio:</label>
                                        <select class="form-control dont-select-me"
                                                name="servicio" id="servicio" v-model="nuevaOrden.servicio"
                                                @change="getCosto">
                                            <option v-for="option in servicios"
                                                    :value="option.Id_Servicio">
                                                {{option.Servicio}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="md-form">
                                        <label for="costo">Costo:</label>
                                        <input type="text" class="form-control" id="costo" v-model="nuevaOrden.costo"
                                               readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="md-form">
                                        <label for="nota">Nota:</label>
                                        <textarea name="nota" class="form-control" rows="6"
                                                  v-model="nuevaOrden.observacion"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="agregarOrden">Agregar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PROCESAR ORDEN DE TRABAJO -->
            <div class="modal fade" id="modalProcesarOrden" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel"
                 aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Procesar Orden</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="md-form">
                                        <label for="ini_proceso">Inicio:</label>
                                        <input type="text" class="form-control" v-model="ordenSel.fecha_ini" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="md-form">
                                        <label for="fin_proceso">Fin:</label>
                                        <!--                                        <input type="text" class="form-control fecha_fin" v-model="ordenSel.fecha_fin">-->
                                        <datepicker :initial="ordenSel.fecha_ini" @changed="getTime"
                                                    v-model="ordenSel.fecha_fin"></datepicker>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="md-form">
                                        <label for="tiempo">Tiempo de Atención:</label>
                                        <input type="text" v-model="ordenSel.tiempo" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="md-form">
                                        <label for="tecnico">Técnico:</label>
                                        <select class="form-control dont-select-me"
                                                name="tecnico" id="tecnico">
                                            <option v-for="option in servicios"
                                                    :value="option.Id_Servicio">
                                                {{option.Servicio}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="procesarOrden">Procesar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CREAR CONEXION -->
            <div class="modal fade" id="modalCrearConexion" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel"
                 aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Procesar Orden</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="md-form">
                                        <label for="ini_proceso">Fecha Inicio Inspección:</label>
                                        <input type="text" class="form-control" v-model="ordenSel.fecha_ini" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="md-form">
                                        <label for="fin_proceso">Fecha Fin Inspección:</label>
                                        <input type="text" class="form-control" v-model="ordenSel.fecha_ini" disabled>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="md-form">
                                        <label for="tiempo">Tiempo de Atención:</label>
                                        <input type="text" v-model="ordenSel.tiempo" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="md-form">
                                        <label for="fin_proceso">Fecha de Conexión:</label>
                                        <datepicker :initial="ordenSel.fecha_ini" v-model="fecha_conexion"></datepicker>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="crearConexion">Crear</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PROCESAR CONEXION -->
            <div class="modal fade" id="modalProcesarConexion" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel"
                 aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel">Procesar Conexión</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <h4>INSPECCIÓN</h4>
                                    <p>Solicitud: <small>{{ordenSel.fecha_ini}}</small></p>
                                    <p>Atención: <small>{{ordenSel.fecha_fin}}</small></p>
                                    <p>1er Tiempo: <small>{{ordenSel.tiempo}}</small></p>
                                </div>
                            </div>

                            <hr>

                            <div class="row">
                                <div class="col-md-12">
                                    <h4>CONEXIÓN</h4>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="md-form">
                                        <label for="ini_proceso">Fecha de Inicio:</label>
                                        <input type="text" class="form-control" v-model="conexionSel.fecha_ini" disabled>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="md-form">
                                        <label for="fin_proceso">Fecha Fin:</label>
                                        <datepicker :initial="conexionSel.fecha_ini" @changed="getTimeConexion"
                                                    v-model="conexionSel.fecha_fin"></datepicker>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="md-form">
                                        <label for="tiempo">2do Tiempo:</label>
                                        <input type="text" v-model="conexionSel.tiempo" class="form-control" disabled>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="md-form">
                                        <label for="tiempo">Tiempo Total (1er Tiempo + 2do Tiempo):</label>
                                        <input type="text" v-model="conexionSel.tiempo" class="form-control" disabled>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" @click="procesarConexion">Procesar</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script src="<?php echo base_url() ?>my-assets/js/vue/components/atencion-cliente/OrdenTrabajo.js"></script>
