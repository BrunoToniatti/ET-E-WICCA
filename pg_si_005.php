<?php include 'include/top.php';?>
<?php
    $select = "{CALL pr_ler_programas(?,?,?)}";
    $parametros = array(3, '', '');
    $stmt = sqlsrv_query($conn, $select, $parametros);
    $lista = "";
    if(sqlsrv_has_rows($stmt)){
        while($row = sqlsrv_fetch_array($stmt)){
            $lista .= "<tr>";
            $lista .= "<td>".$row['programa_id']."</td>";
            $lista .= "<td>".$row['programa_nome']."</td>";
            $lista .= "<td>".$row['programa_link']."</td>";
            $lista .= "<td>".$row['submenu_nome']."</td>";
            $lista .= "<td>".$row['menu_nome']."</td>";            
            $lista .= "<td>".$row['status_nome']."</td>";            
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
            <th>NOME DO PROGRAMA</th>
            <th>PROGRAMA LINK</th>
            <th>MENU HERDADO</th>
            <th>SUB-MENU HERDADO</th>
            <th>STATUS</th>
        </thead>
        <tbody>
            <?=$lista?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>