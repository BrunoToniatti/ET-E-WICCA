<?php include 'include/top.php';?>
<?php
$sql_regiao = "{CALL pr_ler_regioes(?,?,?)}";
$parametros_regiao = array(1, '','');
$stmt_regiao = sqlsrv_query($conn, $sql_regiao, $parametros_regiao);
$regioes = "";
$time_nome = $_GET['time_desc'] ?? "";
$time_id = $_GET['time_id'] ?? "";
$torcedor = $_GET['torcedor'] ?? 0;

$mandar = $_POST['mandar'] ?? "";
if(!empty($mandar)){
    $time_id = $_GET['time_id'] ?? "";
    $torcedor = $_GET['torcedor'] ?? 0;
    $time_cod = $_POST['time_cod'];
    $time_nome = $_POST['time_nome'];
    $regiao_cod = $_POST['regiao_cod'];
    $time_foto = $_POST['time_foto'];
    $sql = "{CALL pr_criar_time(?,?,?,?,?,?,?)}";
    $parametros = array($time_cod, $time_nome, $regiao_cod, $time_foto, $cod, $time_id, $torcedor);
    $stmt = sqlsrv_query($conn, $sql, $parametros);
    if($row = sqlsrv_fetch_array($stmt)){
        if($row['cad']){
            echo "<script>window.alert('".$row['msg']."')</script>";
            echo "<script>window.location.href='pg_tm_002.php';</script>";
        }else{
            echo "<script>window.alert('".$row['msg']."')</script>";
        }
    }
}
while($row_regiao = sqlsrv_fetch_array($stmt_regiao)){
    $regioes .= "<option value=".$row_regiao['regiao_cod'].">".$row_regiao['regiao_nome']."</optiom>";
}
?>
<div class="container">
    <h1>Novo Time</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>?time_id=<?=$time_id?>&torcedor=<?=$torcedor?>" method="post">
        <div class="formulario">
            <label> Código do time: <br>
                <input type="text" name="time_cod" id="time_cod" maxlength="3">
            </label>
            <label>Time nome: <br>
                <input type="text" name="time_nome" id="time_nome" value="<?=$time_nome?>">
            </label>
            <label>Região: <br>
                <select name="regiao_cod" class="select">
                    <option value=""></option>
                    <?=$regioes?>
                </select>
            </label>
            <label>Time foto: <br>
                <input type="text" name="time_foto">
            </label>
        </div>
        <div class="botoes">
            <input type="hidden" name="mandar" value="yes">
            <input type="submit" value="Cadastrar">
        </div>
    </form>
</div>
<?php include 'include/footer.php';?>