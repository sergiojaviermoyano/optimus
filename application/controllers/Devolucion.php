<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class devolucion extends CI_Controller {

	function __construct()
        {
		parent::__construct();
        $this->load->model('Devoluciones');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['permission'] = $permission;
		echo json_encode($this->load->view('devoluciones/list', $data, true));
    }
    
    public function datatable_devolucion(){
		$totalDevoluciones= $this->Devoluciones->getTotalDevoluciones($_REQUEST);
		$devoluciones= $this->Devoluciones->getDevolucion($_REQUEST);

		$response=array(
			'draw' => $_REQUEST['draw'],
			'recordsTotal' => $totalDevoluciones,
			'recordsFiltered' => $totalDevoluciones,
			'data' => $devoluciones
		);

		echo json_encode($response);

    }
    
    public function getDevolucion(){
        $data['data'] = $this->Devoluciones->getDevolucion_($this->input->post());
		$response['html'] = $this->load->view('devoluciones/view_', $data, true);
		echo json_encode($response);
    }

    public function getOrden(){
        $data = $this->Devoluciones->getOrder($this->input->post('id'));
        echo json_encode($data);
    }

    public function setDevolucion(){
        $data = $this->Devoluciones->setDevoluciones($this->input->post());
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