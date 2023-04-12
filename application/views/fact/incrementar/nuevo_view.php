<div class="header">
  <span class="titulo_pagina">INGRESO - NUEVO</span>
</div>
<p></p>

<?php $csrf = array('name' => $this->security->get_csrf_token_name(),'hash' => $this->security->get_csrf_hash());?>
<script>
$(document).ready(function (){
  $("#fecha_ingreso_almacen").datepicker();
  
  $("#nombre_producto").focus();
  $("#id_area").val('');
  var availableTags = [<?php echo $salida;?>];
  $("#nombre_producto" ).autocomplete({
    source: availableTags,
    minLength: 2
  });  
});//fin ready
function pulsar(e) {
  tecla = (document.all) ? e.keyCode :e.which;
  return (tecla!=13);
} 
</script>
<div class="content">
    <div class="pure-g">
      <div class="pure-u-1 pure-u-md-1-3"><p style="margin:5px 20px 5px 20px"><a href="javascript:window.history.back();" id="btn_nuevo" class="pure-button button-secondary" style="width: 100%">Atras</a></p></div>
    </div>
    <hr>

    <h2 class="content-head is-center">Nuevo ingreso</h2>


	<form class="pure-form" id="form_buscar" method="post" data-parsley-validate>
    <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
	  <fieldset>
	    <input type="text" id="nombre_producto" name="nombre_producto" placeholder="Item a ingresar..." required>
	    <button type="submit" id="btn_submit" class="pure-button pure-button-primary">Agregar ítem</button>
	  </fieldset>
	</form>
    
  <form method="post" class="pure-form pure-form-stacked" id="form_nuevo" target="_blank" data-parsley-validate>  
    <input type="hidden" name="<?php echo $csrf['name'];?>" value="<?php echo $csrf['hash'];?>">
    <fieldset>
      <table id="tabla_pedido" style="margin-top: -0.5em">
        <thead>
          <th>N°</th><th>Cant. a ingresar</th><th>P. Unid. Adq.</th><th>Producto</th><th>Obs.</th><th>Borrar</th>
        </thead>
        <tbody>
        </tbody>
      </table>
          <div class="pure-g" style="margin-top: -2em">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="proveedor">Proveedor:</label>
                <input name="proveedor" id="proveedor" placeholder="Ej. Juan Perez" required>
              </div>
            </div>
            
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="observacion_general">Glosa ingreso:</label>
                <input name="observacion_general" id="observacion_general" placeholder="Ej. Por ingreso a almacen." required>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="doc_respaldo">Doc. Respaldo:</label>
                <!--<input name="doc_respaldo" id="doc_respaldo" placeholder="Ej. Factura" required>-->
                <select name="doc_respaldo" id="doc_respaldo">
                  <option value="FACTURA">FACTURA</option>
                  <option value="RECIBO">RECIBO</option>
                  <option value="NOTA VENTA">NOTA VENTA</option>
                  <option value="OTRO">OTRO</option>
                </select>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-control-group">
                <label for="nro_doc_respaldo">Nro. Doc. Respaldo:</label>
                <input type="number" name="nro_doc_respaldo" id="nro_doc_respaldo" placeholder="Ej. 1001" data-parsley-min="0" required>
              </div>
            </div>
            
          </div>

          <div class="pure-g">
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_cargo">Guardar ingreso:</label>
                <button id="btn_guardar" type="submit" class="pure-button button-success">Guardar</button>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
              <div class="pure-controls">
                <label for="nombre_cargo">Cancelar:</label>
                <a href="javascript:history.back()" class="pure-button button-error">Cancelar</a>
              </div>
            </div>
            <div class="pure-u-1 pure-u-md-1-3">
            </div>            
          </div>
        </fieldset>      
  </form>

</div>

<script>
  var productos = new Array();

function buscarElemento(elemento){
  var ok = false;
  for(var i=0;i<productos.length;i++){
      if(productos[i]===elemento)
        ok = true;
  }
  if(!ok){
    productos.push(elemento);
    return true;
  }
  else return false;
}
function dibujarTabla(){

  $('#tabla_pedido > tbody > tr').remove();
  for(var i=0;i<productos.length;i++)
  {
    //envia mos cant_i y prod_i
    $('#tabla_pedido > tbody').append('<tr><td style="text-align:right">'+(i+1)+'</td><td> <input type="text" style="width:75px" name="cant_'+i+'"  value="1" onkeypress="return pulsar(event)" required></td><td> <input type="number" style="width:75px" name="precio_'+i+'" placeholder="Ej. 30,5" onkeypress="return pulsar(event)" data-parsley-min="0" step="0.1" required></td><td><input type="text" name="prod_'+i+'" value="'+productos[i]+'" readonly></td><td><input type="text"  name="obs_'+i+'" onkeypress="return pulsar(event)"></td><td><a href="javascript:eliminar_producto('+i+')" class="pure-button button-error">Borrar</a></td></tr>');
  }
  //console.log(productos);
}
function eliminar_producto(i){
  productos.splice(i, 1);
  dibujarTabla();
  //location.reload();
}

$('#form_buscar').submit(function(){
  if($(this).parsley().isValid())
    {
      //$("#btn_submit").fadeOut();
      //$("#nombre_producto").fadeOut();
      $("#nombre_producto").focus();

      var url = BASE_URL+"orden/buscar_producto";
      $.ajax({
        type: "POST",
        url: url,
        data: $('#form_buscar').serialize(),
        success: function(data)
        {
          //agregamos el resultado al array
          if(data!=""){
            if(!buscarElemento(data))
              alert("Ya existe en el listado");
            else{
              dibujarTabla();
              $("#nombre_producto").val("");
            }
          }
        }
      });
      ;
    }//fin if
  return false;
});  

$('#form_nuevo').submit(function(){
  if($(this).parsley().isValid() && (productos.length>0))
    {
      if(confirm("¿Esta seguro de almacenar los cambios?")){
        $("#btn_guardar").attr("disabled", true);


        var url = BASE_URL+"incrementar/incrementar_item/"+productos.length;
        $.ajax({
          type: "POST",
          url: url,
          data: $('#form_nuevo').serialize(),
          success: function(data)
          {
            //console.log(data);
            //window.open(BASE_URL+'sabs/imprimir/'+data, '', 'width=800,height=600');
            location.href=BASE_URL+'incrementar';
          }
        });
        
      }
    }//fin if
    else
      alert("Debe haber productos en el formulario");
  return false;
});

</script>
