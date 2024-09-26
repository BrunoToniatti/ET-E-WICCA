<?php include 'include/top.php';?>
<?php
    $select = "{CALL pr_ler_fornecedores(?,?)}";
    $parametros = array(1, '');
    $stmt = sqlsrv_query($conn, $select, $parametros);
    $lista = "";
    if(sqlsrv_has_rows($stmt)){
        while($row = sqlsrv_fetch_array($stmt)){
            $lista .= "<tr>";
            $lista .= "<td><a href='pg_fd_001.php?forn_cod=".$row['fornecedor_cod']."' class='linkTable'>".$row['fornecedor_cod']."</a></td>";
            $lista .= "<td><a href='pg_fd_001.php?forn_cod=".$row['fornecedor_cod']."' class='linkTable'>".$row['fornecedor_nome']."</a></td>";
            $lista .= "<td><a href='pg_fd_001.php?forn_cod=".$row['fornecedor_cod']."' class='linkTable'>".$row['cnpj']."</a></td>";
            $lista .= "<td><a href='pg_fd_001.php?forn_cod=".$row['fornecedor_cod']."' class='linkTable'>".$row['status_nome']."</a></td>";
            $lista .= "</tr>";
        }
    }
?>

<style>
.linkTable{
	color: black !important;
}
</style>
<div class="container">
    <h1>LISTAR FORNECEDORES</h1>
    <br>
    <br>
    <table>
        <thead>
            <th>CÓDIGO</th>
            <th>FORNECEDOR</th>
            <th>CNPJ</th>
            <th>STATUS</th>
        </thead>
        <tbody>
            <?=$lista?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>