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
              <h4>Puntos de Venta</h4>
            </div>
          </div>
          <div class="panel-body">
            <div class="row">
            <div class="col-md-12">
                <a href="<?php echo base_url();?>fact/punto_venta/nuevo_punto_venta" class="btn btn-primary">Nuevo Punto De venta</a>
                <a href="<?php echo base_url();?>fact/punto_venta/" target="_blank" class="btn btn-primary">Imprimir</a>
                <a href="<?php echo base_url();?>fact/admin/" class="btn btn-primary">Volver Atrás</a>
              </div>
            </div>
<p></p>
<p><div class="content">
   
    <table id="tabla_puntos_de_venta" class="table table-condensed table-hover table-bordered text-center fs-13" width="100%">
      <thead>
        <tr>
          <th>Nro.</th>
          <th>Cod. Suc.</th>
          <th>Cod. P.V.</th>
          <th>Cod. CUIS</th>
          <th>Fecha vig. CUIS</th>
          <th>Descripción</th>
          <th>Nombre P.V.</th>
          <th>Editar</th>
          <th>Bloquear</th>
        </tr>
      </thead>
      <tbody>
        <?php
         
          $salida='';
        $i=1;
        $codigo_tipo_punto_venta = $this->config->item('codigo_tipo_punto_venta');
        
        foreach ($puntos as $key => $value){
          $cuis = $this->cuis_model->get_cuis_id_punto_venta($value['id_punto_venta']);
          if(is_null($cuis)){
            $s_cuis= '<a href="'.base_url().'fact/punto_venta/solicitar_cuis_punto_venta/'.$value['id_punto_venta'].'" class="button-small pure-button button-success">Solicitar</a>';
            $s_cuis_fecha= '-';
            $s_btn_amarillo= '<a class="button-small pure-button button-warning" href="'.base_url().'fact/punto_venta/nuevo_punto_venta/'.$value['id_punto_venta'].'">Editar</a>';
            $s_btn_rojo= '';
          }
          else{
            $s_cuis = $cuis['cuis_codigo'];
            $s_cuis_fecha = $cuis['cuis_fecha_vigencia'];
            $s_btn_amarillo= '';
            $s_btn_rojo= '<a class="button-small pure-button button-error" href="'.base_url().'fact/punto_venta/'.$value['id_punto_venta'].'">Bloquear</a>';
          }

          $salida.= '
            <tr>
              <td>'.$i++.'</td>
              <td>'.($value['codigo_sucursal']).'</td>
              <td>'.($value['codigo_punto_venta']).'</td>
              <td>'.($s_cuis).'</td>
              <td>'.($s_cuis_fecha).'</td>
              <td>'.($value['descripcion_punto_venta']).'</td>
              <td>'.($value['nombre_punto_venta']).'</td>              
              <td>'.($s_btn_amarillo).'</td>
              <td>'.($s_btn_rojo).'</td>
            </tr>
          ';
        }
        echo $salida;
        ?>
      </tbody>
    </table>
  </div>
  </p>
