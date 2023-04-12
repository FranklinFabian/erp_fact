



<!--<p><a id="lanzador" href="#modal_asistente">Open Modal</a></p>-->
<!-- MODAL 
<script>
    $("#modal_asistente").modal({
        escapeClose: false,
        clickClose: false,
        showClose: true
    });
</script>
-->

        
		<div class="footer">
            
            <?php echo $this->config->item('pie');?> &nbsp; <div id="status"></div>
		</div>
  </div>
<!-- Fin main-->
</div>
<!-- Fin layout-->

<script src="<?php echo base_url();?>public/js/functions.js"></script>
<script>
var s = document.getElementById('status');
setInterval(function () {
  s.className = navigator.onLine ? 'online' : 'offline';
  s.innerHTML = navigator.onLine ? 'En linea' : 'Sin conexión';  
}, 250);      

</script>



</body>
</html>
