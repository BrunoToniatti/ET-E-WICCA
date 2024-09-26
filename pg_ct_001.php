<?php include 'include/top.php';?>
<?php
$pg               	= 'pg_pr_003';
$mandar				= $_POST['mandar'] ?? "";
$msg                = "";
if(!empty($mandar)){
	$categoria 	= $_POST['categoria'];
	$insert = $conn->query("call pr_criar_categoria('$categoria', '$cod', @msg, @cad);");
	if($insert){
		$resultado = $conn->query("SELECT	@msg AS msg, @cad AS cad;");
        if($resultado->num_rows > 0){
            $rowResultado = $resultado->fetch_assoc();
            if($rowResultado['cad']){
                echo "<script>window.location.href='pg_ct_001.php'</script>";
                $msg = $rowResultado['msg'];
            }else{
                $msg = $rowResultado['msg'];
            }
        }
	}
}

$categoria = $conn->query("CALL pr_ler_categorias()");
$listarCategorias = "";
if($categoria->num_rows > 0){
	while($rowCT = $categoria->fetch_assoc()){
		$listarCategorias .= "<li class='listinha'>".$rowCT['cate_nome']."</li>";
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
		
		ul{
			list-style: none;
		}
		
		.listinha{
			font-size: 22px;
			color: black;
			font-style: italic;
			margin-left: -30px;
			border-bottom: 1px solid black;
		}
    </style>
</head>
<body>
	<div class="container">
		<div class="box">
			<!-- Botão para abrir o modal -->
			<button id="openModalBtn"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;Tipo de Categoria</button>
			<div class="destaque">
				<h3>Tipos de categoria <?=$msg?></h3>
			</div>
			<ul>
				<?=$listarCategorias?>
			<ul>
		</div>
		<div id="myModal" class="modal">
			<div class="modal-content">
				<span class="close">&times;</span>
				<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
					<input type="text" name="categoria" placeholder="Informe o nome da categoria">
					<br>
					<br>
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
