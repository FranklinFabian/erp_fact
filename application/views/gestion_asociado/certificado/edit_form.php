<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Añadir certificado</h1>
            <small>Añadir certificado</small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i>Hogar</a></li>
                <li><a href="#">Certificado</a></li>
                <li class="active">Añadir certificado</li>
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
                                    <h4>Añadir certificado</h4>
                                </div>
                                <div class="col-lg-6" align="right">
                                    <a href="<?php echo base_url() . 'Cga_certificado/print/' . $id; ?>" class="btn btn-info btn-md" data-toggle="tooltip" data-placement="left" title=" Imprimir " target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
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
                        <br>
                        <hr>
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
    var idP =  "<?php echo $id;?>";

    $('#loadNewModal').click(function(e){
        e.preventDefault();
        loadModal(0,"new");
    });

    function loadModal(id , type){
        $.get( base_url + '/Cga_certificado/modal_edit/?id=' + id + '&type=' + type + '&idP=' + idP , function (data) {
            $("#modal-content").html(data);
            $("#form_modal").modal("show");
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
                    url :  base_url+'/Cga_certificado/dataTable/',
                    type : 'POST',
                    data: {idP:idP},
                },
                pagingType:"full_numbers",
                pageLength:"10",
                order: [[ 0, "desc" ]],
                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'codigo_suscripcion', title: 'Codigo de suscripcion' },
                    { data: 'codigo', title: 'Codigo de certificado' },
                    { data: 'fecha', title: 'Fecha de Certificado' },
                    { data: 'estado', title: 'Estado' },
                    { data: 'fecha_entrega', title: 'Fecha de entrega' },
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


