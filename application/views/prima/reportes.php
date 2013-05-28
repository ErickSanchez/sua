<script type="text/javascript">
	$(document).ready(function(){

	      $( "#from" ).datepicker({
	      		defaultDate: "+1w",
	      		changeMonth: true,
	      		numberOfMonths: 1,
	      		onClose: function( selectedDate ) {
	        $( "#to" ).datepicker( "option", "minDate", selectedDate );
	      }
	    });
	    $( "#to" ).datepicker({
	      defaultDate: "+1w",
	      changeMonth: true,
	      numberOfMonths: 1,
	      onClose: function( selectedDate ) {
	        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
	      }
	    });
			
		$(".trabajador-no").hide();
		$("#tipo-reporte").change(function(){			
			switch($(this).val()){
				case '1': $(".trabajador-no").hide(); $(".trabajador").show(); break;
				case '2': $(".reporte-no").hide(); $(".reporte").show(); break;
				case '3': $(".trabajador-no").hide(); $(".trabajador").show(); break;
				case '4': $(".relacion-no").hide(); $(".relacion").show(); break;
				case '5': $(".incapacidad-no").hide(); $(".incapacidad").show(); break;
				default:
			}
		});
	});
</script>
  <div class="span10 offset1">
  	<!--form class="form-horizontal"-->
  	<?php echo form_open('',array('class'=>'form-horizontal'));?>
  		  <fieldset class="well span10">	  	
	  		<div class="control-group">
	    		<label class="control-label" for="tipo-reporte">Seleccione el Reporte</label>
	    		<div class="controls">
	      			<select id="tipo-reporte" name="tipo-reporte" class="span5">
	      				<option value="1">Trabajadores Promedio Expuestos al Riesgo</option>
	      				<option value="2">Reporte de Riesgos de Trabajo</option>
	      				<option value="3">Carátula del la Determinación</option>
	      				<option value="4">Relación de Casos de R.T</option>
	      				<option value="5">Incapacidades de Trabajadores</option>
	      			</select>
	    		</div>
	  		</div>
	  		<div class="control-group trabajador relacion reporte-no  incapacidad-no alpha">
	    		<label class="control-label" for="anio">Período de Reporte</label>
	    		<div class="controls">
	      			<select id="anio" name="anio" class="span2">
							<?php for ($i=1997; $i < date('Y')+2; $i++) { 
	      					if($anio == $i)
	      						echo '<option selected>'.$i.'</option>';
	      					else
	      						echo '<option>'.$i.'</option>';
	      				}?>
	      			</select>
	    		</div>
	  		</div>	  			
	  		<div class="control-group span4 reporte incapacidad trabajador-no relacion-no alpha">
	    		<label class="control-label" for="inicio">Fecha Inicial</label>
	    		<div class="controls">
					<input type="text" id="from" name="inicio" class="span2 datepicker" placeholder="DD/MM/AA">
	    		</div>
	  		</div>

	  		<div class="control-group span4 reporte incapacidad trabajador-no relacion-no alpha">
	    		<label class="control-label" for="fin">Fecha Final</label>
	    		<div class="controls">
					<input type="text" id="to" name="fin" class="span2 datepicker" placeholder="DD/MM/AA">
	    		</div>
	  		</div>
	  		<div class="control-group span4 incapacidad trabajador-no  relacion-no reporte-no alpha">
	    		<label class="control-label" for="ramo">Ramo de Seguro</label>
	    		<div class="controls">
	      			<select id="ramo" name="ramo" class="span2">
	      				<option value="1">Todos</option>
	      				<option value="2">1 Riesgos de Tabjo</option>
	      				<option value="3">2 Enfermedad General</option>
	      				<option value="4">3 Maternidad</option>
	      			</select>
	    		</div>
	  		</div>	  			
	  		<!--                                 -->	  
	  		<div class="control-group span4 relacion trabajador-no reporte-no  incapacidad-no alpha">
	    		<label class="control-label" for="registro-patronal-2">Registro Patronal 2</label>
	    		<div class="controls">
	      			<select id="registro-patronal-2" name="reg_pats[]" class="span2">
	      				<option></option>
	      				<?php 
	      				foreach ($patrones as $value) {
	      				 	echo '<option value="'.$value->REG_PAT.'">'.$value->REG_PAT.'</option>';
	      				 } ?>
	      			</select>
	    		</div>
	  		</div>
	  		<div class="control-group span4 relacion trabajador-no reporte-no  incapacidad-no alpha">
	    		<label class="control-label" for="registro-patronal-3">Registro Patronal 3</label>
	    		<div class="controls">
	      			<select id="registro-patronal-3" name="reg_pats[]" class="span2">
	      				<option></option>
	      				<?php 
	      				foreach ($patrones as $value) {
	      				 	echo '<option value="'.$value->REG_PAT.'">'.$value->REG_PAT.'</option>';
	      				 } ?>
	      			</select>
	    		</div>
	  		</div>
		<div class="clear"></div>
	  		<div class="control-group span4 relacion trabajador-no reporte-no  incapacidad-no alpha">
	    		<label class="control-label" for="registro-patronal-4">Registro Patronal 4</label>
	    		<div class="controls">
	      			<select id="registro-patronal-4" name="reg_pats[]" class="span2">
	      				<option></option>
	      				<?php 
	      				foreach ($patrones as $value) {
	      				 	echo '<option value="'.$value->REG_PAT.'">'.$value->REG_PAT.'</option>';
	      				 } ?>
	      			</select>
	    		</div>
	  		</div>

	  		<div class="control-group span4 relacion trabajador-no reporte-no incapacidad-no alpha">
	    		<label class="control-label" for="registro-patronal-5">Registro Patronal 5</label>
	    		<div class="controls">
	      			<select id="registro-patronal-5" name="reg_pats[]" class="span2">
	      				<option></option>
	      				<?php 
	      				foreach ($patrones as $value) {
	      				 	echo '<option value="'.$value->REG_PAT.'">'.$value->REG_PAT.'</option>';
	      				 } ?>
	      			</select>
	    		</div>
	  		</div>
	  		<!-- -->			
	  	</fieldset>
	  	<fieldset class="well span10 info">
	  	</fieldset>	  		
    	<fieldset class="well span10">  		  	
	    		<button class="btn span2 offset1">Generar</button>    			
	    		<a href="<?= site_url()?>" class="btn span2 offset2" >Salir</a>
    	</fieldset>
	</form>
  </div>