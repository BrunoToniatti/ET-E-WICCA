<?php include 'include/top.php';?>
<?php
$pg                = 'pg_fd_004';
$cabecalho         = 'fornecedor';
$fornecedor_cod    = $_GET['forn_cod'] ?? "";

$tipo_pagamento = $conn->query("SELECT * FROM tipo_pagamento WHERE pagamento_funcao  IN('P', 'A')");
$listarTp = "";
if($tipo_pagamento->num_rows > 0){
	$listarTp .= "<option value='' selected disabled>Escolher Forma de pagamento</option>";
	while($rowTp = $tipo_pagamento->fetch_assoc()){
		$listarTp .= "<option value='".$rowTp['pagamento_id']."'>".$rowTp['pagamento_nome']."</option>";
	}
}

$mandar		= $_POST['mandar'] ?? "";
if(!empty($mandar)){
	$forma_pagamento = $_POST['forma_pagamento'] ?? "";
	$pix		= $_POST['pix'] ?? "";
	$agencia    = $_POST['agencia'] ?? "";
	$banco      = $_POST['banco'] ?? "";
	$conta      = $_POST['conta'] ?? "";
	$fornecedor_cod    = $_GET['forn_cod'] ?? "";
	
	$insert 	= $conn->query("INSERT INTO forma_pagamento (pagamento_forma, pagamento_banco, 					pagamento_agencia, pagamento_conta, pagamento_pix, id_fornecedor) 
	VALUES ('$forma_pagamento', '$banco', '$agencia', '$conta', '$pix', '$fornecedor_cod')");
	
	if($insert){
		echo "<script>window.location.href='pg_fd_004.php?forn_cod=$fornecedor_cod';</script>";
	}
}

$selectFormaPagamento = $conn->query("SELECT * FROM forma_pagamento WHERE id_fornecedor = '$fornecedor_cod'");
$listarFormas = "";
if($selectFormaPagamento->num_rows > 0){
	while($rowForma = $selectFormaPagamento->fetch_assoc()){
		$listarFormas .= "<tr>";
		if($rowForma['pagamento_forma'] == 1){
			$listarFormas .= "<td class='lista'><i><b>PIX</b> -> ".$rowForma['pagamento_pix']."</i></td>";
		}else if($rowForma['pagamento_forma'] == 2){
			$listarFormas .= "<td class='lista'><i><b>Transferência Bancária -> Banco</b> = ".$rowForma['pagamento_banco']." <b>Agencia</b> = ".$rowForma['pagamento_agencia']." <b>Conta</b> = ".$rowForma['pagamento_conta']."</i></td>";
		}
		$listarFormas .= "</tr>";
	}
}

?>
    <style>
        /* Estilos para o modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0,0,0);
            background-color: rgba(0,0,0,0.4);
            padding-top: 60px;
            transition: opacity 0.5s;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            animation: slide-in 0.5s ease-out;
        }
        @keyframes slide-in {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
        /* Estilos para o botão */
        #openModalBtn {
            float: right;
            display: flex;
            align-items: center;
            background-color: transparent;
            border: none;
            cursor: pointer;
            font-size: 16px;
            color: #007bff;
            transition: color 0.3s, transform 0.3s, background-color 0.3s;
			border-radius: 10px;
			padding: 5px;
        }
        #openModalBtn:hover {
            color: white;
			background-color: #007bff;
            transform: scale(1.1);
        }
		.box{
			margin-top: 50px;
		}
		
		.lista{
			background-color: transparent !important;
			text-align: left !important;
			padding: 10px !important;
		}
    </style>
</head>
<body>
	<div class="container">
		<?php include 'include/cabecalho.php';?>
		<div class="box">
			<!-- Botão para abrir o modal -->
			<button id="openModalBtn"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Forma de pagamento</button>
			<div class="destaque">
				<h3>Formas de Pagamento</h3>
			</div>
			<table>
				<?=$listarFormas?>
			</table>
		</div>
		<div id="myModal" class="modal">
			<div class="modal-content">
				<span class="close">&times;</span>
				<form action="<?=$_SERVER['PHP_SELF']?>?forn_cod=<?=$fornecedor_cod?>" method="post">
					<select name="forma_pagamento" id="forma_pagamento">
						<?=$listarTp?>
					</select>
					<br><br>
					<div id="pix_input" style="display: none;">
						<label for="pix">Digite o Pix:</label>
						<input type="text" id="pix" name="pix">
					</div>
					<div id="transferencia_inputs" style="display: none;">
						<label for="banco">Banco:</label>
						<input type="text" id="banco" name="banco">
						<br>
						<label for="conta">Conta:</label>
						<input type="text" id="conta" name="conta">
						<br>
						<label for="agencia">Agência:</label>
						<input type="text" id="agencia" name="agencia">
					</div>
					<br>
					<div class="botoes">
						<input type="submit" value="Cadastrar">
					</div>
					<input type="hidden" name="mandar" value="yes">
				</form>
			</div>
		</div>
	</div>
    <?php include 'include/footer.php';?>

    <script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the button that opens the modal
    var btn = document.getElementById("openModalBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Get the select element and input fields
    var formaPagamentoSelect = document.getElementById("forma_pagamento");
    var pixInput = document.getElementById("pix_input");
    var transferenciaInputs = document.getElementById("transferencia_inputs");

    // Add event listener for the select element
    formaPagamentoSelect.addEventListener("change", function() {
        var selectedValue = this.value;
        if (selectedValue == "1") { // Assuming "1" is for Pix
            pixInput.style.display = "block";
            transferenciaInputs.style.display = "none";
        } else if (selectedValue == "2") { // Assuming "2" is for Transferência Bancária
            pixInput.style.display = "none";
            transferenciaInputs.style.display = "block";
        } else {
            pixInput.style.display = "none";
            transferenciaInputs.style.display = "none";
        }
    });
</script>
