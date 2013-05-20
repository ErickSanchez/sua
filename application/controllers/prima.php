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
		if($this->_check_session())
		{
			$array['content'] = $this->load->view('prima/calculo_dias','',true);
			$array['prima'] = TRUE;
	        $this->load->view('template',$array);
		}
	}

	public function calculo_prima()
	{
		if($this->_check_session())
		{
			$array['content'] = $this->load->view('prima/calculo_prima','',true);
			$array['prima'] = TRUE;
	        $this->load->view('template',$array);
		}
	}

	public function reportes()
	{
		if($this->_check_session())
		{
			$array['content'] = $this->load->view('prima/reportes','',true);
			$array['prima'] = TRUE;
	        $this->load->view('template',$array);
		}
	}

	private function _check_session()
	{		
		if($this->session->userdata('loggedIn'))
				return TRUE;
		else
			$this->redirect('login','refresh');
	}
}