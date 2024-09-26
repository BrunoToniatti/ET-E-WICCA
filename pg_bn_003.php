<?php include 'include/top.php';?>
<?php

$id = $_GET['id'];
$sql_ler = "{CALL pr_ler_banners(?)}";
$parametros_ler = array($id);
$stmt_ler = sqlsrv_query($conn, $sql_ler, $parametros_ler);
$row_ler = sqlsrv_fetch_array($stmt_ler);

$tipo = $_POST['tipo'] ?? "";

if(!empty($tipo)){
	$banner_desc		    = $_POST['banner_desc'] ?? "";
	$banner_alerta		    = strtoupper($_POST['banner_alerta']) ?? "";
	$banner_titulo		    = $_POST['banner_titulo'] ?? "";
	$banner_botao_texto	    = $_POST['banner_botao_texto'] ?? "";
	$banner_foto		    = $_POST['banner_foto'] ?? "";
	$status_cod			    = $_POST['status_cod'] ?? "";

    $sql = "{CALL pr_man_banners(?,?,?,?,?,?,?,?)}";
    $parametros = array($tipo, $id, $banner_desc, $banner_alerta, $banner_titulo, $banner_botao_texto, $banner_foto, $status_cod);
    $stmt = sqlsrv_query($conn, $sql, $parametros);
    $row = sqlsrv_fetch_array($stmt);
    if($row['cad']){
        echo "<script>window.alert('".$row['msg']."')</script>";
        if($tipo == 2){
            echo "<script>window.location.href='pg_bn_002.php';</script>";
        }else{
            echo "<script>window.location.href='pg_bn_003.php?id=".$id."';</script>"; 
        }
    }else{
        echo "<script>window.alert('".$row['msg']."')</script>";
    }

}
?>

<div class="container">
    <h1>Cadastrar Marca</h1>
    <form action="pg_bn_003.php?id=<?=$id?>" method="post">
        <div class="formulario">
            <label>Banner Descrição: <br>
                <input type="text" name="banner_desc" id="banner_desc" value="<?=$row_ler['banner_desc']?>">                
            </label>
            <label>Banner Alerta: <br>
                <input type="text" name="banner_alerta" id="banner_alerta" value="<?=$row_ler['banner_alerta']?>">                
            </label>
            <label>Banner Titulo: <br>
                <input type="text" name="banner_titulo" id="banner_titulo" value="<?=$row_ler['banner_titulo']?>">                
            </label>
            <label>Banner Botão: <br>
                <input type="text" name="banner_botao_texto" id="banner_botao_texto" value="<?=$row_ler['banner_botao_texto']?>">                
            </label>
            <label>Banner Foto: <br>
                <input type="text" name="banner_foto" id="banner_foto" value="<?=$row_ler['banner_foto']?>">                
            </label>
            <label> Status <br>
            <select name="status_cod" class="select">
            <?php if($row_ler['status_cod'] == 1) {?>
                <option value="1">Ativo</option>
                <option value="2">Inativo</option>
            <?php } else {?>
                <option value=2>Inativo</option>
                <option value=1>Ativo</option>
            <?php }?>                
            </select>
            </label>
        </div>
        <input type="hidden" name="tipo" value="1">
        <div class="botoes">
            <input type="submit" value="Atualizar" class="atualizar" style="width: 150px !important; height: 40px !important;">
    </form>
			<form action="pg_bn_003.php?id=<?=$id?>" method="post">
                <input type="hidden" name="tipo" value="2">
				<input type="submit" value="Apagar" class="apagar" style="margin-top: -55px !important; width: 150px !important; height: 40px !important;">
			</form>
        </div>
</div>

<?php include 'include/footer.php';?>
