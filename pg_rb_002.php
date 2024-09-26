<?php include 'include/top.php';?>
<?php

    $mostrar = "nao";
    $select = "{CALL pr_gerenciar_recebimento(?,?)}";
    $parametros = array(1, '');
    $stmt = sqlsrv_query($conn, $select, $parametros);
    $lista = "";
    if(sqlsrv_has_rows($stmt)){
        $mostrar = "sim";
        while($row = sqlsrv_fetch_array($stmt)){
            $lista .= "<form action='pg_rb_002.php?recebimento_cod=".$row['recebimento_cod']."' method='post'>";
            $lista .= "<input type='hidden' name='receber' value='yes'>";
            $lista .= "<tr>";
            $lista .= "<td>".$row['recebimento_cod']."</td>";
            $lista .= "<td>".$row['produto_cod']."</td>";
            $lista .= "<td>".$row['produto_desc']."</td>";
            $lista .= "<td>".$row['recebimento_quantidade']."</td>";
            $lista .= "<td>".$row['recebimento_status']."</td>";
            if($row['recebimento_status'] == 'Aguardando Chegada'){      
                $lista .= "<td><input type='submit' value='RECEBER' style='width: 80%;'></input></td>";
            }else{
                $lista .= "<td style='color: green;'><i class='fa-solid fa-check'></i></td>";
            }      
            $lista .= "</tr>";
            $lista .= "</form>";
        }
    }else{
        $lista .= "Nenhum recebimento";
    }

$receber = $_POST['receber'] ?? "";
if(!empty($receber)){
    $recebimento_cod = $_GET['recebimento_cod'];
    $sql = "{CALL pr_gerenciar_recebimento(?,?)}";
    $parametros_rb = array(2, $recebimento_cod);
    $stmt_rb = sqlsrv_query($conn, $sql, $parametros_rb);
        if($row_rb = sqlsrv_fetch_array($stmt_rb)){
            if($row_rb['cad']){
                echo "<script>window.location.href='pg_rb_002.php';</script>";
            }
        }
    }

?>
<div class="container">
    <h1>LISTAR PROGRAMAS</h1>
    <br>
    <br>
    <?php if($mostrar == "sim"){?>
        <table>
            <thead>
                <th>#</th>
                <th>PRODUTO CÓDIGO</th>
                <th>PRODUTO NOME</th>
                <th>QUANTIDADE</th>
                <th colspan='2'>STATUS</th>
            </thead>
            <tbody>
                <?=$lista?>
            </tbody>
        </table>
    <?php }else { ?>
        <h1>Nenhum recebimento pendente</h1>
    <?php }?>
</div>
<?php include 'include/footer.php';?>