<?php include 'include/top.php';?>
<?php
$acesso             = $_POST['acesso'] ?? "";
$mandar             = $_POST['mandar'] ?? "";
$acesso_para_banco  = strtolower($acesso);
$msg                = "";
if(!empty($mandar)){
    $insert = "{CALL pr_criar_acesso(?)}";
    $parametros = array($acesso_para_banco);
    $stmt = sqlsrv_query($conn, $insert, $parametros);
	if(sqlsrv_has_rows($stmt)){
		$row = sqlsrv_fetch_array($stmt);
        if($row['cad']){
            echo "<script>window.alert('".$row['msg']."')</script>";
            echo "<script>window.location.href='pg_si_008.php';</script>";
        }else{
            echo "<script>window.alert('".$row['msg']."')</script>";
        }
	}
}
?>

<div class="container">
    <h1>Cadastrar Acesso <?=$msg?></h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="cadastrar">
        <input type="text" name="acesso" id="acesso" placeholder="Informe o nome do acesso...">
        <input type="hidden" name="mandar" value="yes">
        <input type="submit" value="Cadastrar" id="btnCadastrar" onclick="fnReload()">
    </form>
</div>
<?php include 'include/footer.php';?>