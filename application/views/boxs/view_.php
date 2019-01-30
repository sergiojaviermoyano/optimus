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
      <label style="margin-top: 7px;">Fondo Inicial <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <input type="text" class="form-control" id="cajaImpApertura" value="<?php echo $data['box']['cajaImpApertura'];?>" <?php echo ($data['action'] != 'Add' ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>

<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Ventas <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <input type="text" class="form-control" id="cajaImpVentas" value="<?php echo number_format($data['box']['cajaImpVentas'],2);?>" disabled="disabled" >
    </div>
</div><br>
<?php
  if($data['action'] == 'Close'){
   foreach ($data['box']['medios'] as $key => $item):?>
         <div class="row">
            <div class="col-xs-4"></div>
            <div class="col-xs-2">
              <?php echo $item['medDescripcion'];?>
            </div>
            <div class="col-xs-5">
              <strong><?php echo $item['importe'];?></strong>
            </div>
          </div><br>
    <?php endforeach;
    echo '
    <div class="row">
      <div class="col-xs-4"></div>
      <div class="col-xs-2">
        Cobranza Cta Cte Clientes
      </div>
      <div class="col-xs-5">
        <strong>'.$data['box']['cliente'].'</strong>
      </div>
    </div><br>';

    echo '
    <div class="row">
      <div class="col-xs-4"></div>
      <div class="col-xs-2">
        Pago Cta Cte Proveedores
      </div>
      <div class="col-xs-5">
        <strong>'.$data['box']['proveedor'].'</strong>
      </div>
    </div><br>';
  }
?>
<div class="row">
  <div class="col-xs-4">
      <label style="margin-top: 7px;">Retiros <strong style="color: #dd4b39">*</strong>: </label>
    </div>
  <div class="col-xs-5">
      <input type="text" class="form-control" id="cajaRetiros" value="<?php echo $data['box']['cajaRetiros'];?>" disabled="disabled" >
    </div>
</div><br>
<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Redición <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <input type="text" class="form-control" id="cajaImpRendicion" value="<?php echo $data['box']['cajaImpRendicion'];?>" <?php echo ($data['action'] != 'Close' ? 'disabled="disabled"' : '');?>  >
    </div>
</div><br>

<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Apertura <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <input type="text" class="form-control" id="cajaApertura" value="<?php echo $data['box']['cajaApertura'] != null ? date("d-m-Y H:i", strtotime($data['box']['cajaApertura'])) : ''; ?>" disabled="disabled" >
    </div>
</div><br>

<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Cierre <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <input type="text" class="form-control" id="cajaCierre" value="<?php echo $data['box']['cajaCierre'] != null ? date("d-m-Y H:i", strtotime($data['box']['cajaCierre'])) : '';?>" disabled="disabled" >
    </div>
</div><br>

<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Usuario <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <input type="text" class="form-control" id="usr" value="<?php echo $data['box']['usrLastName'].', '.$data['box']['usrName'] ;?>" disabled="disabled" >
    </div>
</div><br>

</div>
