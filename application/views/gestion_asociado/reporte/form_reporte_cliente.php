<!-- Add new  start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1> Reportes </h1>
            <small> Cliente </small>
            <ol class="breadcrumb">
                <li><a href="#">Hogar</a></li>
                <li><a href="#"> Reportes </a></li>
                <li class="active"> Cliente </li>
            </ol>
        </div>
    </section>

    <section class="content">
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
                            <h4> Cliente </h4>
                        </div>
                    </div>
                   
                    <div class="panel-body">

                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#pdf"> PDF </a></li>
                            <!-- <li><a data-toggle="tab" href="#excel"> EXCEL </a></li> -->
                        </ul>

                        <div class="tab-content">

                            <div id="pdf" class="tab-pane fade in active">
                                <div class="row" style="padding: 50px;" align="center">
                                    <form action="reporte_cliente_pdf" method="POST">

                                          <div class="col-sm-12">
                                            <div class="form-group row">
                                                <input type="submit" id="add-product" class="btn btn-default btn-large" name="add" value="Generar Reporte" />
                                            </div>
                                        </div>

                                    </form>

                                </div>
                            </div>

                            <div id="excel" class="tab-pane fade">
                                <div class="row" style="padding: 50px;" align="center">
                                    <a href="<?php echo base_url('Cma_reporte/inventario_fisico_excel') ?>" class="btn btn-default m-b-5 m-r-2" target="_blank"><i class="fa fa-file-excel-o">  </i> Generar Reporte </a>
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




