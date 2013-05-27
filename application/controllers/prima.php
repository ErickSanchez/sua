<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prima extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('prima_model');
	}

	public function index(){
	}

	public function calculo_dias(){
		$this->_check_session();
		

		$patron = $this->_get_patron();	
		$data['title'] = $patron->REG_PAT.' :: '.$patron->NOM_PAT;
		$content_data['patron']	= $patron;

		$data['content'] = $this->load->view('prima/calculo_dias','',true);
		$data['prima'] = TRUE;
		$data['styles'] = array('prima','bootstrap.min');
		$data['scripts'] = array('bootstrap.min');
	    $this->load->view('template',$data);
		
	}

	public function calculo_prima(){
		$this->_check_session();

		if(!empty($_POST)){
			$calculos = array();
			$data['calculos'] = $calculos;
		}
		
			$patron = $this->_get_patron();	
			$data['title'] = $patron->REG_PAT.' :: '.$patron->NOM_PAT;
			$content_data['patron']	= $patron;

			$content_data['S'] = $this->prima_model->get_dias_sub($this->session->userdata('patron'));
			$content_data['V'] 	= 28;
			$content_data['I']  = $this->prima_model->get_porcentajes($this->session->userdata('patron'));
			$content_data['D']  = $this->prima_model->get_defunciones($this->session->userdata('patron'));
			$content_data['F'] 	= $this->prima_model->get_factor_prima();
			$content_data['M'] 	= $this->prima_model->get_prima_minima();
			$content_data['N'] 	= $this->prima_model->get_trabajadores($this->session->userdata('patron'));
			
			$content_data['patrones'] = $this->prima_model->get_patrones($this->session->userdata('id'),'REG_PAT');

			$data['content'] = $this->load->view('prima/calculo_prima',$content_data,true);
			$data['prima'] = TRUE;
			$data['styles'] = array('prima','bootstrap.min');
			$data['scripts'] = array('bootstrap.min');
	        $this->load->view('template',$data);
		
	}

	public function reportes(){
		$this->_check_session();
	
		$patron = $this->_get_patron();	
		$data['title'] = $patron->REG_PAT.' :: '.$patron->NOM_PAT;
		$content_data['patron']	= $patron;

		$data['content'] = $this->load->view('prima/reportes','',true);
		$data['prima'] = TRUE;
		$data['styles'] = array('prima','bootstrap.min');
		$data['scripts'] = array('bootstrap.min');
	    $this->load->view('template',$data);
		
	}
	private function _get_patron(){

		 $patron = $this->session->userdata('patron');
		if(!empty($patron)){
			$patron = $this->prima_model->get_patron($patron);
			if($patron){
				return $patron[0];
			}
		}
		redirect('','refresh');
	}
	private function _check_session(){		
		if($this->session->userdata('loggedIn'))
				return TRUE;
		redirect('login','refresh');
	}

	private function _prima_rt($patron = 0){
		
		if($patron){			
			return array('prima'=>'','dias'=>'');
		}
		return null;
	}
}