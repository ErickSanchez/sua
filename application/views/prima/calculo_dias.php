<div class="offset1">
  	<?php echo form_open('',array('class'=>'form-horizontal'));?>
  		  <fieldset class="well span10">	  	
	  		<div class="control-group">
	    		<label class="control-label" for="registro-patronal-5">Año a Calcular</label>
	    		<div class="controls">
	      			<select>
	      				<option></option>
	      				<option>2013</option>
	      				<option>2012</option>
	      				<option>2011</option>
	      			</select>
	    		</div>
	  		</div>
	  		<div class="control-group span5 alpha">
	    		<label class="control-label" for="enero">Enero</label>
	    		<div class="controls">
	      			<input type="text" id="enero" name="enero" class="span2" value="">
	    		</div>
	    		<label class="control-label" for="febrero">Febrero</label>
	    		<div class="controls">
	      			<input type="text" id="febrero" name="febrero" class="span2" value="">
	    		</div>

	    		<label class="control-label" for="marzo">Marzo</label>
	    		<div class="controls">
	      			<input type="text" id="marzo" name="marzo" class="span2" value="">
	    		</div>

	    		<label class="control-label" for="abril">Abril</label>
	    		<div class="controls">
	      			<input type="text" id="abril" name="abril" class="span2" value="">
	    		</div>

	    		<label class="control-label" for="mayo">Mayo</label>
	    		<div class="controls">
	      			<input type="text" id="mayo" name="mayo" class="span2" value="">
	    		</div>

	    		<label class="control-label" for="junio">Junio</label>
	    		<div class="controls">
	      			<input type="text" id="junio" name="junio" class="span2" value="">
	    		</div>

	    		<label class="control-label" for="julio">Julio</label>
	    		<div class="controls">
	      			<input type="text" id="julio" name="julio" class="span2" value="">
	    		</div>

	    		<label class="control-label" for="agosto">Agosto</label>
	    		<div class="controls">
	      			<input type="text" id="agosto" name="agosto" class="span2" value="">
	    		</div>

	    		<label class="control-label" for="septiembre">Septiembre</label>
	    		<div class="controls">
	      			<input type="text" id="septiembre" name="septiembre" class="span2" value="">
	    		</div>

	    		<label class="control-label" for="obtubre">Obtubre</label>
	    		<div class="controls">
	      			<input type="text" id="obtubre" name="obtubre" class="span2" value="">
	    		</div>

	    		<label class="control-label" for="noviembre">Noviembre</label>
	    		<div class="controls">
	      			<input type="text" id="noviembre" name="noviembre" class="span2" value="">
	    		</div>

	    		<label class="control-label" for="diciembre">Diciembre</label>
	    		<div class="controls">
	      			<input type="text" id="diciembre" name="diciembre" class="span2" value="">
	    		</div>
	  		</div>
	  		<div class="control-group span5 alpha">
	    		<label class="control-label" for="dias-cotizados">Total de Dias Cotizados</label>
	    		<div class="controls">
					<input type="text" id="dias-cotizados" name="dias-cotizados" class="span2" value="">
	    		</div>
	  		</div>
	  		<div class="control-group span5 alpha">
	  			<label class="control-label" for="dias-anuales">Dividido entre 365 dias del año</label>
	  			<div class="controls">
	  				<input type="text" id="dias-anuales" name="dias-anuales" class="span2" value="">
	  			</div>
	  		</div>
	  		<div class="control-group span5 alpha">
	  			<label class="control-label" for="trabajadores-rt">Trabajadores Promedio Expuestos a Riesgos</label>
	  			<div class="controls">
	  				<input type="text" id="trabajadores-rt" name="trabajadores-rt" class="span2" value="">
	  			</div>
	  		</div>
			<div class="span5 alpha"><br/><br/><br/><br/><br/></div>
	  		<div class="control-group span5 alpha">
	  			<label class="control-label" for="avance">Avance</label>
	  			<div class="controls">
	  				<input type="text" id="avance" name="avance" class="span2" value="" disabled>	
	  			</div>
	  			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  			<input type="text" id="" name="" class="span4 omega" value="" disabled>
	  		</div>

	  		<div class="control-group span8 offset1">	  		
	    			Comentarios del Proceso
	      			<textarea id="comentarios" name="comentarios" class="span8" disabled></textarea>
	  		</div>	  		
	  	</fieldset>  		  		  		
    	<fieldset class="well span10">  		  	
	    		<button class="btn span2 offset1">Calcular</button>    			
	    		<button class="btn span2 offset4">Salir</button>
    	</fieldset>
	</form>
  </div>
