<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>SUA</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/smoothness/jquery-ui-1.10.3.custom.min.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/template.css">
		<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.menu_option').click(function(){
					if($(this).parent('ul').find('.submenu').css('display') == 'none')
					{
						$(this).parent('ul').find('.submenu').show("slow");
						$(this).addClass("button-active");
					}
					else
					{
						$(this).parent('ul').find('.submenu').hide("slow");
						$(this).removeClass("button-active");
					}
				});

				$(' #logout_button ').button();
			});
		</script>
	</head>
	<body>
		<div id="header">
			<h3>SUA Sistema Unico de Autodetermiación</h3>
			<a href="<?=site_url()?>login/logout/" id="logout_button">Salir</a>
		</div>
		<div id="menu">
			<ul class="navigation">
				<li class="menu_option"><span></span>Actualizar</li>
				<li class="submenu">
					<ul>
						<li class="menu_suboption">Patrones</li>
						<li class="menu_suboption">Trabajadores</li>
						<li class="menu_suboption">Salarios Minimos</li>
						<li class="menu_suboption">INPC y Recargos</li>
					</ul>
				</li>
			</ul>
			<ul class="navigation">
				<li class="menu_option">Afiliación</li>
				<li class="submenu">
					<ul>
						<li class="menu_suboption">Generar Movimientos</li>
						<li class="menu_suboption">Recepción de Movimiento</li>
						<li class="menu_suboption">Reporte del Estado</li>
					</ul>
				</li>
			</ul>
			<ul class="navigation">
				<li class="menu_option <?php if(!empty($prima)) echo 'button-active';?>">Determinación Prima RT</li>
				<li class="submenu" <?php if(!empty($prima)) echo 'style="display:list-item;"';?>>
					<ul>
						<li class="menu_suboption">
							<a href="<?=site_url('prima/calculo_dias')?>">Cálculo de Dias</a>
						</li>
						<li class="menu_suboption">
							<a href="<?=site_url('prima/calculo_prima')?>">Cálculo de Prima RT</a>
						</li>
						<li class="menu_suboption">
							<a href="<?=site_url('prima/reportes')?>">Obtención de Reportes</a>
						</li>
					</ul>
				</li>
			</ul>
			<ul class="navigation">
				<li class="menu_option">Aportaciones</li>
				<li class="submenu">
					<ul>
						<li class="menu_suboption">Voluntarias</li>
						<li class="menu_suboption">Complementarias</li>
					</ul>
				</li>
			</ul>
			<ul class="navigation">
				<li class="menu_option">Cálculos</li>
				<li class="submenu">
					<ul>
						<li class="menu_suboption">Pago Oportuno</li>
						<li class="menu_suboption">Pago Extemporáneo</li>
						<li class="menu_suboption">Pago de Diferencias</li>
					</ul>
				</li>
			</ul>
			<ul class="navigation">
				<li class="menu_option">Reportes</li>
				<li class="submenu">
					<ul>
						<li class="menu_suboption">Análisis de la Información</li>
					</ul>
				</li>
			</ul>
		</div>
		<div id="content">
			<?=$content?>
		</div>
	</body>
</html>