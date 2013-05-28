  <script type="text/javascript">
  var cange = [0,0,0];
  	$(document).ready(function(){
  		$("#reg-pat-2").change(function(){
  			if(cange[0] == 0 && $('#reg-pat-4 option').size() > 2){
  				$("#reg-pat-3").removeAttr('disabled');
  				$(this).html('<option value="'+$(this).val()+'"selected>'+$(this).val()+'<option>');
  				for(i=3;i<=5;i++)
  					$("#reg-pat-"+i+" option[value='"+$(this).val()+"']").remove();
  				cange[0] = 1;
  			}
  		});

  		 $("#reg-pat-3").change(function(){
  		 	if(cange[1] == 0 && $('#reg-pat-4 option').size() > 2){
	  		 	$("#reg-pat-4").removeAttr('disabled');
	  		 	$(this).html('<option value="'+$(this).val()+'"selected>'+$(this).val()+'<option>');
	  		 	for(i=4;i<=5;i++)
	  				$("#reg-pat-"+i+" option[value='"+$(this).val()+"']").remove();
	  			cange[1] = 1;
	  		}

  		});

  		 $("#reg-pat-4").change(function(){
  		 	if(cange[2] == 0 && $('#reg-pat-4 option').size() > 2){
  		 		$("#reg-pat-5").removeAttr('disabled');
  		 		$(this).html('<option value="'+$(this).val()+'"selected>'+$(this).val()+'<option>');
  		 		$("#reg-pat-5 option[value='"+$(this).val()+"']").remove();	
  		 		cange[2] = 1;
  		 	}
  		});
  	});
  </script>	
