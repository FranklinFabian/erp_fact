<script src="<?php echo base_url() ?>my-assets/js/admin_js/json/almacen.js" type="text/javascript"></script>
<!-- Edit Product Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Edita tu ingreso</h1>
            <small>Edita tu ingreso></small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i>Hogar</a></li>
                <li><a href="#">Ingreso</a></li>
                <li class="active">Editar ingreso</li>
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
        <!-- Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4>Editar ingreso</h4>
                                </div>
                                <div class="col-lg-6" align="right">

                                    <a href="<?php echo base_url() . 'Cma_ingreso/print_ingreso/' . $id; ?>" class="btn btn-info btn-md" data-toggle="tooltip" data-placement="left" title=" Imprimir " target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cma_ingreso/update', array('class' => 'form-vertical', 'id' => 'update', 'name' => 'update')) ?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="row">
                                    <input type="hidden" name="id" value="{id}" id="id">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="date" class="col-sm-4 col-form-label"> Fecha: <i class="text-danger">*</i></label>
                                            <div class="col-sm-8">
                                                <?php
                                                $date=date_create($fecha);
                                                $fecha = date_format($date,"d-m-Y");
                                                ?>
                                                <input class="form-control" type="text" size="50" name="fecha" id="fecha" value="<?php echo $fecha; ?>" required />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="provider" class="col-sm-4 col-form-div"> Proveedor: <i class="text-danger">*</i></label>
                                            <div class="col-sm-8">
                                                <select name="id_proveedor" class="form-control" style="width:100%" required>
                                                    <option></option>
                                                    <?php foreach ($proveedores as $proveedor) {
                                                        if ($proveedor['id'] == $id_proveedor){ ?>
                                                            <option value="<?php echo $proveedor['id'] ?>" selected>  <?php echo $proveedor['nombre'] . ' / ' . $proveedor['nit'] ; ?> </option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $proveedor['id'] ?>">  <?php echo $proveedor['nombre'] . ' / ' . $proveedor['nit'] ;?> </option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="provider" class="col-sm-4 col-form-div"> Orden de Compra: <i class="text-danger">*</i></label>
                                            <div class="col-sm-8">
                                                <select name="id_orden" class="form-control" style="width:100%" required>
                                                    <option></option>
                                                    <?php foreach ($ordenes_compra as $orden) {
                                                        if ($orden['id'] == $id_orden){ ?>
                                                            <option value="<?php echo $orden['id'] ?>" selected>  <?php echo $orden['codigo'] . ' / ' . $orden['fecha_formateada'] ; ?> </option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $orden['id'] ?>">  <?php echo $orden['codigo'] . ' / ' . $orden['fecha_formateada'] ;?> </option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="glosa" class="col-sm-4 col-form-label"> Glosa: </label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" name="glosa" id="glosa" rows="3" placeholder="Glosa" >{glosa}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" id="add" class="btn btn-primary btn-large" name="add" value="Guardar cambios" />
                            </div>
                        </div>

                        <hr>

                        <!-- <div class="form-group row">
                            <div class="col-sm-12" align="right">
                                <input type="button" id="loadNewModal" class="btn btn-success btn-large" value="Nuevo Registro" />
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover display nowrap  " style="width:100%" id="dataTable">

                                </table>
                            </div>
                        </div>

                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>

<!--begin::Modal-->
<div class="modal fade" id="form_modal"  role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal-content"></div>
    </div>
</div>
<!--end::Modal-->

<!-- Edit Product End -->



<script type="text/javascript">

    var base_url = "<?php echo base_url();?>";

    $('#loadNewModal').click(function(e){
        e.preventDefault();
        loadModal(0,"new");
    });

    function loadModal(id , type){
        var idP =  $('#id').val();
        $.get( base_url + '/Cma_ingreso/modal_edit/?id=' + id + '&type=' + type + '&idP=' + idP , function (data) {
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
            url : base_url+'/Cma_ingreso/deleteSecundario/',
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
            var idP = $('#id').val();

            table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax:{
                    url :  base_url+'/Cma_ingreso/dataTable/',
                    type : 'POST',
                    data: {id_cabecera:idP},
                },
                pagingType:"full_numbers",
                pageLength:"10",
                order: [[ 0, "desc" ]],
                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'grupo', title: 'Grupo' },
                    { data: 'articulo', title: 'Articulo' },
                    { data: 'cantidad', title: 'Cantidad' },
                    { data: 'costo_real', title: 'Costo Real', render: $.fn.dataTable.render.number('.', ',', 2, 'Bs. ')},
                    { data: 'costo_contable', title: 'Costo Contable', render: $.fn.dataTable.render.number('.', ',', 2, 'Bs. ')},
                    { data: 'total_real', title: 'Total Real', render: $.fn.dataTable.render.number('.', ',', 2, 'Bs. ') },
                    { data: 'total_contable', title: 'Total Contable', render: $.fn.dataTable.render.number('.', ',', 2, 'Bs. ') },
                    { data: 'button', title: 'Acciones' },
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
                        targets: [ 4,5,6,7,8],
                        searchable: false,
                        orderable: false,
                    },
                    {
                        targets: [ 1,2,4,5,6,7,8],
                        className:"all"
                    },
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
        $("#fecha").datepicker({ dateFormat:'dd-mm-yy' });
        $('.select2_general').select2({
            placeholder: "Seleccione una opción"
        });
        snippet_datatable.init();
    });

</script>


