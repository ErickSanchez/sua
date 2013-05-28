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


		if(!empty($_POST['anio'])){
			$anio = $_POST['anio'];
			$calculos = $this->_casos_rt($this->session->userdata('patron'),$anio);
		}
		else
			$anio = date('Y')-1;

		$calculos['anio'] = $anio;
		$data['content'] = $this->load->view('prima/calculo_dias',$calculos,true);
		$data['prima'] = TRUE;
		$data['styles'] = array('prima','bootstrap.min');
		$data['scripts'] = array('bootstrap.min');
	    $this->load->view('template',$data);
		
	}

	private function _casos_rt($reg_pat = '', $anio = ''){

		$Total = 0;
	//Indice 0 = Total	1,2,3...Meses
	$Meses =array(0,0,0,0,0,0,0,0,0,0,0,0,0,0);	
		$Afiliado = $this->prima_model->get_dias_cotizables($reg_pat,$anio);
		$Dias_Sub = $this->prima_model->get_dias_sub($reg_pat,$anio,true);
		foreach ($Afiliado as  $dias) {
				$Dias  = 0;
					
						if($dias->Enero > 0){
							if($anio == $dias->A){
								if($dias->M == 1)
									$Dias = $dias->Enero+1; 
								else
									$Dias = 31; 
							}
							else
								$Dias = 31;
							$Meses[1] += $Dias;	
					 	   $Total += $Dias;
						}
						elseif($dias->Enero == 0){
						   $Meses[1] += 1;	
					 	   $Total += 1;
						}

					
						if($dias->Febrero > 0){
							if($anio == $dias->A){
								if($dias->M == 2)
									$Dias = $dias->Febrero+1; 
								else
									$Dias = $dias->DF; 
							}
							else
								$Dias = $dias->DF;

						   $Meses[2] += $Dias;	
					 	   $Total += $Dias;
						}
						elseif($dias->Febrero == 0){
						   $Meses[2] += 1;	
					 	   $Total += 1;
						}

						if($dias->Marzo > 0){
							if($anio == $dias->A){
								if($dias->M == 3)
									$Dias= $dias->Marzo+1; 
								else
									$Dias= 31; 
							}
							else
								$Dias = 31; 
						 
						     $Meses[3] += $Dias;	
					 	   $Total += $Dias;
					 	  }
					 	  elseif($dias->Marzo == 0){
						   $Meses[3] += 1;	
					 	   $Total += 1;
						}
						
						if($dias->Abril > 0){
							if($anio == $dias->A){
								if($dias->M == 4)
									$Dias = $dias->Abril+1; 
								else
									$Dias = 30; 
							}
							else
								$Dias = 30; 

						 	$Meses[4] += $Dias;	
					 	   $Total += $Dias;
						}
						elseif($dias->Abril == 0){
						   $Meses[4] += 1;	
					 	   $Total += 1;
						}
						
						if($dias->Mayo > 0){
							if($anio == $dias->A){
								if($dias->M == 5)
									$Dias = $dias->Mayo+1; 
								else
									$Dias = 31; 
							}
							else
								$Dias = 31; 
						   $Meses[5] += $Dias;	
					 	   $Total += $Dias;
						}
						elseif($dias->Mayo == 0){
						   $Meses[5] += 1;	
					 	   $Total += 1;
						}
						
						if($dias->Junio > 0){
							if($anio == $dias->A){						
								if($dias->M == 6){
									$Dias = $dias->Junio+1; 
								}
								else
									$Dias = 30; 
							}
							else
								$Dias = 30; 
						   $Meses[6] += $Dias;	
					 	   $Total += $Dias;	
						}
						elseif($dias->Junio == 0){
						   $Meses[6] += 1;	
					 	   $Total += 1;
						}

						if($dias->Julio > 0){
							if($anio == $dias->A){
								if($dias->M == 7)
									$Dias = $dias->Julio+1; 
								else
									$Dias = 31; 
							}
							else
								$Dias = 31; 
						   $Meses[7] += $Dias;	
					 	   $Total += $Dias;
						}
						elseif($dias->Julio == 0){
						   $Meses[7] += 1;	
					 	   $Total += 1;
						}
						
						if($dias->Agosto > 0){
							if($anio == $dias->A){
								if($dias->M == 8)
									$Dias = $dias->Agosto+1; 
								else
									$Dias = 31; 
							}
							else
								$Dias = 31; 
						   $Meses[8] += $Dias;	
					 	   $Total += $Dias;
						}
						elseif($dias->Agosto == 0){
						   $Meses[8] += 1;	
					 	   $Total += 1;
						}
						
						if($dias->Septiembre > 0){
							if($anio == $dias->A){
								if($dias->M == 9)
									$Dias = $dias->Septiembre+1; 
								else
									$Dias = 30; 
							}
							else
								$Dias = 30; 
						   $Meses[9] += $Dias;	
					 	   $Total += $Dias;
						}
						elseif($dias->Septiembre == 0){
						   $Meses[9] += 1;	
					 	   $Total += 1;
						}

						if($dias->Octubre > 0){
							if($anio == $dias->A){
								if($dias->M == 10)
									$Dias = $dias->Octubre+1; 
								else
									$Dias= 31; 
							}
							else
								$Dias = 31; 
							$Meses[10] += $Dias;	
					 	   $Total += $Dias;	
						}
						elseif($dias->Octubre == 0){
						   $Meses[10] += 1;	
					 	   $Total += 1;
						}
						
						if($dias->Noviembre > 0){
							if($anio == $dias->A){
								if($dias->M == 11)
									$Dias= $dias->Noviembre+1; 
								else
									$Dias= 30; 
							}
							else
								$Dias = 30; 
						   $Meses[11] += $Dias;	
					 	   $Total += $Dias;
						}
						elseif($dias->Noviembre == 0){
						   $Meses[11] += 1;	
					 	   $Total += 1;
						}
					
						if($dias->Diciembre > 0){
							if($anio == $dias->A){
								if($dias->M == 12)
									$Dias = $dias->Diciembre+1; 
								else
									$Dias= 31; 
							}
							else
								$Dias= 31; 				
							$Meses[12] += $Dias;	
					 	   $Total += $Dias;		
						}
						elseif($dias->Diciembre == 0){
						   $Meses[12] += 1;	
					 	   $Total += 1;
						}
				}
			$dias_subsidiados = 0;
				foreach ($Dias_Sub as $value) {
						$dias_subsidiados += $value->Dia_Sub;

						if($value->Dia_Sub){
							$d   =   ($value->DA + $value->Dia_Sub-1);
							$dif =   $d - $value->DF;		
							if( $d <= $value->DF ){
								$Meses[$value->MA] -= $value->Dia_Sub;
							}
							else{
								$Meses[$value->MA] -= $value->Dia_Sub - $dif;
								$Meses[$value->MA+1] -= $dif;
							}		
						}
				}
			
			if($Total != 0)
				return array('Meses'=>$Meses,'Total'=>$Total,'Dias_Subcidiados'=>$dias_subsidiados);

			return array();
	}

	public function calculo_prima(){
		$this->_check_session();

		if(!empty($_POST)){
			$calculos = array();
			$data['calculos'] = $calculos;
		}
		
		$anio = '2012';
			$patron = $this->_get_patron();	
			$data['title'] = $patron->REG_PAT.' :: '.$patron->NOM_PAT;
			$content_data['patron']	= $patron;

			$content_data['S']   = $this->prima_model->get_dias_sub($this->session->userdata('patron'),$anio);
			$content_data['V'] 	 = 28;
			$content_data['I']   = $this->prima_model->get_porcentajes($this->session->userdata('patron'));
			$content_data['D']   = $this->prima_model->get_defunciones($this->session->userdata('patron'));
			$content_data['F'] 	 = $this->prima_model->get_factor_prima();
			$content_data['M'] 	 = $this->prima_model->get_prima_minima();
			$content_data['N'] 	 = $this->prima_model->get_trabajadores($this->session->userdata('patron'));
			$content_data['RT']  = $this->prima_model->get_prima_rt($this->session->userdata('patron'));
			
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