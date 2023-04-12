<style type="text/css">
    .prints{
        background-color: #31B404;
        color:#fff;
    }
</style>
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Administrar suscripción</h1>
            <small>Administrar suscripción</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> Hogar </a></li>
                <li><a href="#">Suscripción</a></li>
                <li class="active"> Administrar suscripción</li>
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

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Administrar suscripción</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover nowrap" style="width:100%" id="dataTable">

                            </table>
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
            table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax:{
                    url :  base_url+'/Cga_suscripcion/dataList/',
                    type : 'POST'
                },
                pagingType:"full_numbers",
                pageLength:"10",
                order: [[ 0, "desc" ]],
                columns: [
                    { data: 'id', title: 'Id' },
                    { data: 'codigo', title: 'Codigo' },
                    { data: 'ci', title: 'CI' },
                    //{ data: 'departamento', title: 'Expedido' },
                    { data: 'razon_social', title: 'Razon social' },
                    //{ data: 'fecha_nacimiento', title: 'Fecha nacimiento' },
                    //{ data: 'genero', title: 'Genero' },
                    { data: 'nit', title: 'Nit' },
                    { data: 'direccion', title: 'Dirección' },
                    { data: 'telefono', title: 'Telefono' },
                    //{ data: 'profesion', title: 'Profesión' },
                    //{ data: 'ocupacion', title: 'Ocupación' },
                    //{ data: 'nivel_educacion', title: 'Nivel de educación' },
                    //{ data: 'numero_dependientes', title: 'Numero de dependientes' },
                    //{ data: 'estado_civil', title: 'Estado civil' },
                    //{ data: 'estado_cliente', title: 'Estado cliente' },
                    //{ data: 'fecha_registro', title: 'Fecha de registro' },
                    //{ data: 'tipo_socio', title: 'Tipo de socio' },
                    //{ data: 'codigo_socio', title: 'Codigo de socio' },
                    //{ data: 'fecha_socio', title: 'Fecha de socio' },
                    { data: 'button', title: 'Acciones'},
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
        snippet_datatable.init();
    });

</script>
