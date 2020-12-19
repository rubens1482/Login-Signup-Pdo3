	<div class="panel panel-danger" >
		<!--  CABEÇALHO DA TABELA DE DADOS -->
		<div class="panel-heading"  >
			<div class="row">
				<div class="col-sm-6" >
					<strong>RELATORIO DE CAIXA <?php if (isset($_GET['data_i'])){ ?>Data Inicial:  <?php echo invertData($data_i) ?><?php }else{ ?> :  <?php echo $mes_hoje ?>/<?php echo $ano_hoje ?><?php }?></strong>
				</div>
				<div class="col-sm-6" style="text-align: right;">
					<strong>
						<?php if (isset($_GET['filtrar_data'])){ $saldoanterior = $saldo_dti?>
							SALDO ANTERIOR:  <?php echo formata_dinheiro($saldoanterior) ?>
						<?php }else{ $saldoanterior = $saldo_ant?>
							SALDO ANTERIOR:  <?php echo formata_dinheiro($saldoanterior) ?>
						<?php }?>
					</strong>
				</div>
			</div>
		</div>
		<!--  CORPO DA TABELA DE DADOS -->
		<div class="panel-body" >
			<div class="container-fluid" >
				<table id="tb_home_filtrar" class="table table-responsive table-bordered table-striped table-condensed table-hover" >
					<thead>
						<th style=" text-align: center;">Seq.</th>
						<th style=" text-align: center;">Id.</th>
						<th style=" text-align: center;">Data</th>
						<th style=" text-align: left;">Descricao</th>
						<th style=" text-align: center;">Categoria</th>
						<th style=" text-align: center;">Folha</th>
						<th style=" text-align: center;">Entradas</th>
						<th style=" text-align: center;">Saidas</th>
						<th style=" text-align: center;">Saldo</th>
					</thead>					
					<tbody>
						<?php
							$pdo = new Database();
							$db = $pdo->dbConnection();
						
							// VERIFICAR SE O CAMPO BUSCA FOI PREENCHIDO
							if(isset($_GET['busca']) && $_GET['busca'] != ''){
								$busca = $_GET['busca'];
							} else{
								$busca = '';
							}
							// VERIFICAR SE A DATA INICIAL FOI PREENCHIDA
							if(isset($_GET['data_i']) && $_GET['data_i'] != ''){
								$data_i = invertData($_GET['data_i']);
							} else{
								$data_i = '';
							}
							// VERIFICAR SE A DATA FINAL FOI PREENCHIDA
							if(isset($_GET['data_f']) && $_GET['data_f'] != ''){
								$data_f = invertData($_GET['data_f']);
							} else{
								$data_f = '';
							}
							// COMANDOS SQL PARA VERIFICAR CAMPO BUSCA, DATA INICIAL E DATA FINAL
							if(isset($_GET['data_i']) && isset($_GET['data_f'])){
								$stmt = $db->prepare("SELECT * FROM lc_movimento WHERE idconta=:contapd and descricao LIKE :busca and datamov>=:data_i and datamov<=:data_f ORDER BY datamov ASC");
								$stmt->bindparam(':contapd', $contapd );
								$stmt->bindvalue(':busca', '%'.$busca.'%' );
								$stmt->bindparam(':data_i', $data_i );
								$stmt->bindparam(':data_f', $data_f );							
								$stmt->execute();
								$result = $stmt->fetchAll(PDO::FETCH_ASSOC);	
							}else{
								
								$stmt = $db->prepare("SELECT * FROM lc_movimento WHERE idconta=:contapd and month(datamov)=:mes_hoje and year(datamov)=:ano_hoje ORDER BY datamov ASC");
								$stmt->bindparam(':contapd', $contapd );
								$stmt->bindparam(':mes_hoje', $mes_hoje );
								$stmt->bindparam(':ano_hoje', $ano_hoje );
								
								$stmt->execute();
								$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
							}
							 
							$cont=0;
							$seq=0;
							$saldo=0;
							
							foreach ($result as $row) {
							$cont++;
							$seq++;
							
							$cat = $row['cat'];
							$stmt = $db->prepare("SELECT * FROM lc_cat WHERE id='$cat'");
							$stmt->execute();
							$qr2=$stmt->fetch(PDO::FETCH_ASSOC);
							$categoria = $qr2['nome'];	
						?>
						
						<tr >
							<td style=" text-align: center; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><?php echo $seq; ?></strong></td>
							<td style=" text-align: center; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>">
								<a style=" text-align: center; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>" href="#edit<?php echo $row['id']; ?>" data-toggle="modal" name="btn_edit_mov" ><strong style="font-size:12px;"><i><u><?php echo $row['id']; ?></u></i></strong></a>									
							<?php include('operations/edit_mov.php'); ?>
							</td>
							<td style=" text-align: center; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><?php echo InvertData($row['datamov']); ?></strong></td>
							<td style=" text-align: left; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><?php echo $row['descricao']; ?></strong></td>
							<td style=" text-align: left; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><?php echo $row['cat']; ?> - <a style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>" href="?mes=<?php echo $mes_hoje?>&ano=<?php echo $ano_hoje?>&filtro_cat=<?php echo $cat?>"><strong style="font-size:12px;"><?php echo $categoria?></a></td>
							<td style=" text-align: center; color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><strong style="font-size:12px;"><?php echo $row['folha']; ?></strong></td>
							<td style=" text-align: center;">
								<p style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#0000FF"?>"><?php if ($row['tipo']==1) echo "+" ; else echo ""?><strong style="font-size:12px;"><?php if ($row['tipo']==1) echo formata_dinheiro($row['valor']); else echo "";?></strong></p>
							</td>
							<td style=" text-align: center;">
								<p style="color:<?php if ($row['tipo']==0) echo "#C00"; else echo "#030"?>"><?php if ($row['tipo']==0) echo "-"; else echo ""?><strong style="font-size:12px;"><?php if ($row['tipo']==0) echo formata_dinheiro($row['valor']); else echo ""?></strong></p>
							</td>
							<?php if ($row['tipo']==1) formata_dinheiro($saldo=$saldo+$row['valor']); else formata_dinheiro($saldo=$saldo-$row['valor']); ?>
							<?php if(isset($_POST["filtrar_data"])) $acumulado = $saldoanterior + $saldo; else $acumulado = $saldoanterior+$saldo;?>
							<td style=" text-align: center;">
								<p style="color:<?php if ($acumulado>0) echo "#00f"; else echo"#C00" ?>"><strong style="font-size:12px;"><?php echo formata_dinheiro($acumulado);?></strong></p>
							</td>							
						</tr>					
						<?php  } ?>						
					</tbody>
				</table>
			</div>
		</div>
		<!--  RODAPÉ DA TABELA DE DADOS -->
		<div class="panel-footer" >
			<div class="container-fluid" >
				<table id="tb_home_f" class="table table-responsive table-bordered table-striped table-condensed table-hover" >
					<tr>
						<td style="width:220px; text-align: right; " COLSPAN="4"><strong> A TRANSPORTAR TOTAIS DO DIA </strong></td>
						<td style="width:100px; text-align: center; ">
							<strong>
								<span style="font-size:12px; color:<?php echo "#0000FF" ?>">
									<?php if (isset($_GET['filtrar_data'])){ $entradas_per = $entradas_ep?>
									<?php echo formata_dinheiro($entradas_ep) ?>
									<?php }else{ $entradas_per = $entradas_m?>
									<?php echo formata_dinheiro($entradas_per) ?>
									<?php }?>
								</span>
							</strong>
						</td>
						<td style="width:100px; text-align: center; ">
							<strong>
								<span style="font-size:12px; color:<?php echo "#C00" ?>">
									<?php if (isset($_GET['filtrar_data'])){ $saidas_per = $saidas_ep?>
									<?php echo formata_dinheiro($saidas_ep) ?>
									<?php }else{ $saidas_per = $saidas_m?>
									<?php echo formata_dinheiro($saidas_per) ?>
									<?php }?>
								</span>
							</strong>
						</td>
						<td style="width:100px; text-align: center; "><?php echo "" ?></td>
					</tr>
					<tr>
						<td style="width:180px; text-align: right; " COLSPAN="4"><strong> SALDO ANTERIOR </strong></td>
						<td style="width:100px; text-align: center; ">
							<strong>
								<span style="font-size:12px; color:<?php echo "#006400" ?>">
									<?php if (isset($_GET['filtrar_data'])){ $saldoanterior = $saldo_dti?>
									<?php echo formata_dinheiro($saldoanterior) ?>
									<?php }else{ $saldoanterior = $saldo_ant?>
									<?php echo formata_dinheiro($saldoanterior) ?>
									<?php }?>
								</span>
							</strong>
						</td>
						<td style="width:100px; text-align: center; "></td>
						<td style="width:100px; text-align: center; "></td>
					</tr>
					<tr>
						<td style="width:180px; text-align: right; " COLSPAN="4"><strong> SALDO ATUAL </strong></td>
						<td style="width:100px; text-align: center; "></td>
						<td style="width:100px; text-align: center; "></td>
						<td style="width:100px; text-align: center; ">
							<strong>
								<span style="font-size:14px; color:<?php echo "#006400" ?>">
									<?php if (isset($_GET['filtrar_data'])){ $saldo_atual = $saldo_dti+$entradas_ep-$saidas_ep?>
									<?php echo formata_dinheiro($saldo_atual) ?>
									<?php }else{ $saldo_atual = $resultado_mes?>
									<?php echo formata_dinheiro($saldo_atual) ?>
									<?php }?>
								</span>
							</strong>
						</td>
					</tr>
				</table>
			</div>
		</div>
	</div>