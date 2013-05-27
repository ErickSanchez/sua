<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prima_model extends CI_Model {

	public function get_patron($reg_pat = '	',$fields = '*'){
		return $this->db->select($fields)->from('patron')->where('REG_PAT',$reg_pat)->get()->result();
	}

	public function get_patrones($id_usuario = '',$fields = '*'){

		return $this->db->select($fields)->from('patron')->where('ID_USER',$id_usuario)->get()->result();
	}

	public function get_afiliados($reg_pat = ''){
		return $this->db->select('*')->from('afiliacion')->where('REG_PATR',$reg_pat)->get()->result();
	}

	public function get_dias_sub($reg_pat = '',$fields = '*'){
		//select('sum(Dia_Sub)')->from('incapacidades')->where('Reg_Pat',$reg_pat)->get()->result();
		$S = $this->db->query("SELECT SUM(Dia_Sub) AS S FROM incapacidades WHERE Reg_Pat='$reg_pat'");

		if($S->num_rows){
			$S = $S->result();
			return $S[0]->S;
		}
		return 0;

	}

	public function get_porcentajes($reg_pat = ''){
		//select('sum(Por_Inc)')->from('incapacidades')->where('Reg_Pat',$reg_pat)->get()->result();
		$I = $this->db->query("SELECT SUM(Por_Inc) AS I FROM incapacidades WHERE Reg_Pat='$reg_pat'");
		if($I->num_rows){
			$I = $I->result();
			return $I[0]->I;
		}
		return 0;
	}
	public function get_defunciones($reg_pat = ''){
		$D = $this->db->query("SELECT COUNT(*) AS D FROM  incapacidades WHERE Reg_Pat='$reg_pat' AND Consecuencia=4");
		if($D->num_rows){
			$D = $D->result();
			return $D[0]->D;
		}
		return 0;
	}

	public function get_factor_prima($anio = ''){
		if(!$anio)
			$anio = date('Y');
		//select('*')->from('factor_prima')->where('Ano',$anio)->get()->result();
		$F = $this->db->query("SELECT Factor_Si AS F FROM factor_prima WHERE Ano='$anio'");
		if($F->num_rows){
			$F = $F->result();
			return $F[0]->F;
		}
		return 0;
	}
	public function get_prima_minima($anio = ''){
		if(!$anio)
			$anio = date('Y');
		//select('*')->from('factor_prima')->where('Ano',$anio)->get()->result();
		$M = $this->db->query("SELECT Prima_Minima AS M FROM prima_minima WHERE Ano='$anio'");
		if($M->num_rows){
			$M = $M->result();
			return $M[0]->M;
		}
		return 0;
	}
	public function get_trabajadores($reg_pat = ''){
		return $this->db->query("SELECT DISTINCT Num_Afi FROM incapacidades WHERE Reg_Pat='$reg_pat'")->num_rows;
		
	}	
}