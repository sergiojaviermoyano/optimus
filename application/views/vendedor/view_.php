<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="error" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
	        Revise que todos los campos esten completos
      </div>
	</div>
</div>
<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Código <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <input type="text" class="form-control" id="codigo" value="<?php echo $data['vendedor']['codigo'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>

<div class="row">
  <div class="col-xs-4">
      <label style="margin-top: 7px;">Nombre: </label>
    </div>
  <div class="col-xs-5">
      <input type="text" class="form-control" id="nombre" value="<?php echo $data['vendedor']['nombre'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>

<div class="row">
    <div class="col-xs-4">
        <label style="margin-top: 7px;">Estado: </label>
    </div>
    <div class="col-xs-5">
        <select class="form-control" id="estado"  <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
          <?php
              echo '<option value="AC" '.($data['vendedor']['estado'] == 'AC' ? 'selected' : '').'>Activo</option>';
              echo '<option value="IN" '.($data['vendedor']['estado'] == 'IN' ? 'selected' : '').'>Inactivo</option>';
          ?>
        </select>
    </div>
  </div>

</div>
