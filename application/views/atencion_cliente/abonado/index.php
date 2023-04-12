<div class="content-wrapper" id="app-abonado">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-users"></i>
        </div>
        <div class="header-title">
            <h1>Atención al Cliente</h1>
            <small>Registro de Abonado</small>
            <?php echo $this->breadcrumb->render(); ?>
        </div>
    </section>

    <section class="content">
        <div id="abonados">

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-body">

                            <div class="form-group row">
                                <div class="col-sm-4">
                                    <label for="">Seleccione Cliente:</label>
                                </div>

                                <div class="col-sm-4">
                                    <autocomplete
                                            ref="autocomplete"
                                            source="<?php echo base_url() ?>rest/AtencionCliente/clientes/"
                                            results_value="Id_Cliente"
                                            results_display="Nombres"
                                            input_class="form-control"
                                            @selected="checkCliente"
                                            placeholdeR="Seleccione Cliente...">
                                    </autocomplete>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row" v-show="showBtnAddAbonado">
                <div class="col-sm-12">
                    <div class="column">
                        <?php if ($this->permission1->method('add_product_csv', 'create')->access()) { ?>
                            <button class="btn btn-info m-b-5 m-r-2" data-toggle="modal"
                                    data-target="#modalAgregarAbonado"><i class="fa fa-plus"></i> Agregar Abonado
                            </button>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="row" v-show="showListAbonado">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-body form">

                            <div class="table-responsive" style="margin-top: 10px">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Categoria</th>
                                        <th class="text-center">Medidor</th>
                                        <th class="text-center">Lectura Inicial</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(abonado, i) in abonados">
                                        <td>{{ abonado.Id_Abonado }}</td>
                                        <td>{{ abonado.Categoria }}</td>
                                        <td>{{ abonado.Serie_Medidor }}</td>
                                        <td>{{ abonado.Lectura }}</td>
                                        <td>{{ abonado.Estado_Abonado }}</td>
                                        <td>
                                            <!--                                                <button v-if="orden.Estado=='SOLICITADO'" class="btn btn-default"-->
                                            <!--                                                        data-toggle="tooltip"-->
                                            <!--                                                        data-placement="top" data-original-title="Procesar"-->
                                            <!--                                                        @click="modalOrden(orden.Id_Orden)">-->
                                            <!--                                                    <i class="fa fa-cogs"></i>-->
                                            <!--                                                </button>-->
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- NUEVO ABONADO -->
            <div class="modal fade" id="modalAgregarAbonado" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel"
                 aria-hidden="true" data-backdrop="static">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="panel panel-bd lobidrag" id="form_wizard_1">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">{{clienteSel.Codigo}} - {{clienteSel.Nombres}} / <span
                                            class="step-title">Paso 1 de 4 </span></h4>
                            </div>
                            <div class="modal-body form">
                                <form class="horizontal-form" id="submit_form" @submit.prevent="addAbonado">
                                    <div class="form-wizard">
                                        <div class="form-body">
                                            <ul class="nav nav-pills nav-justified steps">
                                                <li>
                                                    <a href="#tab1" data-toggle="tab" class="step">
                                                        <span class="number">1 </span><span class="desc">
                                                <i class="fa fa-check"></i> Categoría </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#tab2" data-toggle="tab" class="step">
                                                        <span class="number">2 </span><span class="desc">
                                                <i class="fa fa-check"></i> Dirección </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#tab3" data-toggle="tab" class="step">
                                                        <span class="number">3 </span><span class="desc">
                                                <i class="fa fa-check"></i> Medidor </span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#tab4" data-toggle="tab" class="step">
                                                        <span class="number">4 </span><span class="desc">
                                                <i class="fa fa-check"></i> Suministro </span>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div id="bar" class="progress progress-striped" role="progressbar">
                                                <div class="progress-bar progress-bar-success">
                                                </div>
                                            </div>
                                            <div class="tab-content">
                                                <!--                                        <div id="msgerror" class="alert alert-danger display-none">-->
                                                <!--                                            <button class="close" data-dismiss="alert"></button>-->
                                                <!--                                            Verifique, existen errores en el formulario.-->
                                                <!--                                        </div>-->
                                                <!--                                        <div class="alert alert-success display-none">-->
                                                <!--                                            <button class="close" data-dismiss="alert"></button>-->
                                                <!--                                            Your form validation is successful!-->
                                                <!--                                        </div>-->
                                                <div class="tab-pane active" id="tab1">

                                                    <div class="form-group row">
                                                        <div class="col-sm-6">
                                                            <select class="form-control dont-select-me"
                                                                    name="categoria" id="categoria" v-model="categoria"
                                                                    required>
                                                                <option :value="null" disabled selected>Seleccionar
                                                                    Categoría
                                                                </option>
                                                                <option v-for="option in categorias"
                                                                        :value="option.Id_Categoria">
                                                                    {{option.Descripcion}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="tab-pane" id="tab2">

                                                    <div class="form-group row">
                                                        <label for="supplier_name"
                                                               class="col-sm-3 col-form-label">Localidad</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control dont-select-me"
                                                                    name="localidad" id="localidad" v-model="localidad"
                                                                    @change="getZonas()">
                                                                <option :value="null" disabled selected>Seleccionar...
                                                                </option>
                                                                <option v-for="option in localidades"
                                                                        :value="option.Id_Localidad">
                                                                    {{option.Localidad}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="mobile" class="col-sm-3 col-form-label">Zona</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control dont-select-me"
                                                                    name="zona" id="zona" v-model="zona"
                                                                    @change="getCalles()">
                                                                <option v-for="option in zonas" :value="option.Id_Zona"
                                                                        :key="option.Id_Zona">
                                                                    {{option.Zona}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="mobile"
                                                               class="col-sm-3 col-form-label">Dirección</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control dont-select-me"
                                                                    name="calle" id="calle" v-model="calle">
                                                                <option v-for="option in calles"
                                                                        :value="option.Id_Calle"
                                                                        :key="option.Id_Calle">
                                                                    {{option.Calle}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="mobile"
                                                               class="col-sm-3 col-form-label">Número</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" name="numero"
                                                                   id="numero" v-model="numero">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="mobile" class="col-sm-3 col-form-label">Centro de
                                                            Transformación</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control dont-select-me"
                                                                    name="centro" id="centro" v-model="centro"
                                                                    @change="getPostes()">
                                                                <option v-for="option in centros"
                                                                        :value="option.Id_Centro_Transformacion"
                                                                        :key="option.Id_Centro_Transformacion">
                                                                    {{option.Centro_Transformacion}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="mobile"
                                                               class="col-sm-3 col-form-label">Poste</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control dont-select-me"
                                                                    name="poste" id="poste" v-model="poste">
                                                                <option v-for="option in postes"
                                                                        :value="option.Id_Poste"
                                                                        :key="option.Id_Poste">
                                                                    {{option.Poste}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="mobile"
                                                               class="col-sm-3 col-form-label">Distancia</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" name="distancia"
                                                                   id="distancia" v-model="distancia">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="tab-pane" id="tab3">

                                                    <div class="form-group row">
                                                        <label for="mobile"
                                                               class="col-sm-3 col-form-label">Medidor</label>
                                                        <div class="col-sm-5">
                                                            <input type="text" class="form-control" name="serie_medidor"
                                                                   id="serie_medidor" v-model="serie_medidor">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="mobile"
                                                               class="col-sm-3 col-form-label">Lectura</label>
                                                        <div class="col-sm-2">
                                                            <input type="number" class="form-control" name="lectura"
                                                                   id="lectura" v-model="lectura">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="mobile"
                                                               class="col-sm-3 col-form-label">Multiplicador</label>
                                                        <div class="col-sm-2">
                                                            <input type="number" class="form-control"
                                                                   name="multiplicador"
                                                                   id="multiplicador" v-model="multiplicador">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="tab-pane" id="tab4">

                                                    <div class="form-group row">
                                                        <label for="supplier_name"
                                                               class="col-sm-3 col-form-label">Suministro</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control dont-select-me"
                                                                    name="tipo_suministro" id="tipo_suministro"
                                                                    v-model="tipo_suministro">
                                                                <option v-for="option in tipo_suministros"
                                                                        :value="option.Id_Tipo_Suministro">
                                                                    {{option.Tipo_Suministro}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="supplier_name"
                                                               class="col-sm-3 col-form-label">Consumidor</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control dont-select-me"
                                                                    name="tipo_consumidor" id="tipo_consumidor"
                                                                    v-model="tipo_consumidor">
                                                                <option v-for="option in tipo_consumidores"
                                                                        :value="option.Id_Tipo_Consumidor">
                                                                    {{option.Tipo_Consumidor}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="supplier_name"
                                                               class="col-sm-3 col-form-label">Medición</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control dont-select-me"
                                                                    name="tipo_medicion" id="tipo_medicion"
                                                                    v-model="tipo_medicion">
                                                                <option v-for="option in tipo_mediciones"
                                                                        :value="option.Id_Tipo_Medicion">
                                                                    {{option.Tipo_Medicion}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="supplier_name"
                                                               class="col-sm-3 col-form-label">Liberación</label>
                                                        <div class="col-sm-6">
                                                            <select class="form-control dont-select-me"
                                                                    name="tipo_liberacion" id="tipo_liberacion"
                                                                    v-model="tipo_liberacion">
                                                                <option v-for="option in tipo_liberaciones"
                                                                        :value="option.Id_Liberacion_Servicio">
                                                                    {{option.Liberacion_Servicio}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <div class="row">
                                                <div class="col-md-offset-3 col-md-12">
                                                    <a href="javascript:;" class="btn btn-default button-previous">
                                                        <i class="ti-arrow-circle-left"></i> Atras </a>
                                                    <a id="btnContinuar" href="javascript:;"
                                                       class="btn btn-primary button-next">
                                                        Continuar <i class="ti-arrow-circle-right"></i>
                                                    </a>
                                                    <button type="submit" id="btnguardar"
                                                            class="btn btn-success button-submit">
                                                        Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script src="<?php echo base_url() ?>my-assets/js/vue/components/atencion-cliente/Abonados.js"></script>
