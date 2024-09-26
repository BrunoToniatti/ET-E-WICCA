<?php include 'include/top.php';?>
<?php
$msg = "";
$pg = 'pg_pr_001';
$pf_cod   = $_GET['pf_cod'] ?? "" ;
if(empty($pf_cod)){
	$referencias = $conn->query("CALL pr_ler_referencias()");
    $conn->next_result();
	$listarReferencias = "";
	if ($referencias->num_rows > 0) {
		while ($rowFornecedor = $referencias->fetch_assoc()) {
			$listarReferencias .= "<option value='" . $rowFornecedor['produto_cod'] . "'>" . $rowFornecedor['produto_cod'] . " - " . $rowFornecedor['produto_nome'] . "</option>";
		}
	}

    $sabores = $conn->query("CALL pr_ler_sabores()");
    $conn->next_result();
	$listarSabores = "";
	if ($sabores->num_rows > 0) {
		while ($rowSabores = $sabores->fetch_assoc()) {
			$listarSabores .= "<option value='" . $rowSabores['sabor_id'] . "'>". $rowSabores['sabor_nome'] . "</option>";
		}
	}


	$tipo_produto = $conn->query("SELECT * FROM tipo_produto");
	$listarTipoProduto = "";
	if ($tipo_produto->num_rows > 0) {
		while ($rowTipoProduto = $tipo_produto->fetch_assoc()) {
			$listarTipoProduto .= "<option value='" . $rowTipoProduto['tipo_id'] . "'>" . $rowTipoProduto['tipo_nome'] . "</option>";
		}
	}
	
	$produto_box = $conn->query("SELECT * FROM box");
	$listarBox = "";
	if ($produto_box->num_rows > 0) {
		while ($rowBox = $produto_box->fetch_assoc()) {
			$listarBox .= "<option value='" . $rowBox['box_id'] . "'>" . strtoupper($rowBox['box_nome']) . "</option>";
		}
	}

	$produto_marca = $conn->query("CALL pr_ler_marcas(2)");
	$conn->next_result();
	$listarMarca = "";
	if ($produto_marca->num_rows > 0) {		
		while ($rowMarca = $produto_marca->fetch_assoc()) {
			$listarMarca .= "<option value='" . $rowMarca['marca_id'] . "'>" . strtoupper($rowMarca['marca_nome']) . "</option>";
		}
	}

	$categorias = $conn->query("CALL pr_ler_categorias()");
	$conn->next_result();
	$listarCategorias = "";
	if ($categorias->num_rows > 0) {
		while ($rowCategorias = $categorias->fetch_assoc()) {
			$listarCategorias .= "<option value='" . $rowCategorias['cate_id'] . "'>" . strtoupper($rowCategorias['cate_nome']) . "</option>";
		}
	}
	
	$cadastrar = $_POST['cadastrar'] ?? "";
	if (!empty($cadastrar)) {
		$referencias     	= $_POST['referencia'] ?? "";
		$sabor          	= $_POST['sabor'] ?? "";
        $produto_box   		= $_POST['produto_box'] ?? "";
        $foto    			= $_POST['foto'] ?? "";
		$marca				= $_POST['produto_marca'] ?? "";
		$categoria			= $_POST['categoria'] ?? "";
	
		$sql = "CALL pr_criar_produto_final('$referencias', $sabor, '$produto_box', '$cod', '$foto', '$marca', '$categoria',@msg, @cad);";
        $conn->next_result();
    if ($conn->query($sql)) {
        $resultado = $conn->query("SELECT @msg AS msg, @cad AS cad");
            if($resultado->num_rows > 0){
                $rowResultado = $resultado->fetch_assoc();
                if($rowResultado['cad']){
                    $msg = $rowResultado['msg'];
                    echo "<script>window.location.href='pg_rf_002.php';</script>";
                }else{
                    $msg = $rowResultado['msg'];
                }
            }
			
		}
	}
} else {
	$cabecalho = 'produto_final';
	$select = $conn->query("CALL pr_ler_produtos_finais_busca('$pf_cod')");
	$conn->next_result();
	if($select->num_rows > 0){
		$row = $select->fetch_assoc();

		$referencias = $conn->query("CALL pr_ler_referencias()");
    	$conn->next_result();
		$listarReferencias = "";
		if ($referencias->num_rows > 0) {
			while ($rowFornecedor = $referencias->fetch_assoc()) {
				$listarReferencias .= "<option value='" . $rowFornecedor['produto_cod'] . "'>" . $rowFornecedor['produto_cod'] . " - " . $rowFornecedor['produto_nome'] . "</option>";
			}
		}
	
    	$sabores = $conn->query("CALL pr_ler_sabores()");
    	$conn->next_result();
		$listarSabores = "";
		if ($sabores->num_rows > 0) {
			while ($rowSabores = $sabores->fetch_assoc()) {
				$listarSabores .= "<option value='" . $rowSabores['sabor_id'] . "'>". $rowSabores['sabor_nome'] . "</option>";
			}
		}
	
	
		$tipo_produto = $conn->query("SELECT * FROM tipo_produto");
		$listarTipoProduto = "";
		if ($tipo_produto->num_rows > 0) {
			while ($rowTipoProduto = $tipo_produto->fetch_assoc()) {
				$listarTipoProduto .= "<option value='" . $rowTipoProduto['tipo_id'] . "'>" . $rowTipoProduto['tipo_nome'] . "</option>";
			}
		}
		
		$produto_box = $conn->query("SELECT * FROM box");
		$listarBox = "";
		if ($produto_box->num_rows > 0) {
			while ($rowBox = $produto_box->fetch_assoc()) {
				$listarBox .= "<option value='" . $rowBox['box_id'] . "'>" . strtoupper($rowBox['box_nome']) . "</option>";
			}
		}
	
		$produto_marca = $conn->query("CALL pr_ler_marcas(2)");
		$conn->next_result();
		$listarMarca = "";
		if ($produto_marca->num_rows > 0) {		
			while ($rowMarca = $produto_marca->fetch_assoc()) {
				$listarMarca .= "<option value='" . $rowMarca['marca_id'] . "'>" . strtoupper($rowMarca['marca_nome']) . "</option>";
			}
		}
	
		$categorias = $conn->query("CALL pr_ler_categorias()");
		$conn->next_result();
		$listarCategorias = "";
		if ($categorias->num_rows > 0) {
			while ($rowCategorias = $categorias->fetch_assoc()) {
				$listarCategorias .= "<option value='" . $rowCategorias['cate_id'] . "'>" . strtoupper($rowCategorias['cate_nome']) . "</option>";
			}
		}
	}
	
}
?>
<div class="container">
    <?php if (empty($pf_cod)) { ?>
        <h1>Cadastrar Produto <?=$msg?></h1>
        <form id="produtoForm" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
			<div>
				<label>Referencia <br>
            		<select name="referencia" class="select">
						<option value=""></option>
            		    <?=$listarReferencias?>
            		</select>
				</label>
				<label>Sabor: <br>
            		<select name="sabor" class="select">
						<option value=""></option>
            		    <?=$listarSabores?>
            		</select>
				</label>
            	<label>Box: <br>
					<select name="produto_box" class="select">
						<option value=""></option>
            	    	<?=$listarBox?>
            		</select>
				</label>
				<label>Marca: <br>
					<select name="produto_marca" class="select">
						<option value=""></option>
            	    	<?=$listarMarca?>
            		</select>
				</label>
				<label>Categoria: <br>
					<select name="categoria" class="select">
						<option value=""></option>
            	    	<?=$listarCategorias?>
            		</select>
				</label>	
				<label> Link da Foto <br>
            	    <input type="text" name="foto">
            	</label> 
			</div>
            <hr>
            <br>
            <input type="hidden" name="cadastrar" value="yes">
            <br>
            <div class="botoes">
                <input type="submit" value="Cadastrar Produto">
            </div>
        </form>
    <?php } else { ?>
		<?php include 'include/cabecalho.php';?>
		<h1>Cadastrar Produto <?=$msg?></h1>
        <form id="produtoForm" action="<?=$_SERVER['PHP_SELF']?>" method="POST">
			<div>
				<label>Referencia <br>
            		<select name="referencia" class="select">
						<option value="<?=$row['produto_cod']?>"><?=strtoupper($row['produto_nome'])?></option>
            		    <?=$listarReferencias?>
            		</select>
				</label>
				<label>Sabor: <br>
            		<select name="sabor" class="select">
						<option value="<?=$row['sabor_id']?>"><?=strtoupper($row['sabor_nome'])?></option>
            		    <?=$listarSabores?>
            		</select>
				</label>
            	<label>Box: <br>
					<select name="produto_box" class="select">
						<option value="<?=$row['box_id']?>"><?=strtoupper($row['box_nome'])?></option>
            	    	<?=$listarBox?>
            		</select>
				</label>
				<label>Marca: <br>
					<select name="produto_marca" class="select">
						<option value="<?=$row['marca_id']?>"><?=strtoupper($row['marca_nome'])?></option>
            	    	<?=$listarMarca?>
            		</select>
				</label>
				<label>Categoria: <br>
					<select name="categoria" class="select">
						<option value="<?=$row['cate_id']?>"><?=strtoupper($row['cate_nome'])?></option>
            	    	<?=$listarCategorias?>
            		</select>
				</label>	
				<label> Link da Foto <br>
            	    <input type="text" name="foto" value="<?=$row['link_foto']?>">
            	</label> 
			</div>
            <hr>
            <br>
            <input type="hidden" name="cadastrar" value="yes">
            <br>
            <div class="botoes">
                <input type="submit" value="Cadastrar Produto">
            </div>
        </form>
	<?php } ?>
</div>
<script>
$('#valor').mask('000.000.000.000.000,00', {reverse: true});
</script>
<?php include 'include/footer.php';?>
