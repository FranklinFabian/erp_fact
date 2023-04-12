<!-- Admin Home Start -->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="header-icon">
      <i class="pe-7s-world"></i>
    </div>
    <div class="header-title">
      <h1>Facturacion</h1>
      <small>Atención al consumidor</small>
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
              <h4>informacion Clientes</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
              <div class="col-md-12">
              <a href="<?php echo base_url();?>fact/cliente/nuevo_cliente" class="btn btn-primary">Nuevo Cliente</a>
              <a href="<?php echo base_url();?>fact/cliente/" class="btn btn-primary">Ultimos Registros</a>
              <a href="<?php echo base_url();?>fact/categorias/" class="btn btn-primary">Atras</a>
 
              </div>
              
            </div>
<p></p>
<div class="content">

    <hr>

    <table id="tabla_clientes" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
      <thead>
        <caption>ULTIMOS CLIENTES REGISTRADOS </caption>
        <tr>
          <th>N°</th>
          <th>Razón Social</th>
          <th>Doc.Factura</th>
          <th>NIT</th>
          <th>CI</th>
          <th>Email</th>
          <th>Dirección</th>
          <th>Fecha Nac.</th>
          <th>Télf./Cel.</th>
          <th></th>
          <th>Ver</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i=1;
        
        foreach ($datos_cliente as $key => $value){
          echo '
            <tr>
              <td>'.($i++).'</td>
              <td>'.($value['razon_social']).'</td>';
              switch ($value['tipo_doc_fact']) {
                case '1':echo '<td>CI</td>';break;
                case '2':echo '<td>CEX</td>';break;
                case '3':echo '<td>PASAPORTE</td>';break;
                case '4':echo '<td>OTRO</td>';break;
                case '5':echo '<td>NIT</td>';break;
                default:echo '<td>CI</td>';break;

              }
              echo '<td>'.($value['nit']).'</td>
              <td>'.($value['ci']).'</td>
              <td>'.($value['correo']).'</td>
              <td>'.($value['direccion']).'</td>
              <td>'.(($value['nacimiento'])).'</td>
              <td>'.($value['telefono']).'</td>
              <td> <a href="'.base_url().'fact/cliente/editar/'.$value['idcliente'].'" class="button-small pure-button button-warning">Editar</a></td>
              <td> <a href="'.base_url().'fact/abonado/listar_abonos_cliente/'.$value['idcliente'].'" class="button-small pure-button pure-button-primary">Abonos</a></td>
            </tr>
          ';
        }
        
        ?>
      </tbody>
    </table>

</div>
<script>
</script>
