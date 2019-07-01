<?php

	//Linka a conexão montada com o banco de dados em conexão.php.
	include('./php/conexao.php');

if(isset($_POST['id']) && isset($_POST['stat']) || !empty($_POST['id']) && !empty($_POST['stat'])){

	$id = $_POST['id'];

	$sql = "UPDATE clientes 
		SET status = '".$_POST['stat']."' WHERE id = ".$id;

	$cliente = mysqli_query($conn, $sql);
}

if (isset($_GET['id']) && !empty($_GET['id']) && !isset($_POST['stat'])) {

	$id = $_GET['id'];

	$sqlConsulta = "SELECT * FROM clientes WHERE id = " . $id;
	$result = mysqli_query($conn, $sqlConsulta);

	if (FALSE === $result) {
		echo 'O cliente informado não existe';
	}

	$cliente = mysqli_fetch_array($result);
}
if (isset($_POST) && !empty($_POST) && !isset($_POST['stat'])) {
	if (isset($_POST['id']) && !empty($_POST['id'])) {

		$id = $_POST['id'];

		$sql = "UPDATE clientes 
		SET nome = '".$_POST['nome']."', 
		telefone = '".$_POST['telefone']."', 
		senha = '".$_POST['senha']."', 
		rua = '".$_POST['rua']."', 
		complemento = '".$_POST['complemento']."', 
		bairro = '".$_POST['bairro']."', 
		cidade = '".$_POST['cidade']."', 
		cep = '".$_POST['cep']."', 
		email = '".$_POST['email']."',
		estado_id = '".$_POST['estado_id']."'
		WHERE id = ".$id; 

		$result = mysqli_query($conn,$sql);

		if (!$result) {
			exit('erro');
		}
		exit('ok');

	} else {

		$sql = "INSERT INTO clientes (nome, telefone, email, senha, rua, complemento,
		bairro, cidade, cep, status, estado_id)
		VALUES (
		'".$_POST["nome"]."', 
		'".$_POST["telefone"]."', 
		'".$_POST["email"]."', 
		'".$_POST["senha"]."', 
		'".$_POST["rua"]."', 
		'".$_POST["complemento"]."',
		'".$_POST["bairro"]."', 
		'".$_POST["cidade"]."', 
		'".$_POST["cep"]."',
		".$_POST["status"].",
		".$_POST["estado_id"].")";

		$result = mysqli_query($conn,$sql);	

		if (!$result) {
			exit('erro');
		}
		exit('ok');
	}
}
?>
<form action="" id="formulando" method="POST">
	<input type="hidden" class="form-control" name="id" value="<?php echo isset($cliente['id']) ? $cliente['id'] : '' ; ?>">
	<div class="form-row">
		<div class="form-group col-xs-12 col-md-6">
			<label for="nome">Nome</label>
			<input type="text" class="form-control" name='nome' value="<?php echo isset($cliente['nome']) ? $cliente['nome'] : ''; ?>" placeholder="Seu nome completo">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-xs-12 col-md-6">
			<label for="nome">Telefone</label>
			<input type="text" class="form-control telefone" name="telefone" value="<?php echo isset($cliente['telefone']) ? $cliente['telefone'] : ''; ?>" placeholder="0000-0000">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-xs-12 col-md-6">		
			<label for="email">Email</label>
			<input type="text" class="form-control" name="email" value="<?php echo isset($cliente['email']) ? $cliente['email'] : ''; ?>" placeholder="Email">		
		</div>
		<div class="form-group col-xs-12 col-md-6">				
			<label for="senha">Senha</label>
			<input type="password" class="form-control" name="senha" value="<?php echo isset($cliente['senha']) ? $cliente['senha'] : ''; ?>" placeholder="Senha">
		</div>
	</div>
	<div class="form-group col-xs-12 col-md-4">
		<label for="cep">CEP</label>
		<input type="text" maxlength="9" class="form-control cep" id="cep" name="cep" value="<?php echo isset($cliente['cep']) ? $cliente['cep'] : ''; ?>" placeholder="00000.000" =>
	</div>
	<div class="form-group col-xs-12 col-md-4">
		<label for="estado_id">Estado</label>
		<select name="estado_id" class="form-control uf">
		<?php 
		
		$sql = "SELECT *FROM estados";

		$resultando = mysqli_query($conn, $sql);

		while($row = mysqli_fetch_array($resultando)) { ?>

		<option value="<?php echo $row['id']; ?>"><?php echo $row['nome']. ' - ' .$row['uf']; ?></option>

	<?php 

		} ?>
		</select>
	</div>
	<div class="form-group col-xs-12 col-md-4">
		<label for="cidade">Cidade</label>
		<input name="cidade" class="form-control" type="text" id="cidade" value="<?php echo isset($cliente['cidade']) ? $cliente['cidade'] : ''; ?>" placeholder="Cidade">
	</div>
	<div class="form-row">
		<div class="form-group col-xs-12 col-md-6">
			<label for="rua">Endereço</label>
			<input type="text" class="form-control" id="rua" name="rua" value="<?php echo isset($cliente['rua']) ? $cliente['rua'] : ''; ?>" placeholder="Logradouro">
		</div>
		<div class="form-group col-xs-12 col-md-6">
			<label for="complemento">Complemento</label>
			<input type="text" class="form-control" name="complemento" value="<?php echo isset($cliente['complemento']) ? $cliente['complemento'] : ''; ?>" placeholder="Referências">
		</div>
	</div>
	<div class="form-row">
		<div class="form-group col-xs-12 col-md-6">
			<label for="bairro">Bairro</label>
			<input type="text" class="form-control" id="bairro" name="bairro" value="<?php echo isset($cliente['bairro']) ? $cliente['bairro'] : ''; ?>" placeholder="Bairro">
		</div>
	</div>
<?php
	
	if (!isset($_GET['edita'])) {
	?>
		<div class="form-group col-xs-12 col-md-6">
			<label for="status">Status</label>
			<select name="status" class="form-control">
				<option selected value="">
					<?php 
					if (isset($cliente['status'])) {
						if ($cliente['status'] == 1){
							echo 'Ativo';
						} if ($cliente['status'] == 0){
							echo "Inativo";
						}
					} else { 
						echo isset($cliente['status']) ? "" : "Escolha";
					}
					?>
				</option>
				<option value="0">Inativo</option>
				<option value="1">Ativo</option>
			</select>
		</div>
<?php
	}
?>

</form>

<script type="text/javascript" src="js/formato.js"></script>
<script type="text/javascript" src="js/viacep.js"></script>