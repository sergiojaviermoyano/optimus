<!--
<div class="row">
	<div class="col-xs-12">
		<div class="alert alert-danger alert-dismissable" id="error_" style="display: none">
	        <h4><i class="icon fa fa-ban"></i> Error!</h4>
	        Revise que todos los campos esten completos
      </div>
	</div>
</div>
<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Importe <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <input type="text" class="form-control" id="retImporte" value="" >
    </div>
</div><br>

<div class="row">
	<div class="col-xs-4">
      <label style="margin-top: 7px;">Comentario <strong style="color: #dd4b39">*</strong>: </label>
    </div>
	<div class="col-xs-5">
      <textarea class="form-control" id="retDescripcion"></textarea>
    </div>
</div><br>

</div>
-->

<?php 
if(count($retiros) > 0) {                  
  foreach($retiros as $r)	
	{
		$date = date_create($r['retFecha']);
		echo '
		<div class="row">
			<div class="col-xs-2">Fecha:</div>
			<div class="col-xs-4"><label>'.date_format($date, 'd-m-Y H:i').'</label></div>
		    <div class="col-xs-2">Importe:</div>
			<div class="col-xs-4"><label>$'.number_format($r['retImporte'], 2, ",", ".").'</label></div>
		</div>
		<div class="row">
			<div class="col-xs-2">Motivo:</div>
			<div class="col-xs-10"><label>'.$r['retDescripcion'].'</label></div>
		</div>
		<div class="row">
			<div class="col-xs-6"></div>
			<div class="col-xs-2">Usuario:</div>
			<div class="col-xs-4"><label>'.$r['usrNick'].'</label></div>
		</div>
		<div class="row">
			<div class="col-xs-12"><hr></div>
		</div>';
		//var_dump($r);
	}
}
?>