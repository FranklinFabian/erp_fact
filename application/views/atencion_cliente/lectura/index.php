<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-users"></i>
        </div>
        <div class="header-title">
            <h1>Lecturación</h1>
            <small>Abonados</small>
            <?php echo $this->breadcrumb->render(); ?>
        </div>
    </section>

    <section class="content">
        <div id="lectura">

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="md-form">
                                        <label for="servicio">Localidad:</label>
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
                                <div class="col-md-3">
                                    <div class="md-form">
                                        <label for="costo">Zona:</label>
                                        <select class="form-control dont-select-me"
                                                name="zona" id="zona" v-model="zona">
                                            <option v-for="option in zonas" :value="option.Id_Zona"
                                                    :key="option.Id_Zona">
                                                {{option.Zona}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="md-form">
                                        <label for="costo">Emisión:</label>
                                        <input type="text" class="form-control" id="emision" v-model="emision"
                                               readonly>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="md-form">
                                        <button @click="loadAbonados()" class="btn btn-primary">Registrar</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row" v-show="frmAbonado">
                <div class="col-sm-12">
                    <div class="panel panel-bd lobidrag">
                        <div class="panel-body" v-if="abonado">

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="codigo" class="col-sm-4 col-form-label">CLIENTE:</label>
                                        <span class="col-sm-8">{{abonado.cliente.Codigo}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="nit" class="col-sm-4 col-form-label">NIT</label>
                                        <span class="col-sm-8">{{abonado.cliente.Nit}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="telefono" class="col-sm-4 col-form-label">TELEFONO</label>
                                        <span class="col-sm-8">{{abonado.cliente.Telefono}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="codigo" class="col-sm-2 col-form-label">RAZON:</label>
                                        <span class="col-sm-10">{{abonado.cliente.Nombres}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="codigo" class="col-sm-4 col-form-label">ABONADO:</label>
                                        <span class="col-sm-8">{{abonado.Id_Abonado}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="nit" class="col-sm-4 col-form-label">MEDIDOR</label>
                                        <span class="col-sm-8">{{abonado.Serie_Medidor}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="telefono" class="col-sm-4 col-form-label">CATEGORÍA</label>
                                        <span class="col-sm-8">{{abonado.categoria.Descripcion}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group row">
                                        <label for="codigo" class="col-sm-2 col-form-label">UBICACIÓN:</label>
                                        <span class="col-sm-10">{{abonado.ubicacion}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="codigo" class="col-sm-4 col-form-label">ESTADO:</label>
                                        <span class="col-sm-8">{{abonado.Estado_Abonado}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="nit" class="col-sm-4 col-form-label">LEY 1886?</label>
                                        <span class="col-sm-8">{{abonado.adulto}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group row">
                                        <label for="telefono" class="col-sm-4 col-form-label">INQUILINO</label>
                                        <span class="col-sm-8">{{abonado.inquilino}}</span>
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="panel panel-bd lobidrag" style="background: lightcyan">
                                        <div class="panel-body form">

                                            <div class="table-responsive" style="margin-top: 10px">
                                                <table class="table table-bordered table-hover">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">Emisión</th>
                                                        <th class="text-center">KWh</th>
                                                        <th class="text-center">Contador</th>
                                                        <th class="text-center">Estimado</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr v-for="(l, i) in abonado.lecturas">
                                                        <td>{{ l.emision.Emision }}</td>
                                                        <td>{{ l.Consumo_Actual }}</td>
                                                        <td>{{ l.Lectura_Actual }}</td>
                                                        <td>{{ l.Estimado }}</td>
                                                    </tr>
                                                    </tbody>
                                                    <tfoot>
                                                    <tr v-if="abonado.lecturas">
                                                        <td colspan="3">PROMEDIO DE CONSUMO</td>
                                                        <td>000</td>
                                                    </tr>
                                                    </tfoot>
                                                </table>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="panel panel-bd lobidrag" style="background: lightgreen">
                                        <div class="panel-body form">
                                            <div class="form-group row">
                                                <label for="telefono" class="col-sm-5 col-form-label">Lectura
                                                    Anterior</label>
                                                <input type="text" class="col-sm-5" v-model="lanterior" readonly>
                                            </div>
                                            <div class="form-group row">
                                                <label for="telefono" class="col-sm-5 col-form-label">Potencia</label>
                                                <input type="text" class="col-sm-5" v-model="lpotencia">
                                            </div>
                                            <div class="form-group row">
                                                <label for="telefono" class="col-sm-5 col-form-label">Lectura
                                                    Actual</label>
                                                <input type="text" class="col-sm-5" v-model="lactual" @input="updateConsumo">
                                            </div>
                                            <div class="form-group row">
                                                <label for="telefono"
                                                       class="col-sm-5 col-form-label">Multiplicador</label>
                                                <input type="text" class="col-sm-5" v-model="lmultiplicador">
                                            </div>
                                            <div class="form-group row">
                                                <label for="telefono" class="col-sm-5 col-form-label">Consumo
                                                    KWh</label>
                                                <input type="text" class="col-sm-5" v-model="lconsumo">
                                            </div>
                                        </div>
                                        <div class="panel-footer" align="center">
                                            <button class="btn btn-success" @click="crearNuevaLectura">Validar/Guardar</button>
                                            <button class="btn btn-warning">Observar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="panel-footer" align="center">
                            <v-pagination v-if="pageCount > 0" :classes="bootstrapPaginationClasses"
                                          v-model="currentPage" :page-count="pageCount"></v-pagination>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
    window.onload = function () {
        $('body').addClass("sidebar-mini sidebar-collapse");
    }
</script>

<script src="<?php echo base_url() ?>my-assets/js/vue/components/atencion-cliente/Lectura.js"></script>
