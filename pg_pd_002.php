<?php include 'include/top.php';?>
<?php
    $ped_cod = $_GET['ped_cod'];
    $carrinho_cod = $_GET['carrinho_cod'] ?? "";
    if(!empty($carrinho_cod)){
        $sql_separar = "{CALL pr_separar_produto(?)}";
        $parametros_separar = array($carrinho_cod);
        $stmt_separar = sqlsrv_query($conn, $sql_separar, $parametros_separar);
        $row_separar = sqlsrv_fetch_array($stmt_separar);
        if($row_separar['cad']){
            echo "<script>window.location.href='pg_pd_002.php?ped_cod=".$ped_cod."';</script>";
        }
    }
?>
<style>
    .destaque h3{
        display: flex;
        justify-content: space-between;
    }
    .destaque h3 input{
        margin: 2px;
        background-color: green;
    }

    .destaque h3 input:hover{
        background-color: greenyellow;
        color: black;
    }
</style>
<div class="container">
	<?php include 'include/abas/pedido.php';
        $sql_carrinho = "{CALL pr_loja_ler_produtos_carrinhos_chave(?,?)}";
        $parametros_carrinho = array($row['chave'], $row['cli_cod']);
        $stmt_carrinho = sqlsrv_query($conn, $sql_carrinho, $parametros_carrinho);
        $row_carrinho = sqlsrv_fetch_array($stmt_carrinho);

        $enviado = "";
        $enviar = $_POST['enviar'] ?? "";
        if(!empty($enviar)){
            $sql_enviar = "{CALL pr_abrir_pedido(?,?,?,?)}";
            $parametros_enviar = array(3, 0, $row['cli_cod'], $row['chave']);
            $stmt_enviar = sqlsrv_query($conn, $sql_enviar, $parametros_enviar);
            $row_enviar = sqlsrv_fetch_array($stmt_enviar);

            if($row_enviar['cad']){
                echo "<script>window.alert('".$row_enviar['msg']."')</script>";
                echo "<script>window.location.href='pg_pd_002.php?ped_cod=".$ped_cod."';</script>";
            }
        }

        //pr_abrir_pedido]
	    //@ped_etapa	INT,
	    //@ped_valor	FLOAT,
	    //@cli_cod	INT,
	    //@chave
    ?>
    <div class="destaque">
    <form action="pg_pd_002.php?ped_cod=<?=$ped_cod?>" method="post">
        <h3>Produtos
            <?php if ($row['ped_status'] <> 'Enviado para a transportadora') {?>
            <?php if ($row_carrinho['total_separados'] == $row_carrinho['total_produtos']) { ?>           
                <input type="hidden" name="enviar" value="yes">
                <input type="submit" value="ENVIAR PARA TRANSPORTE">
            <?php }
            }?>
        </h3>
        </form>
    </div>
    <table>
        <thead>
            <tr>
                <th>Produto Código</th>
                <th>Produto Descrição</th>
                <th>Quantidade</th>
                <th>SEPARAR</th>
            </tr>
        </thead>
    <?php
        $sql_carrinho = "{CALL pr_loja_ler_produtos_carrinhos_chave(?,?)}";
        $parametros_carrinho = array($row['chave'], $row['cli_cod']);
        $stmt_carrinho = sqlsrv_query($conn, $sql_carrinho, $parametros_carrinho); 
        while($row_carrinho = sqlsrv_fetch_array($stmt_carrinho)){
    ?>
    <form action="pg_pd_002.php?ped_cod=<?=$ped_cod?>&carrinho_cod=<?=$row_carrinho['carrinho_cod']?>" method="post">
        <tr>
            <td><?=$row_carrinho['produto_cod']?></td>
            <td><?=$row_carrinho['produto_desc']?></td>
            <td><?=$row_carrinho['carrinho_quantidade']?></td>
            <?php if($row_carrinho['separado'] == FALSE){?>
                <td><input type="submit" value="SEPARAR" style="width: 80%; height: 80%;"></td>
            <?php } else {?>
                <td>SEPARADO</td>
            <?php }?>
        </tr>
    </form>
    <?php }?>
    </table>
</div>
<?php include 'include/footer.php';?>