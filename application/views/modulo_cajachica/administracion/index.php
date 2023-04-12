<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Administración</h1>
            <small>Administración</small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i>Hogar</a></li>
                <li class="active">Administración</li>
            </ol>
        </div>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4>Administración de Caja Chica</h4>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-4 col-form-label"> Fecha Inicio: </label>
                                        <div class="col-sm-6">
                                            <input class="form-control" type="text" size="50" id="fecha_inicio"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-4 col-form-label"> Fecha Fin: </label>
                                        <div class="col-sm-6">
                                            <input class="form-control" type="text" size="50" id="fecha_fin"  />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-4 col-form-label"> Cuenta: </label>
                                        <div class="col-sm-6">
                                            <select id="id_catalogo_cuenta" class="form-control select2_general" style="width: 100%">
                                                <option></option>
                                                <?php foreach ($cuentas as $cuenta) { ?>
                                                    <option value="<?php echo $cuenta['id'] ?>">  <?php echo $cuenta['nombre'] ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-4 col-form-label"> Solicitante: </label>
                                        <div class="col-sm-6">
                                            <select id="id_catalogo_solicitante" class="form-control select2_general" style="width: 100%">
                                                <option></option>
                                                <?php foreach ($solicitantes as $solicitante) { ?>
                                                    <option value="<?php echo $solicitante['id'] ?>">  <?php echo $solicitante['nombre'] ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <input type="button" id="filtrarEgresos" class="btn btn-success btn-large" value="Filtrar" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">

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

<!--begin::Modal-->
<div class="modal fade" id="form_modal"  role="dialog" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal-content"></div>
    </div>
</div>
<!--end::Modal-->




<script type="text/javascript">

    var base_url = "<?php echo base_url();?>";

    $('#loadNewModal').click(function(e){
        e.preventDefault();
        loadModal(0,"new");
    });

    function loadModal(id , type){
        $.get( base_url + '/Cmcajachica_administracion/modal_edit/?id=' + id + '&type=' + type , function (data) {
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
            url : base_url+'/Cmcajachica_administracion/delete/',
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
                language: {
                    url: 'assets/languaje/es_es.json'
                },
                "scrollX": true,
                "bFilter": false,
                dom: 'Bfrtip',
                buttons: [
                    {name: 'copyHtml5', extend: 'copy',  title: 'Reporte'},
                    {name: 'excelHtml5',
                        extend: 'excelHtml5',
                        title: 'Reporte',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4, 5 ]
                        },
                    },
                    {name: 'pdfHtml5',
                        extend: 'pdfHtml5',
                        title: 'Reporte',
                        orientation: 'portrait',
                        pageSize: 'legal',
                        customize: function(doc)
                        {
                            doc.styles.tableHeader.fontSize = 12;
                            doc.defaultStyle.fontSize = 11; //<-- set fontsize to 16 instead of 10
                            doc.defaultStyle.alignment = 'center';
                            doc.content[1].margin = [ 40, 0, 40, 0 ]; //left, top, right, bottom
                        },
                        exportOptions: {
                            columns: [ 1, 2, 3, 4, 5]
                        },
                    }
                ],
                processing: true,
                serverSide: true,
                ajax:{
                    url :  base_url+'/Cmcajachica_administracion/dataList/',
                    type : 'POST',
                    data: function(data){
                        // Read values
                        var fecha_inicio = $('#fecha_inicio').val();
                        var fecha_fin = $('#fecha_fin').val();
                        var cuenta = $('#id_catalogo_cuenta').val();
                        var solicitante = $('#id_catalogo_solicitante').val();

                        // Append to data
                        data.fecha_inicio = fecha_inicio;
                        data.fecha_fin = fecha_fin;
                        data.cuenta = cuenta;
                        data.solicitante = solicitante;
                    },
                },
                pagingType:"full_numbers",
                pageLength:"10",
                order: [[ 0, "desc" ]],
                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'fecha', title: 'Fecha' },
                    { data: 'cuenta', title: 'Cuenta' },
                    { data: 'solicitante', title: 'Solicitante' },
                    { data: 'monto', title: 'Monto', render: $.fn.dataTable.render.number('.', ',', 2, 'Bs. ')},
                    { data: 'descripcion', title: 'Descripcion' },
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
        $("#fecha_inicio").datepicker({ dateFormat:'dd-mm-yy' });
        $("#fecha_fin").datepicker({ dateFormat:'dd-mm-yy' });

        $('.select2_general').select2({
            placeholder: "Seleccione una opción"
        });
        snippet_datatable.init();
    });

    $("#filtrarEgresos").on("click", function() {
        table.draw();
    });

</script>


