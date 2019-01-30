<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class sale extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		$this->load->model('Sales');
		$this->load->model('Lists');
		$this->load->model('Customers');
		$this->load->model('Vendedores');
		$this->load->model('Orders');
		$this->Users->updateSession(true);
	}

	public function minorista(){
		$data['lists'] = $this->Lists->List_List();
		$data['final'] = $this->Customers->DefaultCustomer();
		$data['vendedores'] = $this->Vendedores->getActiveVendedores();
		echo json_encode($this->load->view('sales/minorista', $data, true));
	}

	public function minoristaGet($oId){
		$data['lists'] = $this->Lists->List_List();
		$data['order'] = $this->Orders->getOrder($oId);
		$data['final'] = $this->Customers->CustomerById($data['order']['order']['cliId']);
		$data['vendedores'] = $this->Vendedores->getActiveVendedores();
		echo json_encode($this->load->view('sales/minoristaGet', $data, true));
	}

	public function setSaleMinorista(){
		echo json_encode($this->Sales->setSaleMinorista($this->input->post()));
	}

	public function mayorista(){
		$data['lists'] = $this->Lists->List_List();
		$data['final'] = $this->Customers->DefaultCustomer();
		$data['vendedores'] = $this->Vendedores->getActiveVendedores();
		echo json_encode($this->load->view('sales/mayorista', $data, true));
	}

	public function mayoristaGet($oId){
		$data['lists'] = $this->Lists->List_List();
		$data['order'] = $this->Orders->getOrder($oId);
		$data['final'] = $this->Customers->CustomerById($data['order']['order']['cliId']);
		$data['vendedores'] = $this->Vendedores->getActiveVendedores();
		echo json_encode($this->load->view('sales/mayoristaGet', $data, true));
	}

	public function setSaleMayorista(){
		echo json_encode($this->Sales->setSaleMayorista($this->input->post()));
	}

	public function preventa(){
		$data['lists'] = $this->Lists->List_List();
		$data['final'] = $this->Customers->DefaultCustomer();
		$data['vendedores'] = $this->Vendedores->getActiveVendedores();
		echo json_encode($this->load->view('sales/preventa', $data, true));
	}

	public function setSalePreventa(){
		echo json_encode($this->Sales->setSalePreventa($this->input->post()));
	}

	public function setSalePago(){
		echo json_encode($this->Sales->setSalePago($this->input->post()));
	}

	public function listado_minorista($permission){
		$data=array();
		$data['list'] = array();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('sales/listado_minorista', $data, true));
	}

	public function datatable_minorista(){
		$totalVentas= $this->Sales->getTotalSaleMinorista($_REQUEST);
		$ventas= $this->Sales->getSaleMinorista($_REQUEST);

		$response=array(
			'draw' => $_REQUEST['draw'],
			'recordsTotal' => $totalVentas,
			'recordsFiltered' => $totalVentas,
			'data' => $ventas
		);

		echo json_encode($response);

	}


	public function listado_mayorista($permission){
		$data=array();
		$data['list'] = array();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('sales/listado_mayorista', $data, true));
	}

	public function datatable_mayorista(){
		$totalVentas= $this->Sales->getTotalSaleMayorista($_REQUEST);
		$ventas= $this->Sales->getSaleMayorista($_REQUEST);

		$response=array(
			'draw' => $_REQUEST['draw'],
			'recordsTotal' => $totalVentas,
			'recordsFiltered' => $totalVentas,
			'data' => $ventas
		);

		echo json_encode($response);

	}

	public function listado_reserva($permission){
		$data=array();
		$data['list'] = array();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('sales/listado_reserva', $data, true));
	}

	public function datatable_reserva(){
		$totalVentas= $this->Sales->getTotalReservaFiltered($_REQUEST);
		$ventas= $this->Sales->getReservaFiltered($_REQUEST);

		$response=array(
			'draw' => $_REQUEST['draw'],
			'recordsTotal' => $totalVentas,
			'recordsFiltered' => $totalVentas,
			'data' => $ventas
		);

		echo json_encode($response);

	}


	public function printComprobante($id=0){
		echo json_encode($this->Sales->getSaleById($_REQUEST));
	}

	/*public function printComprobante(){
		$this->load->library('pdf');
		$data=array();
		$data['orden_data']=$this->Sales->getSaleById($_REQUEST);
		$file_pdf = $this->pdf->generate_pdf('sales/print_orden',$data);
		echo json_encode(array('result'=>true,'filename_url'=>$file_pdf));
	}*/


	public function detailComprobante(){
		$order_detail_output=$this->Sales->getReservaDetailHTML($_REQUEST);
		echo json_encode(array('html'=>$order_detail_output));
	}
}
