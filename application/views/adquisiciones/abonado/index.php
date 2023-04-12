<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Adquisiciones</h1>
            <small>Abonado</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i>Hogar</a></li>
                <li class="active">Abonado</li>
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
                                    <h4>Administración de Abonados</h4>
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
                                <table class="table table-bordered table-hover display nowrap  " style="width:100%" id="dataTables">

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

<!-- Edit Product End -->



<script type="text/javascript">

    var base_url = "<?php echo base_url();?>";

    $('#loadNewModal').click(function(e){
        e.preventDefault();
        loadModal(0,"new");
    });

    function loadModal(id , type){
        $.get( base_url + '/adquisiciones/Cabonado/modal_edit/?id=' + id + '&type=' + type , function (data) {
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
            url : base_url+'/adquisiciones/Cabonado/delete/',
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

            table = $('#dataTables').DataTable({
                language: {
                    url: 'assets/languaje/es_es.json'
                },
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax:{
                    url :  base_url+'/adquisiciones/Cabonado/dataList/',
                    type : 'POST',
                },
                pagingType:"full_numbers",
                pageLength:"10",
                order: [[ 0, "desc" ]],
                columns: [
                    { data: 'id', title: 'Código' },
                    { data: 'cid', title: 'CID' },
                    { data: 'razon_social', title: 'Cliente' },
                    { data: 'fecha_registro', title: 'Registro' },
                    { data: 'categoria', title: 'Categoria' },
                    { data: 'localidad', title: 'Localidad' },
                    { data: 'zona', title: 'Zona' },
                    { data: 'direccion', title: 'Dirección' },
                    { data: 'numero', title: 'Número' },
                    { data: 'transformador', title: 'Transformador' },
                    { data: 'poste', title: 'Poste' },
                    { data: 'distancia_poste', title: 'Distancia Poste' },
                    { data: 'medidor', title: 'Medidor' },
                    { data: 'lectura', title: 'Lectura' },
                    { data: 'multiplicador', title: 'Multiplicador' },
                    { data: 'suministro', title: 'Suministro' },
                    { data: 'consumidor', title: 'Consumidor' },
                    { data: 'medicion', title: 'Medición' },
                    { data: 'liberacion', title: 'Liberación' },
                    { data: 'existe_inquilino', title: 'Inquilino' },
                    { data: 'ci_inquilino', title: 'Inquilino Ci' },
                    { data: 'nombre_inquilino', title: 'Inquilino Nombre' },
                    { data: 'cel_inquilino', title: 'Inquilino Cel' },
                    { data: 'existe_ley_adulto', title: 'Ley Adulto Mayor' },
                    { data: 'fecha_ley_adulto', title: 'Fecha Solicitud' },
                    { data: 'button', title: 'Acciones' },


                ],
                columnDefs:[
                    /*{
                        targets: [ 0 ],
                        searchable: false,
                        width: "10px",
                        orderable: false,
                        visible: false
                    }*/

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
        $('.select2_general').select2({
            placeholder: "Seleccione una opción"
        });
        snippet_datatable.init();
    });

</script>


