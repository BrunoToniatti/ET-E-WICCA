<?php include 'include/top.php';?>
<?php

$sql = "{CALL pr_ler_times(?,?)}";
$parametros = array(1, '');
$stmt = sqlsrv_query($conn, $sql, $parametros);
$lista = "";
if(sqlsrv_has_rows($stmt)){
    while ($row = sqlsrv_fetch_array($stmt)){
        $lista .= "<tr>";
        $lista .= "<td><a href='pg_tm_003.php?time_cod=".$row['time_cod']."'>".$row['time_cod']."</td>";
        $lista .= "<td><a href='pg_tm_003.php?time_cod=".$row['time_cod']."'>".$row['time_descricao']."</td>";
        $lista .= "<td><a href='pg_tm_003.php?time_cod=".$row['time_cod']."'>".$row['time_compras']."</td>";
        $lista .= "<td><a href='pg_tm_003.php?time_cod=".$row['time_cod']."'>".$row['regiao_nome']."</td>";
        $lista .= "</tr>";
    }
    
}

?>
    <div class="container">
        <h1>Listar Times</h1>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th width="500px">NOME</th>
                    <th>QUANTIDADE DE COMPRAS</th>
                    <th>REGIÃO</th>
                </tr>
            </thead>
            <tbody>
                <?=$lista?>
            </tbody>
        </table>
    </div>
<?php include 'include/footer.php';?>