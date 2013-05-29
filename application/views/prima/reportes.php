<div class="row">
  <div class="span12 offset1">
  <?php echo form_open('',array('class'=>'form-horizontal'));?>
  <fieldset class="well">
  		<div class="control-group span10">
	    		<label class="control-label" for="registro-patronal-5">Seleccione Reporte</label>
	    		<div class="controls">
	      			<select>
	      				<option></option>
                        <option name="trabajadores">Trabajadores Promedio Expuestos al Riesgo</option>
	      				<option name="reporte">Reporte de Riesgos de Trabajo</option>
                        <option name="caratula">Car&aacute;tula del Formulario</option>
	      				<option name="relacion">Relaci&oacute;n de Casos de R.T.</option>
                        <option name="incapacidad">Incapacidades de Trabajadores</option>
                    </select>	  	
                </div>
	  		</div>
            <div class="control-group span10 offset1">	  	
	      			<textarea class="span9" disabled style="height:200px;"></textarea>
	  		</div>
            <fieldset class="well">  		  	
	    		<button class="btn span3 offset1">Generar</button>    			
	    		<button class="btn span3 offset3">Salir</button>
    	</fieldset>

  </div>
</div>