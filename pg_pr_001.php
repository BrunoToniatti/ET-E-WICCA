<?php include 'include/top.php';?>
<?php
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

$cadastrar = $_POST['cadastrar'] ?? "";
if (!empty($cadastrar)) {
    $produto_compra_form = $_POST['produto_compra'];
    $produto_venda_form  = $_POST['produto_venda'];
	$fornecedor_cod = $_POST['fornecedor_cod'];
	$tipo_cod       = $_POST['tipo_cod'];
	$cor_cod        = $_POST['cor_cod'];
	$tamanho        = $_POST['tamanho'];
	$box_cod        = $_POST['box_cod'];
	$time_cod       = $_POST['time_cod'];
    $produto_desc   = $_POST['produto_desc'];
    $produto_foto   = $_POST['produto_foto'];
    $produto_compra = floatval(str_replace(',', '.', str_replace('.', '', $produto_compra_form)));
    $produto_venda  = floatval(str_replace(',', '.', str_replace('.', '', $produto_venda_form)));

	$sql = "{CALL pr_criar_produto (?,?,?,?,?,?,?,?,?,?,?)}";
    $parametros = array($produto_desc, $produto_compra, $produto_venda, $fornecedor_cod, $tipo_cod, $cor_cod, $tamanho, $box_cod, $time_cod, $cod, $produto_foto);
    $stmt = sqlsrv_query($conn, $sql, $parametros);
    if ($row = sqlsrv_fetch_array($stmt)) {
        if($row['cad']){
            echo "<script>window.alert('".$row['msg']."')</script>";
            echo "<script>window.location.href='pg_pr_003.php?produto_cod=".$row['produto_cod']."';</script>";
        }else{
            echo "<script>window.alert('".$row['msg']."')</script>";
        }		
	}
}
?>
<div class="container">
    <h1>Cadastrar Produto</h1>
    <form id="produtoForm" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <div class="formulario">
            <label>Fornecedor <br>
                <select name="fornecedor_cod" class="select">
                    <option value=""></option>
                    <?=$listarFornecedores?>
                </select>
            </label>
            <label> Tipo de produto <br>
                <select name="tipo_cod" class="select" style="width: 100%;">
                    <option value=""></option>
                    <?=$listarTipoProduto?>
                </select>
            </label>
            <label> Cor <br>
                <select name="cor_cod" class="select" style="width: 100%;">
                    <option value=""></option>
                    <?=$listarCores?>
                </select>
            </label>
            <label> Tamanho <br>
                <select name="tamanho" class="select" style="width: 100%;">
                    <option value=""></option>
                    <?=$listarTamanhos?>
                </select>
            </label>
            <label> Box <br>
                <select name="box_cod" class="select" style="width: 100%;">
                    <option value=""></option>
                    <?=$listarBox?>
                </select>
            </label>
            <label> Time <br>
                <select name="time_cod" class="select" style="width: 100%;">
                    <option value=""></option>
                    <?=$listarTimes?>
                </select>
            </label>
            <label> Valor compra <br>
                <input type="text" id="valor_compra" name="produto_compra">
            </label>
            <label> Valor venda <br>
                <input type="text" id="valor_venda" name="produto_venda">
            </label>
            <label> Link da foto <br>
                <input type="text" id="produto_foto" name="produto_foto">
            </label>
        </div>
        <div class="descricao" style="width: 100%;">
            <label style="width: 100%;">Descrição do produto: <br>
            <input type="text" name="produto_desc" id="produto_desc" style="width: 100% !important;">
            </label>
            <input type="hidden" name="cadastrar" value="yes">
        </div>
            
        <div class="botoes">
            <input type="submit" value="Cadastrar Produto">
        </div>
    </form>
</div>
<script>
$('#valor_compra').mask('000.000.000.000.000,00', {reverse: true});
$('#valor_venda').mask('000.000.000.000.000,00', {reverse: true});
</script>
<?php include 'include/footer.php';?>
