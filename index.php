<?php

	//Linka a conexão montada com o banco de dados em conexão.php.
include('./php/conexao.php');

	//Faz a consulta de todas as informações de clientes no banco de dados
$consulta = "SELECT * FROM clientes";

	//Transforma a consulta e a conexão em query (formato q torna possível sua chamada mais tarde)
	//E or die para caso ocorra algum erro, dito q ele imprime o error como resultado
$result = mysqli_query($conn ,$consulta) or die ($mysqli_error);

	//Verifica se o id é existente via query string (url)
if(isset($_GET['id']) && !empty($_GET['id'])){

	//Joga o id passado via query string(url) para a variavel $id
	$id= $_GET['id'];

	//Aqui fazemos uma consulta para deletar as informações do cliente cujo id corresponde ao passado
	//Via query string(url)
	$sql = "DELETE FROM clientes WHERE id=" .$id;

	//Transforma sql em uma query do msqli para caso ocorra no futuro uma leitura mais específica como
	//mysqli_fetch_row()
	$deleta = mysqli_query($conn,$sql);

	//Aqui verificamos se o $deleta existe, se carrega algum valor
	if ($deleta) {

	//Aqui redirecionamos para a pagina do index.php pós verificação de q o $deleta ocorreu 
		header("Location: /index.php");

	//Else para caso a variavel $deleta n passe no if. Depurando assim oq estiver dentro
	} else {

	//Um echo, utilizado para imprimir oq vier dentro das aspas
	//Motivo para o echo: está dentro de um php
		echo "Não Funcionou!!";
	}
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="componentes/css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery-3.4.1.js"></script>
	<script type="text/javascript" src="js/viacep.js"></script>
	<script type="text/javascript" src="componentes/js/bootstrap.js"></script>
	<script type="text/javascript" src="componentes/jQuery-Mask-Plugin-master/dist/jquery.mask.min.js"></script>
	<script type="text/javascript" src="js/envio_form.js"></script>
	<script type="text/javascript" src="js/formato.js"></script>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
	<title>CRUD</title>
</head>
<body>
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
      <a class="navbar-brand" href="./index.php" style="margin-left: 0px;">CLIENTES</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="./estados/estados.php">Estados</a></li>

      </ul>
      <form class="navbar-form navbar-right" method="GET">
        <div class="form-group">
          	<label for="pesquisando"></label>	
			<input type="text" name="pesquisando" id="pesquisando" class="form-control" placeholder="pesquisar">
  		</div>
      </form>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
</div>
	</header>
				<!-- Aqui cria-se uma formatação de tabela na div -->
				<div class="table-responsive row-md-12" id="essa">
					<table class="table table-responsive table-bordered" style="background-color: white;">
						<tr class="active">
							<td class="col-md-1" style="text-align: center; font-size: 25px;">Nome</td>
							<td class="col-md-1" style="text-align: center; font-size: 25px;">Senha</td>
							<td class="col-md-1" style="text-align: center; font-size: 25px;">Telefone</td>
							<td class="col-md-1" style="text-align: center; font-size: 25px;">Email</td>
							<td class="col-md-1" style="text-align: center; font-size: 25px;">Endereco</td>
							<td class="col-md-1" style="text-align: center; font-size: 25px;">Compl.</td>
							<td class="col-md-1" style="text-align: center; font-size: 25px;">Bairro</td>
							<td class="col-md-1" style="text-align: center; font-size: 25px;">Estado</td>
							<td class="col-md-1" style="text-align: center; font-size: 25px;">Cidade</td>
							<td class="col-md-1" style="text-align: center; font-size: 25px;">Cep</td>
							<td class="col-md-2" style="text-align: center;">
							<!-- Aqui usa-se a url de forma a deixar o id nulo, para q nas regras
								conseguintes ele consiga satisfazer-las a fim de adicionar um usuário-->

								<button type="button" class="btn btn-primary btn-form" data-id="">
									<i class="far fa-plus-square"></i>
								</button>	
							</td>
						</tr>

						<?php 

		//Verifica a página atual caso seja informada na URL, senão atribui como 1ª página 
						$pagina = (isset($_GET['pagina']))? $_GET['pagina'] : 1;

	    //Seleciona todos os itens da tabela através de uma consulta no banco de dados
						$cmd = "SELECT * FROM clientes"; 

		//Trasnforma a consulta em uma query para mais tarde ser possível a chamada dela em outras 
		//Functions do mysqli
						$client = mysqli_query($conn, $cmd); 

	    //Conta o total de itens 
						$total = mysqli_num_rows($client); 

	    //Seta a quantidade de itens por página, neste caso, 2 itens 
						$registros = 2; 

	    //Calcula o número de páginas arredondando o resultado para cima com ceil
						$numPaginas = ceil($total/$registros); 

	    //Variavel para calcular o início da visualização com base na página atual 			**
						$inicio = ($registros*$pagina)-$registros; 

	    //Seleciona os itens por página através de uma consulta no bd ditando que irá do inicio até
		//A quantidade de registros isso se não satisfazer o if, este que irá pegar o nome colocado
		//Em pesquisa e o armazenará na variável $pesquisou, para mais tarde ser alocada em uma consulta
		//Para trazer apenas aqueles q contém oq foi pesquisado, pós isso ele é passado para uma query
		//Para q possa ser impresso no while a baixo
						if(isset($_GET['pesquisando']) && !empty($_GET['pesquisando'])){

							$pesquisou = $_GET['pesquisando'];

							$cmd = "SELECT * FROM clientes WHERE nome LIKE '$pesquisou%' ";	

							$client = mysqli_query($conn, $cmd); 

		    //Conta o total de itens 
							$total = mysqli_num_rows($client); 

		    //Seta a quantidade de itens por página, neste caso, 2 itens 
							$registros = 2; 

		    //Calcula o número de páginas arredondando o resultado para cima com ceil
							$numPaginas = ceil($total/$registros); 

		    //Variavel para calcular o início da visualização com base na página atual 			**
							$inicio = ($registros*$pagina)-$registros; 

							$cmd = "SELECT c.*, e.nome as n, e.uf FROM clientes c
							INNER JOIN estados e ON c.estado_id = e.id 
							WHERE c.nome LIKE '$pesquisou%' LIMIT $inicio, $registros";

							$client = mysqli_query($conn, $cmd);

						}else{

							$cmd = "SELECT c.*, e.nome as n, e.uf
							FROM clientes c
							INNER JOIN estados e ON c.estado_id = e.id LIMIT $inicio,$registros";

							$client = mysqli_query($conn, $cmd);
						}

		//Neste while utilizamos o fetch_array q retorna uma matriz q corresponde a linha obtida 
		//Ou nulo, aplicando também neste array a regra da consulta client para q assim apenas 
		//Mostre o tanto especificado, no caso 2 por aba
						while($row = mysqli_fetch_array($client)) { ?> 
							<tr>
								<td class="col-md-1" style="text-align: center;"><?php echo $row['nome']; ?></td>
								<td class="col-md-1" style="text-align: center;"><?php echo $row['senha']; ?></td>
								<td class="col-md-1" style="text-align: center;"><?php echo $row['telefone']; ?></td>
								<td class="col-md-1" style="text-align: center;"><?php echo $row['email']; ?></td>
								<td class="col-md-1" style="text-align: center;"><?php echo $row['rua']; ?></td>
								<td class="col-md-1" style="text-align: center;"><?php echo $row['complemento']; ?></td>
								<td class="col-md-1" style="text-align: center;"><?php echo $row['bairro']; ?></td>
								<td class="col-md-1" style="text-align: center;"><?php echo $row['n'] . ' - ' . $row['uf'];?></td>
								<td class="col-md-1" style="text-align: center;"><?php echo $row['cidade']; ?></td>
								<td class="col-md-1" style="text-align: center;"><?php echo $row['cep']; ?></td>
								<td class="col-md-2" style="text-align: center;">
									<div class="col-md-12">
									<button type="button" class="btn btn-warning btn-form col-md-5" test-id='1' style="margin-right: 27.5px;" data-id="<?php echo $row['id'];?>">
										<i class="glyphicon glyphicon-pencil"></i>
									</button>
									<a href="index.php?id=<?php echo $row['id'];?>" class="btn btn-danger col-md-5" style="" name="delete" type="submit">
										<i class="far fa-trash-alt"></i>
									</a>

								
								
								<?php

								if($row['status'] == 1){ ?>

									<button class="btn btn-succes col-md-12 mudanca" value="0" data-id="<?php echo $row['id'];?>">Desativar<i class="fas fa-times" style="margin-left: 6px;"></i></button>

								<?php
								}else{?>

									<button class="btn btn-succes col-md-12 mudanca" value="1" data-id="<?php echo $row['id'];?>">Ativar<i class="fas fa-check" style="margin-left: 6px;"></i></button>

									<?php
								}

								?>
							</div>
							</td>								
							</tr>  
						<?php } ?>   
					</table>	
					<nav aria-label="Page navigation" style="text-align: center;" >

						<ul class="pagination pagination-lg">

							<li>
								<?php 

								$anterior = $pagina -1;
								$proximo = $pagina +1;	

		//Caso a pagina seja > 1 a seta anterior(<) aparece, diminuindo 1 em pagina				
								if(empty($_GET['pesquisando'])){ 
									if($pagina>1) {
										echo " <a href='?pagina=$anterior'>
										<i class='fas fa-angle-left fa-lg'></i>
										</a> ";
									}
								}
								?>

							</li>
							<li>
								<?php 

		//Neste for acontece a marcação da pagina, onde caso $i for igual a $pagina é usado a function do link
		//Via bootstrap( active) para então marcar como clicado o botão correspondente a pagina atual
								if(empty($_GET['pesquisando'])){
									for($i = 1; $i < $numPaginas + 1; $i++) {
								//
										if ($pagina == $i) {

											echo "<a href='index.php?pagina=$i' id='transformacao' class='btn btn-default'>".$i."</a>";			

		//Caso a pagina não seja passada na url	é impresso a paginação sem marcação de nenhum link como clicado					
										} else {

											echo "<a href='index.php?pagina=$i' class='btn btn-default'>".$i."</a>";		

										}

									}
								}

								?>

							</li>

							<li>

								<?php 

								$anterior = $pagina -1;
								$proximo = $pagina +1;

		//Caso a pagina seja < $numPaginas a seta proximo(>) aparece, adicionando 1 em pagina	
								if(empty($_GET['pesquisando'])){
									if($pagina<$numPaginas) {
										echo " <a href='?pagina=$proximo'>
										<i class='fas fa-angle-right fa-lg'></i></a>";

									}
								}
								?>
							</li>
						</ul>
					</nav>
			</div>
			<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="exampleModalLabel">-. Formulário .-</h4>
						</div>
						<div class="modal-body col-xs-12 col-md-12">

						</div>
						<div class="modal-footer" style="text-align: center;">
							<button type="button" class="btn btn-warning" id="btnCancelar">Cancelar</button>
							<button class="btn btn-primary" id="btnEnviar" type="button">Salvar</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" ><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="exampleModalLabel">-. Confirmação .-</h4>
						</div>
						<h5 style="text-align: center;">Cliente salvo com sucesso!!</h5>
						<div class="modal-footer" style="text-align: center;">
							<button class="btn btn-primary" id="btnConfirmando" type="button">Okay</button>
						</div>
					</div>
				</div>
			</div>
			<div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
				<div class="modal-dialog modal-sm" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title" id="exampleModalLabel">-. Confirmação .-</h4>
						</div>
						<h5 style="text-align: center;">Erro ao salvar o cliente</h5>
						<div class="modal-footer" style="text-align: center;">
							<button class="btn btn-primary" id="btnHide" type="button">Okay</button>
						</div>
					</div>
				</div>
			</div>
	</body>
	</html>