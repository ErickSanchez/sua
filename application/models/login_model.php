<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function get_user_data($usuario)
	{
		return $this->db->select('*')->from('usuarios')->where('usuario',$usuario)->get()->row_array();
	}
}