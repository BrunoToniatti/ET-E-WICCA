<?php include 'include/top.php';?>
<?php
$cabecalho = 'produto_final';
$pg = 'pg_rf_003';
$pf_cod = $_GET['pf_cod'];
$select = $conn->query("CALL pr_ler_produtos_finais_busca('$pf_cod')");
$conn->next_result();
if($select->num_rows > 0){
    $row = $select->fetch_assoc();
}
$tipo_produto = $conn->query("SELECT * FROM tipo_produto");
$listarTipoProduto = "";
if ($tipo_produto->num_rows > 0) {		
    while ($rowTipoProduto = $tipo_produto->fetch_assoc()) {
        $listarTipoProduto .= "<option value='" . $rowTipoProduto['tipo_id'] . "'>" . $rowTipoProduto['tipo_nome'] . "</option>";
    }
}
$msg = "";
$mandar = $_POST['mandar'] ?? "";
if(!empty($mandar)){
    $descricao  = $_POST['descricao'] ?? "";
    $valor      = $_POST['valor'] ?? "";
    $sql = $conn->query("CALL pr_criar_desconto ('$pf_cod', '$valor','$descricao', '$cod', 1, @msg, @confi)");
    $conn->next_result();
    if($sql){
        $resultado = $conn->query("SELECT @msg AS msg, @confi AS confi");
        if($resultado->num_rows > 0){
            $rowResultado = $resultado->fetch_assoc();
            if($rowResultado['confi']){
                $msg = $rowResultado['msg'];
            }else{
                $msg = $rowResultado['msg'];
            }
        }
    }
}

$listarDescontos = "";
$sqlD = $conn->query("CALL pr_ler_descontos_por_produto ('$pf_cod')");
$conn->next_result();
if($sqlD->num_rows > 0){
    while($rowD = $sqlD->fetch_assoc()){
        $listarDescontos .= "<tr>";
        $listarDescontos .= "<td>Valor: <b>".number_format($rowD['desconto_valor'], 2, ',', '.')."</b></td>";
        $listarDescontos .= "<td>Descricao: <b>".$rowD['desconto_descricao']."</b></td>";
        $listarDescontos .= "<td>Descricao: <b>".$rowD['dt_criacao']."</b></td>";
        $listarDescontos .= "<td>Status: <b>".$rowD['desconto_status2']."</b></td>";
        $listarDescontos .= "</tr>";
    }
}

$apagar = $_POST['apagar'] ?? "";
if(!empty($apagar)){
    $descricao  = $_POST['descricao'] ?? "";
    $valor      = $_POST['valor'] ?? "";
    $sql = $conn->query("CALL pr_criar_desconto ('$produto_cod', '$valor','$descricao', '$cod', 2, @msg, @confi)");
    $conn->next_result();
    if($sql){
        $resultado = $conn->query("SELECT @msg AS msg, @confi AS confi");
        if($resultado->num_rows > 0){
            $rowResultado = $resultado->fetch_assoc();
            if($rowResultado['confi']){
                echo "<script>window.location.href='pg_pr_004.php?produto_cod=".$produto_cod."';</script>";
                $msg = $rowResultado['msg'];
            }else{
                $msg = $rowResultado['msg'];
            }
        }
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
</style>
<div class="container">
    <?php include 'include/cabecalho.php';?>
	<div class="box">
			<!-- Botão para abrir o modal -->
			<button id="openModalBtn"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;DESCONTO</button>
            
			<div class="destaque">
				<h3>Descontos aplicados</h3>
                <form action="pg_pr_004.php?pf_cod=<?=$pf_cod?>" method="post" style="width: 200px; margin-bottom: 50px;">
                <div class="botoes">
			    	<input type="submit" value="Inativar Desconto" class="apagar">
			    </div>
			    <input type="hidden" name="apagar" value="yes">
            </form>
			</div>
			<table>
				<?=$listarDescontos?>
			</table>
		</div>
    <div id="myModal" class="modal">
			<div class="modal-content">
				<span class="close">&times;</span>
				<form action="pg_pr_004.php?produto_cod=<?=$produto_cod?>" method="post">
                    <div style="display: flex; flex-direction: column;">
                        <div style="display: flex; flex-direction: column; text-align: center;">
                            <h1><?=$msg?></h1>
					        <label>Valor % <br>
                                <input type="text" name="valor" id="valor">
                            </label>
                            <label> Descricao <br>
                                <textarea name="descricao" id="descricao"></textarea>
                            </label>
                        </div>
					    <br>
					    <div class="botoes">
					    	<input type="submit" value="Cadastrar">
					    </div>
					    <input type="hidden" name="mandar" value="yes">
                    </div>
				</form>
			</div>
</div>
<script>
    $('#valor').mask('000.000.000.000.000,00', {reverse: true});
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
</script>
<?php include 'include/footer.php';?>