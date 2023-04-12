<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Añadir pago</h1>
            <small>Añadir pago</small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i>Hogar</a></li>
                <li><a href="#">Pago</a></li>
                <li class="active">Añadir pago</li>
            </ol>
        </div>
    </section>

    <section class="content">
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

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4>Añadir pago</h4>
                                </div>
                                <div class="col-lg-6" align="right">
                                    <a href="<?php echo base_url() . 'Cga_pago/print/' . $id_suscripcion; ?>" class="btn btn-info btn-md" data-toggle="tooltip" data-placement="left" title=" Imprimir " target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="ci" class="col-form-label"><u>Datos Cliente</u></label>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-12" align="center">
                                <img src="<?php echo base_url() . 'assets/uploads/gestion_asociado/'; echo $id ?>.jpg" alt="No tiene fotografia" height="150px">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="ci" class="col-sm-4 col-form-label">Codigo cliente:</label>
                                    <div class="col-sm-8">
                                        {codigo}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="ci" class="col-sm-4 col-form-label">CI:</label>
                                    <div class="col-sm-8">
                                        {ci}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="expedido" class="col-sm-4 col-form-div">Expedido:</label>
                                    <div class="col-sm-8">
                                        {departamento}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="razon_social" class="col-sm-4 col-form-label">Razon social:</label>
                                    <div class="col-sm-8">
                                        {razon_social}
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="fecha_nacimiento" class="col-sm-4 col-form-label fecha">Fecha de nacimiento:</label>
                                    <div class="col-sm-8">
                                        {fecha_nacimiento_formato}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="nit" class="col-sm-4 col-form-label">NIT:</label>
                                    <div class="col-sm-8">
                                        {nit}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="direccion" class="col-sm-4 col-form-label">Dirección:</label>
                                    <div class="col-sm-8">
                                        {direccion}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="telefono" class="col-sm-4 col-form-label">Telefono:</label>
                                    <div class="col-sm-8">
                                        {telefono}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <label for="ci" class="col-form-label"><u>Datos suscripción</u></label>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="ci" class="col-sm-4 col-form-label">Codigo suscripcion:</label>
                                    <div class="col-sm-8">
                                        {codigo_suscripcion}
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="expedido" class="col-sm-4 col-form-div">Costo:</label>
                                    <div class="col-sm-8">
                                        <?php echo number_format($costo_suscripcion,2,',', '.'); ?> Bs.
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="nit" class="col-sm-4 col-form-label">Fecha suscripción:</label>
                                    <div class="col-sm-8">
                                        {fecha_suscripcion_formato}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <hr>

                        <div class="form-group row">
                            <div class="col-sm-12" align="right">
                                <input type="button" id="loadNewModal" class="btn btn-success btn-large" value="Nuevo Registro" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover display nowrap  " style="width:100%" id="dataTable">

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="form_modal"  role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal-content"></div>
    </div>
</div>


<script type="text/javascript">
    var base_url = "<?php echo base_url();?>";
    var idP =  "<?php echo $id_suscripcion;?>";
    var costo =  "<?php echo $costo_suscripcion;?>";

    $('#loadNewModal').click(function(e){
        e.preventDefault();
        loadModal(0,"new");
    });

    function loadModal(id , type){
        $.get( base_url + '/Cga_pago/modal_edit/?id=' + id + '&type=' + type + '&idP=' + idP + '&costo=' + costo , function (data) {
            $("#modal-content").html(data);
            $("#form_modal").modal("show");
        });
    }

    function itemDelete(id){
        swal.fire({
            title: 'Esta seguro de borrar el registro?',
            text: "Recuerde que el registro se eliminará permanentemente.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si, Eliminar!!!',
            cancelButtonText: "No, cancelar"
        }).then(function(result) {
            if (result.value) {
                itemDeleteAction(id);
            }
        });
    }

    function itemDeleteAction(id){
        $.ajax({
            url : base_url+'/Cga_pago/delete/',
            type: 'POST',
            data: {id:id},
        }).done(function(response){
            if  (response == 1){
                table.draw();
                swal.fire({
                    icon: 'success',
                    title: 'El registro fue borrado satisfactoriamente',
                    showConfirmButton: false,
                    timer: 2000
                });
            }else{
                swal.fire({
                    icon: 'error',
                    title: 'Este registro no puede ser eliminado!',
                    text: "Debido a que fue utilizado en uno o mas formularios",
                    showConfirmButton: false,
                    timer: 4000
                });
            }
        });

    }

    var table;
    var snippet_datatable = function () {

        var initTable1 = function() {
            table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax:{
                    url :  base_url+'/Cga_pago/dataTable/',
                    type : 'POST',
                    data: {idP:idP},
                },
                pagingType:"full_numbers",
                pageLength:"10",
                order: [[ 0, "desc" ]],
                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'codigo', title: 'Codigo' },
                    { data: 'fecha', title: 'Fecha' },
                    { data: 'importe_pagado', title: 'Monto', render: $.fn.dataTable.render.number('.', ',', 2, 'Bs. ')},
                    { data: 'button', title: 'Acciones' }
                ],
                columnDefs:[
                    {
                        targets: [ 0 ],
                        searchable: false,
                        width: "10px",
                        orderable: false,
                        visible: false
                    },
                    {
                        targets: [ 3],
                        searchable: false,
                        orderable: false,
                    }
                ],
            });
        };

        return {

            //main function to initiate the module
            init: function() {
                initTable1();
            }

        };

    }();

    $(function(){
        snippet_datatable.init();
    });


</script>


