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

//$submenus = "{CALL pr_ler_submenus(?,?)}";
//$paraSubmenu = array(1, '');
//$stmtSubmenu = sqlsrv_query($conn, $submenus, $paraSubmenu);
//$submenu = "";
//if(sqlsrv_has_rows($stmtSubmenu)){
//    $submenu .= "<option value='' selected disabled>Escolha o submenu</otpion>";
//    while($rowM = sqlsrv_fetch_array($stmtSubmenu)){
//        $submenu .= "<option value='".$rowM['submenu_cod']."'>".$rowM['submenu_nome']."</otpion>";
//    }
//}

$menu_e         = $_POST['menu_e'] ?? "";
$submenu_e      = $_POST['submenu_e'] ?? "";
$mandar         = $_POST['mandar'] ?? "";
$acesso         = $_POST['tp_acesso'] ?? "";
$link           = $_POST['link'] ?? "";
$programa       = $_POST['programa'] ?? "";
$mostrar_menu	= $_POST['mostrar_menu'] ?? "";

if(!empty($mandar)){
    $insert = "{CALL pr_criar_programa(?,?,?,?,?,?,?)}";
    $parametros = array($programa, $link, $acesso, $menu_e, $submenu_e, $cod, $mostrar_menu);
    $stmt = sqlsrv_query($conn, $insert, $parametros);
	if(sqlsrv_has_rows($stmt)){
        $row = sqlsrv_fetch_array($stmt);
		if($row['cad']){
            echo "<script>window.alert('".$row['msg']."')</script>";
            echo "<script>window.location.href='pg_si_005.php';</script>";
        }else{
            echo "<script>window.alert('".$row['msg']."')</script>";
        }
	}else{
		echo "erro!!";
	}
}
?>

<div class="container">
    <h1>Cadastrar Programa</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post" class="cadastrar">
    <select name="menu_e" id="menu_e" class="select">
        <?=$menu?>
    </select>
    <select name="submenu_e" id="submenu_e" class="select">
        <option value="" selected disabled>Escolha o submenu</option>
    </select>
    <input type="text" name="programa" id="programa" placeholder="Escolha um nome para o Programa">
    <input type="text" name="link" id="link" placeholder="Informe o link do programa">
    <select name="tp_acesso" class="select">
        <?=$listarAcesso?>
    </select>
	<select name="mostrar_menu" class="select">
		<option value="" selected disabled>Irá mostrar no menu?</option>
		<option value="S">SIM</option>
		<option value="N">NÃO</option>
	</select>
    <br>
    <input type="hidden" name="mandar" value="yes">
    <input type="submit" value="Cadastrar" id="btnCadastrar">
</form>

</div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var menuSelect = document.getElementById("menu_e");
    var submenuSelect = document.getElementById("submenu_e");

    // Função para atualizar os submenus com base no menu selecionado
    menuSelect.addEventListener("change", function() {
        var selectedMenuId = this.value;

        // Limpar opções atuais de submenu
        while (submenuSelect.options.length > 1) {
            submenuSelect.remove(1);
        }

        // Solicitar submenus relacionados ao menu selecionado via AJAX ou PHP
        if (selectedMenuId !== '') {
            fetch('get_submenus.php?menu_id=' + selectedMenuId)
                .then(response => response.json())
                .then(data => {
                    data.forEach(submenu => {
                        var option = document.createElement("option");
                        option.value = submenu.submenu_id;
                        option.textContent = submenu.submenu_nome;
                        submenuSelect.appendChild(option);
                    });
                });
        }
    });

    // Chamar a função uma vez para configurar os submenus inicialmente
    if (menuSelect.value !== '') {
        menuSelect.dispatchEvent(new Event('change'));
    }
});
</script>
<?php include 'include/footer.php';?>