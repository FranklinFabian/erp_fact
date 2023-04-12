<!-- Edit Product Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Orden de Compra de edición</h1>
            <small>Edita tu orden de compra</small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i> Hogar </a></li>
                <li><a href="#">Orden de compra</a></li>
                <li class="active">Orden de compra de edición</li>
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
                                    <h4> Orden de compra de edición </h4>
                                </div>
                                <div class="col-lg-6" align="right">

                                    <a href="<?php echo base_url() . 'Cma_orden_compra/print/' . $id; ?>" class="btn btn-info btn-md" data-toggle="tooltip" data-placement="left" title=" Imprimir " target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cma_orden_compra/update', array('class' => 'form-vertical', 'id' => 'update', 'name' => 'update')) ?>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
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
                                                            <option value="<?php echo $proveedor['id'] ?>" selected>  <?php echo $proveedor['nombre']; ?> </option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $proveedor['id'] ?>">  <?php echo $proveedor['nombre'] ?> </option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group row">
                                            <label for="observacion" class="col-sm-4 col-form-label"> Observación: </label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control" name="observacion" id="observacion" rows="3" placeholder="Observación" >{observacion}</textarea>
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

                        <div class="form-group row">
                            <div class="col-sm-12" align="right">
                                <input type="button" id="loadNewModal" class="btn btn-success btn-large" value="Nuevo Registro" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover display nowrap  " style="width:100%" id="dataTable">
                                    <tfoot>
                                    <tr>
                                        <th colspan="6" style="text-align:right">Total:</th>
                                        <th></th>
                                    </tr>
                                    </tfoot>

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
        $.get( base_url + '/Cma_orden_compra/modal_edit/?id=' + id + '&type=' + type + '&idP=' + idP , function (data) {
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
            url : base_url+'/Cma_orden_compra/deleteHijo/',
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
                    url :  base_url+'/Cma_orden_compra/dataTable/',
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
                    { data: 'costo', title: 'Costo', render: $.fn.dataTable.render.number('.', ',', 2, 'Bs. ')},
                    { data: 'total', title: 'Total'},
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
                    },

                ],

                "footerCallback": function ( row, data, start, end, display ) {
                    var api = this.api(), data;

                    // Remove the formatting to get integer data for summation
                    var intVal = function ( i ) {
                        return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '')*1 :
                            typeof i === 'number' ?
                                i : 0;
                    };

                    // Total over this page
                    pageTotal = api
                        .column( 5, { page: 'current'} )
                        .data()
                        .reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );

                    // Update footer
                    $( api.column( 4 ).footer() ).html(
                        'Bs. '+pageTotal.toFixed(2).toString().replace(".", ",")
                    );
                }

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


