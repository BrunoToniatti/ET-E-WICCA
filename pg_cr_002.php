<?php include 'include/top.php';?>
<?php
    $sql = "{CALL pr_ler_cores(?)}";
    $parametros = array(1);
    $stmt = sqlsrv_query($conn, $sql, $parametros);
    $lista = "";
    while($row = sqlsrv_fetch_array($stmt)){
        $lista .= "<tr>";
        $lista .= "<td>".$row['cor_cod']."</td>";
        $lista .= "<td>".strtoupper($row['cor_nome'])."</td>";
        $lista .= "<td>".$row['dt_criacao']->format('d/m/Y')."</td>";
        $lista .= "<td>".strtoupper($row['status_nome'])."</td>";
        $lista .= "</tr>";
    }
?>
<div class="container">
    <h1>LISTAR PROGRAMAS</h1>
    <br>
    <br>
    <table>
        <thead>
            <th>#</th>
            <th>NOME DO ACESSO</th>
            <th>DATA CRIAÇÃO</th>
            <th>STATUS</th>          
        </thead>
        <tbody>
            <?=$lista?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>