<?php include 'include/top.php';?>
<?php
$mandar             = $_POST['mandar'] ?? "";
if(!empty($mandar)){
	$box_nome           = $_POST['box_nome'];
	$box				= strtolower($box_nome);
	$box_cod			= $_POST['box_cod'];
    $sql = "{CALL pr_criar_box(?,?,?)}";
	$paramentos = array($box, $box_cod, $cod);
	$stmt = sqlsrv_query($conn, $sql, $paramentos);
	if(sqlsrv_has_rows($stmt)){
		$row = sqlsrv_fetch_array($stmt);
		if($row['cad']){
			echo "<script>window.alert('".$row['msg']."')</script>";
			echo "<script>window.location.href='pg_box_004.php?box_cod=".$row['box_cod']."';</script>";
		}else{
			echo "<script>window.alert('".$row['msg']."')</script>";
		}		
	}
}

?>

<div class="container">
		<h1>Cadastrar Box</h1>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="cadastrar">
			<div class="formulario">
			<label>Código: <br>
				<input type="text" name="box_cod" id="box_cod" maxlength="3">
			</label>
			<label>Box Nome: <br>
				<input type="text" name="box_nome" id="box_nome">
			</label>
			</div>
			<input type="hidden" name="mandar" value="yes">
			<input type="submit" value="Cadastrar" id="btnCadastrar">
		</form>	
</div>
<?php include 'include/footer.php';?>