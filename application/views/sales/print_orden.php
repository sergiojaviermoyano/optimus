<?php
	$fecha= date('d-m-y',strtotime($orden_data['orden']['oFecha']));
	$fecha=explode('-',$fecha);
	$importe_total=0;
?>

<table style="width:100%;  border-spacing: 10px;    border-collapse: separate; color: #72324a;">
	<tr style="border:2px solid #72324a !important; margin:0px auto;">
		<td colspan=3 style="border:2px solid #72324a !important; margin:0px auto; border-radius: 10px;  text-align:center ">
			<h1 style="font-size:55px !important; text-align:center; width:100%; padding-botton:0px;">
				ADOLFO FERNANDEZ
				<br><span style="width:100%; text-align:right; padding-top:0px; font-size:15px !important;">Soluciones Electronicas</span>
			</h1>
			<p style="text-align:center; width:100%;">Fray Justo Santa Maria de Oro 489</p>
			<p style="text-align:center; width:100%;">C.P. 5442 Caucete - San Juan - Tel. 496-3903 - Cel. 154514219</p>
		</td>
	</tr>
	<tr style="border:2px solid #72324a !important; margin:0px auto;">
		<td colspan=3 style="border:2px solid #72324a !important; margin:0px auto; border-radius: 10px;  text-align:left; padding:5px;">
			<table style="width:100%;">
				<tr style="text-align:center; font-size:20px; font-weight:bold; color:#000000;">
					<td style="width:10% !important; border:2px solid #72324a !important; padding-top:10px; height:30px;"><?php echo $fecha[0]?></td>
					<td style="width:10% !important; border:2px solid #72324a !important; padding-top:10px; height:30px"><?php echo $fecha[1]?></td>
					<td style="width:10% !important; border:2px solid #72324a !important; padding-top:10px; height:30px"><?php echo $fecha[2]?></td>
					<td style="width:70% !important; border:2px solid #72324a !important; padding-top:10px; height:30px;font-size:25px;">
						<span style="width:100%; font-size:18px;">NO VALIDO COMO FACTURA</span> <br>
						PRESUPUESTO VALIDO POR 15 DIAS
					</td>
				</tr>
			</table>
		</td>
	</tr>

	<tr style="border:2px solid #72324a !important; margin:0px auto;">
		<td colspan=3 style="border:2px solid #72324a !important; margin:0px auto; border-radius: 10px;  text-align:left; padding:5px;">
			<table style="width:100%;">
				<tr>
					<td style="width:10%; padding-top:20px;"> Señor: </td>
					<td style="width:90% !important; border-bottom: 1px dotted #72324a; padding-top:10px;font-size:20px; font-weight:bold;color:#000000;"><?php echo $orden_data['cliente']['cliNombre']." ".$orden_data['cliente']['cliApellido']?></td>
				</tr>
				<tr>
					<td style="width:10%; padding-top:20px;"> Domicilio:  </td>
					<td style="width:90%; border-bottom: 1px dotted #72324a; padding-top:10px;"><?php echo $orden_data['cliente']['cliDomicilio']?></td>
				</tr>
			</table>
		</td>
	</tr>
	<tr style="border:2px solid #72324a !important; margin:0px auto;">
		<td colspan=3 style="border:2px solid #72324a !important; margin:0px auto; border-radius: 10px;">
			<table style="width:100%;  border-collapse: collapse; border: 0px;">
				<?php $total_art=count($orden_data['orden_detalle'])?>
				<?php foreach($orden_data['orden_detalle'] as $key => $item):?>
					<?php $importe_total+= floatval($item['artVenta'] * $item['artCant']);?>
					<tr style="border:1px solid #72324a !important;text-align:center; font-size:20px;">
						<td style="width:10%; border-left: 0px !important; border-bottom: 1px dotted #72324a !important; margin:0px; padding: 10px ;"><?php echo  $item['artCant']?> </td>
						<td style="width:75%; border-left: 2px solid #72324a !important; border-bottom: 1px dotted #72324a !important; margin:0px; padding:  10px;"><?php echo  $item['artDescripcion']?> </td>
						<td style="width:15%; border-left: 2px solid #72324a !important; border-bottom: 1px dotted #72324a !important; margin:0px; padding:  10px;"><?php echo  $item['artVenta'] * $item['artCant']?> </td>
					</tr>
				<?php endforeach;?>
				<?php for($i=($total_art);  $i<=12; $i++):?>
					<tr style="border:1px solid #72324a !important;">
						<td style="width:10%; border-left: 0px !important; border-bottom: 1px dotted #72324a !important; margin:0px; padding: 20px;"> </td>
						<td style="width:75%; border-left: 2px solid #72324a !important; border-bottom: 1px dotted #72324a !important; margin:0px; padding: 20px;"> </td>
						<td style="width:15%; border-left: 2px solid #72324a !important; border-bottom: 1px dotted #72324a !important; margin:0px; padding: 20px;"> </td>
					</tr>
				<?php endfor;?>
			</table>
		</td>
	</tr>
	<tr style="border:2px solid #72324a !important; margin:0px auto;">
		<td colspan="2" style="font-size:40px; text-align:right; padding: 10px;">
			$
		</td>
		<td colspan="1" style="border:2px solid #72324a !important; margin:0px auto; padding: 10px;border-radius: 10px; text-align:right; font-size:23px; color:#000000;">
		 <?php echo $importe_total?>
		</td>
	</tr>
</table>
