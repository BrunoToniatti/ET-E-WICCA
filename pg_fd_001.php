<?php include 'include/top.php';?>
<?php
$pg 				= 'pg_fd_001';
$cabecalho 			= 'fornecedor';
$fornecedor_cod     = $_GET['forn_cod'] ?? "";
$cadastrar          = $_POST['cadastrar'] ?? "";
if(empty($fornecedor_cod)){
	if(!empty($cadastrar)){
		$nome       		= $_POST['nome_fornecedor'] ?? "";
		$cnpj       		= $_POST['cnpj_cpf'] ?? "";
		$telefone_principal	= $_POST['telefone_principal'] ?? "";
		$email_principal    = $_POST['email_principal'] ?? "";
		$website            = $_POST['website'] ?? "";
		
		$insert = "{CALL pr_criar_fornecedor(?,?,?,?,?,?)}";
		$parametros = array($nome, $cnpj, $telefone_principal, $email_principal, $website, $cod);
		$stmt = sqlsrv_query($conn, $insert, $parametros);								
		if(sqlsrv_has_rows($stmt)){
			$row = sqlsrv_fetch_array($stmt);
			if($row['cad']){
                echo "<script>window.alert('".$row['msg']."')</script>";
				echo "<script>window.location.href='pg_fd_001.php?forn_cod=".$row['fornecedor_cod']."';</script>";
			}else{
                echo "<script>window.alert('".$row['msg']."')</script>";
            }
		}else{
			echo "erro!!";
		}
	}
} else{
	$select = "{CALL pr_ler_fornecedores(?,?)}";
    $parametros = array(2, $fornecedor_cod);
    $stmt = sqlsrv_query($conn, $select, $parametros);
    $lista = "";
    if(sqlsrv_has_rows($stmt)){
		$rowFornecedores = sqlsrv_fetch_array($stmt);
	}

    $tipo = $_POST['tipo'] ?? "";
    if(!empty($tipo)){
        $fornecedor_nome    = $_POST['fornecedor_nome'] ?? "";          
        $cnpj               = $_POST['cnpj'] ?? "";  
        $telefone_principal = $_POST['telefone_principal'] ?? "";  
        $email_principal    = $_POST['email_principal'] ?? "";  
        $website		    = $_POST['website'] ?? "";  
        $cep			    = $_POST['cep'] ?? "";  
        $endereco		    = $_POST['endereco'] ?? "";  
        $complemento	    = $_POST['complemento'] ?? "";  
        $bairro			    = $_POST['bairro'] ?? "";  
        $cidade			    = $_POST['cidade'] ?? "";  
        $estado			    = $_POST['estado'] ?? "";  
        $numero			    = $_POST['numero'] ?? "";  
        $pais			    = $_POST['pais'] ?? "";  
        $status_cod		    = $_POST['status_cod'] ?? "";  
        $sql = "{CALL pr_man_fornecedor(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)}";
        $paramSql = array($tipo, $fornecedor_cod, $fornecedor_nome, $telefone_principal,$email_principal,$website,$cep,$endereco,$complemento,$bairro,$cidade,$estado,$numero,$pais,$status_cod);
        $stmtSql = sqlsrv_query($conn, $sql, $paramSql);
        if(sqlsrv_has_rows($stmtSql)){
            $rowSql = sqlsrv_fetch_array($stmtSql);
            if($rowSql['cad']){
                echo "<script>alert('".$rowSql['msg']."')</script>";
                if($tipo == 2){
                    echo "<script>window.location.href='pg_fd_003.php'</script>";
                }
            }else{
                echo "<script>alert(".$rowSql['msg'].")</script>";
            }
        }
    }

}

// pr_man_fornecedor
$fornecedor_nome    = $_POST['fornecedor_nome'] ?? "";          
$cnpj               = $_POST['cnpj'] ?? "";  
$telefone_principal = $_POST['telefone_principal'] ?? "";  
$email_principal    = $_POST['email_principal'] ?? "";  
$website		    = $_POST['website'] ?? "";  
$cep			    = $_POST['cep'] ?? "";  
$endereco		    = $_POST['endereco'] ?? "";  
$complemento	    = $_POST['complemento'] ?? "";  
$bairro			    = $_POST['bairro'] ?? "";  
$cidade			    = $_POST['cidade'] ?? "";  
$estado			    = $_POST['estado'] ?? "";  
$numero			    = $_POST['numero'] ?? "";  
$pais			    = $_POST['pais'] ?? "";  
$status_cod		    = $_POST['status_cod'] ?? "";      

?>
<div class="container" >
    <?php if(empty($fornecedor_cod)) {?>
        <h1>Cadastrar fornecedor</h1>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="POST" >
			<input type="text" id="cnpj" name="cnpj_cpf" placeholder="CNPJ" maxlength="18">
            <input type="text" name="nome_fornecedor" placeholder="Nome do Fornecedor">
            <input type="text" id="telefone" name="telefone_principal" placeholder="Telefone Principal">
            <input type="email" name="email_principal" placeholder="E-mail Principal">
            <input type="url" name="website" placeholder="Website">
            <br>
            <input type="hidden" name="cadastrar" value="yes">
            <br>
            <div class="botoes">
                <input type="submit" value="Cadastrar Fornecedor">
            </div>
        </form>
    <?php }
	else {?>
		<?php include 'include/cabecalho.php';?>
        <form action="<?=$_SERVER['PHP_SELF']?>?forn_cod=<?=$fornecedor_cod?>" method="POST" >
			<input type="text" name="cnpj" placeholder="CNPJ" value="<?=$rowFornecedores['cnpj']?>" disabled>
            <input type="text" name="fornecedor_nome" placeholder="Nome do Fornecedor" value="<?=$rowFornecedores['fornecedor_nome']?>">
            <input type="text" id="telefone" name="telefone_principal" value="<?=$rowFornecedores['telefone_principal']?>">
            <input type="email" name="email_principal" value="<?=$rowFornecedores['email_principal']?>">
            <input type="url" name="website" value="<?=$rowFornecedores['website']?>">
            <select name="status_cod" class="select">
                <option value="1">Ativo</option>
                <option value="2">Inativo</option>
            </select>
            <br>
            <input type="hidden" name="tipo" value="1">
            <br>
            <div class="botoes">
                <input type="submit" value="Atualizar" class="atualizar" style="width: 150px !important; height: 40px !important;">
            </form>
				<form action="<?=$_SERVER['PHP_SELF']?>?forn_cod=<?=$fornecedor_cod?>" method="post">
                    <input type="hidden" name="tipo" value="2">
					<input type="submit" value="Apagar" class="apagar" style="margin-top: -55px !important; width: 150px !important; height: 40px !important;">
				</form>
            </div>
	<?php }?>
</div>
<script>
    $('#cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('#telefone').mask('(00) 00000-0000');
</script>
<?php include 'include/footer.php';?>