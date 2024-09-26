<?php include 'include/top.php';?>
<?php
	$sqlF = $conn->query("CALL pr_ler_fornecedores(2);");
	$conn->next_result();
	$listarF = "";
	if($sqlF->num_rows > 0){
		while ($rowF = $sqlF->fetch_assoc()){
			$listarF .= "<option value=".$rowF['id_fornecedor'].">".$rowF['nome_fornecedor']." - ".$rowF['cnpj_cpf']."</otpion>";
		}
	}
	$sqlP = $conn->query("CALL pr_ler_produtos_finais(2);");
	$conn->next_result();
	$listarP = "";
	if($sqlP->num_rows > 0){
		while ($rowP = $sqlP->fetch_assoc()){
			$listarP .= "<option value=".$rowP['pf_cod'].">".$rowP['pf_nome']."</otpion>";
		}
	}

	$mandar = $_POST['mandar'] ?? "";
	$msg = "asdfsad";
	if(!empty($mandar)){
		$fornecedor		= $_POST['fornecedor'] ?? "";	
		$produto 		= $_POST['produto'] ?? "";
		$quantidade		= $_POST['quantidade'] ?? "";
		$dt_entrega		= $_POST['dt_entrega'] ?? "";
		$motivo			= $_POST['motivo'] ?? "";
		$chave			= rand(1,10000);
		$sql = $conn->query("CALL pr_criar_solicicao_compra('$fornecedor', '$produto', '$quantidade', '$dt_entrega', '$motivo', '$cod', '$chave', @msg, @cadastro)");
		$conn->next_result();
		if($sql){
			$resultado = $conn->query("SELECT @msg AS msg, @cadastrado AS cadastrado");
			if($resultado->num_rows > 0){
				$rowResultado = $resultado->fetch_assoc();
				if($rowResultado['cadastrado']){
					echo "<script>window.location.href='pg_sl_002.php';</script>";
					$msg = $rowResultado['msg'];
				}else{
					$msg = $rowResultado['msg'];
				}
			}
		}
	}
?>
	<div class="container">
		<h1>Solicitar compra <?=$msg?></h1>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<label> Fornecedor <br>
				<select name="fornecedor" class="select">
					<option value=""></option>
					<?=$listarF?>
				</select>
			</label>
			<label> Produto <br>
				<select name="produto" class="select">
					<option value=""></option>
					<?=$listarP?>
				</select>
			</label>
			<label>Quantidade: <br>
				<input type="text" name="quantidade" id="numero" maxlength="3">
			</label>
			<label>Data Entrega: <br>
				<input type="text" name="dt_entrega" id="data">
			</label>
			<label style="width: 100%;">Motivo <br>
			<textarea style="width: 89%; height: 150px; padding: 10px;" name="motivo"></textarea>
			</label>
			<br>
			<div style="width: 89%; text-align: center;">
				<input type="hidden" name="mandar" value="yes">
				<input type="submit" value="Solicitar">
			</div>
		</form>
	</div>
	<script>
		$('#numero').mask('0#');
		$('#data').mask("00/00/0000");
	</script>
<?php include 'include/footer.php';?>