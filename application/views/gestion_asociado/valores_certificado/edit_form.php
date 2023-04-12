<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.13.4/jquery.mask.min.js"></script>

<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Editar valor certificado</h1>
            <small>Editar valor certificado</small>
            <ol class="breadcrumb">
                <li><a href="#"><i class="pe-7s-home"></i> Hogar </a></li>
                <li><a href="#">Valor certificado</a></li>
                <li class="active">Valor certificado</li>
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
                            <h4>Editar valor certificado</h4>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cga_valor_certificado/update', array('class' => 'form-vertical', 'id' => 'update')) ?>
                    <div class="panel-body">

                        <div class="form-group row">
                            <label for="nombre" class="col-sm-3 col-form-label"> Monto <i class="text-danger">*</i></label>
                            <div class="col-sm-6">
                                <input class="form-control" name ="monto" id="monto" type="text" placeholder="Monto"  required="" value="{monto}" >
                            </div>
                        </div>

                        <input type="hidden" value="{id}" name="id">

                        <div class="form-group row">
                            <label for="example-text-input" class="col-sm-4 col-form-label"></label>
                            <div class="col-sm-6">
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

<script>

    $('#monto').mask("#.##0,00", {reverse: true});

</script>



