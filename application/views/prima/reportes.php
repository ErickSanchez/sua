<script type="text/javascript">
	$(document).ready(function(){
		
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
	    		<label class="control-label" for="reporte">Seleccione el Reporte</label>
	    		<div class="controls">
	      			<select id="tipo-reporte" name="tipo-reporte" class="span5">
	      				<option value="1">Trabajadores Promedio Expuestos al Riesgo</option>
	      				<option value="2">Reporte de Riesgos de Trabajo</option>
	      				<option value="3">Carátula del Formulario</option>
	      				<option value="4">Relación de Casos de R.T</option>
	      				<option value="5">Incapacidades de Trabajadores</option>
	      			</select>
	    		</div>
	  		</div>
	  		<div class="control-group trabajador relacion reporte-no  incapacidad-no alpha">
	    		<label class="control-label" for="periodo">Período de Reporte</label>
	    		<div class="controls">
	      			<select id="periodo" name="periodo" class="span2">
	      				<option value="2013">2013</option>
	      				<option value="2012">2012</option>
	      				<option value="2011">2011</option>
	      				<option value="2010">2010</option>
	      				<option value="2009">2009</option>
	      				<option value="2008">2008</option>
	      				<option value="2007">2007</option>
	      				<option value="2006">2006</option>
	      				<option value="2005">2005</option>
	      				<option value="2004">2004</option>
	      				<option value="2003">2003</option>
	      				<option value="2002">2002</option>
	      				<option value="2001">2001</option>
	      				<option value="2000">2000</option>
	      				<option value="1999">1999</option>
	      				<option value="1998">1998</option>
	      				<option value="1997">1997</option>
	      			</select>
	    		</div>
	  		</div>	  			
	  		<div class="control-group span4 reporte incapacidad trabajador-no relacion-no alpha">
	    		<label class="control-label" for="fecha-inicio">Fecha Inicial</label>
	    		<div class="controls">
					<input type="date" id="fecha-inicio" name="fecha-inicio" class="span2">
	    		</div>
	  		</div>

	  		<div class="control-group span4 reporte incapacidad trabajador-no relacion-no alpha">
	    		<label class="control-label" for="fecha-fin">Fecha Final</label>
	    		<div class="controls">
					<input type="date" id="fecha-fin" name="fecha-fin" class="span2">
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
	      			<select id="registro-patronal-2" name="registro-patronal-2" class="span2">
	      				<option></option>
	      				<option></option>
	      				<option></option>
	      			</select>
	    		</div>
	  		</div>
	  		<div class="control-group span4 relacion trabajador-no reporte-no  incapacidad-no alpha">
	    		<label class="control-label" for="registro-patronal-3">Registro Patronal 3</label>
	    		<div class="controls">
	      			<select id="registro-patronal-3" name="registro-patronal-3" class="span2">
	      				<option></option>
	      				<option></option>
	      				<option></option>
	      			</select>
	    		</div>
	  		</div>
		<div class="clear"></div>
	  		<div class="control-group span4 relacion trabajador-no reporte-no  incapacidad-no alpha">
	    		<label class="control-label" for="registro-patronal-4">Registro Patronal 4</label>
	    		<div class="controls">
	      			<select id="registro-patronal-4" name="registro-patronal-4" class="span2">
	      				<option></option>
	      				<option></option>
	      				<option></option>
	      			</select>
	    		</div>
	  		</div>

	  		<div class="control-group span4 relacion trabajador-no reporte-no incapacidad-no alpha">
	    		<label class="control-label" for="registro-patronal-5">Registro Patronal 5</label>
	    		<div class="controls">
	      			<select id="registro-patronal-5" name="registro-patronal-5" class="span2">
	      				<option></option>
	      				<option></option>
	      				<option></option>
	      			</select>
	    		</div>
	  		</div>
	  		<!-- -->			
	  	</fieldset>
	  	<fieldset class="well span10 info ">
	  	</fieldset>	  		
    	<fieldset class="well span10">  		  	
	    		<button class="btn span2 offset1">Generar</button>    			
	    		<button class="btn span2 offset2">Salir</button>
    	</fieldset>
	</form>
  </div>