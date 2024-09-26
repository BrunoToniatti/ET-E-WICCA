<?php include 'include/top.php';?>
<?php
$listar = "";
$sql = "{CALL pr_ler_regioes(?,?,?)}";
$parametros = array(2, '', '');
$stmt = sqlsrv_query($conn, $sql, $parametros);
if(sqlsrv_has_rows($stmt)){
    while($row = sqlsrv_fetch_array($stmt)){
        $listar .= "<tr>";
        $listar .= "<td><a href='pg_rg_003.php?regiao_cod=".$row['regiao_cod']."'>".$row['regiao_cod']."</a></td>";
        $listar .= "<td><a href='pg_rg_003.php?regiao_cod=".$row['regiao_cod']."'>".$row['regiao_nome']."</a></td>";
        $listar .= "<td><a href='pg_rg_003.php?regiao_cod=".$row['regiao_cod']."'>".$row['status_nome']."</a></td>";
        $listar .= "</tr>";
    }
}
?>
<div class="container">
    <h1>Listar Regiões</h1>
    <br>
    <br>
    <table>
        <thead>
            <tr>
                <th>UF</th>
                <th>NOME</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?=$listar?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>