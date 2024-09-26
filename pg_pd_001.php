<?php include 'include/top.php';?>
<?php
$mandar = $_POST['mandar'] ?? "";
?>
<div class="container">
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <div class="formulario">
            <label>
                Numero do pedido: <br>
                <input type="text" name="ped_cod" id="ped_cod">
            </label>
            <label>
                Nome do cliente: <br>
                <input type="text" name="cli_nome" id="cli_nome">
            </label>
            <label>
                Data Incial: <br>
                <input type="text" name="data_inicial" id="data_inicial">
            </label>
            <label>
                Data Final: <br>
                <input type="text" name="data_final" id="data_final">
            </label>
            <label>
                Status <br>
                <select name="ped_status" id="ped_status" class="select">
                    <option value=""></option>
                    <option value="teste">Aguardando Pagamento</option>
                </select>
                <input type="hidden" name="mandar" value="yes">
            </label>
            <label>
                <input type="submit" value="Pesquisar" style="width: 100%;">
            </label>
        </div>
    </form>
    <br>
    <br>
    <br>
    <?php 
    if(!empty($mandar)){
        $ped_cod = $_POST['ped_cod'];
        $cli_nome = $_POST['cli_nome'];
        $data_inicial = $_POST['data_inicial'];
        $data_final = $_POST['data_final'];
        $status = $_POST['ped_status'];
    
        $sql = "{CALL pr_ler_pedidos_busca(?,?,?,?,?)}";
        $parametros = array($ped_cod, $cli_nome, $data_inicial, $data_final, $status);
        $stmt = sqlsrv_query($conn, $sql, $parametros);
        if(sqlsrv_has_rows($stmt)) { ?>
    <table>
        <thead>
            <tr>
                <th style="width: 200px;">Numero do pedido</th>
                <th style="width: 600px;">Cliente</th>
                <th>Status</th>
            </tr>
            <tbody>
                <?php while($row = sqlsrv_fetch_array($stmt)) {?>
                    <tr>
                        <td><a href="pg_pd_002.php?ped_cod=<?=$row['ped_cod']?>"><?=$row['ped_cod']?></a></td>
                        <td><a href="pg_pd_002.php?ped_cod=<?=$row['ped_cod']?>"><?=$row['cli_nome']?></a></td>
                        <td><a href="pg_pd_002.php?ped_cod=<?=$row['ped_cod']?>"><?=$row['ped_status']?></a></td>
                    </tr>
                <?php }?>
            </tbody>
        </thead>
    </table>
    <?php } else {?>
            <h1>Nenhum resultado encontrado</h1>
    <?php }
    }?>
</div>
<?php include 'include/footer.php';?>