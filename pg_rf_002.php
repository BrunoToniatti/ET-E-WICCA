<?php include 'include/top.php';?>
<?php
    $select = $conn->query("CALL pr_ler_produtos_finais(1)");
    $conn->next_result();
    $lista = "";
    if($select->num_rows > 0){
        while($row = $select->fetch_assoc()){
            $lista .= "<tr>";
            $lista .= "<td><a href='pg_rf_001.php?pf_cod=".$row['pf_cod']."'>".$row['pf_cod']."</a></td>";
            $lista .= "<td><a href='pg_rf_001.php?pf_cod=".$row['pf_cod']."'>".strtoupper($row['pf_nome'])."</a></td>";
            $lista .= "<td><a href='pg_rf_001.php?pf_cod=".$row['pf_cod']."'>".$row['estoque']."</a></td>";
            $lista .= "<td><a href='pg_rf_001.php?pf_cod=".$row['pf_cod']."'>".strtoupper($row['box_nome'])."</a></td>";
            $lista .= "<td><a href='pg_rf_001.php?pf_cod=".$row['pf_cod']."'>".strtoupper($row['pf_status'])."</a></td>";
            $lista .= "</tr>";
        }
    }
?>
<div class="container">
    <h1>LISTAR PRODUTOS FINAIS</h1>
    <br>
    <br>
    <table>
        <thead>
            <th>CÓDIGO DO PRODUTO</th>
            <th>NOME DO PRODUTO</th>
            <th>ESTOQUE</th>          
            <th>BOX LOCALIZADO</th>          
            <th>STATUS</th>          
        </thead>
        <tbody>
            <?=$lista?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>