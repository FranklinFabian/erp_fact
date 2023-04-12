<!-- Edit Product Start -->
<div class="content-wrapper">
    <section class="content-header">
        <div class="header-icon">
            <i class="pe-7s-note2"></i>
        </div>
        <div class="header-title">
            <h1>Editar cliente</h1>
            <small>Editar cliente</small>
            <ol class="breadcrumb">
                <li><a href="index.html"><i class="pe-7s-home"></i>Hogar</a></li>
                <li><a href="#">Cliente</a></li>
                <li class="active">Editar cliente</li>
            </ol>
        </div>
    </section>

    <section class="content">
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
            <?php
            $this->session->unset_userdata('error_message');
        }
        ?>
        <!-- Purchase report -->
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-bd lobidrag">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4>Editar cliente</h4>
                                </div>
                                <div class="col-lg-6" align="right">

                                    <a href="<?php echo base_url() . 'Cga_cliente/print/' . $id; ?>" class="btn btn-info btn-md" data-toggle="tooltip" data-placement="left" title=" Imprimir " target="_blank" ><i class="ti-printer" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo form_open_multipart('Cga_cliente/update', array('class' => 'form-vertical', 'id' => 'update', 'name' => 'update')) ?>
                    <div class="panel-body">
                        <div class="row">
                            <input type="hidden" name="id" value="{id}" id="id">
                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="ci" class="col-sm-4 col-form-label">CI:<i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name ="ci" id="ci" type="text" placeholder="CI" required value="{ci}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="expedido" class="col-sm-4 col-form-div">Expedido:<i class="text-danger">*</i> </label>
                                    <div class="col-sm-8">
                                        <select name="id_expedido" class="form-control select2_general" style="width:100%" required>
                                            <option></option>
                                            <?php foreach ($departamentos as $departamento) {
                                                if ($departamento['id'] == $id_expedido){ ?>
                                                    <option value="<?php echo $departamento['id'] ?>" selected>  <?php echo $departamento['nombre']; ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $departamento['id'] ?>">  <?php echo $departamento['nombre'];?> </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="razon_social" class="col-sm-4 col-form-label">Razon social:<i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name ="razon_social" id="razon_social" type="text" placeholder="Razon social"  required value="{razon_social}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fecha_nacimiento" class="col-sm-4 col-form-label fecha">Fecha de nacimiento:<i class="text-danger">*</i></label>
                                    <div class="col-sm-8">
                                        <?php
                                        $date=date_create($fecha_nacimiento);
                                        $fecha_nacimiento = date_format($date,"d-m-Y");
                                        ?>
                                        <input class="form-control fecha" type="text" size="50" name="fecha_nacimiento" id="fecha_nacimiento" required value="<?php echo $fecha_nacimiento; ?>"/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="genero" class="col-sm-4 col-form-div">Genero:<i class="text-danger">*</i> </label>
                                    <div class="col-sm-8">
                                        <select name="genero" class="form-control select2_general" style="width:100%" required>
                                            <option></option>
                                            <?php foreach ($generos as $generol) {
                                                if ($generol['id'] == $genero){ ?>
                                                    <option value="<?php echo $generol['id'] ?>" selected>  <?php echo $generol['nombre']; ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $generol['id'] ?>">  <?php echo $generol['nombre'];?> </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nit" class="col-sm-4 col-form-label">NIT:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name ="nit" id="nit" type="text" placeholder="Nit" value="{nit}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="direccion" class="col-sm-4 col-form-label">Dirección:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="direccion" id="direccion" type="text" placeholder="Dirección" value="{direccion}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="estado_cliente" class="col-sm-4 col-form-div">Estado cliente:<i class="text-danger">*</i> </label>
                                    <div class="col-sm-8">
                                        <select name="estado_cliente" class="form-control select2_general" style="width:100%" required>
                                            <option></option>
                                            <?php foreach ($estados_clientes as $estado_cliente1) {
                                                if ($estado_cliente1['id'] == $estado_cliente){ ?>
                                                    <option value="<?php echo $estado_cliente1['id'] ?>" selected>  <?php echo $estado_cliente1['nombre']; ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $estado_cliente1['id'] ?>">  <?php echo $estado_cliente1['nombre'];?> </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="telefono" class="col-sm-4 col-form-label">Telefono:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name ="telefono" id="telefono" type="text" placeholder="Telefono" value="{telefono}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="profesion" class="col-sm-4 col-form-div"> Profesión:</label>
                                    <div class="col-sm-8">
                                        <select name="id_profesion" class="form-control select2_general" style="width:100%">
                                            <option><option>
                                            <?php foreach ($profesiones as $profesion) {
                                                if ($profesion['id'] == $id_profesion){ ?>
                                                    <option value="<?php echo $profesion['id'] ?>" selected>  <?php echo $profesion['nombre']; ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $profesion['id'] ?>">  <?php echo $profesion['nombre'];?> </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="ocupacion" class="col-sm-4 col-form-div"> Ocupación:</label>
                                    <div class="col-sm-8">
                                        <select name="id_ocupacion" class="form-control select2_general" style="width:100%">
                                            <option></option>
                                            <?php foreach ($ocupaciones as $ocupacion) {
                                                if ($ocupacion['id'] == $id_ocupacion){ ?>
                                                    <option value="<?php echo $ocupacion['id'] ?>" selected>  <?php echo $ocupacion['nombre']; ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $ocupacion['id'] ?>">  <?php echo $ocupacion['nombre'];?> </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="nivel_educacion" class="col-sm-4 col-form-div"> Nivel de educación:</label>
                                    <div class="col-sm-8">
                                        <select name="id_nivel_educacion" class="form-control select2_general" style="width:100%">
                                            <option></option>
                                            <?php foreach ($niveles_educacion as $nivel_educacion) {
                                                if ($nivel_educacion['id'] == $id_nivel_educacion){ ?>
                                                    <option value="<?php echo $nivel_educacion['id'] ?>" selected>  <?php echo $nivel_educacion['nombre']; ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $nivel_educacion['id'] ?>">  <?php echo $nivel_educacion['nombre'];?> </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="numero_dependientes" class="col-sm-4 col-form-label">N° Dependientes:</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name ="numero_dependientes" id="numero_dependientes" type="text" placeholder="N° Dependientes" value="{numero_dependientes}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="estado_civil" class="col-sm-4 col-form-div">Estado civil:<i class="text-danger">*</i> </label>
                                    <div class="col-sm-8">
                                        <select name="id_estado_civil" class="form-control select2_general" style="width:100%" required>
                                            <option></option>
                                            <?php foreach ($estados_civiles as $estado_civil) {
                                                if ($estado_civil['id'] == $id_estado_civil){ ?>
                                                    <option value="<?php echo $estado_civil['id'] ?>" selected>  <?php echo $estado_civil['nombre']; ?> </option>
                                                <?php } else { ?>
                                                    <option value="<?php echo $estado_civil['id'] ?>">  <?php echo $estado_civil['nombre'];?> </option>
                                                <?php } ?>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="fotografia" class="col-sm-4 col-form-label">Fotografia:</label>
                                    <div class="col-sm-8">
                                        <input type="file" id="fotografia" name="fotografia" accept="image/jpeg" class="form-control"/>
                                        <small id="msg_foto_1" class="form-text text-danger">Seleccionar solo si desea cambiar la foto.</small>
                                        <br>
                                        <small id="msg_foto_2" class="form-text text-success">Solo se admiten fotografias en formato jpg.</small>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6">
                                <input type="submit" id="add" class="btn btn-primary btn-large" name="add" value="Guardar cambios" />
                            </div>
                        </div>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </section>
</div>


<script type="text/javascript">

    $(function(){
        $(".fecha").datepicker({ dateFormat:'dd-mm-yy' });
        $('.select2_general').select2({
            placeholder: "Seleccione una opción",
            allowClear: true
        });
    });

    window.onload = function () {
        var text_input = document.getElementById('ci');
        text_input.focus();
        text_input.select();
    }

</script>


