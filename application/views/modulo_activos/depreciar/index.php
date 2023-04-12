<!-- Add new  start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1> Depreciar </h1>
            <small>Depreciar</small>
            <ol class="breadcrumb">
                <li><a href="#">Hogar</a></li>
                <li><a href="#"> Depreciar </a></li>
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


<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-bd lobidrag">
            <div class="panel-heading">
                <div class="panel-title">
                    <h4> Depreciar </h4>
                </div>
            </div>

            <div class="panel-body">

                <form action="<?php echo site_url('Cmactivos_depreciar/depreciar');?>" id="form_depreciar" method="post">

                    <div class="col-sm-12">
                        <div class="form-group row" align="center">
                            <input type="submit" id="add-product" class="btn btn-default btn-large" name="add" value="Iniciar Depreciación" />
                        </div>
                    </div>

                </form>

            </div>

        </div>
    </div>

</div>
</section>
</div>

<script>
    $(function() {
        $('.select2_general').select2({
            placeholder: "Seleccione una opción",
            dropdownParent: $('#form_modal')
        });


    });

    $("#form_depreciar").submit(function(event){
        event.preventDefault(); //prevent default action
        var post_url = $(this).attr("action"); //get form action url
        var request_method = $(this).attr("method"); //get form GET/POST method
        var form_data = $(this).serialize(); //Encode form elements for submission

        $.ajax({
            url : post_url,
            type: request_method,
            dataType: 'json',
            data : form_data,
        }).done(function(response){
            if (response.code === 1){
                swal.fire({
                    icon: 'success',
                    title: 'Se realizo la depreciación de manera correcta',
                    showConfirmButton: false,
                    timer: 2000
                })
            }else{
                swal.fire({
                    icon: 'warning',
                    title: 'No hay Articulos Nuevos o Saldo de Depreciación',
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        });

    });


</script>




