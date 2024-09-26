<?php include 'include/top.php';?>
<?php

$ler_acessos = "{CALL pr_ler_acessos(?)}";
$parametros = array(1);
$stmtAcessos = sqlsrv_query($conn, $ler_acessos, $parametros);
$listarAcesso = "";
if(sqlsrv_has_rows($stmtAcessos)){
    $listarAcesso .= "<option value='' selected disabled>Escolha o tipo de acesso</option>";
    while($rowAcessos = sqlsrv_fetch_array($stmtAcessos)){
        $listarAcesso .= "<option value=".$rowAcessos['acesso_cod'].">".strtoupper($rowAcessos['acesso_nome'])."</option>";
    }
}

$mandar     = $_POST['mandar'] ?? "";
$menu       = $_POST['nome'] ?? "";
$acesso     = $_POST['tp_acesso'] ?? "";
$msg        = "";
if(!empty($mandar)){
    $criar_menu = "{CALL pr_criar_menu(?,?,?)}";
    $menuParametros = array($menu, $cod, $acesso);
    $stmt_criar_menu = sqlsrv_query($conn, $criar_menu, $menuParametros);
	if(sqlsrv_has_rows($stmt_criar_menu)){
		$row_criar_menu = sqlsrv_fetch_array($stmt_criar_menu);
        if($row_criar_menu['cad']){
            echo "<script>window.alert('".$row_criar_menu['msg']."')</script>";
            echo "<script>window.location.href='pg_si_002.php';</script>";
        }else{
            echo "<script>window.alert('".$row_criar_menu['msg']."')</script>";
        }
	}
}
?>

<div class="container">
    <h1>Cadastrar Menu <?=$msg?></h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="cadastrar">
        <input type="text" name="nome" id="nome" placeholder="Informe o nome do menu...">
        <select name="tp_acesso" class="select">
            <?=$listarAcesso?>
        </select>
        <input type="hidden" name="mandar" value="yes">
        <input type="submit" value="Cadastrar" id="btnCadastrar" onclick="fnReload()">
    </form>
</div>
<?php include 'include/footer.php';?>