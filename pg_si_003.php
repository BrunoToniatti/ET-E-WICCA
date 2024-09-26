<?php include 'include/top.php';?>
<?php
    $ler = "{CALL pr_ler_submenus(?,?)}";
    $lista = "";
    $param = array(2, '');
    $stmt = sqlsrv_query($conn, $ler, $param);
    if(sqlsrv_has_rows($stmt)){
        while($row = sqlsrv_fetch_array($stmt)){
            $lista .= "<tr>";
            $lista .= "<td>".$row['submenu_cod']."</td>";
            $lista .= "<td>".$row['submenu_nome']."</td>";
            $lista .= "<td>".$row['menu_nome']."</td>";
            $lista .= "<td>".$row['status_nome']."</td>";
            $lista .= "</tr>";
        }
    }
?>
<div class="container">
    <h1>LISTAR SUB-MENUS</h1>
    <br>
    <br>
    <table>
        <thead>
            <th>#</th>
            <th>NOME DO SUBMENU</th>
            <th>MENU HERDADO</th>
            <th>STATUS</th>
        </thead>
        <tbody>
            <?=$lista?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>