<?php include 'include/top.php';?>
<?php
$pg					= 'pg_box_003';
$cabecalho			= 'box';
$box_cod				= $_GET['box_cod'];

$select = "{CALL pr_ler_produtos_box(?)}";
$parametros = array($box_cod);
$stmt = sqlsrv_query($conn, $select, $parametros);
$listarProdutos = "";
while($row = sqlsrv_fetch_array($stmt)){
	$listarProdutos .= "<tr>";
	$listarProdutos .= "<td>".$row['produto_cod']."</td>";
	$listarProdutos .= "<td>".$row['produto_desc']."</td>";
	$listarProdutos .= "<td>".$row['produto_estoque']."</td>";
	$listarProdutos .= "</tr>";
	
	$estoque_total = $row['estoque_total'];
}
?>

<style>
	.box{
		margin-top: 50px;
	}
</style>

<div class="container">		
	<?php include 'include/cabecalho.php';?>	
	<div class="box">
		<div class="destaque">
			<h3>Produtos dentro do box <b style="float: right;">Total Estoque: <i style="color: black;"><?=$estoque_total?></i></b></h3>
		</div>
		<table>
			<thead>
				<tr>
					<th>Código do Produto</th>
					<th>Nome do produto</th>
					<th>Quantida do estoque</th>
				</tr>
			</thead>
			<tbody>
				<?=$listarProdutos?>
			<tbody>
		</table>
	</div>
</div>
<?php include 'include/footer.php';?>