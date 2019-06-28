<?php

	include('../php/conexao.php');

	$consulta = "SELECT *FROM estados";

	if(isset($_POST['ids']) && !empty($_POST['ids'])){

		$id = $_POST['ids'];

		$sql = "DELETE FROM estados
				WHERE id = $id";

		$result = mysqli_query($conn, $sql);

	}

	if(isset($_POST['id']) && !empty($_POST['id'])){

		$id = $_POST['id'];

		$sql = "UPDATE estados
				SET nome = '".$_POST['estado']."', uf = '".$_POST['uf']."' WHERE id = $id";

		$result = mysqli_query($conn, $sql);

		/*if(isset($result)){
			header("Location: ../");
		}*/
	} else if (empty($_POST['id']) && empty($_POST['ids'])) {

		$sql = "INSERT INTO estados (nome, uf)
				VALUES ('".$_POST['estado']."', 
				'".$_POST['uf']."')";

		$result = mysqli_query($conn, $sql);

	}

	/*<form action="" id="formulando" method="POST">
	value="<?php echo isset($cliente['id']) ? $cliente['id'] : '' ; ?>"*/

?>
