<?php include 'include/top.php';?>
<div class="container">
    <h1>Listar Usuários</h1>    
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nome Completo</th>
                    <th>User</th>
                    <th>Último acesso</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "{CALL pr_ler_usuarios}";
                    $stmt = sqlsrv_query($conn, $sql);
                    while($row = sqlsrv_fetch_array($stmt)){ 
                ?>
                <tr>
                    <td><a href="pg_us_003.php?user_cod=<?=$row['user_cod']?>"><?=$row['user_cod']?></a></td>
                    <td><a href="pg_us_003.php?user_cod=<?=$row['user_cod']?>"><?=$row['user_nome_completo']?></a></td>
                    <td><a href="pg_us_003.php?user_cod=<?=$row['user_cod']?>"><?=$row['user_nome']?></a></td>
                    <?php if($row['user_ultimo_acesso'] == '') {?>
                        <td><a href="pg_us_003.php?user_cod=<?=$row['user_cod']?>">Sem atividade do usuário</a></td>
                    <?php } else {?>
                        <td><a href="pg_us_003.php?user_cod=<?=$row['user_cod']?>"><?=$row['user_ultimo_acesso']->format('d/m/Y H:i:s')?></a></td>
                    <?php }?>
                    <td><a href="pg_us_003.php?user_cod=<?=$row['user_cod']?>"><?=$row['status_nome']?></a></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    
</div>
<?php include 'include/footer.php';?>