<!-- Edit Product Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Lecturación</h1>
            <small>Lecturación</small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i> Hogar </a></li>
                <li><a href="#">Lecturación</a></li>
                <li class="active">Lecturación</li>
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
                                    <h4> Lecturación </h4>
                                </div>
                                <div class="col-lg-6" align="right">

                                    <a href="<?php echo base_url() . 'Cma_orden_compra/print/' . $id; ?>" class="btn btn-info btn-md" data-toggle="tooltip" data-placement="left" title=" Imprimir " target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cma_orden_compra/update', array('class' => 'form-vertical', 'id' => 'update', 'name' => 'update')) ?>
                    <input type="hidden" value="{id}" id="id">
                    <div class="panel-body">
                        <div class="row" style="font-weight: bold">
                            <div class="col-lg-1">
                            </div>
                            <div class="col-lg-2">
                                Código Abonado
                            </div>
                            <div class="col-lg-2">
                                Código Cliente
                            </div>
                            <div class="col-lg-2">
                                Nombre
                            </div>
                            <div class="col-lg-2">
                                Medidor
                            </div>
                            <div class="col-lg-2">
                                Lectura
                            </div>
                            <div class="col-lg-1">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-1">
                            </div>
                            <div class="col-lg-2">
                                {id}
                            </div>
                            <div class="col-lg-2">
                                {cid}
                            </div>
                            <div class="col-lg-2">
                                {razon_social}
                            </div>
                            <div class="col-lg-2">
                                {medidor}
                            </div>
                            <div class="col-lg-2">
                                {lectura}
                            </div>
                            <div class="col-lg-1">
                            </div>
                        </div>
                        <br>
                        <div class="row" style="font-weight: bold">
                            <div class="col-lg-1">
                            </div>

                            <div class="col-lg-2">
                                Multiplicador
                            </div>
                            <div class="col-lg-2">
                                Categoria
                            </div>
                            <div class="col-lg-2">
                                NIT
                            </div>
                            <div class="col-lg-2">
                                Dirección
                            </div>

                            <div class="col-lg-3">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-1">
                            </div>

                            <div class="col-lg-2">
                                {multiplicador}
                            </div>
                            <div class="col-lg-2">
                                {categoria}
                            </div>
                            <div class="col-lg-2">
                                {nit}
                            </div>
                            <div class="col-lg-2">
                                {direccion}
                            </div>

                            <div class="col-lg-3">
                            </div>
                        </div>




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
        //$.get( base_url + '/Cma_orden_compra/modal_edit/?id=' + id + '&type=' + type + '&idP=' + idP , function (data) {
        $.get( base_url + '/adquisiciones/Clecturacion/modal_edit/?id=' + id + '&type=' + type + '&idP=' + idP , function (data) {
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
            url :  base_url+'/adquisiciones/Clecturacion/deleteHijo/',
            //url : base_url+'/Cma_orden_compra/deleteHijo/',
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
                    //url :  base_url+'/Cma_orden_compra/dataTable/',
                    url :  base_url+'/adquisiciones/Clecturacion/dataTable/',
                    type : 'POST',
                    data: {id_cabecera:idP},
                },
                pagingType:"full_numbers",
                pageLength:"10",
                order: [[ 0, "desc" ]],
                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'fecha', title: 'Fecha' },
                    { data: 'lectura_anterior', title: 'Lectura Anterior' },
                    { data: 'potencia', title: 'Potencia', render: $.fn.dataTable.render.number('.', ',', 2, 'Bs. ')},
                    { data: 'lectura_actual', title: 'Lectura Actual' },
                    { data: 'multiplicador', title: 'Multiplicador'},
                    { data: 'consumo', title: 'Consumo'},
                    { data: 'estimado', title: 'Estimado'},
                    { data: 'sin_factura', title: 'Sin Factura'},
                    { data: 'observada', title: 'Observada'},
                    { data: 'observacion', title: 'Observación'},
                    { data: 'nota', title: 'Nota'},
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
                    /*{
                        targets: [ 4,5,6],
                        searchable: false,
                        orderable: false,
                    },
                    {
                        targets: [ 1,2,4,5,6],
                        className:"all"
                    },
                    {
                        targets: [ 5],
                        render: $.fn.dataTable.render.number('.', ',', 2, 'Bs. ')
                    },*/

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


