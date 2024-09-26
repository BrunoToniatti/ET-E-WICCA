<?php include 'include/top.php';?>
<?php
    $sql = "{CALL pr_ler_box(?,?)}";
    $parametros = array(2, '');
    $stmt = sqlsrv_query($conn, $sql, $parametros);
    $lista = "";
    if(sqlsrv_has_rows($stmt)){
        while($row = sqlsrv_fetch_array($stmt)){
            $lista .= "<tr>";
            $lista .= "<td><a href='pg_box_004.php?box_cod=".$row['box_cod']."'>".strtoupper($row['box_cod'])."</td>";
            $lista .= "<td><a href='pg_box_004.php?box_cod=".$row['box_cod']."'>".strtoupper($row['box_nome'])."</td>";
            $lista .= "<td><a href='pg_box_004.php?box_cod=".$row['box_cod']."'>".strtoupper($row['status_nome'])."</td>";
            $lista .= "</tr>";
        }
    }
?>
<div class="container">
    <h1>LISTAR BOX</h1>
    <br>
    <br>
    <table>
        <thead>
            <th>#</th>
            <th>NOME DO BOX</th>
            <th>STATUS</th>          
        </thead>
        <tbody>
            <?=$lista?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>