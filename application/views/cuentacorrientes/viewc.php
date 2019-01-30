<section class="content">
  <div class="row">
    <div class="col-xs-9">
      <div class="box-body">
      <table id="credit" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>N°</th>
          	<th>Fecha</th>
            <th>Concepto</th>
            <th>Debe</th>
            <th>Haber</th>
            <th>Usuario</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
	      <?php 
	      $debe = 0;
	      $haber = 0;
	      foreach ($data['data'] as $m) {
	      	echo '<tr>';
          echo '<td>'.$m['cctepId'].'</td>';
	      	echo '<td style="text-align:center; width: 100px;">'.date_format(date_create($m['cctepFecha']), 'd-m-Y').'</td>';
	      	echo '<td '.($m['cctepTipo'] == 'VN' ? 'onClick="LoadRec('.$m['cctepRef'].')" style="cursor: pointer"' : '').'>'.$m['cctepConcepto'].'</td>';
	      	echo '<td style="text-align:right">'.number_format ( $m['cctepDebe'] , 2 , "," , "." ).'</td>';
	      	echo '<td style="text-align:right">'.number_format ( $m['cctepHaber'] , 2 , "," , "." ).'</td>';
          echo '<td style="text-align:center">'.$m['usrNick'].'</td>';
          echo '<td style="text-align:center">';
            if($m['cctepRef'] != null){
              //echo '<i class="fa fa-fw fa-print" style="color: #A4A4A4; cursor: pointer; margin-left: 15px;" onclick="Print('.$m['cctepRef'].')"></i>';
            } else {
              //
              echo '<i class="fa fa-fw fa-file-pdf-o" style="color: #3c8dbc ; cursor: pointer; margin-left: 15px;" onclick="PrintRecibo('.$m['cctepId'].')"></i>';
            }
            echo '</td>';
 
         echo '</tr>';
	      	$debe+= $m['cctepDebe'];
	      	$haber+= $m['cctepHaber'];
	      }
	      ?>
	    </tbody>
	  </table>
      </div>
  </div>
  <div class="col-xs-3" style="text-align: center">
  	<h2>Saldo : <strong style="color: <?php echo $debe - $haber > 0 ? 'red': 'green';?>"> <br><?php echo number_format ( ($debe - $haber) < 0 ? ($debe - $haber) * -1 : ($debe - $haber)  , 2 , "," , "." );?></strong></h2>
  </div>
 </div>