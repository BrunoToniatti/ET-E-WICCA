<?php include 'include/top.php';?>
<?php
    $select = "{CALL pr_ler_produtos(?,?)}";
    $parametros = array(1, '');
    $stmt = sqlsrv_query($conn, $select, $parametros);
    $lista = "";
    while($row = sqlsrv_fetch_array($stmt)){
        $lista .= "<tr>";
        $lista .= "<td><a href='pg_pr_003.php?produto_cod=".$row['produto_cod']."'>".$row['produto_cod']."</td>";
        $lista .= "<td><a href='pg_pr_003.php?produto_cod=".$row['produto_cod']."'>".$row['produto_desc']."</td>";
        $lista .= "<td><a href='pg_pr_003.php?produto_cod=".$row['produto_cod']."'>R$ ".number_format($row['produto_valor_compra'], 2, ',', '.')."</td>";
        $lista .= "<td><a href='pg_pr_003.php?produto_cod=".$row['produto_cod']."'>R$ ".number_format($row['produto_valor_venda'], 2, ',', '.')."</td>";
        $lista .= "</tr>";
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
            <th>VALOR DE VENDA</th>
            <th>VALOR DE COMPRA</th>          
        </thead>
        <tbody>
            <?=$lista?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>