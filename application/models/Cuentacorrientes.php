<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cuentacorrientes extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function getCtaCteP($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$prvId = $data['prvId'];
			$result= array();

			$this->db->select('cuentacorrienteproveedor.*, sisusers.usrNick');
			$this->db->from('cuentacorrienteproveedor');
			$this->db->join('sisusers', 'sisusers.usrId = cuentacorrienteproveedor.usrId');
			$this->db->where(array('prvId' => $prvId));
			$this->db->order_by('cuentacorrienteproveedor.cctepfecha', 'desc');
			$query = $this->db->get();

			$result['data'] = $query->result_array();
			//var_dump($result['data']);
			return $result;
		}
	}

	function setCtaCteP($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$prvId 	= $data['prvId'];
            $cpto 	= $data['cpto'];
			$impte 	= $data['impte'];

			$userdata = $this->session->userdata('user_data');

			//Datos de la caja
			$this->db->select('*');
			$this->db->where(array('cajaCierre'=>null));
			$this->db->from('cajas');
			$query = $this->db->get();
			$result = $query->result_array();
			if(count($result) > 0){
				$result = $query->result_array();
				$cajaId = $result[0]['cajaId'];
			} else {
				$cajaId = null;
			}

			$ctacte = array(
					'cctepConcepto'		=>	$cpto,
					'cctepTipo'			=>	'MN',
					'cctepDebe'			=>	$impte < 0 ? $impte * -1 : 0,
					'cctepHaber'		=>	$impte > 0 ? $impte : 0,
					'cctepFecha'		=> 	date("Y-m-d H:i:s"),
					'prvId'				=> 	$prvId,
					'usrId'				=>	$userdata[0]['usrId'],
					'cajaId'			=> 	$impte > 0 ? $cajaId : null
				);

			if($this->db->insert('cuentacorrienteproveedor', $ctacte) == false) {
				return false;
			}

			return true;
		}
	}

	//Clientes
	function getCtaCteC($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$cliId = $data['cliId'];
			$result= array();

			$this->db->select('cuentacorrientecliente.*, sisusers.usrNick');
			$this->db->from('cuentacorrientecliente');
			$this->db->join('sisusers', 'sisusers.usrId = cuentacorrientecliente.usrId');
			$this->db->where(array('cliId' => $cliId));
			$this->db->order_by('cuentacorrientecliente.cctepfecha', 'desc');
			$query = $this->db->get();

			$result['data'] = $query->result_array();

			return $result;
		}
	}

	function setCtaCteC($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$cliId 	= $data['cliId'];
            $cpto 	= $data['cpto'];
			$impte 	= $data['impte'];

			$userdata = $this->session->userdata('user_data');

			//Datos de la caja
			$this->db->select('*');
			$this->db->where(array('cajaCierre'=>null));
			$this->db->from('cajas');
			$query = $this->db->get();
			$result = $query->result_array();
			if(count($result) > 0){
				$result = $query->result_array();
				$cajaId = $result[0]['cajaId'];
			} else {
				$cajaId = null;
			}

			$ctacte = array(
					'cctepConcepto'		=>	$cpto,
					'cctepTipo'			=>	'MN',
					'cctepDebe'			=>	$impte < 0 ? $impte * -1 : 0,
					'cctepHaber'		=>	$impte > 0 ? $impte : 0,
					'cliId'				=> 	$cliId,
					'usrId'				=>	$userdata[0]['usrId'],
					'cajaId'			=> 	$impte > 0 ? $cajaId : null
				);

			if($this->db->insert('cuentacorrientecliente', $ctacte) == false) {
				return false;
			}

			return true;
		}
	}

	function printRecibo($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$this->db->select('cuentacorrientecliente.*, clientes.cliNombre, clientes.cliApellido');
			$this->db->from('cuentacorrientecliente');
			$this->db->join('clientes', 'clientes.cliId = cuentacorrientecliente.cliId');
			$this->db->where(array('cctepId' => $data['id']));
			$query = $this->db->get();

			$recibo = str_pad($data['id'], 6, "0", STR_PAD_LEFT);
			if($query->num_rows()>0){
				$c = $query->result_array();
				$move = $c[0];


			}else{
				return false;
			}

			$html = '<!DOCTYPE html>
			<html lang="es">
			<head>
			    <meta charset="utf-8">
			    <title>Comprobante '.$data['id'].'</title>
			    <style type="text/css">
		      	#watermark {
		      			opacity: .3;
		      			background-repeat:no-repeat;
						background-position: center center;
		      			background-image: url(\'assets/images/logoEmpresa.png\');
					}
				#watermark2 {
		      			opacity: .3;
		      			background-repeat:no-repeat;
						background-position: center center;
		      			background-image: url(\'assets/images/logoEmpresa.png\');
					}
		    </style>
		    </head>
		    	<div id="watermark">';
			$html .= '<table width="100%" style="font-family: Source Sans Pro ,sans-serif; font-size: 16px;">';
			$html .= '	<tr style="font-size: 25px; text-align: center;">
							<td style="text-align: left; width:50%;">
								<b>'.Globals::getTitle().' '.Globals::getTitle2().'</b><br>
								<span style="font-size: 20px">Recibo</span>
							</td>
							<td>
								N°: <strong>'.$recibo.'</strong>
							</td>
						</tr>
						<tr>
							<td colspan="2"><hr></td>
						</tr>
						<tr>
							<td colspan="2">';
							$importe = 0;
							$dateTime = explode(' ', $move['cctepFecha']);
							$date = explode('-', $dateTime[0]);
							$html.= 'En San Juan a los '.str_pad($date[2], 2, "0", STR_PAD_LEFT).' días del mes de '.$this->getMonth($date[1]).' de '.$date[0].', ';
							if($move['cctepHaber'] != null && $move['cctepHaber'] > 0){
								//Pago
								$html .= 'recibí de <strong>'.$move['cliApellido'].' '.$move['cliNombre'].'</strong> la suma de <strong> $'.number_format($move['cctepHaber'], 2, ',', '.').'.</strong> (pesos '.$this->convertNumber($move['cctepHaber']).').<br>';
								$importe = number_format($move['cctepHaber'], 2, ',', '.');
							}else{
								//Deuda
								$html .= 'se genero deuda a <strong>'.$move['cliApellido'].' '.$move['cliNombre'].'</strong> por la suma de <strong> $'.number_format($move['cctepDebe'], 2, ',', '.').'.</strong> (pesos '.$this->convertNumber($move['cctepDebe']).').<br>';
								$importe = number_format($move['cctepDebe'], 2, ',', '.');
							}
							$html .= 'En concepto de <strong>'.$move['cctepConcepto'].'.</strong>';
			$html .= 		'</td>
						</tr>';
			$html .= 	'<tr>
							<td><br><br>
								<hr>
							</td>
							<td style="text-align: right;">
								Son: <strong style="font-size: 20px; text-align: center;">$'.$importe.'</strong>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="font-size: 10px; text-align: center;">
								<i>* Talón para el cliente.</i>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<br><br>
							</td>
						</tr>';
			$html .= '</table>
					 </div>';

			$html .= '<hr style="border:1px dotted gray;" >';

			$html .= '<div id="watermark2"><br><br>
						<table width="100%" style="font-family: Source Sans Pro ,sans-serif; font-size: 16px;">';
			$html .= '	<tr style="font-size: 25px; text-align: center;">
							<td style="text-align: left; width:50%;">
								<b>'.Globals::getTitle().' '.Globals::getTitle2().'</b><br>
								<span style="font-size: 20px">Recibo</span>
							</td>
							<td>
								N°: <strong>'.$recibo.'</strong>
							</td>
						</tr>
						<tr>
							<td colspan="2"><hr></td>
						</tr>
						<tr>
							<td colspan="2">';
							$importe = 0;
							$dateTime = explode(' ', $move['cctepFecha']);
							$date = explode('-', $dateTime[0]);
							$html.= 'En San Juan a los '.str_pad($date[2], 2, "0", STR_PAD_LEFT).' días del mes de '.$this->getMonth($date[1]).' de '.$date[0].', ';
							if($move['cctepHaber'] != null && $move['cctepHaber'] > 0){
								//Pago
								$html .= 'recibí de <strong>'.$move['cliApellido'].' '.$move['cliNombre'].'</strong> la suma de <strong> $'.number_format($move['cctepHaber'], 2, ',', '.').'.</strong> (pesos '.$this->convertNumber($move['cctepHaber']).').<br>';
								$importe = number_format($move['cctepHaber'], 2, ',', '.');
							}else{
								//Deuda
								$html .= 'se genero deuda a <strong>'.$move['cliApellido'].' '.$move['cliNombre'].'</strong> por la suma de <strong> $'.number_format($move['cctepDebe'], 2, ',', '.').'.</strong> (pesos '.$this->convertNumber($move['cctepDebe']).').<br>';
								$importe = number_format($move['cctepDebe'], 2, ',', '.');
							}
							$html .= 'En concepto de <strong>'.$move['cctepConcepto'].'.</strong>';
			$html .= 		'</td>
						</tr>';
			$html .= 	'<tr>
							<td><br><br>
								<hr>
							</td>
							<td style="text-align: right;">
								Son: <strong style="font-size: 20px; text-align: center;">$'.$importe.'</strong>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="font-size: 10px; text-align: center;">
								<i>* Talón para '.Globals::getTitle().' '.Globals::getTitle2().'.</i>
							</td>
						</tr>';
			$html .= '</table></div><br><hr style="border:1px dotted gray;" ';

			//se incluye la libreria de dompdf
			require_once("assets/plugin/HTMLtoPDF/dompdf/dompdf_config.inc.php");
			//se crea una nueva instancia al DOMPDF
			$dompdf = new DOMPDF();
			//se carga el codigo html
			$dompdf->load_html(utf8_decode($html));
			//aumentamos memoria del servidor si es necesario
			ini_set("memory_limit","300M");
			//Tamaño de la página y orientación
			$dompdf->set_paper('a4','portrait');
			//lanzamos a render
			$dompdf->render();
			//guardamos a PDF
			//$dompdf->stream("TrabajosPedndientes.pdf");
			$output = $dompdf->output();
			file_put_contents('assets/reports/'.$recibo.'.pdf', $output);

			//Eliminar archivos viejos ---------------
			$dir = opendir('assets/reports/');
			while($f = readdir($dir))
			{
				if((time()-filemtime('assets/reports/'.$f) > 3600*24*1) and !(is_dir('assets/reports/'.$f)))
				unlink('assets/reports/'.$f);
			}
			closedir($dir);
			//----------------------------------------
			return $recibo.'.pdf';
		}
	}

	function printReciboP($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$this->db->select('cuentacorrienteproveedor.*, proveedores.prvNombre, proveedores.prvApellido, proveedores.prvRazonSocial ');
			$this->db->from('cuentacorrienteproveedor');
			$this->db->join('proveedores', 'proveedores.prvId = cuentacorrienteproveedor.prvId');
			$this->db->where(array('cctepId' => $data['id']));
			$query = $this->db->get();

			$recibo = str_pad($data['id'], 6, "0", STR_PAD_LEFT);
			if($query->num_rows()>0){
				$c = $query->result_array();
				$move = $c[0];


			}else{
				return false;
			}

			$html = '<!DOCTYPE html>
			<html lang="es">
			<head>
			    <meta charset="utf-8">
			    <title>Comprobante '.$data['id'].'</title>
			    <style type="text/css">
		      	#watermark {
		      			opacity: .3;
		      			background-repeat:no-repeat;
						background-position: center center;
		      			background-image: url(\'assets/images/logoEmpresa.png\');
					}
				#watermark2 {
		      			opacity: .3;
		      			background-repeat:no-repeat;
						background-position: center center;
		      			background-image: url(\'assets/images/logoEmpresa.png\');
					}
		    </style>
		    </head>
		    	<div id="watermark">';
			$html .= '<table width="100%" style="font-family: Source Sans Pro ,sans-serif; font-size: 16px;">';
			$html .= '	<tr style="font-size: 25px; text-align: center;">
							<td style="text-align: left; width:50%;">
								<b>'.Globals::getTitle().' '.Globals::getTitle2().'</b><br>
								<span style="font-size: 20px">Recibo</span>
							</td>
							<td>
								N°: <strong>'.$recibo.'</strong>
							</td>
						</tr>
						<tr>
							<td colspan="2"><hr></td>
						</tr>
						<tr>
							<td colspan="2">';
							$importe = 0;
							$dateTime = explode(' ', $move['cctepFecha']);
							$date = explode('-', $dateTime[0]);
							$html.= 'En San Juan a los '.str_pad($date[2], 2, "0", STR_PAD_LEFT).' días del mes de '.$this->getMonth($date[1]).' de '.$date[0].', ';
							if($move['cctepHaber'] != null && $move['cctepHaber'] > 0){
								//Pago
								$html .= 'entregue a <strong>'.
									(
										($move['prvRazonSocial'] == '' || $move['prvRazonSocial'] == null)
										? ($move['prvApellido'].' '.$move['prvNombre'])
										: ($move['prvRazonSocial'].' ('.$move['prvApellido'].' '.$move['prvNombre'].')')
									).'</strong> la suma de <strong> $'.number_format($move['cctepHaber'], 2, ',', '.').'.</strong> (pesos '.$this->convertNumber($move['cctepHaber']).').<br>';
								$importe = number_format($move['cctepHaber'], 2, ',', '.');
							}else{
								//Deuda
								$html .= '<strong>'.Globals::getTitle().' '.Globals::getTitle2().'</strong> contrajo deuda con el proveedor <strong>'.
								(
									($move['prvRazonSocial'] == '' || $move['prvRazonSocial'] == null)
									? ($move['prvApellido'].' '.$move['prvNombre'])
									: ($move['prvRazonSocial'].' ('.$move['prvApellido'].' '.$move['prvNombre'].')')
								).'</strong> por la suma de <strong> $'.number_format($move['cctepDebe'], 2, ',', '.').'.</strong> (pesos '.$this->convertNumber($move['cctepDebe']).').<br>';
								$importe = number_format($move['cctepDebe'], 2, ',', '.');
							}
							$html .= 'En concepto de <strong>'.$move['cctepConcepto'].'.</strong>';
			$html .= 		'</td>
						</tr>';
			$html .= 	'<tr>
							<td><br><br>
								<hr>
							</td>
							<td style="text-align: right;">
								Son: <strong style="font-size: 20px; text-align: center;">$'.$importe.'</strong>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="font-size: 10px; text-align: center;">
								<i>* Talón para el Proveedor.</i>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<br><br>
							</td>
						</tr>';
			$html .= '</table>
					 </div>';

			$html .= '<hr style="border:1px dotted gray;" >';

			$html .= '<div id="watermark2"><br><br>
						<table width="100%" style="font-family: Source Sans Pro ,sans-serif; font-size: 16px;">';
			$html .= '	<tr style="font-size: 25px; text-align: center;">
							<td style="text-align: left; width:50%;">
								<b>'.Globals::getTitle().' '.Globals::getTitle2().'</b><br>
								<span style="font-size: 20px">Recibo</span>
							</td>
							<td>
								N°: <strong>'.$recibo.'</strong>
							</td>
						</tr>
						<tr>
							<td colspan="2"><hr></td>
						</tr>
						<tr>
							<td colspan="2">';
							$importe = 0;
							$dateTime = explode(' ', $move['cctepFecha']);
							$date = explode('-', $dateTime[0]);
							$html.= 'En San Juan a los '.str_pad($date[2], 2, "0", STR_PAD_LEFT).' días del mes de '.$this->getMonth($date[1]).' de '.$date[0].', ';
							if($move['cctepHaber'] != null && $move['cctepHaber'] > 0){
								//Pago
								$html .= 'entregue a <strong>'.
									(
										($move['prvRazonSocial'] == '' || $move['prvRazonSocial'] == null)
										? ($move['prvApellido'].' '.$move['prvNombre'])
										: ($move['prvRazonSocial'].' ('.$move['prvApellido'].' '.$move['prvNombre'].')')
									).'</strong> la suma de <strong> $'.number_format($move['cctepHaber'], 2, ',', '.').'.</strong> (pesos '.$this->convertNumber($move['cctepHaber']).').<br>';
								$importe = number_format($move['cctepHaber'], 2, ',', '.');
							}else{
								//Deuda
								$html .= '<strong>'.Globals::getTitle().' '.Globals::getTitle2().'</strong> contrajo deuda con el proveedor <strong>'.
								(
									($move['prvRazonSocial'] == '' || $move['prvRazonSocial'] == null)
									? ($move['prvApellido'].' '.$move['prvNombre'])
									: ($move['prvRazonSocial'].' ('.$move['prvApellido'].' '.$move['prvNombre'].')')
								).'</strong> por la suma de <strong> $'.number_format($move['cctepDebe'], 2, ',', '.').'.</strong> (pesos '.$this->convertNumber($move['cctepDebe']).').<br>';
								$importe = number_format($move['cctepDebe'], 2, ',', '.');
							}
							$html .= 'En concepto de <strong>'.$move['cctepConcepto'].'.</strong>';
			$html .= 		'</td>
						</tr>';
			$html .= 	'<tr>
							<td><br><br>
								<hr>
							</td>
							<td style="text-align: right;">
								Son: <strong style="font-size: 20px; text-align: center;">$'.$importe.'</strong>
							</td>
						</tr>
						<tr>
							<td colspan="2" style="font-size: 10px; text-align: center;">
								<i>* Talón para '.Globals::getTitle().' '.Globals::getTitle2().'.</i>
							</td>
						</tr>';
			$html .= '</table></div><br><hr style="border:1px dotted gray;" ';

			//se incluye la libreria de dompdf
			require_once("assets/plugin/HTMLtoPDF/dompdf/dompdf_config.inc.php");
			//se crea una nueva instancia al DOMPDF
			$dompdf = new DOMPDF();
			//se carga el codigo html
			$dompdf->load_html(utf8_decode($html));
			//aumentamos memoria del servidor si es necesario
			ini_set("memory_limit","300M");
			//Tamaño de la página y orientación
			$dompdf->set_paper('a4','portrait');
			//lanzamos a render
			$dompdf->render();
			//guardamos a PDF
			//$dompdf->stream("TrabajosPedndientes.pdf");
			$output = $dompdf->output();
			file_put_contents('assets/reports/'.$recibo.'.pdf', $output);

			//Eliminar archivos viejos ---------------
			$dir = opendir('assets/reports/');
			while($f = readdir($dir))
			{
				if((time()-filemtime('assets/reports/'.$f) > 3600*24*1) and !(is_dir('assets/reports/'.$f)))
				unlink('assets/reports/'.$f);
			}
			closedir($dir);
			//----------------------------------------
			return $recibo.'.pdf';
		}
	}

	function convertNumber($number)
	{
	    list($integer, $fraction) = explode(".", (string) $number);

	    $output = "";

	    if ($integer{0} == "-")
	    {
	        $output = "negative ";
	        $integer    = ltrim($integer, "-");
	    }
	    else if ($integer{0} == "+")
	    {
	        $output = "positive ";
	        $integer    = ltrim($integer, "+");
	    }

	    if ($integer{0} == "0")
	    {
	        $output .= "zero";
	    }
	    else
	    {
	        $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
	        $group   = rtrim(chunk_split($integer, 3, " "), " ");
	        $groups  = explode(" ", $group);

	        $groups2 = array();
	        foreach ($groups as $g)
	        {
	            $groups2[] = $this->convertThreeDigit($g{0}, $g{1}, $g{2});
	        }

	        for ($z = 0; $z < count($groups2); $z++)
	        {
	            if ($groups2[$z] != "")
	            {
	                $output .= $groups2[$z] . $this->convertGroup(11 - $z) . (
	                        $z < 11
	                        && !array_search('', array_slice($groups2, $z + 1, -1))
	                        && $groups2[11] != ''
	                        && $groups[11]{0} == '0'
	                            ? " and "
	                            : ", "
	                    );
	            }
	        }

	        $output = rtrim($output, ", ");
	    }

	    if ($fraction > 0)
	    {
	        $output .= " con ".$this->convertTwoDigit($fraction[0], $fraction[1])." centavos";

	        //for ($i = 0; $i < strlen($fraction); $i++)
	        //{
	        //    $output .= " " . $this->convertDigit($fraction{$i});
	        //}
	    }

	    return $output;
	}

	function convertGroup($index)
	{
	    switch ($index)
	    {
	        case 11:
	            return " decillón";
	        case 10:
	            return " nonillón";
	        case 9:
	            return " octillón";
	        case 8:
	            return " septillón";
	        case 7:
	            return " sextillón";
	        case 6:
	            return " quintrillón";
	        case 5:
	            return " quadrillón";
	        case 4:
	            return " trillón";
	        case 3:
	            return " billón";
	        case 2:
	            return " millón";
	        case 1:
	            return " mil";
	        case 0:
	            return "";
	    }
	}

	function convertThreeDigit($digit1, $digit2, $digit3)
	{
	    $buffer = "";
	    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
	    {
	        return "";
	    }

	    if ($digit1 != "0" )
	    {

	    	if($digit1 != "1" && $digit1 != "5" && $digit1 != "7" && $digit1 != "9")
	        	$buffer .= $this->convertDigit($digit1) . "cien";
	        else{
	        		switch($digit1)
	        		{
	        			case "1":
	        				$buffer .= "cien";
	        				break;
	        			case "5":
	        				$buffer .= "quinien";
	        				break;
	        			case "7":
	        				$buffer .= "setecien";
	        				break;
	        			case "9":
	        				$buffer .= "novecien";
	        				break;
	        		}
	        	}
	        if ($digit2 != "0" || $digit3 != "0")
	        {
	        	if($digit1 != "1")
		        	$buffer .= "tos ";
		        else
		        	$buffer .= "to ";
	        } else {
	        	$buffer .= "tos";
	        }
	    }

	    if ($digit2 != "0")
	    {
	        $buffer .= $this->convertTwoDigit($digit2, $digit3);
	    }
	    else if ($digit3 != "0")
	    {
	        $buffer .= $this->convertDigit($digit3);
	    }

	    return $buffer;
	}

	function convertTwoDigit($digit1, $digit2)
	{
	    if ($digit2 == "0")
	    {
	        switch ($digit1)
	        {
	            case "1":
	                return "diez";
	            case "2":
	                return "veinte";
	            case "3":
	                return "treinta";
	            case "4":
	                return "cuarenta";
	            case "5":
	                return "cincuenta";
	            case "6":
	                return "sesenta";
	            case "7":
	                return "setenta";
	            case "8":
	                return "ochenta";
	            case "9":
	                return "noventa";
	            case "0":
	            	return "cero";
	        }
	    } else if ($digit1 == "1")
	    {
	        switch ($digit2)
	        {
	            case "1":
	                return "once";
	            case "2":
	                return "doce";
	            case "3":
	                return "trece";
	            case "4":
	                return "catorce";
	            case "5":
	                return "quince";
	            case "6":
	                return "dieciséis";
	            case "7":
	                return "diecisiete";
	            case "8":
	                return "dieciocho";
	            case "9":
	                return "diecinueve";
	        }
	    } else if($digit1 == "0"){
	    	switch ($digit2)
	        {
	            case "1":
	                return "un";
	            case "2":
	                return "dos";
	            case "3":
	                return "tres";
	            case "4":
	                return "cuatro";
	            case "5":
	                return "cinco";
	            case "6":
	                return "seis";
	            case "7":
	                return "siete";
	            case "8":
	                return "ocho";
	            case "9":
	                return "nueve";
	            case "0":
	                return "cero";
	        }
	    } else
	    {
	        $temp = $this->convertDigit($digit2);
	        switch ($digit1)
	        {
	            case "2":
	                return "veinti$temp";
	            case "3":
	                return "treinta y $temp";
	            case "4":
	                return "cuarenta y $temp";
	            case "5":
	                return "cincuenta y $temp";
	            case "6":
	                return "sesenta y $temp";
	            case "7":
	                return "setenta y $temp";
	            case "8":
	                return "ochenta y $temp";
	            case "9":
	                return "noventa y $temp";
	        }
	    }
	}

	function convertDigit($digit)
	{
	    switch ($digit)
	    {
	        case "0":
	            return "cero";
	        case "1":
	            return "un";
	        case "2":
	            return "dos";
	        case "3":
	            return "tres";
	        case "4":
	            return "cuatro";
	        case "5":
	            return "cinco";
	        case "6":
	            return "séis";
	        case "7":
	            return "siete";
	        case "8":
	            return "ocho";
	        case "9":
	            return "nueve";
	    }
	}

	function getMonth($monthNumber){
    	switch ($monthNumber) {
    		case '01':
    			return 'Enero';
    			break;
    		case '02':
    			return 'Febrero';
    			break;
    		case '03':
    			return 'Marzo';
    			break;
    		case '04':
    			return 'Abril';
    			break;
    		case '05':
    			return 'Mayo';
    			break;
    		case '06':
    			return 'Junio';
    			break;
    		case '07':
    			return 'Julio';
    			break;
    		case '08':
    			return 'Agosto';
    			break;
    		case '09':
    			return 'Septiembre';
    			break;
    		case '10':
    			return 'Octubre';
    			break;
    		case '11':
    			return 'Noviembre';
    			break;
    		case '12':
    			return 'Diciembre';
    			break;

    		default:
    			return '-';
    			break;
    	}
    }
}
?>
