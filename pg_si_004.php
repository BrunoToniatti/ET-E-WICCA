<?php include 'include/top.php';?>
<?php

$listarAcesso = "";
$acesso = "{CALL pr_ler_acessos(?)}";
$paramAcessos = array(1);
$stmtAcesso = sqlsrv_query($conn, $acesso, $paramAcessos);
if(sqlsrv_has_rows($stmtAcesso)){
    $listarAcesso .= "<option value='' selected disabled>Escolha o tipo de acesso</option>";
    while($rowAcessos = sqlsrv_fetch_array($stmtAcesso)){
        $listarAcesso .= "<option value=".$rowAcessos['acesso_cod'].">".strtoupper($rowAcessos['acesso_nome'])."</option>";
    }
}


	

$menus = "{CALL pr_ler_menus(?)}";
$paramMenu = array(3);
$stmtMenu = sqlsrv_query($conn, $menus, $paramMenu);
$menu = "";
if(sqlsrv_has_rows($stmtMenu)){
    $menu .= "<option value='' selected disabled>Escolha o menu</otpion>";
    while($rowM = sqlsrv_fetch_array($stmtMenu)){
        $menu .= "<option value='".$rowM['menu_cod']."'>".$rowM['menu_nome']."</otpion>";
    }
}

// @submenu_nome	
// @submenu_icone	
// @menu_cod		
// @acesso_cod		
// @user_cod	

$menu_e      = $_POST['menu_e'] ?? "";  
$submenu     = $_POST['submenu'] ?? "";
$mandar      = $_POST['mandar'] ?? "";
$acesso      = $_POST['tp_acesso'] ?? "";
$icone       = $_POST['icone'] ?? "";
$msg         = "";
$cad         = "";
if(!empty($mandar)){
    $insert_submenu = "{CALL pr_criar_submenu(?,?,?,?,?)}";
    $paramSubmenu_criar = array($submenu, $icone, $menu_e, $acesso, $cod);
    $stmtSubmenu_criar = sqlsrv_query($conn, $insert_submenu, $paramSubmenu_criar);
	if(sqlsrv_has_rows($stmtSubmenu_criar)){
		$rowSubemnus_criar = sqlsrv_fetch_array($stmtSubmenu_criar, SQLSRV_FETCH_ASSOC);
        if($rowSubemnus_criar['cad'] == 1){
            echo "<script>window.alert('".$rowSubemnus_criar['msg']."')</script>";
            echo "<script>window.location.href='pg_si_003.php';</script>";
        }else{
            echo "<script>window.alert('".$rowSubemnus_criar['msg']."')</script>";
        }
	}
}
?>

<div class="container">
    <h1>Cadastrar Sub menu</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="cadastrar">
        <select name="menu_e" id="menu_e" class="select">
            <?=$menu?>
        </select>
        <input type="text" name="submenu" id="submenu" placeholder="Escolha um nome para o Submenu">
        <input type="text" name="icone" id="icone" placeholder="Escolha um icone para o Submenu">
        <select name="tp_acesso" class="select">
            <?=$listarAcesso?>
        </select>
        <br>
        <input type="hidden" name="mandar" value="yes">
        <input type="submit" value="Cadastrar" id="btnCadastrar" onclick="fnReload()">
    </form>
</div>
<?php include 'include/footer.php';?>