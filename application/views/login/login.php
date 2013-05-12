<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>SUA</title>
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/smoothness/jquery-ui-1.10.3.custom.min.css">
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/login.css">
		<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-1.9.1.js"></script>
		<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$(' #login_button ').button();
			});
		</script>
	</head>
	<body>
	<?php
		$attributes = array('id' => 'login_form');
		echo form_open('login/access',$attributes);
	?>
			<div id="login_wrapper">
				<div class="header_login"><h3>Iniciar Sesión</h3></div>
				<ul>
					<li class="text_form"><span>Usuario</span></li>
					<li><input type="text" name="usuario" class="text ui-widget-content ui-corner-all" /></li>
				</ul>
				<ul>
					<li class="text_form"><span>Contraseña</span></li>
					<li><input type="password" name="contrasena" class="text ui-widget-content ui-corner-all" /></li>
				</ul>
				<button id="login_button"><span>Aceptar</span></button>
			</div>
	<?php
		echo form_close();
	?>
	</body>
</html>