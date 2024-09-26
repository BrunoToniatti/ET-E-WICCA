<?php include 'include/top.php';?>
<?php
$mandar             = $_POST['mandar'] ?? "";
if(!empty($mandar)){
    $cor_cod = strtoupper($_POST['cor_cod']);
    $cor_nome = $_POST['cor_nome'];
    $sql = "{CALL pr_criar_cor(?,?,?)}";
    $parametros = array($cor_cod, $cor_nome, $cod);
    $stmt = sqlsrv_query($conn, $sql, $parametros);
	if($row = sqlsrv_fetch_array($stmt)){
		if($row['cad']){
            echo "<script>window.alert('".$row['msg']."')</script>";
        }else{
            echo "<script>window.alert('".$row['msg']."')</script>";
        }
	}
}
?>

<div class="container">
    <h1>Cadastrar Cor</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="cadastrar">
        <div class="formulario">
            <label>Cor Código: <br>
                <input type="text" name="cor_cod" id="cor_cod" maxlength="20">
            </label>
            <label>Cor Nome: <br>
                <input type="text" name="cor_nome" id="cor_nome">
            </label>
        </div>
        <input type="hidden" name="mandar" value="yes">
        <input type="submit" value="Cadastrar" id="btnCadastrar">
    </form>
</div>
<?php include 'include/footer.php';?>