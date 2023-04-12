<!-- Add new  start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1> Adquisiciones </h1>
            <small>Reportes</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i>Hogar</a></li>
                <li><a href="#"> Adquisiciones </a></li>
                <li class="active"> Reporte </li>
            </ol>
        </div>
    </section>

    <section class="content">




<!-- New customer -->
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4> Reportes </h4>
                </div>
            </div>

            <div class="panel-body">

                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#pdf"> PDF </a></li>
                </ul>

                <div class="tab-content">

                    <div id="pdf" class="tab-pane fade in active">
                        <div class="row" style="padding: 50px;" align="center">
                            <form action="<?php echo site_url('adquisiciones/Creporte/lista_clientes');?>" method="POST">

                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <h3>Lista de Clientes</h3>

                                    </div>

                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group row pull-right">
                                        <input type="submit" id="add-product" class="btn btn-default btn-large" name="add" value="Generar Reporte" />
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>


                    <hr>

                    <div id="pdf" class="tab-pane fade in active">
                        <div class="row" style="padding: 50px;" align="center">
                            <form action="<?php echo site_url('adquisiciones/Creporte/lista_abonados');?>" method="POST">

                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <h3>Lista de Abonados</h3>

                                    </div>

                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-4 col-form-label">Fecha Inicio: <i class="text-danger">*</i></label>
                                        <div class="col-sm-8">

                                            <input class="form-control fecha" type="text" size="50" name="fec_inicio" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-4 col-form-label">Fecha Fin: <i class="text-danger">*</i></label>
                                        <div class="col-sm-8">

                                            <input class="form-control fecha " type="text" size="50" name="fec_fin" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group row pull-right">
                                        <input type="submit" id="add-product" class="btn btn-default btn-large" name="add" value="Generar Reporte" />
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>


                    <hr>

                    <div id="pdf" class="tab-pane fade in active">
                        <div class="row" style="padding: 50px;" align="center">
                            <form action="<?php echo site_url('adquisiciones/Creporte/lista_ordenes');?>" method="POST">

                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <h3>Lista de Ordenes de Servicio</h3>

                                    </div>

                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-4 col-form-label">Fecha Inicio: <i class="text-danger">*</i></label>
                                        <div class="col-sm-8">

                                            <input class="form-control fecha" type="text" size="50" name="fec_inicio" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-4 col-form-label">Fecha Fin: <i class="text-danger">*</i></label>
                                        <div class="col-sm-8">

                                            <input class="form-control fecha" type="text" size="50" name="fec_fin" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group row pull-right">
                                        <input type="submit" id="add-product" class="btn btn-default btn-large" name="add" value="Generar Reporte" />
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>

                    <hr>

                    <div id="pdf" class="tab-pane fade in active">
                        <div class="row" style="padding: 50px;" align="center">
                            <form action="<?php echo site_url('adquisiciones/Creporte/lista_cortes');?>" method="POST">

                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <h3>Lista de Cortes y Reposiciones</h3>

                                    </div>

                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-4 col-form-label">Fecha Inicio: <i class="text-danger">*</i></label>
                                        <div class="col-sm-8">

                                            <input class="form-control fecha" type="text" size="50" name="fec_inicio" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="date" class="col-sm-4 col-form-label">Fecha Fin: <i class="text-danger">*</i></label>
                                        <div class="col-sm-8">

                                            <input class="form-control fecha" type="text" size="50" name="fec_fin" required />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group row pull-right">
                                        <input type="submit" id="add-product" class="btn btn-default btn-large" name="add" value="Generar Reporte" />
                                    </div>

                                </div>

                            </form>

                        </div>
                    </div>


                </div>

            </div>

        </div>
    </div>

</div>
</section>
</div>

<script type="text/javascript">

    $(function(){
        $(".fecha").datepicker({ dateFormat:'dd-mm-yy' });

    });


</script>
<!-- Add new  end -->