</script>
  <div class="offset1">
  	<!--form class="form-horizontal"-->
  		<?php echo form_open('',array('class'=>'form-horizontal'));?>
  		  <fieldset class="well span10">
	  		<div class="control-group span5 alpha">
	    		<label class="control-label" for="reg-pat-2">Registro Patronal 2</label>
	    		<div class="controls">
	      			<select id="reg-pat-2" name="reg-pat[]" class="span2">
	      				<option></option>
	      				<?php 
	      				foreach ($patrones as $value) {
	      				 	echo '<option value="'.$value->REG_PAT.'">'.$value->REG_PAT.'</option>';
	      				 } ?>
	      			</select>
	    		</div>
	  		</div>
	  		<div class="control-group span5">
	    		<label class="control-label" for="reg-pat-3">Registro Patronal 3</label>
	    		<div class="controls">
	      			<select id="reg-pat-3" name="reg-pat[]" class="span2" disabled>
	      				<option></option>
	      				<?php 
	      				foreach ($patrones as $value) {
	      				 	echo '<option value="'.$value->REG_PAT.'">'.$value->REG_PAT.'</option>';
	      				 } ?>
	      			</select>
	    		</div>
	  		</div>
		<div class="clear"></div>
	  		<div class="control-group span5 alpha">
	    		<label class="control-label" for="reg-pat-4">Registro Patronal 4</label>
	    		<div class="controls">
	      			<select id="reg-pat-4" name="reg-pat[]" class="span2" disabled>
	      				<option></option>
	      				<?php 
	      				foreach ($patrones as $value) {
	      				 	echo '<option value="'.$value->REG_PAT.'">'.$value->REG_PAT.'</option>';
	      				 } ?>
	      			</select>
	    		</div>
	  		</div>

	  		<div class="control-group span5">
	    		<label class="control-label" for="registro-patronal-5">Registro Patronal 5</label>
	    		<div class="controls">
	      			<select id="reg-pat-5" name="reg-pat-5" class="span2" disabled>
	      				<option></option>
	      				<?php 
	      				foreach 	($patrones as $value) {
	      				 	echo '<option value="'.$value->REG_PAT.'">'.$value->REG_PAT.'</option>';
	      				 } ?>
	      			</select>
	    		</div>
	  		</div>
	  		<div class="clear"></div>
	  		<div class="control-group">
	    		<label class="control-label" for="nombre">Nombre o Razon Social</label>
	    		<div class="controls">
	      			<input type="text" id="nombre" name="nombre" class="span7" 
	      			value="<?= empty($patron->NOM_PAT) ?  '':$patron->NOM_PAT ;?>" disabled>
	    		</div>
	  		</div>
	  		 <div class="control-group">
	    		<label class="control-label" for="domicilio">Domicilio</label>
	    		<div class="controls">
	      			<input type="text" id="domicilio" name="domicilio" class="span7" 
	      			value="<?= empty($patron->DOM_PAT) ? '':$patron->DOM_PAT ;?>" disabled>
	    		</div>
	  		</div>
		   	<div class="control-group span5 alpha">
	    		<label class="control-label" for="localidad">Localidad</label>
	    		<div class="controls">
	      			<input type="text" id="localidad" name="localidad" class="span4" 
	      			value="<?= empty($patron->MUN_PAT) ? '':$patron->MUN_PAT ;?>" disabled>
	    		</div>
	  		</div>
	  		<div class="control-group span5 ">
	    		<label class="control-label" for="telefono">Telefono</label>
	    		<div class="controls">
	      			<input type="text" id="telefono" name="telefono" class="span2" 
	      			value="<?= empty($patron->TEL_PAT) ? '':	$patron->TEL_PAT ;?>" disabled>
	    		</div>
	  		</div>
	  		<div class="control-group alpha">
	    		<label class="control-label" for="actividad-economica">Actividad Economica</label>
	    		<div class="controls">
	      			<input type="text" id="actividad-economica" name="actividad-economica" class="span7" value="<?= empty($patron->ACT_PAT) ?  '': $patron->ACT_PAT ;?>" disabled>
	    		</div>
	  		</div>
	  		<div class="control-group alpha">
	    		<label class="control-label" for="representante-legal">Nombre del Patron o Representante Legal</label>
	    		<div class="controls">
	      			<input type="text" id="representante-legal" name="representante-legal" class="span7" value="<?= empty($patron->Pat_Rep) ?  '': $patron->Pat_Rep;?>" disabled>
	    		</div>
	  		</div>
	  		<div class="control-group span2 alpha">
	    		<label class="control-label" for="clase">Clase</label>
	    		<div class="controls">
	      			<input type="text" id="clase" name="clase" class="span1" 
	      			value="<?= empty($patron->Clase) ? '': $patron->Clase;?>" disabled>
	    		</div>
	  		</div>
	  		<div class="control-group span3">
	    		<label class="control-label" for="fraccion">Fracción</label>
	    		<div class="controls">
	      			<input type="text" id="fraccion" name="fraccion" class="span1" 
	      			value="<?= empty($patron->Fraccion) ?  '': $patron->Fraccion ;?>" disabled>
	    		</div>
	  		</div>
	  		<div class="control-group span5">
	    		<label class="control-label" for="prima-anterior">Prima Anterior</label>
	    		<div class="controls">
	      			<input type="text" id="prima-anterior" name="prima-anterior" class="span2" 
	      			value="<?= empty($RT) ? '': $RT;?>" disabled>
	    		</div>
	  		</div>

	  	</fieldset>  		  		

  		<fieldset class="well span10">
  			<div class="control-group span5 well alpha">
	    		<label class="control-label label-large" for="total-casos-rt">Total de casos R.T.</label>
	    		<div class="controls">
	      			<input type="text" id="" name="" class="input-xmini" disabled>
	      			<input type="text" id="total-casos-rt" name="total-casos-rt" class="input-small" 
	      			value="<?= empty($N) ? 0: $N;?>" disabled>
	    		</div>

	    		<label class="control-label label-large" for="total-casos-dias">Total de Dias Subsidiados</label>
	    		<div class="controls">
	      			<input type="text" id="" name="" class="input-xmini" value="S" disabled>	    	
	      			<input type="text" id="total-casos-dias" name="total-casos-dias" class="input-small" value="<?= empty($S) ? 0: $S;?>" disabled>
	    		</div>

	    		<label class="control-label label-large" for="suma-porc">Suma Porc. de Incap. /100</label>
	    		<div class="controls">
	    			<input type="text" id="" name="" class="input-xmini" value="I" disabled>
	      			<input type="text" id="suma-porc" name="suma-porc" class="input-small" value="<?= empty($I) ? 0: ($I/100) ;?>" disabled>
	    		</div>

	    		<label class="control-label label-large" for="defunciones">N° Defunciones</label>
	    		<div class="controls">
	    			<input type="text" id="" name="" class="input-xmini" value="D" disabled>
	      			<input type="text" id="defunciones" name="defunciones" class="input-small" 
	      			value="<?= empty($D) ? 0 : $D ;?>" disabled>
	    		</div>

	    		<label class="control-label label-large" for="trab-prom-rgo">N° de Trab. Prom. Exp. Rgo.</label>
	    		<div class="controls">
	    			<input type="text" id="" name="" class="input-xmini" value="N" disabled>
	      			<input type="text" id="trab-prom-rgo" name="trab-prom-rgo" class="input-small" value="<?= empty($N) ? 0: $N;?>" disabled>
	    		</div>
				<br/>	
	    		<label class="control-label label-large" for="dias-naturales">Dias Naturales del Año</label>
	    		<div class="controls">
	    			<input type="text" id="" name="" class="input-xmini" value="" disabled>
	      			<input type="text" id="dias-naturales" name="dias-naturales" class="input-small" value="<?= empty($S) ? 0: '365';?>" disabled>
	    		</div>

	    		<label class="control-label label-large" for="promedio-vida">Promedio de Vida Activa</label>
	    		<div class="controls">
	    			<input type="text" id="" name="" class="input-xmini" value="V" disabled>
	      			<input type="text" id="promedio-vida" name="promedio-vida" class="input-small" value="<?= empty($V) ? 0: $V;?>" disabled>
	    		</div>

	    		<label class="control-label label-large" for="factor-prima">Factor de Prima</label>
	    		<div class="controls">
	    			<input type="text" id="" name="" class="input-xmini" value="F" disabled>
	      			<input type="text" id="factor-prima" name="factor-prima" class="input-small" value="<?= empty($F) ? 0: $F;?>" disabled>
	    		</div>

	    		<label class="control-label label-large" for="prima-minima">Prima Minima de Riesgos</label>
	    		<div class="controls">
	    			<input type="text" id="" name="" class="input-xmini" value="M" disabled>
	      			<input type="text" id="prima-minima" name="prima-minima" class="input-small" value="<?= empty($M) ? 0: $M;?>" disabled>
	    		</div>
	    		<br>
	  		</div>
	
	<div class="control-group span4 well">
	    		<label class="control-label" for="periodo-computo">Periodo de Computo</label>
	    		<div class="controls">
	      			<select class="input-small" id="periodo-computo" name="periodo-computo">
	      				<option>2013</option>
	      				<option>2012</option>
	      				<option>2011</option>
	      			</select>
	    		</div>
	  		<br/>
				 <a href="#art32" role="button" class="btn offset1" data-toggle="modal">Art. 32 Fraccion VII</a>	    		
	  		</div>
	  		<div class="control-group span4 well">
	    		<label class="control-label label-large" for="acreditacion-st-ps">Acreditación de la ST y PS</label>
	    		<div class="controls">
	      			<input type="text" id="st-ps" name="st-ps" class="span1" 
	      			value="<?= empty($patron->STyPS) ? 'No': $patron->STyPS;?>" disabled>
	    		</div>
	  		</div>
	  		<div class="control-group span4 well">
	    		<label class="control-label" for="prima-resultante">Prima Resultante</label>
	    		<div class="controls">
	      			<input type="text" id="prima-resultante" name="prima-resultante" class="input-small" value="" disabled>
	    		</div>
	  		<br/>
	    		<label class="control-label" for="prima-nueva"><b>Prima Nueva</b></label>
	    		<div class="controls">
	      			<input type="text" id="prima-nueva" name="prima-nueva" class="input-small" value="" disabled>
	    		</div>
	  		</div>

    	</fieldset>
    	<fieldset class="well span10">  		  	
	    		<button type="submit" class="btn span2">Calcular</button>    			
	    		<a href="#" class="btn span3 offset1">Generar Archivo</a>
	    		<a href="<?= site_url()?>" id="salir" class="btn span2 offset1">Salir</a>
    	</fieldset>
	</form>
  </div>
 
<!-- Modal -->
<div id="art32" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="art" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="art">Art. 32 Fraccion VII</h3>
  </div>
  <div class="modal-body">
    <p>Del Reglamento de la Ley del Seguro Social en Materia de Afiliación, Clasificación de Empresas, Recaudación y Fiscalización.</p>

	<p>Cuando la Empresa tenga asignados diversos números de registro patronal en un mismo municipio o en el Distrito Federal, con excepción de los casos señalados en el Art. 21 del reglamento de esta materia, para el cálculo de la prima se tomarán las consecuencias de los casos de riesgo de trabajo acaecidos al personal de la empresa en un municipio o en el Distrito Federal y terminados durante el período de cómputo.</p>

	<p>En caso de que la empresa tenga registrados centros de trabajo en distintos municipios determinará la prima de dichos centros, inclusive aquéllos que cuenten únicamente con trabajadores eventuales o temporales con independencia de los que se encuentran en otro municipio.</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div>