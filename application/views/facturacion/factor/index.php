<div class="content-wrapper" id="app-factores">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-settings"></i>
        </div>
        <div class="header-title">
            <h1>Configuración</h1>
            <small>Factores</small>
            <?php echo $this->breadcrumb->render(); ?>
        </div>
    </section>

    <section class="content">
        <div id="factores">
            <transition
                enter-active-class="animated fadeInLeft"
                leave-active-class="animated fadeOutRight">
                <div class="alert alert-success text-center px-5" v-if="successMSG"
                     @click="successMSG = false">{{successMSG}}
                </div>
            </transition>

            <form @submit.prevent="addFactor">
                <input type="text" class="hidden" name="Id_Factor" v-model="factor.Id_Factor">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <select class="form-control dont-select-me"
                                    name="emision" id="emision" v-model="emision" required>
                                <option :value="null" disabled selected>Seleccionar Emisión</option>
                                <option v-for="option in emisiones" :value="option.Id_Emision">
                                    {{option.Emision}}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-info">
                                RESIDENCIAL
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                De 0 a 20
                                <input type="number" step="0.001" min="0" max="100" name="RE_020" class="form-control" v-model="factor.RE_020"
                                       required>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                De 21 a 100
                                <input type="number" step="0.001" min="0" max="100" name="RE_100" class="form-control" v-model="factor.RE_100"
                                       required>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Mayor de 100
                                <input type="number" step="0.001" min="0" max="100" name="RE_ADE" class="form-control" v-model="factor.RE_ADE"
                                       required>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-info">
                                GENERAL
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                De 0 a 20
                                <input type="number" step="0.001" min="0" max="100" name="GE_020" class="form-control" v-model="factor.GE_020"
                                       required>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                De 21 a 100
                                <input type="number" step="0.001" min="0" max="100" name="GE_100" class="form-control" v-model="factor.GE_100"
                                       required>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Mayor de 100
                                <input type="number" step="0.001" min="0" max="100" name="GE_ADE" class="form-control" v-model="factor.GE_ADE"
                                       required>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-info">
                                INDUSTRIAL MENOR
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                De 0 a 50
                                <input type="number" step="0.001" min="0" max="100" name="I1_050" class="form-control" v-model="factor.I1_050"
                                       required>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Mayor de 50
                                <input type="number" step="0.001" min="0" max="100" name="I1_ADE" class="form-control" v-model="factor.I1_ADE"
                                       required>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-3">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-info">
                                INDUSTRIAL MENOR
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                De 0 a 50
                                <input type="number" step="0.001" min="0" max="100" name="I1_050" class="form-control" v-model="factor.I1_050"
                                       required>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Mayor de 50
                                <input type="number" step="0.001" min="0" max="100" name="I1_ADE" class="form-control" v-model="factor.I1_ADE"
                                       required>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="form-group">
                    <button class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </section>
</div>

<script src="<?php echo base_url() ?>my-assets/js/vue/components/facturacion/Factores.js"></script>
