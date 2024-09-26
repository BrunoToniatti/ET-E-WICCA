<?php include 'include/top.php';?>
<?php
$mandar = $_POST['mandar'] ?? "";
if(!empty($mandar)){
    $tamanho = $_POST['tamanho'];
    $sql = "{CALL pr_criar_tamanho(?,?)}";
    $parametros = array($tamanho, $cod);
    $stmt = sqlsrv_query($conn, $sql, $parametros);
    if($row = sqlsrv_fetch_array($stmt)){
        if($row['cad']){
            echo "<script>window.alert('".$row['msg']."')</script>";
            echo "<script>window.location.href='pg_th_002.php';</script>";
        }else{
            echo "<script>window.alert('".$row['msg']."')</script>";
        }
    }
}
?>
<div class="container">
    <h1>Novo Tamanho</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <div class="formulario">
            <label>Tamanho: <br>
                <input type="text" name="tamanho" id="tamanho">
            </label>
        </div>
        <div class="botoes">
            <input type="hidden" name="mandar" value="yes">
            <input type="submit" value="Cadastrar">
        </div>
    </form>
</div>
<?php include 'include/footer.php';?>