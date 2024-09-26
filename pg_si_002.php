<?php include 'include/top.php';?>
<?php
    $ler = "{CALL pr_ler_menus(?)}";
    $params = array(2);
    $stmt = sqlsrv_query($conn, $ler, $params);
    $lista = "";
    if(sqlsrv_has_rows($stmt)){
        while($row = sqlsrv_fetch_array($stmt)){
            $lista .= "<tr>";
            $lista .= "<td>".$row['menu_cod']."</td>";
            $lista .= "<td>".$row['menu_nome']."</td>";
            $lista .= "<td>".$row['user_nome']."</td>";
            $lista .= "<td>".$row['status_nome']."</td>";
            $lista .= "</tr>";
        }
    }
?>
<div class="container">
    <h1>LISTAR MENUS</h1>
    <br>
    <br>
    <table>
        <thead>
            <th>#</th>
            <th>NOME DO MENU</th>
            <th>CRIADO POR</th>
            <th>STATUS</th>
        </thead>
        <tbody>
            <?=$lista?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>