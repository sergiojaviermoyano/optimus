<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class brand extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Brands');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = $this->Brands->Brand_list();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('brands/list', $data, true));
	}

	public function getBrand(){
		$data['data'] = $this->Brands->getBrand($this->input->post());
		$response['html'] = $this->load->view('brands/view_', $data, true);
		echo json_encode($response);
	}

	public function setBrand(){
		$data = $this->Brands->setBrand($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);
		}
	}
}
