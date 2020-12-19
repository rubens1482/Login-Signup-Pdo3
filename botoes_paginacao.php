<form>
	<!-- PRIMEIRA PAGINA -->
	<?php if ( $pagina > 1) {?>
		<a href="<?php $PHP_SELF ?>?pagina=<?php echo ($pripagina);?><?php echo $busca ?>" class="btn  btn-success" ><span class="glyphicon glyphicon-fast-backward"></span> Primeiro</a>
	<?php } else { ?>
		<a href="<?php $PHP_SELF ?>?pagina=<?php echo ($pripagina);?><?php echo $busca ?>" class="btn  btn-danger"  disabled><span class="glyphicon glyphicon-fast-backward"></span> Primeiro</a>
	<?php } ?> 
	||
	<!-- PAGINA ANTERIOR -->
	<?php if ( $pagina > 1) {?>
		<a href="<?php @$PHP_SELF ?>?pagina=<?php echo $anterior ?><?php echo $busca ?>" class="btn btn-success" ><span class="glyphicon glyphicon-backward"></span> Anterior </a>
	<?php } else { ?>
		<a href="<?php @$PHP_SELF ?>?pagina=<?php echo $anterior ?><?php echo $busca ?>" class="btn btn-danger"  disabled><span class="glyphicon glyphicon-backward"></span> Anterior </a>
	<?php }?>

	<!-- NUMERO DE PAGINAS ATUAIS -->
	||			
	<?php if($numPaginas > 1 && $pagina <= $numPaginas){
		
		for($i = $pagina - 3, $limiteDeLinks = $i + 6; $i <= $limiteDeLinks; $i++){
			if($i < 1) {
				$i = 1;
				$limiteDeLinks = 7;
			}
			if ($limiteDeLinks > $numPaginas){
				$limiteDeLinks = $numPaginas;
				$i = $limiteDeLinks - 4;
			}
			if ($i < 1){
				$i = 1;
				$limiteDeLinks = $numPaginas;
			}
			if( $i == $pagina){ ?>
		<span class="btn btn-danger"  disabled ><?php echo  $i ?></span>
	<?php } else { ?>
		<a href="<?php @$PHP_SELF ?>?pagina=<?php echo $i;?><?php echo $busca ?>"><input type="button" class="btn btn-info" value="<?php echo $i ?>" ></a>
	<?php }
		}
	}
	?>
	||
	<!-- PROXIMA PAGINA -->
	<?php if (($pagina) < $numPaginas) { ?>			
		<a href="<?php $PHP_SELF ?>?pagina=<?php echo ($pagina+1) ?><?php echo $busca ?>" class="btn btn-success" > Proximo <span class="glyphicon glyphicon-forward"></span></a>	
	<?php } else { 	?>	
		<a href="<?php $PHP_SELF ?>?pagina=<?php echo ($pagina+1) ?><?php echo $busca ?>" class="btn btn-danger"  disabled> Proximo <span class="glyphicon glyphicon-forward"></span></a>		
	<?php }	?>
	||
	<!-- ULTIMA PAGINA -->
	<?php if ( $pagina < $numPaginas) {?>
		<a href="<?php @$PHP_SELF ?>?pagina=<?php echo $ultpagina  ?><?php echo $busca ?>" class="btn btn-success" > Ultimo <span class="glyphicon glyphicon-fast-forward"></span></a>
	<?php } else { ?>
		<a href="<?php @$PHP_SELF ?>?pagina=<?php echo $ultpagina  ?><?php echo $busca ?>" class="btn btn-danger"  disabled> Ultimo <span class="glyphicon glyphicon-fast-forward"></span></a>
	<?php } ?>
</form>	