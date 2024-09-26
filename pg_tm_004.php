<?php include 'include/top.php';?>
<?php
$sql = "{CALL pr_gerenciar_times_nao_cad(?,?)}";
$parametros = array(1,'');
$stmt = sqlsrv_query($conn, $sql, $parametros);
$listar = "";
if(sqlsrv_has_rows($stmt)){
    while($row = sqlsrv_fetch_array($stmt)){
        $listar .= "<tr>";
        $listar .= "<td><a href='pg_tm_001.php?time_id=".$row['time_id']."&time_desc=".$row['time_nome']."&torcedor=1'>".$row['time_nome']."</td>";
        $listar .= "<td><a href='pg_tm_001.php?time_id=".$row['time_id']."&time_desc=".$row['time_nome']."&torcedor=1'>".$row['dt_criacao']->format('d/m/Y')."</td>";
        $listar .= "</tr>";
    }
}else{
    $listar .= "<tr>";
    $listar .= "<td colspan='2'>Nenhum resultado encontrado</td>";
    $listar .= "</tr>";
}
?>
<div class="container">
    <h1>Times não cadastrados</h1>
    <table>
        <thead>
            <tr>
                <th>Nome do Time</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            <?=$listar?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>