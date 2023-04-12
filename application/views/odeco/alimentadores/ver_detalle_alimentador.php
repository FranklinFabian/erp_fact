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
                         <li class="active"><a href="#"><i class="fa fa-plus"> </i> VER DETALLES DE ALIMENTADOR</a></li>   
                          <li><a href="<?php echo base_url(); ?>Odeco/alimentadores_listar"><i class="ti-align-justify"> </i> VER LISTA DE ALIMENTADORES</a></li>
                        </ul>
                    </div>
                    <form  enctype="multipart/form-data" class="form-horizontal" accept-charset="UTF-8"  id="guardar_datos">
                    <div class="panel-body">
                        <fieldset class="form-group">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Formulario de Registro</legend>
                                <div class="col-md-9">
                                    <div class="form-group ">
                                        <label for="cod_alimentador" class="col-sm-2 col-form-label">C&oacute;digo Alimentador :</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="cod_alimentador" id="cod_alimentador" type="text" value="<?= ($data[0]['COD_ALIMENTADOR']); ?>" readonly min="0" tabindex="1">
                                        </div>
                                        <label for="cod_proteccion" class="col-sm-2 col-form-label">C&oacute;digo Protecci&oacute;n :<i class="text-danger">*</i></label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="cod_proteccion" id="cod_proteccion" type="text" value="<?= ($data[0]['COD_PROTECCION']); ?>" min="0" tabindex="3">
                                        </div>
                                        <label for="subestacion" class="col-sm-2 col-form-label">Subestaci&oacute;n :</label>
                                        <div class="col-sm-2">
                                            <input class="form-control" name ="subestacion" id="subestacion" type="text" value="<?= ($data[0]['SUBESTACION']); ?>" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="kva_alimentador" class="col-sm-2 col-form-label">kVA Alimentador :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="kva_alimentador" id="kva_alimentador" type="number" value="<?= ($data[0]['KVA_ALIMENTADOR']); ?>" min="0" tabindex="3">
                                        </div>
                                        <label for="kv_alimentador" class="col-sm-2 col-form-label">kV Alimentador :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="kv_alimentador" id="kv_alimentador" type="number" value="<?= ($data[0]['KV_ALIMENTADOR']); ?>" min="0" tabindex="3">
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <label for="consum_mt_nc1" class="col-sm-2 col-form-label">Consumidores MT (NC1) :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="consum_mt_nc1" id="consum_mt_nc1" type="number" value="<?= ($data[0]['CONSUM_MT_1']); ?>" min="0" tabindex="3">
                                        </div>
                                        <label for="consum_mt_nc2" class="col-sm-2 col-form-label">Consumidores MT (NC2) :<i class="text-danger">*</i></label>
                                        <div class="col-sm-4">
                                            <input class="form-control" name ="consum_mt_nc2" id="consum_mt_nc2" type="number" value="<?= ($data[0]['CONSUM_MT_2']); ?>" min="0" tabindex="3">
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
                                        <label for="direccion" class="col-sm-2 col-form-label">Direcci&oacute;n :</label>
                                        <div class="col-sm-10">
                                            <textarea class="form-control" name="direccion" id="direccion" rows="3" tabindex="4"><?= ($data[0]['COD_LOCALIDADES']); ?></textarea>
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
                                <input type="submit" class="btn btn-success btn-block" name="add-customer" value="MODIFICAR REGISTRO" onclick="ModificarRegistro(event);" tabindex="7"/>
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
function ModificarRegistro(obj){
    obj.preventDefault();
    //validar campos del formulario
    var correcto = true;
      if(!campoVacio($("#cod_alimentador")) || !campoVacio($('#cod_proteccion')) || !campoVacio($('#kva_alimentador'))|| !campoVacio($('#kv_alimentador')) || !campoVacio($('#consum_mt_nc1')) || !campoVacio($('#consum_mt_nc2')) || !campoVacio($('#consum_bt_nc1')) || !campoVacio($('#consum_bt_nc2')))
         correcto = false;
      if(correcto==true){
        var cod_alimentador = $("#cod_alimentador").val();
        var cod_proteccion = $("#cod_proteccion").val();
        var subestacion = $("#subestacion").val();
        var kva_alimentador = $("#kva_alimentador").val();
        var kv_alimentador = $("#kv_alimentador").val();
        var consum_mt_nc1 = $("#consum_mt_nc1").val();
        var consum_mt_nc2 = $("#consum_mt_nc2").val();
        var consum_bt_nc1 = $("#consum_bt_nc1").val();
        var consum_bt_nc2 = $("#consum_bt_nc2").val();
        var direccion = $("#direccion").val();
        console.log(cod_alimentador+' - '+cod_proteccion+' - '+subestacion+' - '+kva_alimentador+' - '+kv_alimentador+' - '+consum_mt_nc1+' - '+consum_mt_nc2+' - '+consum_bt_nc1+' - '+consum_bt_nc2+' - '+direccion);

        // Add record
        $.post("<?php echo base_url(); ?>Odeco/modificar_alimentador", {
            cod_alimentador,cod_proteccion,subestacion,kva_alimentador,kv_alimentador,consum_mt_nc1,
            consum_mt_nc2,consum_bt_nc1,consum_bt_nc2,direccion
        }, function (data, status) {
            
        }).done(function(){
            Swal.fire(
                    {
                        icon: 'success',
                        title: 'Se actualiz&oacute; exitosamente el Alimentador',
                    }).then(function (){
                        window.location.href ="<?php echo base_url(); ?>Odeco/alimentadores_listar";
                    });
        }).fail(function(){
            Swal.fire({
                        icon: 'error',
                        title: 'Hubo Problemas al modificar el Alimentador'
                        //type: 'warning'
                    }).then(function (){
                        window.location.href ="<?php echo base_url(); ?>Odeco/alimentadores_listar";
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