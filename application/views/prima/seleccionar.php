  <script type="text/javascript">
  	$(document).ready(function(){

  		$('#select-patron').modal({show:true});
  		$(".select").click(function(){  			
  			//$("input").attr('checked', false);
  			$("input[value='"+$(this).attr('rel')+"']").attr('checked', true);
  		});
  	});
  </script>	 
<?php echo form_open('',array('class'=>'form-horizontal'));?>
 <!-- Modal -->
<div id="select-patron" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="patron" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="patron">Selecciona Un Patron</h3>
  </div>
  <div class="modal-body">
  		<table class="table table-hover">
  			<thead>
				 <tr>
				 	<th></th>
				 	<th></th>
				 	<th>Registro Patronal</th>
				 	<th>Nombre</th>
				 </tr>
			</thead>
			 <tbody>
				 <?php
				 foreach ($patrones as $patron) {		 	
				 echo '<tr class="select" rel="'.$patron->REG_PAT.'">
				 	<td></td>
				 	<td class="radio"><input type="radio" name="patron" value="'.$patron->REG_PAT.'"></td>
				 	<td>'.$patron->REG_PAT.'</td>
				 	<td>'.$patron->NOM_PAT.'</td>
				 </tr>';
				}
				 ?>
 			</tbody>				 
		</table>
  </div>
  <div class="modal-footer">
    <button class="btn" type="submit">Seleccionar</button>
    <button class="btn" type="button" data-dismiss="modal" aria-hidden="true">Cerrar</button>
  </div>
</div>
</form>