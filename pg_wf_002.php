<?php include 'include/top.php';?>
<?php
    $select = $conn->query("CALL pr_ler_workflow(1, '')");
    $lista = "";
    if($select->num_rows > 0){
        while($row = $select->fetch_assoc()){
            $lista .= "<tr>";
            $lista .= "<td><a href='pg_wf_001.php?wf_id=".$row['wf_id']."'>".$row['wf_id']."</td>";
            $lista .= "<td><a href='pg_wf_001.php?wf_id=".$row['wf_id']."'>".strtoupper($row['wf_conta_contabil'])."</td>";
            $lista .= "<td><a href='pg_wf_001.php?wf_id=".$row['wf_id']."'>R$ ".number_format($row['wf_valor'], 2, ',', '.')."</td>";
            $lista .= "<td><a href='pg_wf_001.php?wf_id=".$row['wf_id']."'>".strtoupper($row['user'])."</td>";
            $lista .= "<td><a href='pg_wf_001.php?wf_id=".$row['wf_id']."'>".strtoupper($row['nome_fornecedor'])."</td>";
            $lista .= "<td><a href='pg_wf_001.php?wf_id=".$row['wf_id']."'>".strtoupper($row['wf_dt_vencimento'])."</td>";
            $lista .= "<td><a href='pg_wf_001.php?wf_id=".$row['wf_id']."'>".strtoupper($row['wf_status'])."</td>";
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
            <th>#</th>
            <th>CONTA CONTÁBIL</th>
            <th>VALOR</th>
            <th>USUÁRIO</th>
            <th>FORNECEDOR</th>
            <th>DATA VENCIMENTO</th>        
            <th>STATUS</th>        
        </thead>
        <tbody>
            <?=$lista?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>