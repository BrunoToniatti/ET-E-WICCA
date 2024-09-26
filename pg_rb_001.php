<?php include 'include/top.php';?>
<?php

$mandar = $_POST['mandar'] ?? "";
if(!empty($mandar)){
    $recebimento_quantidade = $_POST['recebimento_quantidade'];
    $produto_cod = $_POST['produto_cod'];

    $sql_gerar = "{CALL pr_gerar_recebimento(?,?,?)}";
    $parametros_gerar = array($recebimento_quantidade, $produto_cod, $cod);
    $stmt_gerar = sqlsrv_query($conn, $sql_gerar, $parametros_gerar);
    if($row_gerar = sqlsrv_fetch_array($stmt_gerar)){
        if($row_gerar['cad']){
            echo "<script>window.alert('".$row_gerar['msg']."')</script>";
        }else{
            echo "<script>window.alert('".$row_gerar['msg']."')</script>";
        }
    }
}

$select = "{CALL pr_ler_produtos(?,?)}";
$parametros = array(3, '');
$stmt = sqlsrv_query($conn, $select, $parametros);
$lista = "";
while($row = sqlsrv_fetch_array($stmt)){
    $lista .= "<option value=".$row['produto_cod'].">".$row['produto_desc']."</option>";
}

?>
<div class="container">
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <div class="formulario">
            <label>Produto: <br> 
                <select name="produto_cod" class="select">
                    <option value=""></option>
                    <?=$lista?>
                </select>
            </label>
            <label>Quantidade: <br>
                <input type="number" name="recebimento_quantidade" min="1">
            </label>
        </div>
        <input type="hidden" name="mandar" value="yes">
        <div class="botoes">
            <input type="submit" value="Gerar recebimento">
        </div>
    </form>
</div>
<?php include 'include/footer.php';?>