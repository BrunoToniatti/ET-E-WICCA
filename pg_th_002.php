<?php include 'include/top.php';?>
<?php
$sql = "{CALL pr_ler_tamanhos(?,?)}";
$parametros = array(1, '');
$stmt = sqlsrv_query($conn, $sql, $parametros);
$lista = "";
while($row = sqlsrv_fetch_array($stmt)){
    $lista .= "<tr>";
    $lista .= "<td>".$row['tamanho']."</td>";
    $lista .= "<td>".$row['user_nome']."</td>";
    $lista .= "<td class='hora'> <b>Dia: ".$row['dt_criacao']->format("d/m/Y")."</b><i><b>Hora:</b> ".$row['dt_criacao']->format("H:i:s")."</i></td>";

    $lista .= "<td>".strtoupper($row['status_nome'])."</td>";
    $lista .= "</tr>";
}
?>
<style>
    .hora{
        display: flex;
        flex-direction: column;
    }

    i {
        color: gray;
        font-size: 12px !important;
    }
</style>
<div class="container">
    <h1>Listar Tamanhos</h1>
    <br>
    <br>
    <table>
        <thead>
            <tr>
                <th>TAMANHO</th>
                <th>CRIADO POR</th>
                <th>DATA DE CRIAÇÃO</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?=$lista?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>