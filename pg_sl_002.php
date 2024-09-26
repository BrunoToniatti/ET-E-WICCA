<?php include 'include/top.php';?>
<?php
    $select = $conn->query("CALL pr_ler_solicitacoes_compra()");
    $lista = "";
    if($select->num_rows > 0){
        while($row = $select->fetch_assoc()){
            $lista .= "<tr>";
            $lista .= "<td><a href='pg_pr_001.php?compra_id=".$row['compra_id']."'>".$row['compra_id']."</td>";
            $lista .= "<td><a href='pg_pr_001.php?compra_id=".$row['compra_id']."'>".strtoupper($row['pf_nome'])."</td>";
            $lista .= "<td><a href='pg_pr_001.php?compra_id=".$row['compra_id']."'>".strtoupper($row['nome_fornecedor'])."</td>";
            $lista .= "<td><a href='pg_pr_001.php?compra_id=".$row['compra_id']."'>R$ ".number_format($row['valor_total'], 2, ',', '.')."</td>";
            $lista .= "<td><a href='pg_pr_001.php?compra_id=".$row['compra_id']."'>".strtoupper($row['qtd'])."</td>";
            $lista .= "<td><a href='pg_pr_001.php?compra_id=".$row['compra_id']."'>".strtoupper($row['dt_entrega'])."</td>";
            $lista .= "</tr>";
        }
    }
?>
<div class="container">
    <h1>LISTAR PROGRAMAS</h1>
    <br>
    <br>
    <table>
        <thead>
            <th>PRODUTO CÓDIGO</th>
            <th>NOME DO PRODUTO</th>
            <th>NOME DO FORNECEDOR</th>
            <th>VALOR</th>
            <th>QUANTIDADE</th>
            <th>DATA ENTREGA</th>          
        </thead>
        <tbody>
            <?=$lista?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>