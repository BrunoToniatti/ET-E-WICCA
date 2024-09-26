<?php include 'include/top.php';?>
<?php
$mandar = $_POST['mandar'] ?? "";
if(!empty($mandar)){
    $regiao_cod = $_POST['regiao_cod'];
    $regiao_nome = $_POST['regiao_nome'];
    $sql = "{CALL pr_criar_regioes(?,?,?)}";
    $parametros = array($regiao_cod, $regiao_nome, $cod);
    $stmt = sqlsrv_query($conn, $sql, $parametros);
    if($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)){
        if($row['cad']){
            echo "<script>window.alert('".$row['msg']."')</script>";
            echo "<script>window.location.href='pg_rg_002.php';</script>";
        }else{
            echo "<script>window.alert('".$row['msg']."')</script>";
        }
    }
}
?>
<div class="container">
    <h1>Nova Região</h1>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <div class="formulario">
            <label>Código da região: <br>
                <input type="text" name="regiao_cod" maxlength="2">
            </label>
            <label>Nome da região: <br>
                <input type="text" name="regiao_nome">
            </label>
        </div>
        <div class="botoes">
            <input type="hidden" name="mandar" value="yes">
            <input type="submit" value="Cadastrar">
        </div>
    </form>
</div>
<?php include 'include/footer.php';?>