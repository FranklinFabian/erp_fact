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
            <h1>Gesti&oacute;n de Elementos de Maniobra</h1>
            <small>Listar Elementos de Maniobra</small>
            <ol class="breadcrumb">
                <li><a href=""><i class="pe-7s-home"></i> <?php echo display('home') ?></a></li>
                <li><a href="#"><?php echo display('odeco') ?></a></li>
                <li class="active">Listar Elem.Maniobra</li>
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
                             <li class="active"><a href="#"><i class="ti-align-justify"> </i> VER LISTA DE ELEMENTOS DE MANIOBRA</a></li>   
                              <li><a href="<?php echo base_url(); ?>odeco/agregar_maniobra"><i class="fa fa-plus"> </i> A&Ntilde;ADIR ELEMENTO DE MANIOBRA</a></li>
                            </ul>
                           
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div>
                                <label for="semestre" class="col-sm-4 col-form-label text-right">Semestre: </label>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="semestre" id="semestre" tabindex="5" aria-required="true">
                                            <option value="<?= $semestre[0]['Sigla']; ?>" selected=""><?= $semestre[0]['Sigla']; ?></option>
                                            <?php foreach ($listar_semestres as $list) { ?>
                                            <option value="<?php echo $list['Sigla'] ?>"><?php echo $list['Sigla'] ?> : <?= date('M/Y',strtotime($list['Mes_Inicio'])); ?> - <?= date('M/Y',strtotime($list['Mes_Final'])); ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                            </div><br><br>
                            <table id="Tabla_maniobras" class="table table-bordered table-striped table-hover" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Cod. Protecci&oacute;n</th>
                                        <th class="text-center">Cod. Alimentador</th>
                                        <th class="text-center">Tipo Protecci&oacute;n</th>
                                        <th class="text-center">Estado</th>
                                        <th class="text-center">Kva Protec.</th>
                                        <th class="text-center">Kv Protec.</th>
                                        <th class="text-center">Zona</th>
                                        <th class="text-center">Protec. Sup.</th>
                                        <th class="text-center">Consum.MT-1</th>
                                        <th class="text-center">Consum.MT-2</th>
                                        <th class="text-center">Consum.BT-1</th>
                                        <th class="text-center">Consum.BT-2</th>
                                        <th class="text-center">Direcci&oacute;n</th>
                                        <th class="text-center">Fecha Registro</th>
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Delete Category ajax code -->
<script type="text/javascript">
    $(document).ready(function(){
        var userDataTable = $('#Tabla_maniobras').DataTable({
            responsive: true,
            dom: 'lBfrtip',
            buttons:[
                    {extend: "excel",exportOptions: {columns: [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14]}, title: "Lista de Elementos de Maniobra", className: "btn-success", text:'Exportar Excel'}
            ],
            ordering: true,
            "aaSorting": [[ 11, "desc" ]],
             "columnDefs": [{
                /*{ "targets": [1,2], searchable: true },
                { "targets": [0], searchable: false },*/
                "bSortable": false,
                "aTargets": [0,15]}
            ],
            info:true,
            language: {
                "decimal": "",
                "emptyTable": "No hay elementos registrados",
                //"info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "info": "_TOTAL_ Elementos de Maniobra Registrados",
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
            lengthMenu:[10, 25, 50,100, 500, "All"],
            //section AJAX RENDER
            searchDelay: 500,
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            //'searching': false, // Remove default Search Control
            'ajax': {
              'url':'<?php echo base_url(); ?>odeco/listar_maniobras_ajax',
              'data': function(data){
                    data.searchSemestre = $('#semestre').val();
              }
            },
            'columns': [
                { data: 'number', class:'text-center'},
                { data:  'cod_proteccion', class:'text-center'},
                { data: 'cod_alimentador', class:'text-center'},
                { data:  'tipo_proteccion', class:'text-center'},
                { data:  'estado', class:'text-center'},
                { data:  'kva_proteccion', class:'text-center'},
                { data:  'kv_proteccion', class:'text-center'},
                { data:  'cod_zona', class:'text-center'},
                { data:  'proteccion_sup', class:'text-center'},
                { data:  'consum_mt_1', class:'text-center'},
                { data:  'consum_mt_2', class:'text-center'},
                { data:  'consum_bt_1', class:'text-center'},
                { data:  'consum_bt_2', class:'text-center'},
                { data:  'direccion', class:'text-center'},
                { data: 'fecha_registro', class:'text-center'},
                { data: 'button', class:'text-center'}
            ]
        });

        $('#semestre').change(function(){ //select options
            userDataTable.draw();
        });
        /*$('#searchName').keyup(function(){//para inputs box
            userDataTable.draw();
        });*/
    });
    function EliminarManiobra(cod_proteccion)
    {
        Swal.fire(
        {
            title: 'Esta seguro de Eliminar el Elemento de Maniobra?',
            text: "Esta accion no puede ser revertido!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si, Eliminar'
        }).then((result)=>{
            if(result.isConfirmed){
                $.post("<?php echo base_url(); ?>odeco/anular_maniobra", {
                    cod_proteccion
                }, function (data, status) {
                    if (data) 
                    {
                        Swal.fire(
                            {
                                icon: 'success',
                                title: 'Se elimin&oacute; exitosamente el Elemento de Maniobra'
                            }).then(function (){
                                window.location.href ="<?php echo base_url(); ?>odeco/listar_maniobras";
                            });
                    }else{
                        Swal.fire({
                                icon: 'error',
                                title: 'Hubo Problemas al eliminar el Registro'
                                //type: 'warning
                            }).then(function (){
                                window.location.href ="<?php echo base_url(); ?>odeco/listar_maniobras";
                            });
                    }
                    
                });
            }
        });
    }    
</script>