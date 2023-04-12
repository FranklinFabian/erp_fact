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
     .error-input{
        border: thin solid #d9534f;
    }
</style>
<!-- Add new customer start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1><?php echo display('generate_claim') ?></h1>
            <small><?php echo display('generate_new_claim') ?></small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('odeco') ?></a></li>
                <li class="active"><?php echo display('generate_claim') ?></li>
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

        // seteando la hora actual
        date_default_timezone_set('America/La_Paz');

        //var_dump($get_nummedidor);
        ?>
        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4><?php echo $title; ?> </h4>
                        </div>
                    </div>
                               
                    <div class="panel-body">
                        <ul class="nav nav-tabs">
                         <li class="active"><a href="#"><i class="fa fa-plus"> </i> GENERAR REGISTRO DE NUEVO CENTRO DE TRANSFORMACION</a></li>   
                          <li><a href="<?php echo base_url(); ?>odeco/listar_centros"><i class="ti-align-justify"> </i> VER LISTA DE CENTROS DE TRANSFORMACION</a></li>
                        </ul>
                    </div>
                    <form  enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8"  id="guardar_datos">
                    <div class="panel-body">
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Detalles de Registro</legend>
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="cod_centro" class="col-sm-2 col-form-label">C&oacute;digo Centro :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="cod_centro" id="cod_centro" type="text" value="<?= ($data[0]['COD_CENTRO']); ?>" min="0" tabindex="3" readonly>
                                        </div>
                                        <label for="tipo_trafo" class="col-sm-2 col-form-label">Tipo Trafo :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="tipo_trafo" id="tipo_trafo" tabindex="5" required="" aria-required="true" required="">
                                                <option value="<?= ($data[0]['TIPO_TRAFO']); ?>"><?= ($data[0]['TIPO_TRAFO']); ?></option>
                                                <option value="Monofasico">Monofasico</option>
                                                <option value="Bifasico">Bifasico</option>
                                                <option value="Trifasico">Trifasico</option>
                                              </select>
                                        </div>
                                        <label for="kva_centro" class="col-sm-2 col-form-label">kVA Centro :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="kva_centro" id="kva_centro" type="number" value="<?= ($data[0]['KVA_CENTRO']); ?>" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="tipo_uso" class="col-sm-2 col-form-label">Tipo Uso :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="tipo_uso" id="tipo_uso" tabindex="5" required="" aria-required="true" required="">
                                                <option value="<?= ($data[0]['TIPO_USO']); ?>"><?= ($data[0]['TIPO_USO']); ?></option>
                                                <option value="General">General</option>
                                                <option value="Exclusivo">Exclusivo</option>
                                              </select>
                                        </div>
                                        <label for="nivel_calidad" class="col-sm-2 col-form-label">Nivel Calidad :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="nivel_calidad" id="nivel_calidad" tabindex="5" required="" aria-required="true" required="">
                                                <option value="<?= ($data[0]['NIVEL_CALIDAD']); ?>"><?= ($data[0]['NIVEL_CALIDAD']); ?></option>
                                                <option value="Calidad 1">Calidad 1</option>
                                                <option value="Calidad 2">Calidad 2</option>
                                              </select>
                                        </div>
                                        <label for="cod_proteccion" class="col-sm-2 col-form-label">C&oacute;digo Protecci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="cod_proteccion" id="cod_proteccion" tabindex="5" aria-required="true" required="">
                                                <option value="<?= ($data[0]['COD_PROTECCION']); ?>"><?= ($data[0]['COD_PROTECCION']); ?></option>
                                                <?php foreach ($get_proteccion as $key => $list) { ?>
                                                    <option value="<?php echo $list['COD_PROTECCION'] ?>"><?php echo $list['COD_PROTECCION'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="cod_alimentador" class="col-sm-2 col-form-label">C&oacute;digo Alimentador :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="cod_alimentador" id="cod_alimentador" tabindex="5" aria-required="true" required="">
                                                <option value="<?= ($data[0]['COD_ALIMENTADOR']); ?>"><?= ($data[0]['COD_ALIMENTADOR']); ?></option>
                                                <?php foreach ($get_codalimentador as $key => $list) { ?>
                                                    <option value="<?php echo $list['COD_ALIMENTADOR'] ?>"><?php echo $list['COD_ALIMENTADOR'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label for="cod_propiedad" class="col-sm-2 col-form-label">C&oacute;digo Propiedad :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="cod_propiedad" id="cod_propiedad" tabindex="5" required="" aria-required="true" required="">
                                                <option value="<?= ($data[0]['COD_PROPIEDAD']); ?>"><?= ($data[0]['COD_PROPIEDAD']); ?></option>
                                                <option value="Del Distribuidor">Del Distribuidor</option>
                                                <option value="Particular">Particular</option>
                                              </select>
                                        </div>
                                        <label for="rel_transfo" class="col-sm-2 col-form-label">Relaci&oacute;n de Transformaci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="rel_transfo" id="rel_transfo" type="text" value="<?= ($data[0]['REL_TRAFO']); ?>" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="posicion_tap" class="col-sm-2 col-form-label">Posici&oacute;n TAP :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="posicion_tap" id="posicion_tap" type="number" value="<?= ($data[0]['POSICION_TAP']); ?>" min="0" tabindex="3">
                                        </div>
                                        <label for="consumidores_mt" class="col-sm-2 col-form-label">Consumidores MT :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="consumidores_mt" id="consumidores_mt" type="number" value="<?= ($data[0]['CONSUM_MT']); ?>" min="0" tabindex="3">
                                        </div>
                                        <label for="consumidores_bt" class="col-sm-2 col-form-label">Consumidores BT :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="consumidores_bt" id="consumidores_bt" type="number" value="<?= ($data[0]['CONSUM_BT']); ?>" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="direccion" class="col-sm-2 col-form-label">Direcci&oacute;n :</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="direccion" id="direccion" rows="3" tabindex="4"><?= ($data[0]['DIRECCION']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-4">
                                <input type="button" class="btn btn-default btn-block" value="Cancelar" onclick="window.history.back();" tabindex="7"/>
                            </div>
                            <div class="col-sm-4">
                                <input type="submit" id="add-customer" class="btn btn-primary btn-block" name="add-customer" value="Guardar Centro de Transformacion" onclick="GuardarRegistro(event);" tabindex="7"/>
                                
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript">
//Registrar Datos en la Base de Datos
function GuardarRegistro(obj){
    obj.preventDefault();
    //validar campos del formulario
    var correcto = true;
      if(!campoVacio($('#cod_centro')) || !campoVacio($("select[name='tipo_trafo']")) || !campoVacio($('#kva_centro')) || !campoVacio($("select[name='tipo_uso']")) || !campoVacio($("select[name='nivel_calidad']")) || !campoVacio($("select[name='cod_proteccion']")) || !campoVacio($("select[name='cod_alimentador']")) || !campoVacio($("select[name='cod_propiedad']")) || !campoVacio($('#rel_transfo')) || !campoVacio($('#posicion_tap')) || !campoVacio($('#consumidores_mt')) || !campoVacio($('#consumidores_bt')))
         correcto = false;
      if(correcto==true){
        var cod_centro = $("#cod_centro").val();
        var tipo_trafo = $("select[name='tipo_trafo']").val();
        var kva_centro = $("#kva_centro").val();
        var tipo_uso = $("select[name='tipo_uso']").val();
        var nivel_calidad = $("select[name='nivel_calidad']").val();
        var cod_proteccion = $("select[name='cod_proteccion']").val();
        var cod_alimentador = $("select[name='cod_alimentador']").val();
        var cod_propiedad = $("select[name='cod_propiedad']").val();
        var rel_transfo = $("#rel_transfo").val();
        var posicion_tap = $("#posicion_tap").val();
        var consumidores_mt = $("#consumidores_mt").val();
        var consumidores_bt = $("#consumidores_bt").val();
        var direccion = $("#direccion").val();
        console.log(cod_centro+' - '+tipo_trafo+' - '+kva_centro+' - '+tipo_uso+' - '+nivel_calidad+' - '+cod_proteccion+' - '+cod_alimentador+' - '+cod_propiedad+' - '+rel_transfo+' - '+posicion_tap+' - '+consumidores_mt+' - '+consumidores_bt+' - '+direccion);

        // Add record
        $.post("<?php echo base_url(); ?>odeco/modificar_centro", {
            cod_centro,tipo_trafo,kva_centro,tipo_uso,nivel_calidad,cod_proteccion,cod_alimentador,cod_propiedad,rel_transfo,posicion_tap,consumidores_mt,consumidores_bt,direccion
        }, function (data, status) {
            
        }).done(function(){
            Swal.fire(
                    {
                        icon: 'success',
                        title: 'Se actualiz&oacute; exitosamente el Centro',
                    }).then(function (){
                        window.location.href ="<?php echo base_url(); ?>odeco/listar_centros";
                    });
        }).fail(function(){
            Swal.fire({
                        icon: 'error',
                        title: 'Hubo Problemas al actualizar el Centro'
                        //type: 'warning'
                    }).then(function (){
                        window.location.href ="<?php echo base_url(); ?>odeco/listar_centros";
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
 
</script>