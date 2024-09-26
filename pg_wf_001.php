<?php include 'include/top.php';?>
<?php
$msg        = "";
$pg         = 'pg_wf_001';
$wf_cod     = $_GET['wf_id'] ?? "" ;
if(empty($wf_cod)){
	$fornecedor = $conn->query("call pr_ler_fornecedores(2)");
    $conn->next_result();
	$listarFornecedores = "";
	if ($fornecedor->num_rows > 0) {
		while ($rowFornecedor = $fornecedor->fetch_assoc()) {
			$listarFornecedores .= "<option value='" . $rowFornecedor['id_fornecedor'] . "'>" . $rowFornecedor['cnpj_cpf'] . " - " . $rowFornecedor['nome_fornecedor'] . "</option>";
		}
	}
	
	$tipo_produto = $conn->query("SELECT * FROM tipo_produto");
	$listarTipoProduto = "";
	if ($tipo_produto->num_rows > 0) {		
		while ($rowTipoProduto = $tipo_produto->fetch_assoc()) {
			$listarTipoProduto .= "<option value='" . $rowTipoProduto['tipo_id'] . "'>" . $rowTipoProduto['tipo_nome'] . "</option>";
		}
	}
	
	$cadastrar = $_POST['cadastrar'] ?? "";
	if (!empty($cadastrar)) {
		$fornecedor     = $_POST['fornecedor'] ?? "";
		$nome_produto   = $_POST['nome_referencia'] ?? "";
		$codigo_produto = $_POST['codigo_referencia'] ?? "";
		$tipo_produto   = $_POST['tipo_referencia'] ?? "";
		$produto_desc   = $_POST['produto_desc'] ?? "";
		$valor          = $_POST['valor'] ?? 0;
	
		$sql = "CALL pr_criar_referencia('$fornecedor', '$nome_produto', '$codigo_produto', '$tipo_produto', '$produto_desc', '$valor', '$cod', @msg, @cad)";
    if ($conn->query($sql)) {
        $resultado = $conn->query("SELECT @msg AS msg, @cad AS cad");
            if($resultado->num_rows > 0){
                $rowResultado = $resultado->fetch_assoc();
                if($rowResultado['cad']){
                    $msg = $rowResultado['msg'];
                    echo "<script>window.location.href='pg_pr_002.php';</script>";
                }else{
                    $msg = $rowResultado['msg'];
                }
            }
			
		}
	}
} else {
	$select = $conn->query("CALL pr_ler_workflow(2, '$wf_cod')");
    if($select->num_rows > 0){
        $rowWF = $select->fetch_assoc();
    }
	$conn->next_result();	

    $autorizar = $_POST['autorizar'] ?? "";
    if(!empty($autorizar)){
        $sql = $conn->query("CALL pr_pagar_wf('$wf_cod', @msg, @conf)");
        $conn->next_result();
        if($sql){
            $resultado = $conn->query("SELECT @msg AS msg, @conf AS confirmacao");
            if($resultado->num_rows > 0){
                $rowResultado = $resultado->fetch_assoc();
                if($rowResultado['confirmacao']){
                    echo "<script>window.location.href='pg_wf_002.php';</script>";
                }
            }
        }
    }

}
?>
<div class="container">
    <?php if (empty($wf_cod)) { ?>
        <h1>Criar WF <?=$msg?></h1>
        <form id="produtoForm" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
            <div class="informacoes">
                <label>Fornecedor: <br>
                    <select name="fornecedor" class="select">
                        <option value=""></option>
                        <?=$listarFornecedores?>
                    </select>
                </label>
                <label> Nome da referencia <br>
                    <input type="text" name="nome_referencia" required>
                </label>
                <label> Codigo da referencia<br>
                    <input type="text" name="codigo_referencia" required>
                </label>
                <label> Tipo de produto <br>
                    <select name="tipo_referencia" class="select" style="width: 100%;">
                    <option value=""></option>
                        <?=$listarTipoProduto?>
                    </select>
                </label>
                <label> Valor Unitario <br>
                    <input type="text" id="valor" name="valor">
                </label>   
            </div>
            <div class="descricao" style="width: 100%;">
                <label style="width: 100%;">Descrição do produto: <br>
                <textarea name="produto_desc" style="width: 100%; height: 150px;"></textarea>
                </label>
                <input type="hidden" name="cadastrar" value="yes">
            </div>
                
            <div class="botoes">
                <input type="submit" value="Cadastrar Referência">
            </div>
        </form>
    <?php } else { ?>
		<form id="produtoForm" action="<?=$_SERVER['PHP_SELF']?>?wf_id=<?=$wf_cod?>" method="POST">
            <input type="text" name="fornecedor" value="<?=$rowWF['nome_fornecedor']?>">
            <input type="text" name="conta" placeholder="Nome do Produto" value="<?=$rowWF['wf_conta_contabil']?>">
            <input type="text" name="codigo_produto" placeholder="Código do produto" value="<?=$rowWF['pf_nome']?>">
            <input type="text" id="valor" name="valor" placeholder="Valor Unitário" value="<?=number_format($rowWF['wf_valor'], 2, ',', '.')?>">
            <br>
            <textarea name="motivo" id="motivo"><?=$rowWF['wf_motivo']?></textarea>
            <input type="hidden" name="autorizar" value="yes">
            <br>
            <div class="botoes">
                <input type="submit" value="Aprovar" class="atualizar">
				<form action="" method="post">
					<input type="submit" value="Reprovar" class="apagar">
				</form>
            </div>
        </form>
	<?php } ?>
</div>
<script>
$('#valor').mask('000.000.000.000.000,00', {reverse: true});
</script>
<?php include 'include/footer.php';?>
