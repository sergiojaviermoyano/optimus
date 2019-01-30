<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class vendedor extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Vendedores');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = $this->Vendedores->List_Vendeores();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('vendedor/list', $data, true));
	}

	public function getVendedor(){
		$data['data'] = $this->Vendedores->getVendedor($this->input->post());
		$response['html'] = $this->load->view('vendedor/view_', $data, true);
		echo json_encode($response);
	}

	public function setVendedor(){
		$data = $this->Vendedores->setVendedor($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);
		}
	}

	public function getActiveVendedores(){
		$data = $this->Vendedores->getActiveVendedores();
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode($data);
		}
	}

}
