<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prima extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('prima_model');
	}

	public function index()
	{
		if($this->_check_session()){

			$data['content'] = $this->load->view('prima/calculo_dias','',true);
			$data['prima'] = TRUE;
			$data['styles'] = array('prima','bootstrap.min');
			$data['scripts'] = array('bootstrap.min');
	        $this->load->view('template',$data);
		}		
	}

	public function calculo_dias()
	{
		$this->_check_session();

			$data['content'] = $this->load->view('prima/calculo_dias','',true);
			$data['prima'] = TRUE;
			$data['styles'] = array('prima','bootstrap.min');
			$data['scripts'] = array('bootstrap.min');
	        $this->load->view('template',$data);
		
	}

	public function calculo_prima()
	{
		$this->_check_session();

			$patron = 'B4734780108';
		if(!empty($_POST)){
			echo "<pre>";
			//print_r($this->prima_model->get_afiliados($patron));	
			echo "</pre>";
			$calculos = array();
			$data['calculos'] = $calculos;
		}
		else
			if($patron){
				$patron = $this->prima_model->get_patron($patron);
				$content_data['patron'] = $patron[0];
			}

		$content_data['patrones'] = $this->prima_model->get_patrones($this->session->userdata('id'),'REG_PAT');

			$data['content'] = $this->load->view('prima/calculo_prima',$content_data,true);
			$data['prima'] = TRUE;
			$data['styles'] = array('prima','bootstrap.min');
			$data['scripts'] = array('bootstrap.min');
	        $this->load->view('template',$data);
		
	}

	public function reportes()
	{
		$this->_check_session();
		
			$data['content'] = $this->load->view('prima/reportes','',true);
			$data['prima'] = TRUE;
			$data['styles'] = array('prima','bootstrap.min');
			$data['scripts'] = array('bootstrap.min');
	        $this->load->view('template',$data);
		
	}

	private function _check_session()
	{		
		if($this->session->userdata('loggedIn'))
				return TRUE;
		
		$this->redirect('login','refresh');
	}

	private function _prima_rt($patron = 0){
		
		if($patron){			
			return array('prima'=>'','dias'=>'');
		}
		return null;
	}
}