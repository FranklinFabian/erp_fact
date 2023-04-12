<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Depreciación</h1>
            <small>Depreciación</small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i>Hogar</a></li>
                <li class="active">Depreciación</li>
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
                                    <h4>Historial de Depreciación</h4>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-4 col-form-label"> Activo: </label>
                                        <div class="col-sm-6">
                                            <select id="id_activo" class="form-control select2_general" style="width: 100%">
                                                <option></option>
                                                <?php foreach ($activos as $activo) { ?>
                                                    <option value="<?php echo $activo['id'] ?>">  <?php echo $activo['codigo_activo'] ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-4 col-form-label"> Fecha Inicio: </label>
                                        <div class="col-sm-6">
                                            <input class="form-control" type="text" size="50" id="fecha_inicio"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-4 col-form-label"> Fecha Fin: </label>
                                        <div class="col-sm-6">
                                            <input class="form-control" type="text" size="50" id="fecha_fin"  />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <input type="button" id="filtrarDepreciacion" class="btn btn-success btn-large" value="Filtrar" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">

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







<script type="text/javascript">

    var base_url = "<?php echo base_url();?>";

    var table;
    var snippet_datatable = function () {

        var initTable1 = function() {

            table = $('#dataTables').DataTable({
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
                            columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 ]
                        },
                    },
                    {name: 'pdfHtml5',
                        extend: 'pdfHtml5',
                        title: 'Reporte',
                        orientation: 'landscape',
                        pageSize: 'legal',
                        customize: function(doc)
                        {
                            doc.styles.tableHeader.fontSize = 8;
                            doc.defaultStyle.fontSize = 7; //<-- set fontsize to 16 instead of 10
                            doc.defaultStyle.alignment = 'center';
                            doc.content[1].margin = [ 10, 0, 10, 0 ]; //left, top, right, bottom
                        },
                        exportOptions: {
                            columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13 ]
                        },
                    }
                ],

                processing: true,
                serverSide: true,
                //responsive: true,
                ajax:{
                    url :  base_url+'/Cmactivos_depreciacion/dataList/',
                    type : 'POST',
                    data: function(data){
                        // Read values
                        var fecha_inicio = $('#fecha_inicio').val();
                        var fecha_fin = $('#fecha_fin').val();
                        var activo = $('#id_activo').val();

                        // Append to data
                        data.fecha_inicio = fecha_inicio;
                        data.fecha_fin = fecha_fin;
                        data.activo = activo;
                    },
                },
                pagingType:"full_numbers",
                pageLength:"10",
                order: [ [2,'asc'] ],
                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'id_activo', title: 'Activo' },
                    { data: 'fecha', title: 'Fecha' },
                    { data: 'valor_inicial', title: 'Valor Inicial' },
                    { data: 'id_ufv', title: 'UFV' },
                    { data: 'factor', title: 'Factor' },
                    { data: 'incremento_actualizacion', title: 'Incremento Actualizacion' },
                    { data: 'valor_actualizado', title: 'Valor Actualizado'},
                    { data: 'depreciacion_acumulada', title: 'Depreciación Acumulada'},
                    { data: 'aitb_depreciacion_acumulada', title: 'AITB Depreciación Acumulada'},
                    { data: 'depreciacion_ejercicio', title: 'Depreciación Ejercicio'},
                    { data: 'depreciacion_acumulada_actualizada', title: 'Depreciación Acumulada Actualizada'},
                    { data: 'valor_neto', title: 'Valor Neto'},
                    { data: 'meses_vida_util', title: 'Meses de Vida Útil'}
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

    $("#filtrarDepreciacion").on("click", function() {
        table.draw();
    });

</script>


