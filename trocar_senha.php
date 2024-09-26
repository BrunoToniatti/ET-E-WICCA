<?php include 'include/conexao.php';?>
<?php 
    session_start();
    $cod = $_SESSION['cod'];

    $sql = "{CALL pr_atualizar_senha(?,?,?)}";
    $parametros = array(1, '', $cod);
    $stmt = sqlsrv_query($conn, $sql, $parametros);
    $row = sqlsrv_fetch_array($stmt);

    //pr_atualizar_senha???

    $mandar = $_POST['mandar'] ?? "";
    if(!empty($mandar)){
        $user_senha = $_POST['user_senha'];
        $sql_alterar = "{CALL pr_atualizar_senha(?,?,?)}";
        $parametros_alterar = array(2, $user_senha, $cod);
        $stmt_alterar = sqlsrv_query($conn, $sql_alterar, $parametros_alterar);
        $row_alterar = sqlsrv_fetch_array($stmt_alterar);
        if($row_alterar['cad']){
            echo "<script>window.location.href='primeira_pagina.php';</script>";
        }else{
            echo "<script>window.alert('".$row_alterar['msg']."');</script>";
        }
    }

?>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PODS ERP</title>
    <link rel="stylesheet" href="css/trocar_senha.css">
</head>
<body>
    <div class="container">
        <h1>Mude sua senha</h1>
        <h2>Olá <?=$row['user_nome_completo']?>, informe sua nova senha por gentileza</h2>
        <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
            <input type="password" name="user_senha">
            <input type="hidden" name="mandar" value="yes">
            <input type="submit" value="Atualizar">
        </form>        
    </div>
</body>
</html>