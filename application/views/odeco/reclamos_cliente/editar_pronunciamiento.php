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
                    <form  enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8"  id="guardar_datos">
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
                                            <input type="text" tabindex="2" class="form-control" name="nro_cuenta" id="nro_cuenta" value="<?= ($data[0]['NRO_CUENTA']); ?>" readonly />
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
                                            <div class="col-sm-6">
                                            <input class="form-control" name ="fecha_inicial" id="fecha_respuesta" type="date" value="<?= date('Y-m-d',strtotime($data[0]['FECHA_HORA_RES'])); ?>"  required="" tabindex="1"></div>
                                            <div class="col-sm-4">
                                            <input class="form-control" name ="hora_inicial" id="hora_respuesta" type="time" value="<?= date('H:i',strtotime($data[0]['FECHA_HORA_RES'])); ?>"   required="" tabindex="1"></div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="fecha_solucion" class="col-sm-2 col-form-label">Fecha Soluci&oacute;n :</label>
                                        <div class="col-sm-4">
                                            <div class="col-sm-6">
                                            <input class="form-control" name ="fecha_inicial" id="fecha_solucion" type="date" value="<?= date('Y-m-d',strtotime($data[0]['FECHA_HORA_SOL'])); ?>"  required="" tabindex="1"></div>
                                            <div class="col-sm-4">
                                            <input class="form-control" name ="hora_inicial" id="hora_solucion" type="time" value="<?= date('H:i',strtotime($data[0]['FECHA_HORA_SOL'])); ?>"   required="" tabindex="1"></div>
                                        </div>
                                        <label for="tiempo_tramite" class="col-sm-2 col-form-label">Tiempo Tr&aacute;mite :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="tiempo_tramite" id="tiempo_tramite" type="text" tabindex="2" value="<?= ($data[0]['TIEMPO_TRAMITE']); ?>" readonly=""> 
                                            <input name ="tiempo_tramite_hidden" id="tiempo_tramite_hidden" type="hidden" value=""> 
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="indicador_justificado" class="col-sm-2 col-form-label">Indicador Justificado :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <label class="input-group"><input name ="indicador_justificado" type="radio" tabindex="2" value="SI" <?= (($data[0]['IND_JUSTIFICADO']=='SI')?'checked="checked"':''); ?>> SI</label> 
                                            <label class="input-group"><input name ="indicador_justificado" type="radio" tabindex="2" value="NO" <?= (($data[0]['IND_JUSTIFICADO']=='NO')?'checked="checked"':''); ?>> NO</label>
                                        </div>
                                        <label for="indicador_conformidad" class="col-sm-2 col-form-label">Indicador Conformidad :</label>
                                        <div class="col-sm-4">
                                            <label class="input-group"><input name ="indicador_conformidad" class="form-check-input" type="radio" tabindex="2" value="SI"> SI</label> 
                                            <label class="input-group"><input name ="indicador_conformidad" class="form-check-input" type="radio" tabindex="2" value="NO"> NO</label>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="estado" class="col-sm-2 col-form-label">Estado :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="estado" id="estado" tabindex="5" required="" aria-required="true">
                                                <option value="<?= ($data[0]['ESTADO']); ?>"><?= ($data[0]['ESTADO']); ?></option>
                                                <option value="EMITIDO"> EMITIDO</option>
                                                <option value="PROCESADO"> PROCESADO</option>
                                                <option value="ANULADO"> ANULADO</option>
                                            </select>
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
                                            <textarea class="form-control" name="observacion" id="observacion" rows="3" tabindex="4"><?= ($data[0]['OBSERVACION']); ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-10">
                                            <input type="submit" id="add-customer" class="btn btn-primary btn-block" name="add-customer" value="Guardar Pronunciamiento" onclick="GuardarPronunciamiento(event);" tabindex="7"/>
                                            
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </fieldset>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Add new customer end -->

<!-- Manage Product End -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="<?php echo base_url() ?>assets/js/moment.min.js" type="text/javascript"></script>
<script type="text/javascript">
    //guardar pronunciamiento del reclamo en la base de datos
    function GuardarPronunciamiento(e)
    {
        e.preventDefault();
        var correcto = true;
        if(!campoVacio($('#fecha_respuesta')) || !campoVacio($('#fecha_solucion'))|| !campoVacio($('input[name="indicador_justificado"]:checked'))|| !campoVacio($("select[name='estado']")))
         correcto = false;
        if(correcto==true){
            //var fecha_respuesta = $('#fecha_respuesta').val();
            var fecha_presentacion = $('#fecha_presentacion').val();
            var fecha_respuesta = $("#fecha_respuesta").val() +' ' + $("#hora_respuesta").val();
            var fecha_solucion = $("#fecha_solucion").val() +' ' + $("#hora_solucion").val();
            var indicador_justificado = $('input[name="indicador_justificado"]:checked').val();
            var indicador_conformidad = $('input[name="indicador_conformidad"]:checked').val();
            //var tiempo_tramite = $('#tiempo_tramite_hidden').val();
            var estado = $('select[name="estado"]').val();
            var observacion = $('#observacion').val();
            var idreclamo = '<?php echo($data[0]['NUMERO']); ?>';
            var tiempo_tramite = CalcularTiempo(fecha_presentacion, fecha_respuesta);
            console.log(fecha_respuesta+' - '+fecha_solucion+' - '+indicador_justificado+' - '+indicador_conformidad+' - '+tiempo_tramite+' - '+estado+' - '+observacion);

            //enviar datos a la base de datos
            $.post("<?php echo base_url(); ?>Odeco/registrar_pronunciamiento", {
                //PARA EL REISTRO ODECO PARA LA AE
                fecha_respuesta,fecha_solucion,indicador_justificado,indicador_conformidad,tiempo_tramite,estado,observacion,idreclamo
            }, function (data, status) {
                
            }).done(function(){
                Swal.fire(
                        {
                            icon: 'success',
                            title: 'Se emiti&oacute; exitosamente el Pronunciamiento'
                            //type: 'success'
                        }).then(function (){
                            window.location.href ="<?php echo base_url(); ?>Odeco/listar_reclamos";
                        });
            }).fail(function(){
                Swal.fire({
                                icon: 'error',
                                title: 'Hubo Problemas al emitir el Pronunciamiento'
                                //type: 'warning'
                            }).then(function (){
                                window.location.href ="<?php echo base_url(); ?>Odeco/listar_reclamos";
                            });
            });
        
        }else{
            Swal.fire({
            icon: 'error',
            title: 'Debe llenar todos los campos requeridos'
            });
        }
    }
    //validar campos
    function campoVacio(obj)
    {
        var correcto = true;
            if(obj.val()==''){
                obj.addClass("error-input");
                correcto = false;
            }else{
                obj.removeClass("error-input")
            }
        return correcto;
    };
    function CalcularTiempo(fecha_presentacion, fecha_respuesta){

        var fecha_hora_recepcion1 = moment(fecha_presentacion, "YYY-MM-DD HH:mm");
        var fecha_hora_actual1 = moment(fecha_respuesta, "YYY-MM-DD HH:mm");
        var diferencia = fecha_hora_actual1.diff(fecha_hora_recepcion1,'h')//diff en horas
        var minutos = diferencia*60;
        var diferencia1 = fecha_hora_actual1.diff(fecha_hora_recepcion1,'m')-minutos // diferencia minutos
        var aux = diferencia1.toString().padStart(2,'0');
        var tiempo_interrupcion = parseFloat(diferencia +'.'+aux).toFixed(2);
        return tiempo_interrupcion;
    }
 
</script>