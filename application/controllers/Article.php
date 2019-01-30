<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class article extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Articles');
		$this->load->model('Rubros');
		$this->load->model('Brands');
		$this->load->model('IvaAliCuotas');

		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = array();//$this->Articles->Articles_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('articles/list', $data, true));
	}

	public function faltante($permission)
	{
		$data['list'] = $this->Articles->Articles_List_Stock();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('articles/listf', $data, true));
	}

  	public function listing(){

		$total=$this->Articles->getTotalArticles($_REQUEST);
		$result = $this->Articles->Articles_List_datatable($_REQUEST);

		$result=array(
			'draw'=>$_REQUEST['draw'],
			'recordsTotal'=>$total,
			'recordsFiltered'=>$total,
			'data'=>$result,
		);
		echo json_encode($result);
	}
	public function getArticle(){

		$rubros=$this->Rubros->Rubro_List();
		$marcas=$this->Brands->Brand_list();

		$ivaAliCuotas=$this->IvaAliCuotas->Iva_List();
		$data['rubros']=$rubros;
		$data['marcas']=$marcas;
		$data['ivaAliCuotas']=$ivaAliCuotas;
		$data['data'] = $this->Articles->getArticle($this->input->post());
		$response['html'] = $this->load->view('articles/view_', $data, true);

		echo json_encode($response);
	}

	public function setArticle(){
		$data = $this->Articles->setArticle($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);
		}
	}

	public function buscadorArticlesNoPrice() {
		$data = $this->Articles->buscadorArticlesNoPrice($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode($data);
		}
	}

	public function getArticleJson(){
		echo json_encode($this->Articles->getArticleJson($this->input->post()));
	}

	public function getArticleJsonMayorista(){
		echo json_encode($this->Articles->getArticleJsonMayorista($this->input->post()));
	}

	public function validateArticle(){
		$data = $this->Articles->validateArticle($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);
		}
	}

	public function buscadorArticlesPrice() {
		$data = $this->Articles->buscadorArticlesPrice($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode($data);
		}
	}

	public function buscadorArticlesPriceMayorista() {
		$data = $this->Articles->buscadorArticlesPriceMayorista($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode($data);
		}
	}

	/*
	public function searchByCode() {
		$data = $this->Articles->searchByCode($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode($data);
		}
	}

	public function searchByAll() {

		$data = $this->Articles->searchByAll($this->input->post());

		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode($data);
		}
	}
*/
	public function update_prices_by_rubro(){
		$data=$this->Articles->update_prices_by_rubro($this->input->post());
		if($data  == false)
		{
			echo json_encode(false);
		}
		else
		{
			echo json_encode(true);
		}
	}

	public function information__($permission)
	{
		$data['list'] = array();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('articles/sales', $data, true));
	}

	public function get_for_update_prices_by_rubro(){
		$data=$this->Articles->get_for_update_prices($this->input->post());
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
