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
      <input type="text" class="form-control" id="medCodigo" value="<?php echo $data['medio']['medCodigo'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>
<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Descripción <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <input type="text" class="form-control" id="medDescripcion" value="<?php echo $data['medio']['medDescripcion'];?>" <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>
<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Tipo <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <select class="form-control" id="tmpId"  <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
        <?php 
        	foreach ($data['tipos'] as $t) {
        		echo '<option value="'.$t['tmpId'].'" '.($data['medio']['tmpId'] == $t['tmpId'] ? 'selected' : '').'>'.$t['tmpDescripción'].'</option>';
        	}
        ?>
      </select>
    </div>
</div><br>
<div class="row">
    <div class="col-xs-4">
        <label style="margin-top: 7px;">Estado: </label>
    </div>
    <div class="col-xs-5">
        <select class="form-control" id="medEstado"  <?php echo ($data['read'] == true ? 'disabled="disabled"' : '');?> >
          <?php 
              echo '<option value="AC" '.($data['medio']['medEstado'] == 'AC' ? 'selected' : '').'>Activo</option>';
              echo '<option value="IN" '.($data['medio']['medEstado'] == 'IN' ? 'selected' : '').'>Inactivo</option>';
          ?>
        </select>
    </div>
  </div>

</div>