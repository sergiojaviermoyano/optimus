<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class box extends CI_Controller {

	function __construct()
        {
		parent::__construct();
		//$this->load->model('Boxs');
		$this->Users->updateSession(true);
	}

	//Utilizado para conectar con el modulo fiscal de indev
	public function facturar(){
		echo json_encode(  );
	}
}
