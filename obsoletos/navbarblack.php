<nav class="navbar navbar-inverse navbar-fixed-top " >
	<div class="container">
		<div class="navbar-header" >
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"> ok</span>
			<span class="icon-bar"> vamos </span>
			<span class="icon-bar"> terá </span>
		  </button>
		  <a class="navbar-brand" href="http://www.localhost/Login-Signup-Pdo/home.php">Livro Caixa <?php print $accountRow['conta'] ?></a>
		</div>
		<div id="navbar" class="navbar-collapse collapse" >
			<ul class="nav navbar-nav">
				<li><a href="?mes=<?php echo date('m')?>&ano=<?php echo date('Y')?>"><?php print "Hoje &eacute:"?><strong> <?php echo date('d')?> de <?php echo mostraMes(date('m'))?> de <?php echo date('Y')?></strong></a></li>	
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				  <span class="glyphicon glyphicon-user"></span> Ir Para <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="list_cat.php"> Adicionar Categorias </a></li>
						<li class="divider"></li>
						<li><a href="filtrarpordata.php"> Filtrar por Data </a></li>
						<li class="divider"></li>
						<li><a href="filtrarporfolha.php"> Filtrar por Folha </a></li>
						<li class="divider"></li>
						<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> profile</a></h5></li>
						<li class="divider"></li>
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				  <span class="glyphicon glyphicon-user"></span>&nbsp;Conta: <?php echo $accountRow['idconta'] . "-" . $accountRow['conta']; ?>&nbsp;<span class="caret"></span></a>
				  <ul class="dropdown-menu">
					<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>
					<li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
				  </ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
				  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				  <span class="glyphicon glyphicon-user"></span>&nbsp;Usu&aacute;rio: <?php echo $userRow['user_name']; ?>&nbsp;<span class="caret"></span></a>
					  <ul class="dropdown-menu">
						<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span>&nbsp;View Profile</a></li>
						<li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
					  </ul>
				</li>
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>