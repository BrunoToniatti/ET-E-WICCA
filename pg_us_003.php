<?php include 'include/top.php';?>
<?php 
    $user_cod = $_GET['user_cod'];
    $sql_ler = "{CALL pr_ler_usuarios_cod(?)}";
    $parametros_ler = array($user_cod);
    $stmt_ler = sqlsrv_query($conn, $sql_ler, $parametros_ler);
    $row_ler = sqlsrv_fetch_array($stmt_ler);
?>
<div class="container">
    <h1>Cadastrar Usuário</h1>
    <form action="pg_us_001.php" method="post">
        <div class="formulario">
        <label>
            Código: <br>
            <input type="text" name="user_cod" id="user_cod" class="codigo" value="<?=$row_ler['user_cod']?>" disabled>
        </label>
        <label> Nome completo: <br>
                <input type="text" name="user_nome_completo" value="<?=$row_ler['user_nome_completo']?>">
            </label>
            <label> User: <br>
                <input type="text" name="user_nome" value="<?=$row_ler['user_nome']?>">
            </label>
            <label> Senha <br>
                <input type="password" name="user_senha" value="<?=$row_ler['user_senha']?>">
            </label>
            <?php 
                $sql_acesso = "{CALL pr_ler_acessos(?)}";
                $parametros_acesso = array(2);
                $stmt_acesso = sqlsrv_query($conn, $sql_acesso, $parametros_acesso);
            ?>
            <label>Acesso <br>
                <select name="acesso_cod" class="select">
                    <option value="<?=$row_ler['user_acesso']?>"><?=strtoupper($row_ler['acesso_nome'])?></option>
                    <?php while($row_acesso = sqlsrv_fetch_array($stmt_acesso)){?>
                        <option value="<?=$row_acesso['acesso_cod']?>"><?=strtoupper($row_acesso['acesso_nome'])?></option>
                    <?php }?>
                </select>
            </label>
            
        </div>
        <div class="botoes">
            <input type="hidden" name="mandar" value="yes">
            <input type="submit" value="Cadastrar">
        </div>
    </form>
</div>
<?php include 'include/footer.php';?>