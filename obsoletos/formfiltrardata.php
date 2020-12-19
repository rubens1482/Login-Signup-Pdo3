
	<form class="form-inline" name="form_filtro_cat" method="get" action="" onsubmit="return valida_form(this)">
		<span><strong> filtrar por cod/desc: </strong></span><input type="text" name="busca" class="form-control input-sm" style="width:180px;" value="">
		<span><strong> Data inicial: </strong></span><input type="text" name="data_i" id="data_i" class="form-control input-sm"  style="width:110px;" value="" >
		<span><strong> Data final: </strong></span><input type="text" name="data_f" id="data_f" class="form-control input-sm"  style="width:110px;" value="">
		<span><strong><label> Categoria: </label></strong></span>
		<input type="hidden" name="data_hoje" value="<?php echo $dia_hoje . "-" . mostraMes($mes_hoje) ."-" . $ano_hoje ?>">
		<a href="#modal_date" class="btn btn-sm btn-success " name="modal_date" data-toggle="modal">
			<i class="glyphicon glyphicon-plus"></i> pdf
		</a>
		<button type="submit" name="filtrar_data" class="btn btn-default btn-sm"  value="Filtrar" >Filtrar</button>	
	</form>
	