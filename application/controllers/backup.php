<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class backup extends CI_Controller {

	function __construct()
    {
		parent::__construct();
		$this->load->model('Backups');
		$this->load->model('Articles');
		$this->load->model('Rubros');
		$this->load->model('Brands');
		$this->Users->updateSession(true);
	}

	public function index($permission)
	{
		$data['list'] = null;//$this->Backups->Backup_List();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('backups/list', $data, true));
	}

	public function generate()
	{
		$data = $this->Backups->Backup_Generate();
		echo json_encode($data);
	}

	public function create_fullbackup(){
		$this->load->dbutil();
		$backup =$this->dbutil->backup();
		
		$this->load->helper('file');
		$fileName = 'afernandez_'.date('Y_m_d_Hmi').'.sql.zip';
		write_file(BACKUPFOLDER.'/'.$fileName, $backup);
		  
		$this->load->helper('download');
		force_download($fileName, $backup);
		exit(3);
	}

	public function update($permission)
	{
		$data['articles'] = $this->Articles->Articles_List();
		$data['rubros']	= $this->Rubros->Rubro_List();
		$data['subrubros'] = $this->Rubros->SubRubro_List();
		$data['marcas'] = $this->Brands->Brand_list();
		$data['permission'] = $permission;
		echo json_encode($this->load->view('backups/update', $data, true));
	}

	public function importar(){
		$data['data'] = $this->Backups->importar($this->input->post());
		echo json_encode($data);
	}
}