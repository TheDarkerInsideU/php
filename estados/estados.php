<?php

	//Linka a conexão montada com o banco de dados em conexão.php.
	include('../php/conexao.php');

	if(isset($_POST['acao']) && $_POST['acao'] == 'consulta_estado'){

		$uf = $_POST['uf'];

		$sql = "SELECT *FROM estados WHERE uf= '$uf'";

		$result = mysqli_query($conn, $sql);

		$row = mysqli_fetch_assoc($result);

		exit($row['id']);

	}

	$consulta = "SELECT *FROM estados";

	$page = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

	$estados = mysqli_query($conn, $consulta); 

	$total_estados = mysqli_num_rows($estados); 

	$registros_pagina = 8; 

    $numero_paginas = ceil($total_estados/$registros_pagina); 

    $inicio = ($registros_pagina*$page)-$registros_pagina; 

    if(isset($_GET['pesquisando']) && !empty($_GET['pesquisando'])){

		$pesquisou = $_GET['pesquisando'];

		$cmd = "SELECT * FROM clientes WHERE nome LIKE '$pesquisou%' ";	

		$estados = mysqli_query($conn, $cmd); 

//Conta o total de itens 
		$total_estados = mysqli_num_rows($estados); 

//Seta a quantidade de itens por página, neste caso, 2 itens 
		$registros_pagina = 8; 

//Calcula o número de páginas arredondando o resultado para cima com ceil
		$numero_paginas = ceil($total_estados/$registros_pagina); 

//Variavel para calcular o início da visualização com base na página atual 			**
		$inicio = ($registros_pagina*$page)-$registros_pagina; 

		$cmd = "SELECT * FROM estados WHERE nome LIKE '$pesquisou%' LIMIT $inicio, $registros_pagina";

		$estados = mysqli_query($conn, $cmd);

    } else {

	    $sql = "SELECT *FROM estados LIMIT $inicio,$registros_pagina";

		$estados = mysqli_query($conn, $sql);

	}	

?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../componentes/css/bootstrap.min.css">
		<script type="text/javascript" src="../js/jquery-3.4.1.js"></script>
		<script type="text/javascript" src="js/estados.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/style.css">
		<script type="text/javascript" src="../componentes/js/bootstrap.js"></script>
		<script type="text/javascript" src="../componentes/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
		<title>Gerenciador de Estados</title>
	</head>
	<body style="text-align: center;">
		<header>
			<div class="row">
				<nav class="navbar navbar-default">
  					<div class="container-fluid">
					    <!-- Brand and toggle get grouped for better mobile display -->
					    <div class="navbar-header">
      						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	    						<span class="sr-only">Toggle navigation</span>
						        <span class="icon-bar"></span>
						        <span class="icon-bar"></span>
						        <span class="icon-bar"></span>
      						</button>
      						<a class="navbar-brand" href="./estados.php" style="margin-left: 0px;">ESTADOS</a>
    					</div>
    					<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      						<ul class="nav navbar-nav">
        						<li>
        							<a href="../index.php">Clientes</a>
        						</li>
      						</ul>
    						<form class="navbar-form navbar-right" method="GET">
						        <div class="form-group">
					          		<label for="pesquisando"></label>	
									<input type="text" name="pesquisando" id="pesquisando" class="form-control" placeholder="pesquisar">
						  		</div>
  							</form>
    					</div>
  					</div>
				</nav>
			</div>	
		</header>
	  	<table class="table table-responsive table-bordered" style="background-color: white;">
	   		<tr class="active">
				<td class="col-md-1" style="text-align: center; font-size: 25px;">UF</td>
				<td class="col-md-3" style="text-align: center; font-size: 25px;">Nome</td>
				<td class="col-md-1" style="text-align: center; font-size: 25px;">
					<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#mod">
						<i class="fas fa-plus" style=""></i>
					</button>
				</td>
			</tr>
			<?php 
				while($row = mysqli_fetch_array($estados)){ 
			?>		<tr>
						<td class="col-md-1" style="text-align: center; font-size: 25px;"><?php echo $row['uf']; ?></td>
						<td class="col-md-3" style="text-align: center; font-size: 25px;"><?php echo $row['nome']; ?></td>
						<td class="col-md-1" style="text-align: center; font-size: 25px;">
							<button type="button" class="btn btn-warning edita" data-toggle="modal" data-target="#mod" data-id="<?php echo $row['id']; ?>">
								<i class="fas fa-pencil-alt" style=""></i>
							</button>
							<button type="button" class="btn btn-danger deleta" value="<?php echo $row['id']; ?>">
								<i class="fas fa-trash-alt" style=""></i>
							</button>
						</td>
					</tr>
			<?php	
				} 
   			?>
	  	</table>
		  	<nav aria-label="Page navigation">
			 	<ul class="pagination">
			    	<li>
	        			<?php 
							$anterior = $page -1;
							$proximo = $page +1;	

							if( $page > 1 ) {
								echo "<a aria-label='Previous' href='?pagina=$anterior'>
									<i class='fas fa-angle-left fa-lg'></i>
									</a> ";
							}
						?> 
			    	</li>
				    <li>
				    	<?php
					  		for( $i = 1; $i < $numero_paginas + 1; $i++ ) {

					  			if ( $page == $i ) {
									echo "<a href='estados.php?pagina=$i' class='btn btn-default' id='transformacao'>"
										.$i.
										"</a>"; 		
								} else {
									echo "<a href='estados.php?pagina=$i' class='btn btn-default'>"
									.$i.
									"</a>";		
								}	
							}
					  	?>
				    </li>
				    <li>
				    	<?php
				      		if( $page < $numero_paginas ){
								echo "<a aria-label='Next' href='?pagina=$proximo'>
									<i class='fas fa-angle-right fa-lg'></i>
									</a> ";
							}
						?>
			    	</li>
			  	</ul>
			</nav>
		<div class="modal fade" id="mod" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		    <div class="modal-dialog modal-sm" role="document">
			    <div class="modal-content">
			      	<div class="modal-header">
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			        		<span aria-hidden="true">&times;</span>
			        	</button>
			        	<h4 class="modal-title" id="myModalLabel">Adicionando</h4>
			      	</div>
			      	<div class="modal-body">
			        	<form action="" id="formulario" class="form-horizontal" method="POST">
						  	<div class="form-group">
						    	<label for="estado" class="col-sm-3 control-label">Estado:</label>
						    	<div class="col-sm-9">
						      		<input type="text" class="form-control" name="estado" id="estado" placeholder="Estado">
						    	</div>
						  	</div>
							<div class="form-group">
							    <label for="uf" class="col-sm-3 control-label">UF:</label>
							    <div class="col-sm-4">
							      	<input type="text" class="form-control" name="uf" id="uf" placeholder="UF">
							    </div>
							</div>
							<div class="modal-footer">
					        	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
					        	<button type="submit" id="salvando" class="btn btn-primary">Salvar</button>
			      			</div>
						</form>
			      	</div>
		    	</div>
		    </div>
		</div>
	</body>
</html>