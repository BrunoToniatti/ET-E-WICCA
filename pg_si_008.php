<?php include 'include/top.php';?>
<?php
    $select = "{CALL pr_ler_acessos(?)}";
    $parametros = array(1);
    $stmt = sqlsrv_query($conn, $select, $parametros);
    $lista = "";
    if(sqlsrv_has_rows($stmt)){
        while($row = sqlsrv_fetch_array($stmt)){
            $lista .= "<tr>";
            $lista .= "<td>".$row['acesso_cod']."</td>";
            $lista .= "<td>".strtoupper($row['acesso_nome'])."</td>";
            $lista .= "<td>".$row['dt_criacao']->format('d/m/Y')."</td>";
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
            <th>NOME DO ACESSO</th>
            <th>DATA DE CRIAÇÃO</th>          
        </thead>
        <tbody>
            <?=$lista?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>