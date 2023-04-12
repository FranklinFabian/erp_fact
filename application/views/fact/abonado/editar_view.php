<div class="header">
  <span class="titulo_pagina">Abonado - Editar</span>
</div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url().$this->router->fetch_class().'/lista';?>" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    
      <form method="post" class="pure-form pure-form-stacked" action="<?php echo base_url();?>abonado/actualizar/<?php echo $abonado['idabonado'];?>" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idservicio">Servicios:</label>
                <?php
                  $data_servicio[null]='';
                  foreach ($servicios as $key => $value) 
                    $data_servicio[$value['idservicio']] = $value['descripcion'];
                  $js_servicio='id="idservicio"';
                  echo form_dropdown('idservicio',$data_servicio,$abonado['idservicio'], $js_servicio);
                ?>
              </div>
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idcategoria">Categoria:</label>
                <?php
                  foreach ($categorias as $key => $value) 
                    $data_categoria[$value['idcategoria']] = $value['codigo'].' - '.$value['categoria'];
                  $js_categoria='id="idcategoria"';
                  echo form_dropdown('idcategoria',$data_categoria, $abonado['idcategoria'], $js_categoria);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idlocalidad">Localidad:</label>
                <?php
                  $localizacion = $this->calles_model->get_all_all($abonado['idcalle']);
                  $data_localidad[null]='Seleccione';
                  foreach ($localidades as $key => $value) 
                    $data_localidad[$value['idlocalidad']] = $value['localidad'];
                  $js_localidad='id="idlocalidad" required="" onchange="cambio_localidad();"';
                  echo form_dropdown('idlocalidad',$data_localidad,$localizacion['idlocalidad'], $js_localidad);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idzona">Zona:</label>
                <?php
                  $data_zona[null]='Seleccione';
                  foreach ($zonas as $key => $value) 
                    $data_zona[$value['idzona']] = $value['zona'];
                  $js_zona='id="idzona" required="" onchange=""';
                  echo form_dropdown('idzona',$data_zona,$localizacion['idzona'], $js_zona);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idcalle">Calle:</label>
                <?php
                  $data_calle[null]='Seleccione';
                  foreach ($calles as $key => $value) 
                    $data_calle[$value['idcalle']] = $value['calle'];
                  $js_calle='id="idcalle" required="" onchange=""';
                  echo form_dropdown('idcalle',$data_calle,$localizacion['idcalle'], $js_calle);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="numero">Número de casa:</label>
                <input id="numero" name="numero" type="text" placeholder="Ej. Mi número" value="<?php echo $abonado['numero']?>" required>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="descripcion">Descripción (referencia):</label>
                <input id="descripcion" name="descripcion" type="text" placeholder="Ej. Mi número" value="<?php echo $abonado['descripcion']?>" required>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idcentro">Circuito:</label>
                <?php
                  $poste_centro = $this->postes_model->get_poste_circu($abonado['idposte']);
                  $data_centro[null]='Seleccione';
                  foreach ($centros as $key => $value) 
                    $data_centro[$value['idcentro']] = $value['centro'];
                  $js_centro='id="idcentro" required="" onchange=""';
                  echo form_dropdown('idcentro',$data_centro, $poste_centro['idcentro'], $js_centro);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idposte">Poste:</label>
                <?php
                  //$poste_poste = $this->postes_model->get_poste_circu($abonado['idposte']);
                  $data_poste[null]='Seleccione';
                  foreach ($postes as $key => $value) 
                    $data_poste[$value['idposte']] = $value['poste'];
                  $js_poste='id="idposte" required="" onchange=""';
                  echo form_dropdown('idposte',$data_poste, $poste_centro['idposte'], $js_poste);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idsuministro">Suministro:</label>
                <?php
                  foreach ($suministros as $key => $value) 
                    $data_suministro[$value['idsuministro']] = $value['codigo'].' - '.$value['suministro'];;
                  $js_suministro='id="idsuministro"';
                  echo form_dropdown('idsuministro',$data_suministro,$abonado['idsuministro'], $js_suministro);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idconsumidor">Consumidor:</label>
                <?php
                  foreach ($consumidores as $key => $value) 
                    $data_consumidor[$value['idconsumidor']] = $value['codigo'].' - '.$value['consumidor'];;
                  $js_consumidor='id="idconsumidor"';
                  echo form_dropdown('idconsumidor',$data_consumidor,$abonado['idconsumidor'], $js_consumidor);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idmedicion">Mediciones:</label>
                <?php
                  foreach ($mediciones as $key => $value) 
                    $data_medicion[$value['idmedicion']] = $value['codigo'].' - '.$value['medicion'];;
                  $js_medicion='id="idmedicion"';
                  echo form_dropdown('idmedicion',$data_medicion,$abonado['idmedicion'], $js_medicion);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idliberacion">Liberación:</label>
                <?php
                  foreach ($liberaciones as $key => $value) 
                    $data_liberacion[$value['idliberacion']] = $value['liberacion'];
                  $js_liberacion='id="idliberacion"';
                  echo form_dropdown('idliberacion',$data_liberacion,$abonado['idliberacion'], $js_liberacion);
                ?>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="cantidad">Cantidad de puntos:</label>
                <input type="number" id="cantidad" name="cantidad" min="0" placeholder="1" value="<?php echo $abonado['cantidad']?>" required>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="medidor">Nro. Medidor:</label>
                <input type="text" id="medidor" name="medidor" placeholder="1" value="<?php echo $abonado['medidor']?>"  required>
              </div>            
            </div>
          </div>
<hr>
          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="fase">Fase:</label>
                <input id="fase" name="fase" type="text" placeholder="Ej. F1" value="<?php echo $abonado['fase'];?>" required>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="capacidad">Capacidad:</label>
                <input id="capacidad" name="capacidad" type="number" placeholder="Ej. 220" value="<?php echo $abonado['capacidad'];?>" required>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="indiceinicial">Indice Inicial:</label>
                <input id="indiceinicial" name="indiceinicial" type="number" placeholder="Ej. 1" value="<?php echo $abonado['indiceinicial'];?>" required>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="mulmed">Mul. Med.:</label>
                <input id="mulmed" name="mulmed" type="number" placeholder="Ej. 50" value="<?php echo $abonado['mulmed'];?>" required>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="encorte">En corte:</label>
                <input id="encorte" name="encorte" type="number" placeholder="Ej. 150" value="<?php echo $abonado['encorte'];?>" required>
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="instalacion">Instalación:</label>
                <input id="instalacion" name="instalacion" type="date" placeholder="" value="<?php echo $abonado['instalacion'];?>">
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="corte">Corte:</label>
                <input id="corte" name="corte" type="date" placeholder="" value="<?php echo $abonado['corte'];?>">
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="reposicion">Reposición:</label>
                <input id="reposicion" name="reposicion" type="date" placeholder="" value="<?php echo $abonado['reposicion'];?>">
              </div>            
            </div>

            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="idestado">Estado:</label>
                <?php
                  foreach ($estados as $key => $value) 
                    $data_estado[$value['idestado']] = $value['codigo'].' - '.$value['estado'];
                  $js_estado='id="idestado"';
                  echo form_dropdown('idestado',$data_estado,$abonado['idestado'], $js_estado);
                ?>
              </div>
            </div>

          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_area">Actualizar:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Actualizar</button>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_area">Cancelar:</label>
                <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div>
            </div>
          </div>

        </fieldset>
      </form>
    </div>
