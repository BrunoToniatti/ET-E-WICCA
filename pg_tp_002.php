<?php include 'include/top.php';?>
<?php
    $select = "{CALL pr_ler_tipo_produto(?,?)}";
    $parametros = array(1, '');
    $stmt = sqlsrv_query($conn, $select, $parametros);
    $lista = "";
    if(sqlsrv_has_rows($stmt)){
        while($row = sqlsrv_fetch_array($stmt)){
            $lista .= "<tr>";
            $lista .= "<td><a href='pg_tp_003.php?tipo_cod=".$row['tipo_cod']."'>".$row['tipo_cod']."</td>";
            $lista .= "<td><a href='pg_tp_003.php?tipo_cod=".$row['tipo_cod']."'>".strtoupper($row['tipo_nome'])."</td>";
            $lista .= "<td><a href='pg_tp_003.php?tipo_cod=".$row['tipo_cod']."'>".strtoupper($row['status_nome'])."</td>";
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
            <th>NOME</th>
            <th>STATUS</th>          
        </thead>
        <tbody>
            <?=$lista?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>