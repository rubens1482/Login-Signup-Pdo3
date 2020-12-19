<div class="container-fluid" style="margin-top:80px; margin-left:160px; margin-right: 160px; ">
		
			<div class="row" style="border: solid; margin: 0 auto;">
				<div class="col-sm-2" style="border: solid; text-align: center; height: 50px; width: 150px; margin: 0 auto;">
					<select class="form-control" id="sel1" onchange="location.replace('?mes=<?php echo $mes_hoje?>&ano='+this.value)">
						<?php
							for ($i=2004;$i<=2050;$i++){
							?>
							<option value="<?php echo $i?>" <?php if ($i==$ano_hoje) echo "selected=selected"?> ><?php echo $i?></option>
						<?php }?>
					</select>
				</div>
				<div class="col-sm-10">
					<ul class="pagination pagination-centered" >
						<?php
							for ($i=1;$i<=12;$i++){
						?>
						<?php if($mes_hoje==$i){?>
							<li class="active">	
								<a href="?mes=<?php echo $i?>&ano=<?php echo $ano_hoje?>">
								<?php }else{?>
							<li style="background-color: #dff";>
								<a href="?mes=<?php echo $i?>&ano=<?php echo $ano_hoje?>">
								
								<?php } ?>	
								<?php echo mostraMes($i);?>
								</a>
							</li>	
								<?php } ?>
					</ul>	
				</div>
				<div class="col-sm-2" style="border: solid; text-align: center; height: 50px; width: 150px; ">
					<a href="#"><button type="button"><h2><?php echo mostraMes($mes_hoje)?>/<?php echo $ano_hoje?></button></a> &nbsp;
				</div>
			</div>
		
		</div>
	</div>