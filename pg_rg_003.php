<?php include 'include/top.php';?>
<?php
$regiao_cod = $_GET['regiao_cod'];
$sql = "{CALL pr_ler_regioes(?,?,?)}";
$parametros = array(3, $regiao_cod, '');
$stmt = sqlsrv_query($conn, $sql, $parametros);
$row = sqlsrv_fetch_array($stmt);

$tipo = $_POST['tipo'] ?? "";
if(!empty($tipo)){
    $regiao_nome = $_POST['regiao_nome'];
    $status_cod = $_POST['status_cod'];
    $sql2 = "{CALL pr_man_regioes(?,?,?,?)}";
    $parametros2 = array($tipo, $regiao_cod, $regiao_nome, $status_cod);
    $stmt2 = sqlsrv_query($conn, $sql2, $parametros2);
    if($row2 = sqlsrv_fetch_array($stmt2)){
        if($row2['cad']){
            echo "<script>window.alert('".$row2['msg']."')</script>";
            if($tipo == 2){
                echo "<script>window.location.href='pg_rg_002.php';</script>";
            }
        }
    }
}
?>
<div class="container">
    <h1>Nova Região</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>?regiao_cod=<?=$regiao_cod?>" method="post">
        <div class="formulario">
            <label>Código da região: <br>
                <input type="text" name="regiao_cod" maxlength="2" disabled class="codigo" value="<?=$row['regiao_cod']?>">
            </label>
            <label>Nome da região: <br>
                <input type="text" name="regiao_nome" value="<?=$row['regiao_nome']?>">
            </label>
            <label>Status: <br>
                <select name="status_cod" class="select">
                    <option value="<?=$row['status_cod']?>"><?=$row['status_nome']?></option>
                    <option value="1">Ativo</option>
                    <option value="2">Inativo</option>
                </select>
            </label>
        </div>
        <br>
        <input type="hidden" name="tipo" value="1">
        <br>
        <div class="botoes">
            <input type="submit" value="Atualizar" class="atualizar" style="width: 150px !important; height: 40px !important;">
        </form>
		<form action="<?=$_SERVER['PHP_SELF']?>?regiao_cod=<?=$regiao_cod?>" method="post">
                <input type="hidden" name="tipo" value="2">
			<input type="submit" value="Apagar" class="apagar" style="margin-top: -55px !important; width: 150px !important; height: 40px !important;">
		</form>
        </div>
            
        </div>
    </form>
</div>
<?php include 'include/footer.php';?>