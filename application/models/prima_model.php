<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prima_model extends CI_Model {

	public function get_patron($registro_patronal = ''){
		return $this->db->select('*')->from('patron')->where('REG_PAT',$registro_patronal)->get()->result();
	}

	public function get_patrones($id_usuario = '',$fields = '*'){

		return $this->db->select($fields)->from('patron')->where('ID_USER',$id_usuario)->get()->result();
	}

	public function get_afiliados($registro_patronal = ''){
		return $this->db->select('*')->from('afiliacion')->where('REG_PATR',$registro_patronal)->get()->result();
	}

}