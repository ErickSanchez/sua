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

		$reg_pat = $this->session->userdata('patron');
		if(!empty($_POST['anio'])){
			$anio = $_POST['anio'];
			$calculos = $this->_casos_rt($reg_pat,$anio);
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
			
			$Meses = $this->_casos_rt($reg_pat,$anio);
			$Patron = $this->_get_patron($reg_pat);			
			$this->fpdf->AddPage();
			$this->fpdf->SetFont('Arial','B',16);
			$this->fpdf->Image('imss.png',10,8,33);
			 $this->fpdf->Cell(40);
			 $this->fpdf->Cell(140,10,'SISTEMA UNICO DE AUTODETERMINACION');
			 $this->fpdf->SetFont('Arial','B',10);
			 $this->fpdf->Ln(6);
			 $this->fpdf->Cell(60);
			  $this->fpdf->Cell(140,10,'REPORTE DE DIAZ COTIZADOS Y');
			   $this->fpdf->Ln(4);
			 $this->fpdf->Cell(43);
			  $this->fpdf->Cell(140,10,'TRABAJADORES PROMEDIO EXPUESTOS AL RIESGO');
			  $this->fpdf->SetFont('Arial','B',8);
			 $this->fpdf->Ln(10);
			 $this->fpdf->Cell(80);
			  $this->fpdf->Cell(140,10,'Periodo de Computo: '.$anio);
			  $this->fpdf->Ln(8);
			 $this->fpdf->Cell(8);
			  $this->fpdf->Cell(2,10,'Fecha: '.date('d/m/Y'));
			   $this->fpdf->Cell(120);
			  $this->fpdf->Cell(8,10,'Pagina:   1');
			  $this->fpdf->Ln(7);
			 $this->fpdf->Cell(8);
			  $this->fpdf->Cell(2,10,'Registro Patronal: '.$Patron->REG_PAT);
			   $this->fpdf->Cell(80);
			  $this->fpdf->Cell(8,10,'R.F.C. '.$Patron->RFC_PAT);
			  $this->fpdf->Ln(7);
			 $this->fpdf->Cell(8);
			  $this->fpdf->Cell(2,10,'Nombre o Razon Social: '.$Patron->NOM_PAT);
			  $this->fpdf->Ln(7);
			 $this->fpdf->Cell(40);
			 ////Tabla
			  $w = array(80, 40,);
			  $meses = array(array('Enero',$Meses['Meses'][1]),
								array('Febrero',$Meses['Meses'][2]),
								array('Marzo',$Meses['Meses'][3]),
								array('Abril',$Meses['Meses'][4]),
								array('Mayo',$Meses['Meses'][5]),
								array('Junio',$Meses['Meses'][6]),
								array('Julio',$Meses['Meses'][7]),
								array('Agosto',$Meses['Meses'][8]),
								array('Septiembre',$Meses['Meses'][9]),
								array('Octubre',$Meses['Meses'][10]),
								array('Noviembre',$Meses['Meses'][11]),
								array('Diciembre',$Meses['Meses'][12]),
								array('Total Dias Cotizados                         =',$Meses['Total']),
								array('Dividido entre 365 Dias                      =',$Meses['N'].'   =   Trabajadores Promedio'),
								array('','               Expuestos al Riesgo')
								);
			 $this->fpdf->Ln(4);					
			 $this->_Table($this->fpdf,40,array('Mes:','Dias Cotizados:'),$w,$meses,0);
			  //$this->fpdf->Cell(10,10,'Mes: ',1);
			  // $this->fpdf->Cell(60,1,1,1);
			  //$this->fpdf->Cell(2,10,'Dias Cotizados: ');
			  
			$this->fpdf->Output();
	}
	private function _Table($pdf,$x,$header,$width,$data,$border = 1){
		// Cabecera
		$i = 0;
		$pdf->SetX($x);
		foreach($header as $col){
			$pdf->Cell($width[$i],6,$col,$border);
			$i++;
		}
		$pdf->Ln();
		// Datos
		
		foreach($data as $row){
		$i = 0;
		$pdf->SetX($x);
			foreach($row as $col)
				$pdf->Cell($width[$i],6,$col,$border);
			$pdf->Ln();
			$i++;
		}
	}
	private function _Table2($pdf,$x,$header,$width,$border = 1){
		// Cabecera
		$i = 0;
		$pdf->SetX($x);
		foreach($header as $col){
			$pdf->Cell($width[$i],6,$col,$border);
			$i++;
		}
	}

	private function _RPT_RiesgosdeTarabajo($reg_pat = '',$inicio = '',$fin = ''){
			$Patron = $this->_get_patron($reg_pat);
			$this->fpdf->AddPage();
			$this->fpdf->SetFont('Arial','B',16);
			$this->fpdf->Image('imss.png',10,8,33);
			 $this->fpdf->Cell(40);
			 $this->fpdf->Cell(140,10,'SISTEMA UNICO DE AUTODETERMINACION');
			 $this->fpdf->SetFont('Arial','B',10);
			 $this->fpdf->Ln(6);
			 $this->fpdf->Cell(60);
			  $this->fpdf->Cell(140,10,'REPORTE DE RIESGO DE TRABAJO');
			  $this->fpdf->SetFont('Arial','B',8);
			 $this->fpdf->Ln(10);
			 $this->fpdf->Cell(50);
			  $this->fpdf->Cell(40,10,'Periodo de Proceso del: '.$inicio);
			  $this->fpdf->Cell(20);
			  $this->fpdf->Cell(2,10,' al: '.$fin);
			  $this->fpdf->Ln(8);
			 $this->fpdf->Cell(8);
			  $this->fpdf->Cell(2,10,'Fecha: '.date('d/m/Y'));
			   $this->fpdf->Cell(120);
			  $this->fpdf->Cell(8,10,'Pagina:   1');
			  $this->fpdf->Ln(7);
			 $this->fpdf->Cell(8);
			  $this->fpdf->Cell(2,10,'Registro Patronal: '.$Patron->REG_PAT);
			   $this->fpdf->Cell(80);
			  $this->fpdf->Cell(8,10,'R.F.C. '.$Patron->RFC_PAT);
			  $this->fpdf->Ln(7);
			 $this->fpdf->Cell(8);
			  $this->fpdf->Cell(2,10,'Nombre o Razon Social: '.$Patron->NOM_PAT);
			  
			  $w = array(30,28,20,15,15,15,15,20,15);
			  $this->fpdf->SetFont('Arial','B',6);
			  $header = array('Numero de Seguro Social', 'Nombre del Asegurado', 'Fecha de Inicio', 'Tipo Rgo.', 'Con. Sec.', 'Dias Subs.', 'Porc. Incap.', 'Fecha Termino', 'Observaciones');
			
			$this->fpdf->Ln(8);					
			 $this->_Table2($this->fpdf,5,$header,$w,0);

			
			$this->fpdf->Output();
	}
	
	private function _RPT_CaratulaDeterminacion($reg_pat = '',$anio = ''){

		/*echo $reg_pat."<br>";
		echo $anio;
			echo "<pre>";
			print_r($_POST);
			echo "</pre>";
			exit();
			*/
			$this->fpdf->AddPage();
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Image('imss.png',10,8,33);
			 $this->fpdf->Cell(40);
			 $this->fpdf->Cell(100,10,'DETERMINACION DE LA PRIMA EN EL SEGURO DE RIESGOS DE TRABAJO');
			 $this->fpdf->Ln(4);
			 $this->fpdf->Cell(45);
			 $this->fpdf->Cell(120,10,'DERIVADA DE LA REVISION ANUAL DE LA SINIESTRALIDAD');
			 $this->fpdf->SetFont('Arial','B',5);
			 $this->fpdf->Ln(4);
			 $this->fpdf->Cell(35);
			  $this->fpdf->Cell(140,10,'INSTITUTO MEXICANO DEL SEGURO SOCIAL');
			  $this->fpdf->Ln(4);
			 $this->fpdf->Cell(35);
			  $this->fpdf->Cell(140,10,'EN EL CUMPLIMIENTO A LO DISPUESTO POR LOS ARTICULOS 15, FRACCION IV. 71.72 Y 74 DE LA LEY DEL SEGURO SOCIAL Y');
			  $this->fpdf->Ln(2);
			 $this->fpdf->Cell(35);
			  $this->fpdf->Cell(140,10,'DECIMO NOVENO TRASITORIO DEL DECRETO POR EL QUE SE REFORMAN DIVERSAS DISPOSICIONES DE LA LEY DEL SEGURO');
			  $this->fpdf->Ln(2);
			 $this->fpdf->Cell(35);
			  $this->fpdf->Cell(140,10,'SOCIAL, PUBLICADO EN EL DIARIO OFICIAL DE LA FEDERACION DEL 20 DE DICIEMBRE DE 2001 Y ARTUCULOS Y FRACCION IV.2');
			   $this->fpdf->Ln(2);
			 $this->fpdf->Cell(35);
			  $this->fpdf->Cell(140,10,'FRACCION VII.3 DEL 32 AL 39, 47 Y 196 DEL REGLAMENTO DE LA LEY DEL SEGURO SOCIAL EN MATERIA DE AFILIACION');
			   $this->fpdf->Ln(2);
			 $this->fpdf->Cell(35);
			  $this->fpdf->Cell(140,10,'CALIFICACION DE EMPRESAS, RECAUDACION Y FISCALIZACION, MANIFIESTO, BAJO PROTESTA DE DECIR VERDAD. QUE LOS');
			   $this->fpdf->Ln(2);
			 $this->fpdf->Cell(35);
			  $this->fpdf->Cell(140,10,'DATOS ASENTADOS EN ESTE DOCUMENTO SON REA;ES RESPECTO A LA SINIESTRALIDAD OCURRIDA EN ESTA EMPRESA');
			  $this->fpdf->Output();
	}

	private function _RPT_CasosRT($reg_pats = array(),$anio = ''){

			/*echo $anio;
			echo "<pre>";
			print_r($reg_pats);
			print_r($_POST);
			echo "</pre>";
			exit();*/
			$this->fpdf->AddPage();
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Image('imss.png',10,8,33);
			 $this->fpdf->Ln(10);
			 $this->fpdf->Cell(40);
			 $this->fpdf->Cell(100,10,'RELACION DE CASOS DE RIESGOS DE TRABAJO TERMINADOS');
			 $this->fpdf->Ln(4);
			 $this->fpdf->SetFont('Arial','B',7);
			 $this->fpdf->Cell(45);
			 $this->fpdf->Cell(120,10,'(DURANTE EL PERIODO DEL 1o. DE ENERO AL 31 DE DICIEMBRE DE 2011)');
			 $this->fpdf->Ln(10);
			 $this->fpdf->SetFont('Arial','B',5);
			 $this->fpdf->Cell(8);
			 $this->fpdf->Cell(100,10,'REGISTRO PATRONAL  D.V.');
			 $this->fpdf->Cell(120,10,'Fecha de Proceso: ');
			 $this->fpdf->Output();
			
			
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

	private function _get_patron($reg_pat = ''){

		if(empty($reg_pat))
		 	$reg_pat = $this->_get_reg_pat();
		if(!empty($reg_pat)){
			$patron = $this->prima_model->get_patron($reg_pat);
			if($patron){
				return $patron[0];
			}
		}
		return null;
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