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
			
			return array('Meses'=>$Meses,'Total'=>$Total,'S'=>$S,'N'=> $this->_Decimal((($Total - $S)/365),1));

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

		if(!empty($_POST['anio'])){
			$anio = $_POST['anio'];
			$reg_pats = $_POST['reg-pat'];
		}
		else{
			$reg_pats = array();
			$anio = date('Y')-1;
		}
		    
			
			$D = $this->_calculos_prima($reg_pats,$anio);			
			
			$data['content'] = $this->load->view('prima/calculo_prima',$D,true);
			$data['prima'] = TRUE;
			$data['styles'] = array('prima','bootstrap.min');
			$data['scripts'] = array('bootstrap.min');
	        $this->load->view('template',$data);
		
	}
	private function _calculos_prima($reg_pats = array(),$anio = ''){
		$reg_pat = $this->_get_reg_pat();
			
		$patron = $this->_get_patron();	
		$data['title'] = $patron->REG_PAT.' :: '.$patron->NOM_PAT;
		$Prima_Anterior  = $this->_Decimal($this->prima_model->get_prima_rt($reg_pat,$anio),4);

		if(!empty($anio)){
			$D = array('V'=>28,'DN'=>365,'M'=>0,'I'=>0,'D'=>0,'F'=>0,'S'=>0,'N'=>0,'Casos_RT'=>0,'Prima_Anterior'=>$Prima_Anterior,'patron'=>$patron);

			if(!empty($reg_pats)){
				foreach ($reg_pats as $regpat) {
					$D['I']   += $this->prima_model->get_porcentajes($regpat,$anio)/100;
					$D['D']   += $this->prima_model->get_defunciones($regpat);
					$D['Casos_RT']  += $this->prima_model->get_casos_rt($regpat,$anio);
					$casos_rt = $this->_casos_rt($regpat,$anio);
					if($casos_rt){
						$D['S']   += $casos_rt['S'];
						$D['N']	  += $casos_rt['N'];
					}					
				}
			}

			$D['M']   = $this->prima_model->get_prima_minima()/100;
			
			$D['I']   += $this->prima_model->get_porcentajes($reg_pat,$anio)/100;
			$D['D']   += $this->prima_model->get_defunciones($reg_pat);
			$D['F']   = $this->prima_model->get_factor_prima();
			
			$D['Casos_RT']  += $this->prima_model->get_casos_rt($reg_pat,$anio);
			$casos_rt = $this->_casos_rt($reg_pat,$anio);
			
			if($casos_rt){
				$D['S']   += $casos_rt['S'];
				$D['N']	  += $casos_rt['N'];
			}
			elseif(!$D['N'])
			  $D['msg'] = "No Existen Trabajadores Promedio Expuestos al Riesgo para este Periodo";


			$D['Prima_Resultante'] =  @$this->_Decimal((( ($D['S']/$D['DN']) + $D['V'] * ($D['I'] + $D['D']) ) * ($D['F']/$D['N']) + $D['M'])*100,5);
			$Limite_Superior = $D['Prima_Anterior']+1;
			$Limite_Inferior = $D['Prima_Anterior']-1;

			if($Limite_Superior < $D['Prima_Resultante'])
				$D['Prima_Nueva'] = $Limite_Superior;
			elseif($Limite_Inferior > $D['Prima_Resultante'])
				$D['Prima_Nueva'] = $Limite_Inferior;
			else
				$D['Prima_Nueva'] = $D['Prima_Resultante'];			
		}
						
			$D['anio'] = $anio;
			$D['patrones'] = $this->prima_model->get_patrones($this->session->userdata('id'),$reg_pat,'REG_PAT');
			return $D;
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
					$this->_RPT_CasosRT($reg_pat,$reg_pats,$_POST['anio']);
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
			$this->fpdf->Image(FCPATH.'assets/img/imss.png',10,8,33);
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
			$this->fpdf->Image(FCPATH.'assets/img/imss.png',10,8,33);
			$this->fpdf->Cell(40);
			$this->fpdf->Cell(140,10,'SISTEMA UNICO DE AUTODETERMINACION');
			$this->fpdf->SetFont('Arial','B',10);
			$this->fpdf->Ln(6);
			$this->fpdf->Cell(60);
			$this->fpdf->Cell(140,10,'REPORTE DE RIESGOS DE TRABAJO');
			$this->fpdf->SetFont('Arial','B',8);
			$this->fpdf->Ln(10);
			$this->fpdf->Cell(50);
			$this->fpdf->Cell(40,10,'Periodo de Proceso del: '.$inicio);
			$this->fpdf->Cell(20);
			$this->fpdf->Cell(2,10,' al: '.$fin);
			  
			$this->fpdf->Ln(10);
			$this->fpdf->Cell(120,10,'Fecha: '.date('d/m/Y'));
			$this->fpdf->Cell(8,10,'Pagina:   1');			  
		  	$this->fpdf->Ln(6);
			$this->fpdf->Cell(100,10,'Registro Patronal: '.$Patron->REG_PAT);
			$this->fpdf->Cell(8,10,'R.F.C. '.$Patron->RFC_PAT);

			$this->fpdf->Ln(6);
			$this->fpdf->Cell(120,10,'Nombre o Razon Social: '.$Patron->NOM_PAT);
			$this->fpdf->Ln(6);
			$this->fpdf->SetLineWidth(.4);
			$this->fpdf->Line(10,56,200,56);

			$this->fpdf->Ln(4);
			$this->fpdf->SetFontSize(7);
			  
			$this->fpdf->SetFont('Arial','',8);
			$width  = array(25,65,16,10,10,13,13,16,28);
			$height = array(3,6,3,3,3,3,3,3,6,6);
			$data   = array(array("Numero de \n Seguro Social", 'Nombre del Asegurado', "Fecha \n Inicio","Tipo\n Rgo.", "Con.\n Sec.", "Dias\n Subs.", "Porc.\n Incap.", "Fecha \nTermino", "Observaciones"));
			$this->_TableMultiCell($this->fpdf,10,$width,$height,$data);			  
			$this->fpdf->SetLineWidth(.4);
			$this->fpdf->Line(10,67,200,67);
			$inicio = $this->_Fecha($inicio);
			$fin    = $this->_Fecha($fin);
			
			$trabajadores = $this->prima_model->get_Num_Afiliacion($reg_pat);
			$riesgo_1_3    = array('casos'=>0,'dias'=>0,'porcentaje'=>0,'defunciones'=>0);
			$riesgo_2      = array('casos'=>0,'dias'=>0,'porcentaje'=>0,'defunciones'=>0);
			$this->fpdf->SetFont('Arial','',7.5);	
			$height = array(6,6,6,6,6,6,6,6,6);

			foreach ($trabajadores as $trabajador) {
				 $data = $this->prima_model->get_datos_inc($reg_pat,$trabajador->NUM_AFIL,$inicio,$fin);
				foreach ($data as $cols) {
					
					$f = strtotime($cols->fin);
					$now = strtotime('now');
					if($f <= $now)
						$observaciones = 'Caso Terminado';
					else
						$observaciones = 'Caso Pendiente';
					$row =  array(array($cols->Num_Afi,$trabajador->TMP_NOM,$cols->Fecha,'  '.substr($cols->Tip_Rie,0,1),'  '.substr($cols->Con_Inc,0,1),'  '.$cols->Dia_Sub,$this->_Decimal($cols->Por_Inc,2),$cols->FechaFin,$observaciones)	);
					$this->_TableMultiCell($this->fpdf,10,$width,$height,$row);
					
					if(substr($cols->Tip_Rie,0,1) == '1' || substr($cols->Tip_Rie,0,1) == '3'){
						$riesgo_1_3['casos']++;	
						$riesgo_1_3['dias']+= $cols->Dia_Sub;	
						$riesgo_1_3['porcentaje']+= $cols->Por_Inc;
						if(strtolower($cols->Ind_Def) == 'si')	
							$riesgo_1_3['defunciones']++;	
					}
					elseif(substr($cols->Tip_Rie,0,1) == '2'){
						$riesgo_2['casos']++;	
						$riesgo_2['dias']+=$cols->Dia_Sub;	
						$riesgo_2['porcentaje']+= $cols->Por_Inc;
						if(strtolower($cols->Ind_Def) == 'si')		
							$riesgo_2['defunciones']++;	
					}
				}
			}

			$width  = array(85,45);
			$height = array(6,6);
			$this->fpdf->SetFont('Arial','B',8);	
			$data   = array(array("Tipo de Riesgo 1 y 3", 'Tipo de Riesgo 2'));
			$this->_TableMultiCell($this->fpdf,44,$width,$height,$data);

			$width  = array(20,20,20,40,20,20,20,20);
			$height = array(6,3,3,6,6,3,3,6);
			$this->fpdf->SetFont('Arial','',8);	
			$data   = array(array("Casos", "Dias\n Subcidiados","Porcentaje Incapacidad","Defunciones","Casos", "Dias\n Subcidiados","Porcentaje Incapacidad","Defunciones"));
			$this->_TableMultiCell($this->fpdf,15,$width,$height,$data);
			$this->_TableMultiCell($this->fpdf,19,$width,$height,array(
				array($riesgo_1_3['casos'],
					$riesgo_1_3['dias'],$riesgo_1_3['porcentaje'],$riesgo_1_3['defunciones'],$riesgo_2['casos'],$riesgo_2['dias'],$riesgo_2['porcentaje'],$riesgo_2['defunciones'])));




			$width  = array(50);
			$height = array(6);
			$this->fpdf->SetFont('Arial','B',8);	
			$data   = array(array("Total de Riesgos de Trabajo"));
			$this->_TableMultiCell($this->fpdf,85,$width,$height,$data);

			$width  = array(20,20,20,20);
			$height = array(6,3,3,6);
			$this->fpdf->SetFont('Arial','',8);	
			$data   = array(array("Casos", "Dias\n Subcidiados","Porcentaje Incapacidad","Defunciones"));
			$this->_TableMultiCell($this->fpdf,70,$width,$height,$data);
			$this->_TableMultiCell($this->fpdf,74,$width,$height,array(
				array($riesgo_1_3['casos']+$riesgo_2['casos'],
					$riesgo_1_3['dias']+$riesgo_2['dias'],
						$riesgo_1_3['porcentaje']+$riesgo_2['porcentaje'],
						$riesgo_1_3['defunciones']+$riesgo_2['defunciones'])));
	

				
		$this->fpdf->Output();

	}
	
	private function _RPT_CaratulaDeterminacion($reg_pat = '',$anio = ''){

			$this->fpdf->AddPage('Landscape');
			$this->fpdf->SetFont('Arial','B',8);
			$this->fpdf->Image(FCPATH.'assets/img/caratula.png',4,8,290,180);
			$D = $this->_calculos_prima('',$anio);
			//echo "<pre>";
			//print_r($D);
			//echo "</pre>";
			//exit();
			$this->fpdf->Text(262,22,date('d      m      Y'));
			$this->fpdf->Text(10,72,substr($D['patron']->REG_PAT,0,10).'                 '.substr($D['patron']->REG_PAT,10,1));
			$this->fpdf->Text(10,81,$D['patron']->NOM_PAT);
			$this->fpdf->Text(163,77,$D['patron']->DOM_PAT);
			$this->fpdf->Text(163,81,$D['patron']->MUN_PAT);

			$this->fpdf->Text(74,109,$anio);

			$this->fpdf->Text(255,77,$D['patron']->CPP_PAT);
			$this->fpdf->Text(255,81,$D['patron']->TEL_PAT);

			$this->fpdf->Text(10,90,$D['patron']->ACT_PAT);
			$this->fpdf->Text(174,90,$D['patron']->Clase);
			$this->fpdf->Text(220,90,$D['patron']->Fraccion);
			$this->fpdf->Text(260,90,$D['Prima_Anterior']);
			
			$this->fpdf->Text(152,117,$D['S']);
			$this->fpdf->Text(190,117,$D['I']);
			$this->fpdf->Text(213,117,$D['D']);
			$this->fpdf->Text(234,117,$D['F']);
			$this->fpdf->Text(249,117,$D['N']);
			$this->fpdf->Text(269,117,$D['M']);

			$this->fpdf->Text(159,125,substr(($D['S']/$D['DN']),0,12));
			$this->fpdf->Text(192,125,substr(($D['I']+$D['D']),0,12));
			$this->fpdf->Text(223,125,substr(($D['F']+$D['N']),0,12));
			$this->fpdf->Text(254,125,$D['M']);
			$this->fpdf->Text(271,125,$D['Prima_Resultante']/100);
			$this->fpdf->Text(120,138,$D['Prima_Resultante']/100);
			$this->fpdf->Text(195,138,$D['Prima_Resultante']);
			$this->fpdf->Text(260,142,$D['Prima_Nueva']);




			$this->fpdf->Text(85,122,$D['S']);
			$this->fpdf->Text(85,134,$D['I']);
			$this->fpdf->Text(85,144,$D['D']);
			$this->fpdf->Text(85,154,$D['N']);
			$this->fpdf->Text(85,169,$D['F']);
			$this->fpdf->Text(85,175,$D['M']);
			
			$this->fpdf->Text(160,162,$anio+1);
			$this->fpdf->Text(216,162,$anio+2);


			if(strtolower($D['patron']->STyPS) == "si")
				$this->fpdf->Text(140,180,"X");
			else
				$this->fpdf->Text(158,180,"X");
			
			$this->fpdf->Text(182,180,$D['patron']->Pat_Rep);



			
			$this->fpdf->Output();
	}

	private function _RPT_CasosRT($reg_pat = '',$reg_pats = array(),$anio = ''){
	
			$this->fpdf->AddPage("P","Letter");
			$Patron = $this->_get_patron($reg_pat);
			$this->fpdf->SetFont('Arial','B',12);
			$this->fpdf->Image(FCPATH.'assets/img/imss.png',10,8,33);
			 $this->fpdf->Ln(10);
			 $this->fpdf->Cell(40);
			 $this->fpdf->Cell(100,10,'RELACION DE CASOS DE RIESGOS DE TRABAJO TERMINADOS');
			 $this->fpdf->Ln(5);
			 $this->fpdf->SetFont('Arial','',9);
			 $this->fpdf->Cell(45);
			 $this->fpdf->Cell(120,10,"(DURANTE EL PERIODO DEL 1o. DE ENERO AL 31 DE DICIEMBRE DE $anio)");
			 $this->fpdf->Ln(10);
			 $left = 6;
			 $this->fpdf->SetFont('Arial','',8);
			 $this->fpdf->Cell(130,10,'REGISTRO PATRONAL    D.V.');
			 $this->fpdf->Cell(60,10,'Fecha defunciones Proceso: '.date('d/m/Y'));			 
			 $this->fpdf->Ln(4);

			 $this->fpdf->Line($left+8,46,40,46);
			 $this->fpdf->Cell($left);
			 $this->fpdf->Cell(30,10,substr($Patron->REG_PAT,0,10));
			 $this->fpdf->Cell(10,10,substr($Patron->REG_PAT,10,1));
			 $this->fpdf->Ln(5);

			 $this->fpdf->Cell(85,10,'NOMBRE DENOMINACION O RAZON SOCIAL: ');
			 $this->fpdf->Cell(90,10,'DOMICILIO: 			 '.$Patron->DOM_PAT);
			 $this->fpdf->Cell(16,10,'C.P. '.$Patron->CPP_PAT);
			 $this->fpdf->Line(114,51,182,51);
			 $this->fpdf->Line(192,51,208,51);
			 $this->fpdf->Ln(5);

			 $this->fpdf->Cell(85,10,''.$Patron->NOM_PAT);
			 $this->fpdf->Line($left,56,90,56);

			 $this->fpdf->Cell(90,10,'MPIO/DELEG: '.$Patron->MUN_PAT);
			 $this->fpdf->Cell(20,10,'TEL: '.$Patron->TEL_PAT);
			 $this->fpdf->Line(114,56,182,56);
			 $this->fpdf->Line(192,56,208,56);

			 $this->fpdf->SetLineWidth(0.5);
			 $this->fpdf->Line($left,58,208,58);			 
			 $this->fpdf->Ln(8);

			 $this->fpdf->SetFont('Arial','',5);
			 $width  = array(14,23,54,18,18,11,15,18,13,18);
			 $height = array(3,6,6,2,3,2,3,3,6,3);
			 $data   = array(array("NUMERO DE\n SEGURIDAD\n SOCIAL",
			  						'CURP',
			  							'NOMBRE DEL ASEGURADO',
			  							"RECAIDA O\n REVALIDACION",
			  							"FECHA DEL ACCIDENTE O\n ENFERMEDAD\n DE TRABAJO\n\n ".utf8_decode("AÑO")." MES DIA",
			  							"TIPO DE\n RIESGO",
			  							"DIAS SUBSIDIADOS",
			  							"PORCENTAJE DE\n INCAPACIDAD\n PERMANENTE\n PARCIAL O\n TOTAL",
			  							"DEFUNCION",
			  							"FECHA DE ALTA \n ".utf8_decode("AÑO")." MES DIA"));
			  $this->_TableMultiCell($this->fpdf,$left,$width,$height,$data);
			 $y = 78;
			 $x = $left;
			 $this->fpdf->SetLineWidth(0.2);			 
			 $this->fpdf->Line($x,$y,$x+=13,$y);
			 $this->fpdf->Line($x+=2,$y,$x+=21,$y);
			 $this->fpdf->Line($x+=2,$y,$x+=53,$y);
			 $this->fpdf->Line($x+=2,$y,$x+=14,$y);
			 $this->fpdf->Line($x+=2,$y,$x+=17,$y);
			 $this->fpdf->Line($x+=2,$y,$x+=9,$y);
			 $this->fpdf->Line($x+=2,$y,$x+=13,$y);
			 $this->fpdf->Line($x+=2,$y,$x+=16,$y);
			 $this->fpdf->Line($x+=2,$y,$x+=12,$y);
			 $this->fpdf->Line($x+=2,$y,$x+=17,$y);
			 $this->fpdf->Ln(16);
			 $height = array(4,4,4,4,4,4,4,4,4,4);			 
			 foreach ($reg_pats as $reg_pat) {
				 $casos_rt = $this->prima_model->get_casos_rt($reg_pat,$anio,true);
				 foreach ($casos_rt as $caso) {
				 	$afiliado =	$this->prima_model->get_data_Afiliado($caso->Num_Afi);
				 	
				 	if(strtolower($caso->Ind_Def) == 'no')
				 		$def = '';
				 	else
				 		$def = "Si";
				 	$sp ='      ';
				 	$rows =  array(array($caso->Num_Afi,$afiliado->CURP,$afiliado->TMP_NOM,$sp,$sp.$caso->inicio,$sp.substr($caso->Tip_Rie,0,1),$sp.$caso->Dia_Sub,$sp.$caso->Por_Inc,$sp.$def,$sp.$caso->fin));
			  		$this->_TableMultiCell($this->fpdf,$left,$width,$height,$rows);

				 }
			}
			 $this->fpdf->Output();
			
			
	}
	private function _RPT_Incapacidades($reg_pat = '',$inicio = '',$fin = '',$ramo = 0){

			$Patron = $this->_get_patron($reg_pat);
			$this->fpdf->AddPage();
			$this->fpdf->SetFont('Arial','B',16);
			$this->fpdf->Image(FCPATH.'assets/img/imss.png',10,8,33);
			 $this->fpdf->Cell(40);
			 $this->fpdf->Cell(140,10,'SISTEMA UNICO DE AUTODETERMINACION');
			 $this->fpdf->SetFont('Arial','B',10);
			 $this->fpdf->Ln(6);
			 $this->fpdf->Cell(60);
			  $this->fpdf->Cell(140,10,'REPORTE DE INCAPACIDADES');
			  $this->fpdf->SetFont('Arial','B',8);
			 $this->fpdf->Ln(10);
			 $this->fpdf->Cell(50);
			  $this->fpdf->Cell(40,10,'Periodo de Proceso del: '.$inicio);
			  $this->fpdf->Cell(20);
			  $this->fpdf->Cell(2,10,' al: '.$fin);
			  
			  $this->fpdf->Ln(10);
			  $this->fpdf->Cell(120,10,'Fecha: '.date('d/m/Y'));
			  $this->fpdf->Cell(8,10,'Pagina:   1');			  

			  $this->fpdf->Ln(6);
			  $this->fpdf->Cell(100,10,'Registro Patronal: '.$Patron->REG_PAT);
			  $this->fpdf->Cell(8,10,'R.F.C. '.$Patron->RFC_PAT);

			  $this->fpdf->Ln(6);
			  $this->fpdf->Cell(120,10,'Nombre o Razon Social: '.$Patron->NOM_PAT);
			  $this->fpdf->Ln(6);
			  $this->fpdf->SetLineWidth(.4);
			  $this->fpdf->Line(10,56,200,56);

			  $this->fpdf->Cell(45,10,utf8_decode("Número de Seguridad Social"));
			  $this->fpdf->Cell(80,10,"Nombre del Trabajador");
			  
			  $this->fpdf->Ln(4);
			  $this->fpdf->SetFontSize(7);
			  
			  $this->fpdf->SetFont('Arial','',8);
			  $width  = array(35,35,38,25,16,17,12,13);
			  $height = array(6,6,6,3,3,6,3,6);
			  $data   = array(array("  Ramo de Seguro",
			  						'Tipo de Riesgo',
			  							'Secuela o Consecuencia',
			  							"Control de la\n Incapacidad",
			  							"Fecha de\n Inicio",
			  							"Folio",
			  							utf8_decode("Días\n Subs."),
			  							'% Incap.'));
			  $this->_TableMultiCell($this->fpdf,10,$width,$height,$data);			  
			$this->fpdf->SetLineWidth(.4);
			$this->fpdf->Line(10,67,200,67);
			$inicio = $this->_Fecha($inicio);
			$fin    = $this->_Fecha($fin);
			
			$trabajadores = $this->prima_model->get_Num_Afiliacion($reg_pat);
			


			$height = array(6,6,6,6,6,6,6,6);
			foreach ($trabajadores as $trabajador) {

				 	$data = $this->prima_model->get_datos_inc($reg_pat,$trabajador->NUM_AFIL,$inicio,$fin,$ramo);
				 	if($data){
				 		$this->fpdf->SetFont('Arial','B',8);
						$this->fpdf->Cell(120,10,$trabajador->NUM_AFIL."     ".$trabajador->TMP_NOM);
						$this->fpdf->Ln(4);
						$this->fpdf->SetFont('Arial','',8);	
					foreach ($data as $cols) {

						$row =  array(array($cols->Ram_Seg,$cols->Tip_Rie,$cols->Secuela,substr($cols->Con_Inc,0,12),$cols->Fecha,$cols->Fol_Inc,$cols->Dia_Sub,$cols->Por_Inc)	);
						$this->_TableMultiCell($this->fpdf,10,$width,$height,$row);
					}
				}
			}	
			$this->fpdf->Output();
	}

	private function _TableMultiCell($pdf,$x,$width,$height, $data,$border = 0){
		
		$i = 0;
		$y = $pdf->GetY() + 2;
		$pdf->SetXY($x,$y);				
		foreach($data as $row){
		$i = 0;
		$xx = $x;
			foreach($row as $col){
				$pdf->MultiCell($width[$i],$height[$i],$col,$border);
				$xx+=$width[$i];
				$pdf->SetXY($xx,$y);
				$i++;
			}
			$pdf->Ln();
			

		}
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

	private function _Fecha($fecha = '21/06/2012'){	
	    return  substr($fecha,6,4).'-'.substr($fecha,3,2).'-'.substr($fecha,0,2);
	}
}