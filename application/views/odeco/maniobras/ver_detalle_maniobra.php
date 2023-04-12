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
                         <li class="active"><a href="#"><i class="fa fa-plus"> </i> VER DETALLES DE ELEMENTO DE MANIOBRA</a></li>   
                          <li><a href="<?php echo base_url(); ?>Odeco/listar_maniobras"><i class="ti-align-justify"> </i> VER LISTA DE ELEMENTOS DE MANIOBRA</a></li>
                        </ul>
                    </div>
                    <form  enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8"  id="guardar_datos">
                    <div class="panel-body">
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Detalles de Registro</legend>
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="cod_proteccion" class="col-sm-2 col-form-label">C&oacute;digo Protecci&oacute;n :</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="cod_proteccion" id="cod_proteccion" type="text" value="<?= ($data[0]['COD_PROTECCION']); ?>" min="0" tabindex="3" readonly>
                                        </div>
                                        <label for="cod_alimentador" class="col-sm-2 col-form-label">C&oacute;digo Alimentador :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="cod_alimentador" id="cod_alimentador" tabindex="5" aria-required="true" required="">
                                                <option value="<?= ($data[0]['COD_ALIMENTADOR']); ?>"><?= ($data[0]['COD_ALIMENTADOR']); ?></option>
                                                <?php foreach ($get_codalimentador as $key => $list) { ?>
                                                    <option value="<?php echo $list['COD_ALIMENTADOR'] ?>"><?php echo $list['COD_ALIMENTADOR'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <label for="tipo_proteccion" class="col-sm-2 col-form-label">Tipo Protecci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="tipo_proteccion" id="tipo_proteccion" tabindex="5" required="" aria-required="true" required="">
                                                <option value="<?= ($data[0]['TIPO_PROTECCION']); ?>"><?= ($data[0]['TIPO_PROTECCION']); ?></option>
                                                <option value="Interruptor">Interruptor</option>
                                                <option value="Reconectador">Reconectador</option>
                                                <option value="Seccionalizador">Seccionalizador</option>
                                                <option value="Seccionador Fusible">Seccionador Fusible</option>
                                                <option value="banco de Capacitor">banco de Capacitor</option>
                                                <option value="Seleccionador Cuchilla">Seccionador Cuchilla</option>
                                              </select>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="estado" class="col-sm-2 col-form-label">Estado :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="estado" id="estado" tabindex="5" required="" aria-required="true" required="">
                                                <option value="<?= ($data[0]['ESTADO']); ?>"><?= ($data[0]['ESTADO']); ?></option>
                                                <option value="ABIERTO">Abierto</option>
                                                <option value="CERRADO">Cerrado</option>
                                              </select>
                                        </div>
                                        <label for="kva_proteccion" class="col-sm-2 col-form-label">kVA Protecci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="kva_proteccion" id="kva_proteccion" type="number" value="<?= ($data[0]['KVA_PROTECCION']); ?>" min="0" tabindex="3">
                                        </div>
                                        <label for="kv_proteccion" class="col-sm-2 col-form-label">kV Protecci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="kv_proteccion" id="kv_proteccion" type="number" value="<?= ($data[0]['KV_PROTECCION']); ?>" min="0" tabindex="3">
                                        </div>
                                        
                                    </div>
                                    <div class="form-group">
                                        <label for="proteccion_superior" class="col-sm-2 col-form-label">Protecci&oacute;n Superior :</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="proteccion_superior" id="proteccion_superior" type="text" value="<?= ($data[0]['PROTECCION_SUP']); ?>" min="0" tabindex="3">
                                        </div>
                                        <label for="cod_zona" class="col-sm-2 col-form-label">C&oacute;digo Zona :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="cod_zona" id="cod_zona" tabindex="5" aria-required="true" required="">
                                                 <option value="<?= ($data[0]['COD_ZONA']); ?>"><?= ($data[0]['COD_ZONA']); ?></option>();
                                                <?php foreach ($get_codzona as $key => $list) { ?>
                                                    <option value="<?php echo $list['Id_Zona'] ?>"><?php echo $list['Zona'] ?></option>
                                                <?php } ?>
                                            </select> 
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="consum_mt_nc1" class="col-sm-2 col-form-label">Consumidores MT (NC1) :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="consum_mt_nc1" id="consum_mt_nc1" type="number" value="<?= ($data[0]['CONSUM_MT_1']); ?>" min="0" tabindex="3">
                                        </div>
                                        <label for="consum_mt_nc2" class="col-sm-2 col-form-label">Consumidores MT (NC2) :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name =<?= ($data[0]['CONSUM_BT_1']); ?>"consum_mt_nc2" id="consum_mt_nc2" type="number" value="<?= ($data[0]['CONSUM_MT_2']); ?>" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="consum_bt_nc1" class="col-sm-2 col-form-label">Consumidores BT (NC1) :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="consum_bt_nc1" id="consum_bt_nc1" type="number" value="<?= ($data[0]['CONSUM_BT_1']); ?>" min="0" tabindex="3">
                                        </div>
                                        <label for="consum_bt_nc2" class="col-sm-2 col-form-label">Consumidores BT (NC2) :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="consum_bt_nc2" id="consum_bt_nc2" type="number" value="<?= ($data[0]['CONSUM_BT_2']); ?>" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="direccion" class="col-sm-2 col-form-label">Direcci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="direccion" id="direccion" rows="3" value="Direcci&oacute;n" tabindex="4"><?= ($data[0]['DIRECCION']); ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6">
                                <input type="submit" class="btn btn-primary btn-block" onclick="ModificarRegistro(event);" tabindex="7"/>
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
function ModificarRegistro(obj)
{
    obj.preventDefault();
    //validar campos del formulario
    var correcto = true;
      if(!campoVacio($("select[name='cod_alimentador']")) || !campoVacio($("select[name='tipo_proteccion']")) || !campoVacio($("select[name='estado']")) || !campoVacio($('#kva_proteccion')) || !campoVacio($('#kv_proteccion'))|| !campoVacio($("select[name='cod_zona']")) || !campoVacio($('#consum_mt_nc1')) || !campoVacio($('#consum_mt_nc2')) || !campoVacio($('#consum_bt_nc1')) || !campoVacio($('#consum_bt_nc2')) || !campoVacio($('#direccion')))
         correcto = false;
      if(correcto==true){
        var cod_proteccion = $("#cod_proteccion").val();
        var cod_alimentador = $("select[name='cod_alimentador']").val();
        var tipo_proteccion = $("select[name='tipo_proteccion']").val();
        var estado = $("select[name='estado']").val();
        var kva_proteccion = $("#kva_proteccion").val();
        var kv_proteccion = $("#kv_proteccion").val();
        var proteccion_superior = $("#proteccion_superior").val();
        var cod_zona = $("select[name='cod_zona']").val();
        var consum_mt_nc1 = $("#consum_mt_nc1").val();
        var consum_mt_nc2 = $("#consum_mt_nc2").val();
        var consum_bt_nc1 = $("#consum_bt_nc1").val();
        var consum_bt_nc2 = $("#consum_bt_nc2").val();
        var direccion = $("#direccion").val();
        console.log(cod_proteccion+' - '+cod_alimentador+' - '+tipo_proteccion+' - '+estado+' - '+kva_proteccion+' - '+kv_proteccion+' - '+proteccion_superior+' - '+cod_zona+' - '+consum_mt_nc1+' - '+consum_mt_nc2+' - '+consum_bt_nc1+' - '+consum_bt_nc2+' - '+direccion);

        // Add record
        $.post("<?php echo base_url(); ?>Odeco/modificar_maniobra", {
            cod_proteccion,cod_alimentador,tipo_proteccion,estado,kva_proteccion,kv_proteccion,proteccion_superior,cod_zona,consum_mt_nc1,consum_mt_nc2,consum_bt_nc1,consum_bt_nc2,direccion
        }, function (data, status) {
            
        }).done(function(){
            Swal.fire(
                    {
                        icon: 'success',
                        title: 'Se actualiz&oacute; correctamente el Elemento de Maniobra',
                    }).then(function (){
                        window.location.href ="<?php echo base_url(); ?>Odeco/listar_maniobras";
                    });
        }).fail(function(){
            Swal.fire({
                        icon: 'error',
                        title: 'Hubo Problemas al actualizar el Elemento de Maniobra'
                        //type: 'warning'
                    }).then(function (){
                        window.location.href ="<?php echo base_url(); ?>Odeco/listar_maniobras";
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