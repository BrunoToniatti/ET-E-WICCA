<?php
include 'include/conexao.php';
session_start();
// Receber dados do formulário
$usuario = $_POST['user'] ?? "";
$senha = $_POST['senha'] ?? "";
$mandar     = $_POST['mandar'] ?? "";
$msg        = "";

if (!empty($mandar)) {
    // Define a consulta para o procedimento armazenado
    $sqlAuth = "{CALL pr_logar_erp(?, ?)}";

    // Prepara os parâmetros para a chamada do procedimento
    $params = array($usuario, $senha);

    $stmt = sqlsrv_query($conn, $sqlAuth, $params);

    if($stmt === false){
        die(print_r(sqlsrv_errors(), true));
    }

    // Executa o procedimento armazenado
    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if($row['entrou']){
        $_SESSION['cod'] = $row['user_cod'];
        $_SESSION['acesso'] = $row['user_acesso'];
        if($row['user_alterar_senha']){
            header("Location: trocar_senha.php");
        }else{
            header("Location: primeira_pagina.php");
        }
    }
}
?>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ET E WICCA</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        img{
            width: 500px;
            height: 410px;
        }
    </style>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image">
                                <img src="img/login.jpeg">
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Olá Novamente!</h1>
                                    </div>
                                    <form  action="<?=$_SERVER['PHP_SELF']?>" method="post">
                                        <div class="form-group">
                                            <input type="text" name= "user" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Informe seu usuário...">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="senha" class="form-control form-control-user"
                                                id="exampleInputPassword" placeholder="Informe sua senha...">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Lembrar-Me</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="mandar" value="yes">
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Login">
                                        <p style="text-align: center; margin-top: 30px; color: red;"><?=$msg?></p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>