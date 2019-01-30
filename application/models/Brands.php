<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Brands extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function Brand_list(){
		$this->db->from('marcaart');
		$this->db->order_by('descripcion', 'asc');
		$query = $this->db->get();

		if ($query->num_rows()!=0)
		{
			return $query->result_array();
		}
		else
		{
			return false;
		}
	}

	function getBrand($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$idBrand = $data['id'];
			$data = array();

			//Datos de la marca
			$query= $this->db->get_where('marcaart',array('id'=>$idBrand));
			if ($query->num_rows() != 0)
			{
				$c = $query->result_array();
				$data['brand'] = $c[0];

			} else {
				$bra = array();
				$bra['id'] = '';
				$bra['descripcion'] = '';
				$data['brand'] = $bra;
			}
			$data['brand']['action'] = $action;

			//Readonly
			$readonly = false;
			if($action == 'Del' || $action == 'View'){
				$readonly = true;
			}
			$data['read'] = $readonly;
			$data['action'] = $action;

			return $data;
		}
	}

	function setBrand($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id 	= $data['id'];
            $act 	= $data['act'];
            $name 	= $data['name'];

			$data = array(
				   'descripcion' 				=> $name
				);

			switch($act){
				case 'Add':
					//Agregar Marca
					if($this->db->insert('marcaart', $data) == false) {
						return false;
					}
					break;

				 case 'Edit':
				 	//Actualizar marca
				 	if($this->db->update('marcaart', $data, array('id'=>$id)) == false) {
				 		return false;
				 	}
				 	break;

				 case 'Del':
				 	//Eliminar Marca
				 	if($this->db->delete('marcaart', array('id'=>$id)) == false) {
				 		return false;
				 	}
				 	break;

			}
			return true;

		}
	}
}
