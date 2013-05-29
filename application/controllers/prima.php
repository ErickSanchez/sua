<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Prima extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('prima_model');
	}

	public function index(){

	}
	public function seleccionar(){
		$this->_check_session();

		$data['title'] = "Selecciona un Patron";		
		$D['patrones'] = $this->prima_model->get_patrones($this->session->userdata('id'),'','REG_PAT, NOM_PAT');
		$data['content'] = $this->load->view('prima/seleccionar',$D,TRUE);
		$data['styles'] = array('prima','bootstrap.min');
		$data['scripts'] = array('bootstrap.min');
		if(!empty($_POST['patron'])){
			$patron['patron'] = $_POST['patron'];
	        $this->session->set_userdata($patron);
	        redirect('prima/calculo_dias','refresh');
		}
	    $this->load->view('template',$data);		
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
	$Meses =array(0,0,0,0,0,0,0,0,0,0,0,0,0);	
		$afiliados = $this->prima_model->get_dias_cotizables($reg_pat,$anio);
		$Dias_Sub = $this->prima_model->get_dias_sub($reg_pat,$anio,true);
		foreach ($afiliados as  $afiliado) {
				$d  = 0;
					
						$d = $this->_calculo_Dias($anio,1,31,$afiliado->A,$afiliado->M,$afiliado->Enero);
						   $Meses[1] += $d;  $Total += $d;
						
						$d = $this->_calculo_Dias($anio,2,$afiliado->DF,$afiliado->A,$afiliado->M,$afiliado->Febrero);
						   $Meses[2] += $d;  $Total += $d;
						
						$d = $this->_calculo_Dias($anio,3,31,$afiliado->A,$afiliado->M,$afiliado->Marzo);
						   $Meses[3] += $d;  $Total += $d;
						
						$d = $this->_calculo_Dias($anio,4,30,$afiliado->A,$afiliado->M,$afiliado->Abril);
						   $Meses[4] += $d;  $Total += $d;
						
						$d = $this->_calculo_Dias($anio,5,31,$afiliado->A,$afiliado->M,$afiliado->Mayo);
						   $Meses[5] += $d;  $Total += $d;
						
						$d = $this->_calculo_Dias($anio,6,30,$afiliado->A,$afiliado->M,$afiliado->Junio);
						   $Meses[6] += $d;  $Total += $d;
						
						$d = $this->_calculo_Dias($anio,7,31,$afiliado->A,$afiliado->M,$afiliado->Julio);
						   $Meses[7] += $d;  $Total += $d;
						
						$d = $this->_calculo_Dias($anio,8,31,$afiliado->A,$afiliado->M,$afiliado->Agosto);
						   $Meses[8] += $d;  $Total += $d;
						
						$d = $this->_calculo_Dias($anio,9,30,$afiliado->A,$afiliado->M,$afiliado->Septiembre);
						   $Meses[9] += $d;  $Total += $d;
						
						$d = $this->_calculo_Dias($anio,10,31,$afiliado->A,$afiliado->M,$afiliado->Octubre);
						   $Meses[10] += $d;  $Total += $d;

						$d = $this->_calculo_Dias($anio,11,30,$afiliado->A,$afiliado->M,$afiliado->Noviembre);
						   $Meses[11] += $d;  $Total += $d;

						$d = $this->_calculo_Dias($anio,12,31,$afiliado->A,$afiliado->M,$afiliado->Diciembre);
						   $Meses[12] += $d;  $Total += $d;					
				}
				$S = 0;
				foreach ($Dias_Sub as $value) {
						$S += $value->Dia_Sub;
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
				return array('Meses'=>$Meses,'Total'=>$Total,'S'=>$S,'N'=> $this->_Decimal((($Total-$S)/365),1));
			return array();
	}
	private function _calculo_Dias($A = 0,$M= 0,$D = 0, $db_A = 0,$db_M = 0,$db_D = 0){
					$dias = 0;
					if($db_D > 0){
							if($A == $db_A){
								if($M == $db_M)
									$dias = $db_D+1; 
								else
									$dias= $D; 
							}
							else
								$dias= $D; 
						}
						elseif($db_D == 0)
						    $dias = 1;

					return $dias;
	}
	public function calculo_prima(){
		$this->_check_session();

		if(!empty($_POST)){
			$calculos = array();
			$data['calculos'] = $calculos;
		}
		
		
		$reg_pat = $this->session->userdata('patron');
			
		if(!empty($_POST['anio']))
			$anio = $_POST['anio'];
		else
		  $anio = date('Y')-1;

			$patron = $this->_get_patron();	
			$data['title'] = $patron->REG_PAT.' :: '.$patron->NOM_PAT;
			$D['Prima_Anterior']  = $this->_Decimal($this->prima_model->get_prima_rt($reg_pat,$anio),4);
			$D['patron']	= $patron;

		if(!empty($_POST['anio'])){			
			$D['V']   = 28;
			$D['M']   = $this->prima_model->get_prima_minima()/100;
			$D['DN']  = 365; 			
			
			$D['I']   = $this->prima_model->get_porcentajes($reg_pat,$anio)/100;
			$D['D']   = $this->prima_model->get_defunciones($reg_pat);
			$D['F']   = $this->prima_model->get_factor_prima();
			
			$D['Casos_RT']  = $this->prima_model->get_casos_rt($reg_pat,$anio);
			$casos_rt = $this->_casos_rt($reg_pat,$anio);
			if($casos_rt){
				$D['S']   = $casos_rt['S'];
				$D['N']	  = $casos_rt['N'];		
			
		

			$D['Prima_Resultante'] =  $this->_Decimal((( ($D['S']/$D['DN']) + $D['V'] * ($D['I'] + $D['D']) ) * ($D['F']/$D['N']) + $D['M'])*100,5);
			$Limite_Superior = $D['Prima_Anterior']+1;
			$Limite_Inferior = $D['Prima_Anterior']-1;

			if($Limite_Superior < $D['Prima_Resultante'])
				$D['Prima_Nueva'] = $Limite_Superior;
			elseif($Limite_Inferior > $D['Prima_Resultante'])
				$D['Prima_Nueva'] = $Limite_Inferior;
			else
				$D['Prima_Nueva'] = $D['Prima_Resultante'];
			}else
			  $D['msg'] = "No Existen Trabajadores Promedio Expuestos al Riesgo para este Periodo";

		}
			
			
			$D['anio'] = $anio;
			$D['patrones'] = $this->prima_model->get_patrones($this->session->userdata('id'),$reg_pat,'REG_PAT');

			$data['content'] = $this->load->view('prima/calculo_prima',$D,true);
			$data['prima'] = TRUE;
			$data['styles'] = array('prima','bootstrap.min');
			$data['scripts'] = array('bootstrap.min');
	        $this->load->view('template',$data);
		
	}

	public function reportes(){
		$this->_check_session();
	
		$this->load->library('fpdf');
		$reg_pat = $this->session->userdata('patron');
		//$pdf = new FPDF();
		if(!empty($_POST['anio']))
			$anio = $_POST['anio'];
		else
			$anio = date('Y')-1;

		if(!empty($_POST['tipo-reporte'])){

			switch ($_POST['tipo-reporte']) {
				case 1:
					$this->_RPT_TrabajadoresExpuestosRT($reg_pat,$_POST['anio']);
					break;
				case 2:
					$this->_RPT_RiesgosdeTarabajo($reg_pat,$_POST['inicio'],$_POST['fin']);
					break;
				case 3:
					$this->_RPT_CaratulaDeterminacion($reg_pat,$_POST['anio']);
					break;
				case 4:
					$reg_pats = $_POST['reg_pats'];
					$reg_pats[] = $reg_pat;
					$this->_RPT_CasosRT($reg_pats,$_POST['anio']);
					break;
				case 5:
					$this->_RPT_Incapacidades($reg_pat,$_POST['inicio'],$_POST['fin'],$_POST['ramo']);
					break;																			
				default:
			}
			$D['tipo_reporte'] = $_POST['tipo-reporte'];
		}


		$patron = $this->_get_patron();	
		$data['title'] = $patron->REG_PAT.' :: '.$patron->NOM_PAT;
		
		$D['patron']	= $patron;
		$D['anio']	= $anio;
		$D['patrones'] = $this->prima_model->get_patrones($this->session->userdata('id'),$reg_pat,'REG_PAT');

		$data['content'] = $this->load->view('prima/reportes',$D,true);
		$data['prima'] = TRUE;
		$data['styles'] = array('prima','bootstrap.min');
		$data['scripts'] = array('bootstrap.min');
	    $this->load->view('template',$data);
		
	}

	private function _RPT_TrabajadoresExpuestosRT($reg_pat = '',$anio = ''){

			$this->fpdf->AddPage();
			$this->fpdf->SetFont('Arial','B',16);
			$this->fpdf->Cell(40,10,'¡Hola, Mundo!');
			$this->fpdf->Output();
	}
	
	private function _RPT_RiesgosdeTarabajo($reg_pat = '',$inicio = '',$fin = ''){

		echo $reg_pat."<br>";
		echo $inicio.': '.$fin;
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
			exit();
	}
	
	private function _RPT_CaratulaDeterminacion($reg_pat = '',$anio = ''){

		echo $reg_pat."<br>";
		echo $anio;
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
			exit();
	}

	private function _RPT_CasosRT($reg_pats = array(),$anio = ''){

			echo $anio;
			echo "<pre>";
			print_r($reg_pats);
			print_r($_POST);
			echo "</pre>";
			exit();
	}
	private function _RPT_Incapacidades($reg_pat = '',$inicio = '',$fin = '',$ramo = 0){

		echo $reg_pat."<br>";
		echo $inicio.': '.$fin.'<br>';
		echo $ramo;
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
			exit();
	}
	private function _get_reg_pat(){

		 $patron = $this->session->userdata('patron');
		if(!empty($patron)){
			return $patron ;
		}
		else
			redirect('prima/seleccionar','refresh');
	}

	private function _get_patron(){

		 $patron = $this->_get_reg_pat();
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

	private function _Decimal($numero,$digitos){	
	    $raiz = 10;
	    $multiplicador = pow ($raiz,$digitos);
	    $resultado = ((int)($numero * $multiplicador)) / $multiplicador;
	    return number_format($resultado, $digitos);
	}
}