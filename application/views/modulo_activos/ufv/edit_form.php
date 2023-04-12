<!--Edit unit edit  start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Editar Ufv</h1>
            <small>Editar Ufv</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i>Hogar</a></li>
                <li><a href="#">Ufv</a></li>
                <li class="active">Editar Ufv</li>
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

        <!-- New customer -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <h4>Editar Ufv</h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cmactivos_ufv/update', array('class' => 'form-vertical', 'id' => 'update')) ?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="date" class="col-sm-3 col-form-label"> Fecha: <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <?php
                                $date=date_create($fecha);
                                $fecha = date_format($date,"d-m-Y");
                                ?>
                                <input class="form-control" type="text" size="50" name="fecha" id="fecha" value="<?php echo $fecha; ?>" required />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="valor" class="col-sm-3 col-form-label">Valor<i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="valor" id="valor" type="text" placeholder="Valor"  required="" value="{valor}">
                            </div>
                        </div>


                        <input type="hidden" value="{id}" name="id">

                        <div class="form-group row">
                            <div class="col-sm-9" align="right">
                                <input type="submit" id="edit" class="btn btn-success btn-large" name="edit" value="Guardar cambios" />
                            </div>
                        </div>

                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>

    </section>
</div>
<!-- Edit unit edit end -->

<script type="text/javascript">
    $(function(){
        $("#fecha").datepicker({ dateFormat:'dd-mm-yy' });
    });
</script>


