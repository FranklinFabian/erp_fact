<style type="text/css">
    .nav-tabs > li.active > a {
      background-color: #3B8104 !important;
      color: #fff !important;
      border-radius: 4;
    }
    .nav-tabs > li> a {
      background-color: #1C93C7 !important;
      color: #fff !important;
      border-radius: 4;
    }
</style>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Detalle de Reclamo</h1>
            <small>Detalles</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('odeco') ?></a></li>
                <li class="active">Detalle de Reclamo</li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Alert Message -->
        <?php
        $message = $this->session->userdata('message');
        if (isset($message)) {
            ?>
            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $message ?>                    
            </div>
            <?php
            $this->session->unset_userdata('message');
        }
        $error_message = $this->session->userdata('error_message');
        if (isset($error_message)) {
            ?>
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo $error_message ?>                    
            </div>
            <?php
            $this->session->unset_userdata('error_message');
        }
        ?>
        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4> Detalle de Reclamo</h4>
                        </div>
                    </div>
                               
                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                         <li class="active"><a href="#"><i class="fa fa-search"> </i> VER RECLAMO</a></li>   
                          <li><a href="<?php echo base_url(); ?>odeco/listar_reclamos"><i class="ti-align-justify"> </i> VER LISTA DE RECLAMOS</a></li>
                          <li><a href="<?php echo base_url(); ?>odeco"><i class="fa fa-plus"> </i> GENERAR RECLAMO</a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">INFORMACI&Oacute;N DE RECLAMO</legend>
                                <div class="col-md-9">
                                    <div class="form-group row">
                                        <label for="nro_reclamo" class="col-sm-2 col-form-label">Nro. de Reclamo :</label>
                                        <div class="col-sm-2">
                                            <input type="text" tabindex="2" class="form-control" name="nro_reclamo" id="nro_reclamo" value="<?= ($data[0]['NUMERO']); ?>" readonly="" />
                                        </div>
                                        <label for="nro_cuenta" class="col-sm-2 col-form-label">Nro. Cuenta :</label>
                                        <div class="col-sm-2">
                                            <input type="text" tabindex="2" class="form-control" name="nro_cuenta" id="nro_cuenta" value="<?=($data[0]['NRO_CUENTA']); ?>" readonly />
                                        </div>
                                        <label for="niv_calidad" class="col-sm-2 col-form-label">Niv. Calidad :</label>
                                        <div class="col-sm-2">
                                            <input type="text" tabindex="2" class="form-control" name="niv_calidad" id="niv_calidad" value="<?= ($data[0]['NIVEL_CALIDAD']); ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="cod_localidad" class="col-sm-2 col-form-label">Cod. Localidad :</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="cod_localidad" id="cod_localidad" type="text" tabindex="2" value="<?= ($data[0]['COD_LOCALIDAD']); ?>" readonly=""> 
                                        </div>
                                        <label for="categoria" class="col-sm-2 col-form-label">Categor&iacute;a :</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="categoria" id="categoria" type="text" tabindex="2" value="<?= ($data[0]['CATEGORIA']); ?>" readonly=""> 
                                        </div>
                                        <label for="cod_reclamo" class="col-sm-2 col-form-label">Cod. Reclamo :</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="cod_reclamo" id="cod_reclamo" type="text" tabindex="2" value="<?= ($data[0]['COD_RECLAMO']); ?>" readonly=""> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fecha_presentacion" class="col-sm-2 col-form-label">Fecha Presentaci&oacute;n :</label>
                                        <div class="col-sm-4">
                                            <input type="text" tabindex="2" class="form-control" name="fecha_presentacion" id="fecha_presentacion" value="<?= ($data[0]['FECHA_HORA_REC']); ?>" readonly />
                                        </div>
                                        <label for="fecha_respuesta" class="col-sm-2 col-form-label">Fecha Respuesta :</label>
                                        <div class="col-sm-4">
                                            <input type="text" tabindex="2" class="form-control" name="fecha_respuesta" id="fecha_respuesta" value="<?= ($data[0]['FECHA_HORA_RES']); ?>" readonly />
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fecha_solucion" class="col-sm-2 col-form-label">Fecha Soluci&oacute;n :</label>
                                        <div class="col-sm-4">
                                            <input type="text" tabindex="2" class="form-control" name="fecha_solucion" id="fecha_solucion" value="<?= ($data[0]['FECHA_HORA_SOL']); ?>" readonly />
                                        </div>
                                        <label for="tiempo_tramite" class="col-sm-2 col-form-label">Tiempo Tr&aacute;mite :</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="tiempo_tramite" id="tiempo_tramite" type="text" tabindex="2" value="<?= ($data[0]['TIEMPO_TRAMITE']); ?>" readonly=""> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="indicador_justificado" class="col-sm-2 col-form-label">Indicador Justificado :</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="indicador_justificado" id="indicador_justificado" type="text" tabindex="2" value="<?= ($data[0]['IND_JUSTIFICADO']); ?>" readonly=""> 
                                        </div>
                                        <label for="indicador_conformidad" class="col-sm-2 col-form-label">Indicador Conformidad :</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="indicador_conformidad" id="indicador_conformidad" type="text" tabindex="2" value="<?= ($data[0]['IND_CONFORMIDAD']); ?>" readonly=""> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="estado" class="col-sm-2 col-form-label">Estado :</label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="estado" id="estado" type="text" tabindex="2" value="<?= ($data[0]['ESTADO']); ?>" readonly=""> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="motivo" class="col-sm-2 col-form-label">Motivo :</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="motivo" id="motivo" rows="3" tabindex="4" readonly=""><?= ($data[0]['MOTIVO']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="observacion" class="col-sm-2 col-form-label">Observaci&oacute;n :</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="observacion" id="observacion" rows="3" tabindex="4" readonly=""><?= ($data[0]['OBSERVACION']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new customer end -->

<!-- Manage Product End -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">

 
</script>