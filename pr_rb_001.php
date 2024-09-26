<?php include 'include/top.php';?>
<?php
    $select = $conn->query("CALL pr_ler_referencias()");
    $lista = "";
    if($select->num_rows > 0){
        while($row = $select->fetch_assoc()){
            $lista .= "<tr>";
            $lista .= "<td><a href='pg_pr_001.php?produto_cod=".$row['produto_cod']."'>".$row['produto_cod']."</td>";
            $lista .= "<td><a href='pg_pr_001.php?produto_cod=".$row['produto_cod']."'>".strtoupper($row['produto_nome'])."</td>";
            $lista .= "<td><a href='pg_pr_001.php?produto_cod=".$row['produto_cod']."'>R$ ".number_format($row['produto_valor'], 2, ',', '.')."</td>";
            $lista .= "<td><a href='pg_pr_001.php?produto_cod=".$row['produto_cod']."'>".strtoupper($row['produto_status'])."</td>";
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
            <th>VALOR</th>
            <th>STATUS</th>          
        </thead>
        <tbody>
            <?=$lista?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>