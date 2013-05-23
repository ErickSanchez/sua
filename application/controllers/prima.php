<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prima extends CI_Controller {

	public function __construct() {
		parent::__construct();
		//$this->load->model('prima_model');
	}

	public function index()
	{
		if($this->_check_session()){

			$data['content'] = $this->load->view('prima/calculo_dias','',true);
	        $this->load->view('template',$data);
		}		
	}

	public function calculo_dias()
	{
		$this->_check_session();

			$data['content'] = $this->load->view('prima/calculo_dias','',true);
			$data['prima'] = TRUE;
	        $this->load->view('template',$data);
		
	}

	public function calculo_prima()
	{
		$this->_check_session();
		

			$data['content'] = $this->load->view('prima/calculo_prima','',true);
			$data['prima'] = TRUE;
			$data['style'] = 'prima';
	        $this->load->view('template',$data);
		
	}

	public function reportes()
	{
		$this->_check_session();
		
			$data['content'] = $this->load->view('prima/reportes','',true);
			$data['prima'] = TRUE;
	        $this->load->view('template',$data);
		
	}

	private function _check_session()
	{		
		if($this->session->userdata('loggedIn'))
				return TRUE;
		
		$this->redirect('login','refresh');
	}
}