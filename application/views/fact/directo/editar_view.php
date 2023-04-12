<div class="header">
  <span class="titulo_pagina">directo - Editar</span>
</div>
<p></p>
<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
  <div class="content">
    <div class="pure-g">      
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="<?php echo base_url().$this->router->fetch_class().'/lista';?>" class="pure-button button-secondary" style="width:100%;">Volver atras</a></p></div>
    </div>
    
      <form method="post" class="pure-form pure-form-stacked" action="<?php echo base_url()?>directo/actualizar/<?php echo $directo['iddirecto']?>" data-parsley-validate>
        <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
        <fieldset>
          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="beneficiario">Beneficiario:</label>
                <input id="beneficiario" name="beneficiario" type="text" placeholder="Ej. T-2121" value="<?php echo $directo['beneficiario']?>"required>
              </div>            
            </div>            
          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="">Actualizar:</label>
                <button type="submit" class="pure-button button-success">Actualizar</button>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="">Cancelar:</label>
                <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div>
            </div>
          </div>

        </fieldset>
      </form>
    </div>