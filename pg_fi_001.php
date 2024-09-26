<?php include 'include/top.php';?>
<?php
$mandar     = $_POST['mandar'] ?? "";
$nome       = $_POST['nome'] ?? "";
$funcao     = $_POST['funcao'] ?? "";

if(!empty($mandar)){
    $insert = $conn->query("INSERT INTO tipo_pagamento (pagamento_nome, pagamento_funcao) 
							VALUES ('$nome', '$funcao')");
	if($insert){
		echo "<script>window.location.href='pg_fi_002.php';</script>";
	}
}
?>

<div class="container">
    <h1>Cadastrar Tipo de pagamento</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="cadastrar">
        <input type="text" name="nome" id="nome" placeholder="Informe o nome do tipo de pagamento...">
        <select name="funcao" class="select">
			<option value="" selected disabled>Função do pagamento</option>
			<option value="A">AMBOS</option>
			<option value="R">RECEBER</option>
			<option value="P">PAGAR</option>
        </select>
        <input type="hidden" name="mandar" value="yes">
        <input type="submit" value="Cadastrar" id="btnCadastrar" onclick="fnReload()">
    </form>
</div>
<?php include 'include/footer.php';?>