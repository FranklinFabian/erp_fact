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
<!-- Manage Category Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Listado - Dias Feriados</h1>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#">Odeco</a></li>
                <li class="active">Listado - Dias Feriados</li>
            </ol>
        </div>
    </section>

    <section class="content">
        <!-- Manage Category -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <ul class="nav nav-tabs">
                             <li class="active"><a href="#"><i class="ti-align-justify"> </i> LISTA DE DIAS FERIADOS</a></li>   
                              <li><a href="<?php echo base_url(); ?>odeco/agregar_feriado"><i class="fa fa-plus"> </i> A&Ntilde;ADIR FERIADO</a></li>
                            </ul>
                           
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div>
                                <label for="anio" class="col-sm-4 col-form-label text-right">A&ntilde;o: </label>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="anio" id="anio" tabindex="5" aria-required="true">
                                            <option value="<?= $gestion; ?>" selected=""><?= $gestion; ?></option>
                                            <?php foreach ($gestiones as $list) { ?>
                                            <option value="<?php echo $list['gestion'] ?>"><?php echo $list['gestion'] ?> </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                            </div><br><br><br>
                            <table id="Tabla_feriados" class="table table-bordered table-striped table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Descripcion de Dia Feriado</th>
                                        <th class="text-center">Fecha</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- Manage Category End -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Delete Category ajax code -->
<script type="text/javascript">
$(document).ready(function(){
        var userDataTable = $('#Tabla_feriados').DataTable({
            responsive: true,
            dom: 'lBfrtip',
            buttons:[
                    {extend: "excel",exportOptions: {columns: [0,1,2]}, title: "Lista de Dias Feriados", className: "btn-success", text:'Exportar Excel'}
            ],
            ordering: true,
            "aaSorting": [[ 1, "asc" ]],
             "aoColumnDefs": [{
                /*{ "targets": [1,2], searchable: true },
                { "targets": [0], searchable: false },*/
                "bSortable": false,
                "aTargets": [0,3]}
            ],
            info:true,
            language: {
                "decimal": "",
                "emptyTable": "No hay elementos registrados",
                //"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "info": "_TOTAL_ Feriados Registrados",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:&nbsp;&nbsp; ",
                "zeroRecords": "No se encontraron resultados.",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },
            lengthMenu:[10, 25, 50,100],
            //section AJAX RENDER
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?php echo base_url(); ?>odeco/listar_feriados_ajax',
              'data': function(data){
                    data.searchAnio = $('#anio').val();
              }
            },
            'columns': [
                { data: 'number', class:'text-center'},
                { data: 'descripcion', class:'text-center'},
                { data: 'fecha', class:'text-center'},
                { data: 'button', class:'text-center'}
            ]
        });

        $('#anio').change(function(){ //select options
            userDataTable.draw();
        });
        /*$('#searchName').keyup(function(){//para inputs box
            userDataTable.draw();
        });*/
    });

    function EliminarRegistro(id_feriado)
    {
        Swal.fire(
        {
            title: 'Esta seguro de Eliminar el Registro?',
            text: "Esta accion no puede ser revertido!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar'
        }).then((result)=>{
            if(result.isConfirmed){
                $.ajax({
                    data: {id_feriado},
                    url: '<?php echo base_url(); ?>odeco/anular_feriado',
                    type: 'POST',
                    dataType: 'json'
                    })
                .done(function(response)
                    {
                        Swal.fire(
                            {
                                icon: 'success',
                                title: 'Se elimin&oacute; exitosamente el Registro'
                            }).then(function (){
                                window.location.href ="<?php echo base_url(); ?>odeco/listar_feriados";
                            });
                    })
                .fail(function(response)
                    {
                        Swal.fire({
                                icon: 'error',
                                title: 'Hubo Problemas al eliminar el Registro'
                                //type: 'warning
                            }).then(function (){
                                window.location.href ="<?php echo base_url(); ?>odeco/listar_feriados";
                            });
                    });
            }
        });
    }    
</script>