<?php include 'include/top.php';?>
<?php

$sql = "{CALL pr_ler_marcas(?,?)}";
$parametros = array(1, '');
$stmt = sqlsrv_query($conn, $sql, $parametros);
$listarMarcas = "";
if(sqlsrv_has_rows($stmt)){
    while ($row = sqlsrv_fetch_array($stmt)){
        $listarMarcas .= "<tr>";
        $listarMarcas .= "<td><a href='pg_mc_003.php?marca_cod=".$row['marca_cod']."'>".$row['marca_cod']."</td>";
        $listarMarcas .= "<td><a href='pg_mc_003.php?marca_cod=".$row['marca_cod']."'>".$row['marca_nome']."</td>";
        $listarMarcas .= "<td><a href='pg_mc_003.php?marca_cod=".$row['marca_cod']."'>".$row['marca_compras']."</td>";
        $listarMarcas .= "<td><a href='pg_mc_003.php?marca_cod=".$row['marca_cod']."'>".$row['status_nome']."</td>";
        $listarMarcas .= "</tr>";
    }
    
}

?>
    <div class="container">
        <h1>MARCAS</h1>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th width="500px">NOME</th>
                    <th>QUANTIDADE DE COMPRAS</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                <?=$listarMarcas?>
            </tbody>
        </table>
    </div>
<?php include 'include/footer.php';?>