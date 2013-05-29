
<script type="text/javascript">
$(document).ready(function(){
	$("#salir").click(function(){
		location.href="<?= base_url()?>";
	});
});
	
</script>
<div class="offset1">
<?php echo form_open('',array('class'=>'form-horizontal'));?>
  		  <fieldset class="well span10">	  	
	  		<div class="control-group">
	    		<label class="control-label" for="anio">Año a Calcular</label>
	    		<div class="controls">
	     			<select id="anio" name="anio">
	      				<?php for ($i=1997; $i < date('Y')+2; $i++) { 
	      					if($anio == $i)
	      						echo '<option selected>'.$i.'</option>';
	      					else
	      						echo '<option>'.$i.'</option>';
	      				}?>
	     			</select>
	    		</div>
	  		</div>
	  		<div class="control-group span5 alpha">
	    		<label class="control-label" for="enero">Enero</label>
	    		<div class="controls">
	      			<input type="text" id="enero" name="enero" class="span2" value="<?=empty($Meses) ? '': $Meses[1];?>" disabled>
	    		</div>
	    		<label class="control-label" for="febrero">Febrero</label>
	    		<div class="controls">
	      			<input type="text" id="febrero" name="febrero" class="span2" value="<?=empty($Meses) ? '': $Meses[2];?>" disabled>
	    		</div>

	    		<label class="control-label" for="marzo">Marzo</label>
	    		<div class="controls">
	      			<input type="text" id="marzo" name="marzo" class="span2" value="<?=empty($Meses) ? '': $Meses[3];?>" disabled>
	    		</div>

	    		<label class="control-label" for="abril">Abril</label>
	    		<div class="controls">
	      			<input type="text" id="abril" name="abril" class="span2" value="<?=empty($Meses) ? '': $Meses[4];?>" disabled>
	    		</div>

	    		<label class="control-label" for="mayo">Mayo</label>
	    		<div class="controls">
	      			<input type="text" id="mayo" name="mayo" class="span2" value="<?=empty($Meses) ? '': $Meses[5];?>" disabled>
	    		</div>

	    		<label class="control-label" for="junio">Junio</label>
	    		<div class="controls">
	      			<input type="text" id="junio" name="junio" class="span2" value="<?=empty($Meses) ? '': $Meses[6];?>" disabled>
	    		</div>

	    		<label class="control-label" for="julio">Julio</label>
	    		<div class="controls">
	      			<input type="text" id="julio" name="julio" class="span2" value="<?=empty($Meses) ? '': $Meses[7];?>" disabled>
	    		</div>

	    		<label class="control-label" for="agosto">Agosto</label>
	    		<div class="controls">
	      			<input type="text" id="agosto" name="agosto" class="span2" value="<?=empty($Meses) ? '': $Meses[8];?>" disabled>
	    		</div>

	    		<label class="control-label" for="septiembre">Septiembre</label>
	    		<div class="controls">
	      			<input type="text" id="septiembre" name="septiembre" class="span2" value="<?=empty($Meses) ? '': $Meses[9];?>" disabled>
	    		</div>

	    		<label class="control-label" for="octubre">Octubre</label>
	    		<div class="controls">
	      			<input type="text" id="octubre" name="octubre" class="span2" value="<?=empty($Meses) ? '': $Meses[10];?>" disabled>
	    		</div>

	    		<label class="control-label" for="noviembre">Noviembre</label>
	    		<div class="controls">
	      			<input type="text" id="noviembre" name="noviembre" class="span2" value="<?=empty($Meses) ? '': $Meses[11];?>" disabled>
	    		</div>

	    		<label class="control-label" for="diciembre">Diciembre</label>
	    		<div class="controls">
	      			<input type="text" id="diciembre" name="diciembre" class="span2" value="<?=empty($Meses) ? '': $Meses[12];?>" disabled>
	    		</div>

	    		<label class="control-label" for="total">Total = </label>
	    		<div class="controls">
	      			<input type="text" id="total" name="total" class="span2" value="<?=empty($Meses) ? '': $Total - $S;?>" disabled>
	    		</div>
	  		</div>
	  		<div class="control-group span5 alpha">
	    		<label class="control-label" for="dias-cotizados">Total de Dias Cotizados</label>
	    		<div class="controls">
					<input type="text" id="dias-cotizados" name="dias-cotizados" class="span2" value="<?=empty($Meses) ? '': $Total - $S;?>" disabled>
	    		</div>
	  		</div>
	  		<div class="control-group span5 alpha">
	  			<label class="control-label" for="dias-anuales">Dividido entre 365 dias del año</label>
	  			<div class="controls">
	  				<input type="text" id="dias-anuales" name="dias-anuales" class="span2" value="<?= empty($Meses)? '':365;?>" disabled>
	  			</div>
	  		</div>
	  		<div class="control-group span5 alpha">
	  			<label class="control-label" for="trabajadores-rt">Trabajadores Promedio Expuestos a Riesgos</label>
	  			<div class="controls">  <!-- substr(($Total-$Meses[0])/365,0,3) -->
	  				<input type="text" id="trabajadores-rt" name="trabajadores-rt" class="span2" value="<?= empty($Meses)? '': $N ;?>" disabled>
	  			</div>
	  		</div>
	  	</fieldset>  		  		  		
    	<fieldset class="well span10">  		  	
	    		<button type="submit" class="btn span2 offset1">Calcular</button>    			
	    		<button id="salir" type="button" class="btn span2 offset4">Salir</button>
    	</fieldset>
	</form>
  </div>
