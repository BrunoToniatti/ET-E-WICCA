<?php include 'include/header.php';?>
<?php
    // PARA LISTAR OS ACESSOS CADASTRADOS DENTRO DO SISTEMA
    $selectAcesso = "SELECT * FROM acessos";
    $acessoLista = "";
    $resultadoAcesso = $conn->query($selectAcesso);
    if($resultadoAcesso->num_rows > 0){
        while($rowAcesso = $resultadoAcesso->fetch_assoc()){
            $acessoLista .= "<option value=".$rowAcesso['acesso_nome'].">".$rowAcesso['acesso_nome']."</option>";
        }
    }

    // RESGATAR VALORES DO FORMULÁRIO
    $user           = $_POST['user'] ?? "";
    $senha          = $_POST['senha'] ?? "";
    $acesso         = $_POST['acesso'] ?? "";
    $nome_completo  = $_POST['nome_completo'] ?? "";
    // PRECISAMOS DECLARAR UM VALOR PARA A VÁRIAVEL MSG FORA DO IF, POIS DENTRO DO IF ELA SO VAI SE TORNAR UMA VARIAVEL QUANDO A CONDIÇÃO DO IF FOR VERDADEIRA
    // SE ELA NÃO FOR DECLARADA AQUI FORA O SISTEMA ACUSA UM ERRO DIZENDO QUE NÃO EXISTE UMA VARIAVÉL CHAMADA MSG, TESTE VOCÊ MESMO!! TIRE ESSE $MSG E DEIXE APENAS DENTRO DO IF
    $msg            = "";

    // VARIÁVEL PARA CONFIRMAR QUE O FORMULÁRIO FOI ENVIADO
    $mandar         = $_POST['mandar'] ?? "";

    // VERIFICA SE A VARIÁVEL MANDAR É VAZIA
    if(!empty($mandar)){
        // ESTOU VERIFICANDO SE TODOS OS CAMPOS ESTÃO COMPLETOS NÃO ESTÃO VAZIOS, ISSO É PARA PRECAVER ERROS FUTUROS DE USÚARIOS COM INFORMAÇÕES INCOMPLETAS
        if(!empty($user) || !empty($senha) || !empty($acesso) || !empty($nome_completo)){
        // SE NÃO FOR VAZIA ENTÃO EXECUTE O CÓDIGO A SEGUIR
        $adicionarUsuario           = "INSERT INTO users (user, user_senha, user_acesso, user_nome_completo) value ('$user', '$senha', '$acesso', '$nome_completo')";
        $resultadoAdicionarUsuario  = $conn->query($adicionarUsuario);
        // ESTA VARIAVEL "RESULTADO" ME RETORNA UM VALOR EM BOOLENA (TRUE OU FALSE) NESTE CASO COLOCAMOS A VARIÁVEL DENTRO DO IF POIS SE FOI ENVIADO COM SUCESSO
        // AO BANCO DE DADOS ENTÃO O VALOR DESSA VÁRIAVEL RETORNA "TRUE", SE ELA RETORNAR TRUE ENTÃO SIGNIFICA QUE FOI CADASTRADO COM SUCESSO
            if($resultadoAdicionarUsuario){
                // RETORNO UMA MSG DE SUCESSO CASO SEJA CADASTRADO COM SUCESSO O USUÁRIO
                $msg = "USUÁRIO CADASTRADO COM SUCESSO!";
            }else{
                // SE A VARIÁVEL RETORNAR "FALSE" ENTÃO ELE RETORNA ESTA MSG
                $msg = "ERRO AO CADASTRAR USUÁRIO";
            }
        }else{
            // ALERTA SE EXISTE CAMPOS VAZIOS QUE AINDA NÃO FORAM PREENCHIDOS
            $msg = "EXISTEM CAMPOS VAZIOS!";
        }
    }

?>


<div class="container">
<!-- MINHA PREFERÊNCIA!! PREFIRO DE COMEÇO IMPRIMIR A MSG BEM AO LADO DO TITULO POIS ASSIM CONSIGO VERIFICAR SE DER ERRO OU NÃO OQUE ACONTECEU -->
    <h1>CADASTRAR USUÁRIO <?=$msg?></h1>
    <br>
    <br>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <input type="text" name="nome_completo" id="nome_completo" placeholder="Nome Completo">
        <input type="text" name="user" id="user" placeholder="Usuário">
        <input type="text" name="senha" id="senha" placeholder="Senha">
        <input type="hidden" name="mandar" value="sim">
        <select name="acesso" id="acesso">
            <option value="" disabled selected>Tipo de acesso</option>
            <?=$acessoLista?>
        </select>
        <input type="hidden" name="mandar" value="yes">
        <input type="submit" id="btn-class2" value="Cadastrar">
    </form>
</div>
<?php include 'include/footer.php';?>