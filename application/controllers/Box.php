<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class box extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Boxs');
		$this->Users->updateSession(true);
	}

	/*Utilizado para cobranza y/o Pagos*/
	public function getMedios(){
		echo json_encode( $this->Boxs->getMedios() );
	}

	public function medios($permission){
		//$data['tipos'] = $this->Boxs->Tipos_List();
		$data['list'] = $this->Boxs->Medios_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('boxs/medios', $data, true));
	}

	public function getMedio(){
		$data['data'] = $this->Boxs->getMedio($this->input->post());
		$response['html'] = $this->load->view('boxs/mediosview', $data, true);

		echo json_encode($response);
	}
	
	public function setMedio(){
		$data = $this->Boxs->setMedio($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);	
		}
	}



	public function index($permission)
	{
		$data['list'] = $this->Boxs->Box_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('boxs/list', $data, true));
	}
/*
	public function pagination()
	{
		echo json_encode($this->Boxs->Box_List($this->input->post()));
	}

*/
	public function datatable_listing(){
		$totalRecords= $this->Boxs->getTotalBoxes($_REQUEST);
		$data= $this->Boxs->getBoxes($_REQUEST);

		$response=array(
			'draw' => $_REQUEST['draw'],
			'recordsTotal' => $totalRecords,
			'recordsFiltered' => count($data),
			'data' => $data
		);

		echo json_encode($response);

	}

	public function getBox(){
		$data['data'] = $this->Boxs->getBox($this->input->post());
		$response['html'] = $this->load->view('boxs/view_', $data, true);
		echo json_encode($response);
	}

	public function setBox(){
		$data = $this->Boxs->setBox($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);
		}
	}
	
	public function getRetiro(){
		$response['html'] = $this->load->view('boxs/retiro_', null, true);
		echo json_encode($response);
	}

	public function setRetiro(){
		$data = $this->Boxs->setRetiro($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);
		}
	}
	
	public function isOpenBox(){
		echo json_encode($this->Boxs->isOpenBox());
	}
	
	public function getRetiros(){
		$data['retiros'] = $this->Boxs->getRetiros($this->input->post());
		$response['html'] = $this->load->view('boxs/retiros_', $data, true);
		echo json_encode($response);
	}
	
	public function printBox(){
		echo json_encode($this->Boxs->printBox($this->input->post()));
	}
	/*
	public function getPagosOrden(){
		echo json_encode($this->Boxs->getPagosOrden($this->input->post()));
	}
	*/
}
