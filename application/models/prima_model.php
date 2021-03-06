<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prima_model extends CI_Model {

	public function get_patron($reg_pat = '	',$fields = '*'){
		return $this->db->select($fields)->from('patron')->where('REG_PAT',$reg_pat)->get()->result();
	}

	public function get_patrones($id_usuario = '',$reg_pat='',$fields = '*'){

		//return $this->db->select($fields)->from('patron')->where('ID_USER',$id_usuario)->get()->result();
		return $this->db->query("SELECT $fields FROM patron WHERE ID_USER='$id_usuario' AND REG_PAT!='$reg_pat'")->result();
	}

	public function get_afiliados($reg_pat = ''){
		return $this->db->select('*')->from('afiliacion')->where('REG_PATR',$reg_pat)->get()->result();
	}

	public function get_dias_sub($reg_pat = '',$anio = '2012',$field = false){

		if($field)
			$fields = " MONTH(Fec_Acc) AS MA,DAY(Fec_Acc)AS DA,DAY(LAST_DAY(Fec_Acc))AS DF,Dia_Sub ";
		else
			$fields = " SUM(Dia_Sub) AS S ";
		//select('sum(Dia_Sub)')->from('incapacidades')->where('Reg_Pat',$reg_pat)->get()->result();
		$S = $this->db->query("SELECT ".$fields." FROM incapacidades WHERE Reg_Pat='$reg_pat' AND YEAR(Fec_Acc)='$anio' AND Fec_Ter < NOW()");

		if($field)
			return $S->result();
		else
			if($S->num_rows){
				$S = $S->result();
				return $S[0]->S;
			}
		return 0;

	}
 public  function get_dias_cotizables($reg_pat = '', $anio = '2012'){
 	return $this->db->query("SELECT NUM_AFIL,YEAR(FEC_ALT) AS A,DAY(FEC_ALT) AS D , MONTH(FEC_ALT) AS M,DAY(LAST_DAY('$anio-2-21'))AS DF, DATEDIFF('".$anio."-1-31',`FEC_ALT`)  AS Enero, DATEDIFF(LAST_DAY('".$anio."-2-1'),`FEC_ALT`)  AS Febrero,	DATEDIFF('".$anio."-3-31',`FEC_ALT`)  AS Marzo, 
 											DATEDIFF('".$anio."-4-30',`FEC_ALT`)  AS Abril,	DATEDIFF('".$anio."-5-31',`FEC_ALT`)  AS Mayo, DATEDIFF('".$anio."-6-30 23:59:59',`FEC_ALT`)  AS Junio, DATEDIFF('".$anio."-7-31',`FEC_ALT`)  AS Julio,
 											DATEDIFF('".$anio."-8-31',`FEC_ALT`)  AS Agosto, DATEDIFF('".$anio."-9-30',`FEC_ALT`)  AS Septiembre,	DATEDIFF('".$anio."-10-31',`FEC_ALT`) AS Octubre, DATEDIFF('".$anio."-11-30',`FEC_ALT`) AS Noviembre,
 											DATEDIFF('".$anio."-12-31',`FEC_ALT`) AS Diciembre	FROM asegura WHERE `REG_PATR`='$reg_pat' AND $anio >= YEAR(FEC_ALT)")->result();
 }
	public function get_porcentajes($reg_pat = '',$anio = 0){
		//select('sum(Por_Inc)')->from('incapacidades')->where('Reg_Pat',$reg_pat)->get()->result();
		$I = $this->db->query("SELECT SUM(Por_Inc) AS I FROM incapacidades WHERE Reg_Pat='$reg_pat' AND YEAR(Fec_Ter) = '$anio' AND Fec_Ter <= NOW()");
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

	public function get_prima_rt($reg_pat = '',$anio = 0){
		$RT = $this->db->query("SELECT Ano,ValMes,Prima_Rt AS RT FROM prima_rt AS prt WHERE Reg_Pat= '$reg_pat' AND Ano <= $anio   ORDER BY Ano DESC LIMIT 1");
		if($RT->num_rows){
			$RT = $RT->result();
			return $RT[0]->RT;
		}
		return 0;
	}
	public function get_casos_rt($reg_pat = '',$anio = 0, $data = false){
		
		if($data)
			$sql = "SELECT Num_Afi,Tip_Rie,Dia_Sub,Por_Inc,Ind_Def,CONCAT(YEAR(Fec_Acc),'    ',MONTH(Fec_Acc),'    ',DAY(Fec_Acc)) AS inicio,CONCAT(YEAR(Fec_Ter),'    ',MONTH(Fec_Ter),'    ',DAY(Fec_Ter)) AS fin FROM incapacidades WHERE Reg_Pat='$reg_pat' AND YEAR(Fec_Ter) = '$anio' AND Fec_Ter <= NOW() AND Tip_Rie IS NOT NULL AND Tip_Rie != ''";
		else
			$sql = "SELECT DISTINCT Num_Afi FROM incapacidades WHERE Reg_Pat='$reg_pat' AND YEAR(Fec_Ter) = $anio AND Fec_Ter <= NOW() AND Tip_Rie IS NOT NULL AND Tip_Rie != ''";
		
		$caos_rt = $this->db->query($sql);

	if($data)		
		return $caos_rt->result();		
	else
		return $caos_rt->num_rows;		
}
public function get_data_Afiliado($num_afi = ''){
	return $this->db->query("SELECT NUM_AFIL,CURP,TMP_NOM FROM asegura WHERE NUM_AFIL = '$num_afi'")->row();
}
public function get_Num_Afiliacion($reg_pat = ''){
	return $this->db->query("SELECT NUM_AFIL,TMP_NOM FROM asegura WHERE REG_PATR = '$reg_pat'")->result();
}
	public function get_datos_inc($reg_pat,$num_afi,$inicio = '',$fin = '',$ramo = '1'){		
		$ramo_sql = '';
			if($ramo)
				$ramo_sql = " AND Ram_Seg LIKE '%".$ramo."%' ";

		return $this->db->query("SELECT Num_Afi,Ram_Seg,Tip_Rie,Secuela,Con_Inc,CONCAT(DAY(Fec_Acc),'/',MONTH(Fec_Acc),'/',YEAR(Fec_Acc)) AS Fecha, CONCAT(DAY(Fec_Acc),'/',MONTH(Fec_Acc),'/',YEAR(Fec_Acc)) AS FechaFin,Fec_Acc AS inicio,Fec_Ter AS fin ,Fol_Inc,Dia_Sub,Por_Inc,Ind_Def 
									FROM incapacidades 	WHERE REG_PAT='$reg_pat' AND Num_Afi='$num_afi' AND Fec_Acc >= '$inicio' AND Fec_Ter <= '$fin' ".$ramo_sql)->result();
	}
}