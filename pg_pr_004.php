<?php include 'include/top.php';?>
<?php
$cabecalho = 'produto';
$pg = 'pg_pr_004';
$produto_cod = $_GET['produto_cod'];

$sql_listar = "{CALL pr_gerenciar_desconto(?,?,?,?,?)}";
$parametros_listar = array(2, '', '', '', $produto_cod);
$stmt_listar = sqlsrv_query($conn, $sql_listar, $parametros_listar);
$listar_descontos = "";
if(sqlsrv_has_rows($stmt_listar)){
    while($row_listar = sqlsrv_fetch_array($stmt_listar)){
        $listar_descontos .="<tr>";
        $listar_descontos .="<td class='lista'><i><b>".$row_listar['user_nome']."</b><br><span class='data'>".$row_listar['dt_criacao']->format('d/m/Y')."</span></i></td>";
        $listar_descontos .="<td>".$row_listar['desconto_motivo']."</td>";
        $listar_descontos .="<td>".number_format($row_listar['desconto_porcentagem'], 2, ',','.')."%</td>";
        $listar_descontos .="<td>R$ ".number_format($row_listar['desconto_valor'], 2, ',','.')."</td>";
        $listar_descontos .="<td>".$row_listar['status_nome']."</td>";
        $listar_descontos .="</tr>";
    }
}else{
    $listar_descontos = "Nenhum desconto encontrado";
}

$mandar = $_POST['mandar'] ?? "";
if(!empty($mandar)){
    $descricao  = $_POST['descricao'] ?? "";
    $valor_form = $_POST['valor'] ?? "";
    $porcentagem = floatval(str_replace(',', '.', str_replace('.', '', $valor_form)));
    $sql = "{CALL pr_gerenciar_desconto(?,?,?,?,?)}";
    $parametros = array(1, $descricao, $porcentagem, $cod, $produto_cod);
    $stmt = sqlsrv_query($conn, $sql, $parametros);
    if($row = sqlsrv_fetch_array($stmt)){
        if($row['cad'] == FALSE){
            echo "<script>window.alert('".$row['msg']."')</script>";
        }
    }
}

$apagar = $_POST['apagar'] ?? "";
if(!empty($apagar)){
    $sql = "{CALL pr_gerenciar_desconto(?,?,?,?,?)}";
    $parametros = array(3, '', '', '', $produto_cod);
    $stmt = sqlsrv_query($conn, $sql, $parametros);
    if($row = sqlsrv_fetch_array($stmt)){
        if($row['cad']){
            echo "<script>window.alert('".$row['msg']."')</script>";
            echo "<script>window.location.href='pg_pr_004.php?produto_cod=".$produto_cod."';</script>";
        }else{
            echo "<script>window.alert('".$row['msg']."')</script>";
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
        .data{
            font-size: 12px !important;
        }
    </style>
</style>
<div class="container">
    <?php include 'include/abas/produtos.php';?>
	<div class="box">
			<!-- Botão para abrir o modal -->
			<button id="openModalBtn"><i class="fa-solid fa-plus"></i>&nbsp;&nbsp;DESCONTO</button>            
			<div class="destaque">
				<h3>Descontos aplicados</h3>
                <form action="pg_pr_004.php?produto_cod=<?=$produto_cod?>" method="post" style="width: 200px; margin-bottom: 50px;">
                <div class="botoes">
			    	<input type="submit" value="Inativar Desconto" class="apagar">
			    </div>
			    <input type="hidden" name="apagar" value="yes">
            </form>
			</div>
			<table>
                <thead>
                    <tr>
                        <th>Usuário/Data</th>
                        <th width="500px">Motivo</th>
                        <th>Porcentagem</th>
                        <th>Valor Descontado</th>
                        <th>Status</th>
                    </tr>
                </thead>
				<?=$listar_descontos?>
			</table>
		</div>
    <div id="myModal" class="modal">
			<div class="modal-content">
				<span class="close">&times;</span>
				<form action="pg_pr_004.php?produto_cod=<?=$produto_cod?>" method="post">
                    <div style="display: flex; flex-direction: column;">
                        <div style="display: flex; flex-direction: column; text-align: center;">
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