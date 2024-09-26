<?php include 'include/top.php';?>
<?php
	$pg                	= 'pg_fd_002';
	$cabecalho         	= 'fornecedor';
	$fornecedor_cod    	= $_GET['forn_cod'] ?? "";
	$atualizar		 	= $_POST['atualizar'] ?? "";
	$selectCabecalho = "{CALL pr_ler_fornecedores(?,?)}";
    $parametrosCabecalho = array(2, $fornecedor_cod);
    $stmt = sqlsrv_query($conn, $selectCabecalho, $parametrosCabecalho);
	if(sqlsrv_has_rows($stmt)){
		$rowFornecedores = sqlsrv_fetch_array($stmt);
		$cep 			= $rowFornecedores['cep'] ?? "";
		$endereco 		= $rowFornecedores['endereco'] ?? "";
		$complemento 	= $rowFornecedores['complemento'] ?? "";
		$bairro 		= $rowFornecedores['bairro'] ?? "";
		$cidade 		= $rowFornecedores['cidade'] ?? "";
		$estado 		= $rowFornecedores['estado'] ?? "";
		$uf  		    = $rowFornecedores['uf'] ?? "";
		$pais 			= $rowFornecedores['pais'] ?? "";
	}
	
	if(!empty($atualizar)){
		$cep 			= $_POST['cep'] ?? "";
		$endereco 	    = $_POST['endereco'] ?? "";
		$complemento    = $_POST['complemento'] ?? "";
		$bairro 	    = $_POST['bairro'] ?? "";
		$cidade 	    = $_POST['cidade'] ?? "";
		$uf_form 	    = $_POST['uf'] ?? "";
        $uf             = strtoupper($uf_form);
        $estado         = $_POST['estado'] ?? "";
		$pais 			= $_POST['pais'] ?? "";

        $sql_trocar = "{CALL pr_adicionar_endereco_fornecedor(?,?,?,?,?,?,?,?,?,?)}";
        $parametros_trocar = array($fornecedor_cod, $cep, $endereco, $complemento, $bairro, $cidade, $uf, $estado, $pais, $cod);
        $stmt_update = sqlsrv_query($conn, $sql_trocar, $parametros_trocar);
        if($row = sqlsrv_fetch_array($stmt_update)){
            if($row['cad']){
                echo "<script>window.alert('".$row['msg']."')</script>";
            }
        }



    //@fornecedor_cod
	//@cep		
	//@endereco	
	//@complemento
	//@bairro		
	//@cidade		
	//@uf			
	//@estado			
	//@pais		
	//@user_cod
		
	}
?>
<div class="container">
    <?php include 'include/cabecalho.php';?>
        <form action="<?=$_SERVER['PHP_SELF']?>?forn_cod=<?=$fornecedor_cod?>" method="post">
            <div class="formulario">
                <label>CEP: <br> 
                <input type="text" id="cep" name="cep" placeholder="CEP" value="<?=$cep?>">
                </label>
                <label>Endereço: <br>
                <input type="text" id="endereco" name="endereco" placeholder="Endereço" value="<?=$endereco?>">
                </label>
                <label>Complemento <br>
                <input type="text" id="complemento" name="complemento" placeholder="Complemento" value="<?=$complemento?>">
                </label>
                <label>Bairro <br>
                <input type="text" id="bairro" name="bairro" placeholder="Bairro" value="<?=$bairro?>">
                </label>
                <label>Cidade <br>
                <input type="text" id="cidade" name="cidade" placeholder="Cidade" value="<?=$cidade?>">
                </label>
                <label>UF <br>
                <input type="text" id="uf" name="uf" placeholder="UF" value="<?=$uf?>" maxlength="2">
                </label>
                <label>Estado <br>
                <input type="text" name="estado" id="estado" placeholder="Estado" value="<?=$estado?>">
                </label>
                <label>Pais <br>
                <input type="text" id="pais" name="pais" placeholder="País" value="<?=$pais?>">
                </label>
            </div>
            <div class="botoes">
				<input type="hidden" name="atualizar" value="yes">
                <input type="submit" value="Atualizar" class="atualizar">
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

    $(document).ready(function() {
    $('#cep').on('blur', function() {
        var cep = $(this).val().replace(/\D/g, '');

        if (cep != "") {
            var validacep = /^[0-9]{8}$/;

            if(validacep.test(cep)) {
                $('#endereco').val('...');
                $('#bairro').val('...');
                $('#cidade').val('...');
                $('#uf').val('...');
                $('#estado').val('...');
                $('#pais').val('Brasil'); // Valor padrão para Brasil

                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                    if (!("erro" in dados)) {
                        $('#endereco').val(dados.logradouro);
                        $('#complemento').val(dados.complemento);
                        $('#bairro').val(dados.bairro);
                        $('#cidade').val(dados.localidade);
                        
                        var uf = dados.uf;
                        $('#uf').val(uf); // Armazenando a UF

                        // Fazendo a chamada para a API do IBGE para obter o nome completo do estado
                        $.getJSON("https://servicodados.ibge.gov.br/api/v1/localidades/estados/"+ uf, function(estadoData) {
                            if (estadoData) {
                                $('#estado').val(estadoData.nome); // Armazenando o nome completo do estado
                            } else {
                                alert("Erro ao obter o nome do estado.");
                            }
                        });
                    } else {
                        alert("CEP não encontrado.");
                        limpa_formulário_cep();
                    }
                });
            } else {
                alert("Formato de CEP inválido.");
                limpa_formulário_cep();
            }
        } else {
            limpa_formulário_cep();
        }
    });

    function limpa_formulário_cep() {
        $('#endereco').val('');
        $('#complemento').val('');
        $('#bairro').val('');
        $('#cidade').val('');
        $('#uf').val('');
        $('#estado').val('');
        $('#pais').val('');
    }
});
</script>
<?php include 'include/footer.php';?>