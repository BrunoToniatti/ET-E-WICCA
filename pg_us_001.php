<?php include 'include/top.php';
//pr_criar_usuario 
//@user_nome			VARCHAR(200),
//@user_senha			VARCHAR(200),
//@user_acesso		INT,
//@user_nome_completo

$mandar = $_POST['mandar'] ?? "";
if(!empty($mandar)){
    $user_nome			    = $_POST['user_nome'];
    $user_senha			    = $_POST['user_senha']; 
    $user_acesso		    = $_POST['acesso_cod'] ?? 0;
    $user_nome_completo     = $_POST['user_nome_completo'];
    
    $sql = "{CALL pr_criar_usuario (?,?,?,?,?)}";
    $parametros = array($user_nome, $user_senha, $user_acesso, $user_nome_completo, $cod);
    $stmt = sqlsrv_query($conn, $sql, $parametros);
    $row = sqlsrv_fetch_array($stmt);
    if($row['cad']){
        echo "<script>window.alert('".$row['msg']."')</script>";
        echo "<script>window.location.href='pg_us_002.php';</script>";
    }else{
        echo "<script>window.alert('".$row['msg']."')</script>";
    }
}

?>
<div class="container">
    <h1>Cadastrar Usuário</h1>
    <form action="pg_us_001.php" method="post">
        <div class="formulario">
        <label> Nome completo: <br>
                <input type="text" name="user_nome_completo">
            </label>
            <label> User: <br>
                <input type="text" name="user_nome">
            </label>
            <label> Senha <br>
                <input type="password" name="user_senha">
            </label>
            <?php 
                $sql_acesso = "{CALL pr_ler_acessos(?)}";
                $parametros_acesso = array(2);
                $stmt_acesso = sqlsrv_query($conn, $sql_acesso, $parametros_acesso);
            ?>
            <label>Acesso <br>
                <select name="acesso_cod" class="select">
                    <option value=""></option>
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