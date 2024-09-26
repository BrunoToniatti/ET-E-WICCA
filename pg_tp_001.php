<?php include 'include/top.php';?>
<?php
$mandar = $_POST['mandar'] ?? "";
if(!empty($mandar)){
    $tipo_cod = $_POST['tipo_cod'];
    $tipo_nome = $_POST['tipo_nome'];
    $insert = "{CALL pr_criar_tipo_produto(?,?,?)}";
    $parametros = array($tipo_cod, $tipo_nome, $cod);
    $stmt = sqlsrv_query($conn, $insert, $parametros);
	if(sqlsrv_has_rows($stmt)){
		$row = sqlsrv_fetch_array($stmt);
        if($row['cad']){
            echo "<script>window.alert('".$row['msg']."')</script>";
            echo "<script>window.location.href='pg_tp_002.php';</script>";
        }else{
            echo "<script>window.alert('".$row['msg']."')</script>";
        }
	}
}
?>

<div class="container">
    <h1>Novo Tipo de Produto</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="cadastrar">
        <div class="formulario">
            <label> Código: <br>
                <input type="text" name="tipo_cod" id="tipo_cod" maxlength="2">
            </label>
            <label> Tipo de produto: <br>
                <input type="text" name="tipo_nome" id="tipo_nome">
            </label>
            <input type="hidden" name="mandar" value="yes">
        </div>
        <div class="botoes">
            <input type="submit" value="Cadastrar">
        </div>
    </form>
</div>
<?php include 'include/footer.php';?>