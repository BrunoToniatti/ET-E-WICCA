<?php include 'include/top.php';?>
<?php
$time_cod = $_GET['time_cod'];
$cabecalho = 'times';
$pg = 'pg_tm_003';

$sql_regiao = "{CALL pr_ler_regioes(?,?,?)}";
$parametros_regiao = array(1, '','');
$stmt_regiao = sqlsrv_query($conn, $sql_regiao, $parametros_regiao);
$regioes = "";
while($row_regiao = sqlsrv_fetch_array($stmt_regiao)){
    $regioes .= "<option value=".$row_regiao['regiao_cod'].">".$row_regiao['regiao_nome']."</optiom>";
}

$tipo = $_POST['tipo'] ?? "";
if(!empty($tipo)){
    $time_descricao = $_POST['time_descricao'];
    $regiao_cod = $_POST['regiao_cod'];
    $sql = "{CALL pr_man_times(?,?,?,?)}";
    $parametros = array($tipo, $time_cod, $time_descricao, $regiao_cod);
    $stmt = sqlsrv_query($conn, $sql, $parametros);
    if($row = sqlsrv_fetch_array($stmt)){
        if($row['cad']){
            echo "<script>window.alert('".$row['msg']."')</script>";
            if($tipo == 2){
                echo "<script>window.location.href='pg_tm_002.php';</script>";
            }
        }
    }
}
?>
<div class="container">
    <?php include 'include/abas/times.php';?>
    <form action="<?=$_SERVER['PHP_SELF']?>?time_cod=<?=$time_cod?>" method="post">
        <div class="formulario">
            <label> Código do time: <br>
                <input type="text" name="time_cod" id="time_cod" class="codigo" maxlength="3" value="<?=$row['time_cod']?>" disabled>
            </label>
            <label>Time nome: <br>
                <input type="text" name="time_descricao" id="time_descricao" value="<?=$row['time_descricao']?>">
            </label>
            <label>Região: <br>
                <select name="regiao_cod" class="select">
                    <option value="<?=$row['regiao_cod']?>"><?=$row['regiao_nome']?></option>
                    <?=$regioes?>
                </select>
            </label>
            <input type="hidden" name="tipo" value="1">
        </div>
        <div class="botoes">
            <input type="submit" value="Atualizar" class="atualizar" style="width: 150px !important; height: 40px !important;">
        </form>
				<form action="<?=$_SERVER['PHP_SELF']?>?time_cod=<?=$time_cod?>" method="post">
                    <input type="hidden" name="tipo" value="2">
					<input type="submit" value="Apagar" class="apagar" style="margin-top: -55px !important; width: 150px !important; height: 40px !important;">
				</form>
            </div>
</div>
<?php include 'include/footer.php';?>