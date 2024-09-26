<?php include 'include/top.php';?>
<div class="container">
    <h1>Listar Banners</h1>
    <br>
    <br>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Descrição do Banner</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "{CALL pr_ler_banners(?)}";
                $parametros = array('');
                $stmt = sqlsrv_query($conn, $sql, $parametros);
                while($row = sqlsrv_fetch_array($stmt)){
            ?>
            <tr>
                <td><a href="pg_bn_003.php?id=<?=$row['id']?>"><?=$row['id']?></td>
                <td><a href="pg_bn_003.php?id=<?=$row['id']?>"><?=$row['banner_desc']?></td>
                <td><a href="pg_bn_003.php?id=<?=$row['id']?>"><?=$row['status_nome']?></td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>
<?php include 'include/footer.php';?>