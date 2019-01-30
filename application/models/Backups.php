<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Backups extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	
	function Backup_List(){

		$query= $this->db->get('sisgroups');
		//var_dump($query);
		
		if ($query->num_rows()!=0)
		{
			return $query->result_array();	
		}
		else
		{
			return false;
		}
	}

	function Backup_Generate(){
		$this->load->dbutil();

		// Crea una copia de seguridad de toda la base de datos y la asigna a una variable
		$copia_de_seguridad = &$this->dbutil->backup(); 

		// Carga el asistente de archivos y escribe el archivo en su servidor
		$this->load->helper('file');
		write_file('assets/backs/db-backup-last.gz', $copia_de_seguridad); 

		// Carga el asistente de descarga y envía el archivo a su escritorio
		//$this->load->helper('download');
		//force_download('copia_de_seguridad.gz', $copia_de_seguridad);

		return true;
	}

	function importar($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$querys	= $data['query'];
            
            $response[] = array();
            $response['queryError'] = array(); 
            $response['rowInserted'] = 0; 
            $response['rowUpdated'] = 0; 

            $queryArray = explode('~~', $querys);
            $rowInserted = 0;
            $rowUpdated = 0;
            //Recorrer uno por uno e insertar, si no inserta, hacer el update
            foreach ($queryArray as $row) {
            	if($row != ''){
            		try{
            			//Primero el insert de rubros , despues update de subrubos, luego update de marcas y al final insert de articulos
            			if(!$this->db->simple_query($row)){
            				//Registro para actualizar rubros
            				if (strpos($row, "INSERT INTO `rubros` ") !== false) {
            					$rowItem = explode(') VALUES (', $row);
							 	$rowItem = str_replace(');', '', $rowItem[1]);
							 	$rowItem = explode(',', $rowItem);
							 	$data = array(
											   	//'rubId'						=> $code,
											   	'rubDescripcion' 				=> str_replace('\'', '', $rowItem[1]),
											   	'rubEstado'						=> str_replace(' ', '', (str_replace('\'', '', $rowItem[2])))
											);
							 	if($this->db->update('rubros', $data, array('rubId'=>$rowItem[0])) == false) {
							 		$response['queryError'][] = 'Rubro: '.$rowItem[1].'('.$rowItem[0].')';
							 	} else {
							 		$response['rowUpdated']++;
							 	}
            				}
            				//-----------------------------------------
            				//Registro para actualizar sub rubros
            				if (strpos($row, "INSERT INTO `subrubros` ") !== false) {
            					$rowItem = explode(') VALUES (', $row);
							 	$rowItem = str_replace(');', '', $rowItem[1]);
							 	$rowItem = explode(',', $rowItem);
							 	$data = array(
											   	//'subrId'						=> $code,
											   	'subrDescripcion' 				=> str_replace('\'', '', $rowItem[1]),
											   	'rubId'			 				=> str_replace('\'', '', $rowItem[2]),
											   	'subrEstado'					=> str_replace(' ', '', (str_replace('\'', '', $rowItem[3])))
											);
							 	if($this->db->update('subrubros', $data, array('subrId'=>$rowItem[0])) == false) {
							 		$response['queryError'][] = 'SubRubro: '.$rowItem[1].'('.$rowItem[0].')';
							 	} else {
							 		$response['rowUpdated']++;
							 	}
            				}
							//-----------------------------------------
							//Registro para actualizar marcas
							if (strpos($row, "INSERT INTO `marcaart` ") !== false) {
            					$rowItem = explode(') VALUES (', $row);
							 	$rowItem = str_replace(');', '', $rowItem[1]);
							 	$rowItem = explode(',', $rowItem);
							 	$data = array(
											   	//'id'						=> $code,
											   	'descripcion' 				=> $rowItem[1],
											);
							 	if($this->db->update('marcaart', $data, array('id'=>$rowItem[0])) == false) {
							 		$response['queryError'][] = 'marca: '.$rowItem[1].'('.$rowItem[0].')';
							 	} else {
							 		$response['rowUpdated']++;
							 	}
            				}
							//-----------------------------------------
            				//Registro para actualizar Artículos;
            				if (strpos($row, "INSERT INTO `articles`") !== false) {
							 	$rowItem = explode(') VALUES (', $row);
							 	$rowItem = str_replace(');', '', $rowItem[1]);
							 	$rowItem = explode(',', $rowItem);
							 	$data = array(
											   	//'artBarCode'					=> $code,
											   	'artDescription' 				=> str_replace('\'', '', $rowItem[1]),
											   	'artCoste'						=> trim(str_replace('\'', '', $rowItem[2])),
											   	'artMarginMinorista'			=> trim(str_replace('\'', '', $rowItem[3])),
											   	'artMarginMinoristaIsPorcent' 	=> (int)trim(str_replace('\'', '', $rowItem[4])),
											   	'artEstado' 					=> str_replace(' ', '', (str_replace('\'', '', $rowItem[5]))),
												'artMinimo'						=> trim(str_replace('\'', '', $rowItem[6])),
												'subrId'						=> trim(str_replace('\'', '', $rowItem[8])),
												'artMarginMayorista'			=> trim(str_replace('\'', '', $rowItem[9])),
												'artMarginMayoristaIsPorcent' 	=> (int)trim(str_replace('\'', '', $rowItem[10])),
												'artCosteIsDolar'				=> (int)trim(str_replace('\'', '', $rowItem[11])),
												'marcaId'						=> trim(str_replace('\'', '', $rowItem[12]))
											);

							 	//var_dump($data);

							 	if($this->db->update('articles', $data, array('artBarCode'=>str_replace('\'', '', $rowItem[0]))) == false) {
							 		$response['queryError'][] = 'Articulo: '.$rowItem[1].'('.$rowItem[0].')';
							 	} else {
							 		$response['rowUpdated']++;
							 	}
							 	//echo $this->db->last_query();
							}
            			} else {
            				//Registro insertado
            				$response['rowInserted']++;
            			}
            		}catch(Execption $e){
            			$response['queryError'][] = $e;
            		}
            	}
            }
            
			return $response;

		}
	}
}
?>