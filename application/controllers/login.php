<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

	public function Login() 
	{
		parent::__construct();
		$this->load->model('login_model');
	}

	public function index()
	{
		if(!$this->session->userdata('loggedIn'))
			$this->load->view('login/login');
		else
			$this->access();
	}

	public function access()
	{
		if($this->session->userdata('loggedIn'))
		{
			$array['content'] = $this->load->view('login/dashboard','',true);
	        $this->load->view('template',$array);
		}
		else
		{
			if($this->_check_password($this->input->post()))
			{
				$Data = $this->login_model->get_user_data($this->input->post('usuario'));
	            $data2['id'] = $Data['id'];
	            $data2['nombre'] = $Data['nombre'];
	            $data2['email'] = $Data['email'];
	            $data2['patron'] = 'B4734780108';
	            $data2['loggedIn'] = true;
	            $this->session->set_userdata($data2);
	            $array['content'] = $this->load->view('login/dashboard','',true);
	            $this->load->view('template',$array);
			}
			else
			{
				$array['message'] = 'Email o Contraseña invalidos';
				$this->load->view('login/login',$array);
			}
		}
	}

	private function _check_password($data)
	{
		$user_data = $this->login_model->get_user_data($data['usuario']);
		if(!empty($user_data))
			if($user_data['contrasena'] === sha1($this->config->item('encryption_key').$data['contrasena']))
				return TRUE;
		return FALSE;
	}

	public function logout() {
		$this->session->sess_destroy();
		$this->load->view('login/login');
	}
}