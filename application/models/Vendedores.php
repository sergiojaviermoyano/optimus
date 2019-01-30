<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vendedores extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	function List_Vendeores(){
		$this->db->from('vendedores');
		$this->db->order_by('nombre', 'asc');
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

	function getVendedor($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$action = $data['act'];
			$idVen = $data['id'];
			$data = array();

			//Datos del rubro
			$query= $this->db->get_where('vendedores',array('id'=>$idVen));
			if ($query->num_rows() != 0)
			{
				$c = $query->result_array();
				$data['vendedor'] = $c[0];

			} else {
				$art = array();
				$art['id'] = '';
				$art['codigo'] = '';
				$art['nombre'] = '';
				$art['estado'] = '';
				$data['vendedor'] = $art;
			}
			$data['vendedor']['action'] = $action;

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

	function setVendedor($data = null){
		if($data == null)
		{
			return false;
		}
		else
		{
			$id 	= $data['id'];
						$act 	= $data['act'];
						$name 	= $data['name'];
						$status = $data['status'];
						$code = $data['code'];

			$data = array(
					 'codigo' 				=> $code,
					 'nombre'					=> $name,
					 'estado'					=> $status
				);

			switch($act){
				case 'Add':
					//Agregar Vendedor
					if($this->db->insert('vendedores', $data) == false) {
						return false;
					}
					break;

				 case 'Edit':
					//Actualizar vendedor
					if($this->db->update('vendedores', $data, array('id'=>$id)) == false) {
						return false;
					}
					break;

				 case 'Del':
					//Eliminar Vendedor
					if($this->db->delete('vendedores', array('id'=>$id)) == false) {
						return false;
					}
					break;

			}
			return true;

		}
	}


	function getActiveVendedores(){
		$this->db->select('*');
		$this->db->from('vendedores');
		$this->db->order_by('nombre', 'asc');
    $this->db->where('estado', 'AC');
		$query= $this->db->get();

		return $query->result_array();
	}

}
?>
