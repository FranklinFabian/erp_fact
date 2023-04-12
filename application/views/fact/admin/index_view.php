<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1>Atención al consumidor</h1>
      <small>Administración</small>
      <?php echo $this->breadcrumb->render() ?>
    </div>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Alert Message -->
    <?php $message = $this->session->userdata('message');
    if (isset($message)) { ?>
      <div class="alert alert-info alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $message ?>
      </div>
    <?php $this->session->unset_userdata('message');
    }
    $error_message = $this->session->userdata('error_message');
    if (isset($error_message)) { ?>
      <div class="alert alert-danger alert-dismissable">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <?php echo $error_message ?>
      </div>
    <?php $this->session->unset_userdata('error_message');
    }
    ?>

    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
          <div class="panel-heading">
            <div class="panel-title">
              <h4>Amdinistración</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
                <a href="<?php echo base_url();?>fact/admin/empresa" class="btn btn-primary">Institución/configuración</a>
                <a href="<?php echo base_url();?>fact/punto_venta/" class="btn btn-primary">Puntos De Venta</a>
              </div>
            </div>


            

          <div class="sub_content">
<div class="pure-g">
  

  <?php
    

    //verificamos que exista 1 producto para mostrar el inv. inicial
    if(!empty($prods)){

      // verificamos si existen datos en el inventario inicial con al menos 1 reg. en nro_adquisicion
        $nro_ad = $this->nro_adquisicion_model->get_all();
        if(empty($nro_ad))
          echo '<div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="'.base_url().'admin/inventario_inicial" class="pure-button button-success" style="width:100%;">Inventario Inicial</a></p></div>';
        else{
          $sali = $this->salida_model->get_all();
          if(empty($sali))// si el inventario esta vacio
            echo '<div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="'.base_url().'admin/inventario_inicial" class="pure-button button-warning" style="width:100%;">Inventario Inicial</a></p></div>';
          else// el inventario no esta vacio y tiene una salida BLOQUEAMOS
            echo '<div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="'.base_url().'reporte/inventario_inicial/" target="_blank" class="pure-button button-black" style="width:100%;">Inventario Inicial</a></p></div>';
        }

    }

  ?>

</div>





          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Main content end -->
</div>
<!-- Admin Home end -->

<script>
function valores_fabrica(){
if(confirm("Esta operación eliminara todos los datos del sistema. ¿Desea continuar?"))
  location.href="<?php echo base_url()?>admin/valores_fabrica/";
}
</script>
