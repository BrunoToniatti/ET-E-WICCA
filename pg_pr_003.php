<?php include 'include/top.php';?>
<?php
$produto_cod = $_GET['produto_cod'];
$pg = 'pg_pr_003';

$fornecedor = "{CALL pr_ler_fornecedores(?,?)}";
$parametros_fornecedores = array(3, '');
$stmt_fornecedores = sqlsrv_query($conn, $fornecedor, $parametros_fornecedores);
$listarFornecedores = "";
while ($rowFornecedor = sqlsrv_fetch_array($stmt_fornecedores)) {
    $listarFornecedores .= "<option value='" . $rowFornecedor['fornecedor_cod'] . "'>" . $rowFornecedor['cnpj'] . " - " . $rowFornecedor['fornecedor_nome'] . "</option>";
}
	
$tipo_produto = "{CALL pr_ler_tipo_produto(?,?)}";
$parametros_tp_produto = array(2, '');
$stmt_tp_produto = sqlsrv_query($conn, $tipo_produto, $parametros_tp_produto);
$listarTipoProduto = "";
while ($rowTipoProduto = sqlsrv_fetch_array($stmt_tp_produto)) {
	$listarTipoProduto .= "<option value='" . $rowTipoProduto['tipo_cod'] . "'>" . $rowTipoProduto['tipo_nome'] . "</option>";
}

$cores = "{CALL pr_ler_cores(?)}";
$parametros_cores = array(2);
$stmt_cores = sqlsrv_query($conn, $cores, $parametros_cores);
$listarCores = "";
while($rowCores = sqlsrv_fetch_array($stmt_cores)){
    $listarCores .= "<option value=".$rowCores['cor_cod'].">".$rowCores['cor_nome']."</option>";
}

$tamanhos = "{CALL pr_ler_tamanhos(?,?)}";
$parametros_tamanhos = array(2, '');
$stmt_parametros = sqlsrv_query($conn, $tamanhos, $parametros_tamanhos);
$listarTamanhos = "";
while($row = sqlsrv_fetch_array($stmt_parametros)){
    $listarTamanhos .= "<option value=".$row['tamanho'].">".$row['tamanho']."</option>";
}

$boxes = "{CALL pr_ler_box(?,?)}";
$parametros_boxes = array(3, '');
$stmt_boxes = sqlsrv_query($conn, $boxes, $parametros_boxes);
$listarBox = "";
while($rowBoxes = sqlsrv_fetch_array($stmt_boxes)){
    $listarBox .= "<option value=".$rowBoxes['box_cod'].">".strtoupper($rowBoxes['box_nome'])."</option>";
}

$times = "{CALL pr_ler_times(?,?)}";
$parametros_times = array(3, '');
$stmt_times = sqlsrv_query($conn, $times, $parametros_times);
$listarTimes = "";
while($rowtimes = sqlsrv_fetch_array($stmt_times)){
    $listarTimes .= "<option value=".$rowtimes['time_cod'].">".strtoupper($rowtimes['time_descricao'])."</option>";
}

$sql = "{CALL pr_ler_produtos(?,?)}";
$parametros = array(2, $produto_cod);
$stmt = sqlsrv_query($conn, $sql, $parametros);
$row = sqlsrv_fetch_array($stmt);
?>
    <div class="container">
        <?php include 'include/abas/produtos.php';?>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <div class="formulario">
            <label> Produto Código <br>
                <input type="text" id="produto_cod" name="produto_cod" class="codigo" disabled value="<?=$row['produto_cod']?>">
            </label>
            <label>Fornecedor <br>
                <select name="fornecedor_cod" class="select">
                    <option value="<?=$row['fornecedor_cod']?>"><?=$row['fornecedor_nome']?></option>
                    <?=$listarFornecedores?>
                </select>
            </label>
            <label> Tipo de produto <br>
                <select name="tipo_cod" class="select" style="width: 100%;">
                    <option value="<?=$row['tipo_cod']?>"><?=$row['tipo_nome']?></option>
                    <?=$listarTipoProduto?>
                </select>
            </label>
            <label> Cor <br>
                <select name="cor_cod" class="select" style="width: 100%;">
                    <option value="<?=$row['cor_cod']?>"><?=$row['cor_nome']?></option>
                    <?=$listarCores?>
                </select>
            </label>
            <label> Tamanho <br>
                <select name="tamanho" class="select" style="width: 100%;">
                    <option value="<?=$row['tamanho']?>"><?=$row['tamanho']?></option>
                    <?=$listarTamanhos?>
                </select>
            </label>
            <label> Box <br>
                <select name="box_cod" class="select" style="width: 100%;">
                    <option value="<?=$row['box_cod']?>"><?=$row['box_nome']?></option>
                    <?=$listarBox?>
                </select>
            </label>
            <label> Time <br>
                <select name="time_cod" class="select" style="width: 100%;">
                    <option value="<?=$row['time_cod']?>"><?=$row['time_descricao']?></option>
                    <?=$listarTimes?>
                </select>
            </label>
            <label> Valor compra <br>
                <input type="text" id="valor_compra" name="produto_compra" value="<?=$row['produto_valor_compra']?>">
            </label>
            <label> Valor venda <br>
                <input type="text" id="valor_venda" name="produto_venda" value="<?=$row['produto_valor_venda']?>">
            </label>
            <label> Link da foto <br>
                <input type="text" id="produto_foto" name="produto_foto" value="<?=$row['produto_foto']?>">
            </label>
        </div>
        <div class="descricao" style="width: 100%;">
            <label style="width: 100%;">Descrição do produto: <br>
            <input type="text" name="produto_desc" id="produto_desc" style="width: 100% !important;" value="<?=$row['produto_desc']?>">
            </label>
            <input type="hidden" name="cadastrar" value="yes">
        </div>
        </form>
    </div>
<?php include 'include/footer.php';?>