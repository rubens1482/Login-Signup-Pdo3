<!--  FORMULARIO DE FILTROS: DATAS, CATEGORIAS -->
<div class="container-fluid" style="margin-top:0px; margin-left:120px; margin-right: 120px; padding: 0;">
	<div class="container container-fluid" style="margin-top: 0px; margin-left: 0px; margin-right: 5px; padding: 0; width:100%; ">
	<!-- FORMULARIO DE BUSCA, DATA INICIAL, DATA FINAL E FILTRO DE CATEGORIAS  -->
		<form class="form-inline" name="form_filtro_cat" method="get" action="">
			<div class="panel panel-default">
				<div class="panel-body">	
					<span><strong> filtrar por cod/desc: </strong></span><input type="text" name="filtrar" class="form-control input-sm" style="width:180px;" value="">
					<span><strong><label> Categoria: </label></strong></span>
						<select class="form-control input-sm" name="filtro_cat" style="width: 90px;" onchange="form_filtro_cat.submit()" >
						<option value="">Tudo</option>	
							<?php
							$sql = $db->prepare("SELECT DISTINCT c.id, c.nome FROM lc_cat c, lc_movimento m WHERE m.cat=c.id and m.idconta=:contapd and month(m.datamov)=:mes_hoje and year(m.datamov)=:ano_hoje");
							$sql->bindparam(':contapd', $contapd );
							$sql->bindparam(':mes_hoje', $mes_hoje );
							$sql->bindparam(':ano_hoje', $ano_hoje );
							$sql->execute();
							while ($row = $sql->fetch(PDO::FETCH_ASSOC)) { ?>
							<option <?php if (isset($_GET['filtro_cat']) && $_GET['filtro_cat']==$row['id'])echo "selected=selected"?> value="<?php echo $row['id']?>"><?php echo $row['nome']?></option>
							<?php } ?>
						</select>
					<input type="hidden" name="data_hoje" value="<?php echo $dia_hoje . "-" . mostraMes($mes_hoje) ."-" . $ano_hoje ?>">
					<button type="submit" name="enviar" class="btn btn-default btn-sm"  value="Filtrar" style="border: solid 1px; border-radius:1px; box-shadow: 1px 1px 1px 1px black; width:80px;" >Filtrar</button>	
				</div>
			</div>
		</form>
	</div>
</div>