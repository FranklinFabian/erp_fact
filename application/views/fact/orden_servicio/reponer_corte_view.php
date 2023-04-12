<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>

<div class="header">
  <span class="titulo_pagina">Procesar - ORDEN</span>
</div>
<p></p>
<div class="content">
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="javascript:history.back();" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    <div class="pure-g" style="background-color: #fff; padding:.5em; border-radius:5px">
      <div class="pure-u-1 pure-u-md-1-3"><strong>Cliente: </strong> <?php echo $cliente['ci']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Nombre: </strong> <?php echo $cliente['razon_social']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Teléfono: </strong> <?php echo $cliente['telefono']?></div>
      
      <div class="pure-u-1 pure-u-md-1-3"><strong>Circuito: </strong> <?php echo $centro['centro']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Poste: </strong> <?php echo $poste['poste']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Medidor: </strong> <?php echo $abonado['medidor']?></div>

      <div class="pure-u-1 pure-u-md-1-3"><strong>Zona: </strong> <?php echo $direccion['zona']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Calle: </strong> <?php echo $direccion['calle']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Descripción: </strong> <?php echo $abonado['descripcion']?></div>

      <div class="pure-u-1 pure-u-md-1-3"><strong>Categoria: </strong> <?php echo $categoria['categoria']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Estado: </strong> <?php echo $estado['estado']?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Abonado: </strong> <?php echo $abonado['idabonado']?></div>
    </div>
<br>
    <div class="pure-g" style="background-color: #fff; padding:.5em; border-radius:5px">
      <div class="pure-u-1 pure-u-md-1-3"><strong>N° corte: </strong> <?php echo $corte['numero']?></div>      
      <div class="pure-u-1 pure-u-md-1-3"><strong>Fecha corte: </strong> <?php echo ($corte['fecha_final'])?></div>
      <div class="pure-u-1 pure-u-md-1-3"><strong>Cortador: </strong> <?php echo $corte['empleado']?></div>
          
    </div>
    <form method="post" class="pure-form pure-form-stacked" action="<?php echo base_url();?>orden_servicio/crear_reposicion/" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">

          <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="solicitante">Solicitante:</label>
                <input type="text" name="solicitante" id="solicitante" required autofocus>
              </div>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="ci">CI:</label>
                <input type="text" name="ci" id="ci" required>
              </div>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" id="telefono" required>
              </div>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <input type="hidden" name="idcorte" id="idcorte" value="<?php echo $corte['idcorte']?>">
              </div>
            </div>
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <input type="hidden" name="idservicio" id="idservicio" value="<?php echo $corte['idservicio']?>">
              </div>
            </div>
            
          </div><!--fin pure g-->

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-controls">
                <label for="">Aceptar:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Aceptar</button>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-2">
              <div class="pure-controls">
                <label for="">Cancelar:</label>
                <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div>
            </div>
          </div>
        </fieldset>
      </form>

</div>
